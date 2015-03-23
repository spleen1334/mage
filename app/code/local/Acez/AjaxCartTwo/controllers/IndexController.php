<?php

require_once 'Mage/Checkout/controllers/CartController.php';
class Acez_AjaxCartTwo_IndexController 
	extends Mage_Checkout_CartController 
{

    public function addAction()
    {
		// setup
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();

		// check ajax
		// Nas kod generise response koji koristimo posle u JS
        if($params['isAjax'] == 1){
            $response = array();
            try {
                if (isset($params['qty'])) {
                    $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                    );
                    $params['qty'] = $filter->filter($params['qty']);
                }
 
                $product = $this->_initProduct();
                $related = $this->getRequest()->getParam('related_product');
 
                /**
                 * Check product availability
                 */
                if (!$product) {
					// -------------- NAS KOD ----------------------------------
                    $response['status'] = 'ERROR';
                    $response['message'] = $this->__('Unable to find Product ID');
                }
 
                $cart->addProduct($product, $params);
                if (!empty($related)) {
                    $cart->addProductsByIds(explode(',', $related));
                }
 
                $cart->save();
 
                $this->_getSession()->setCartWasUpdated(true);
 
                /**
                 * @todo remove wishlist observer processAddToCart
                 */
                Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
                );
 
                if (!$cart->getQuote()->getHasError()){
                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));

					// -------------- NAS KOD ----------------------------------
                    $response['status'] = 'SUCCESS';
                    $response['message'] = $message;

					// pripremi layout obj, uzmi block i renderuj u html
                    $this->loadLayout();
                    $toplink = $this->getLayout()->getBlock('top.links')->toHtml();
                    $sidebar_block = $this->getLayout()->getBlock('cart_sidebar');

                    Mage::register('referrer_url', $this->_getRefererUrl());


					// -------------- NAS KOD ----------------------------------
                    $sidebar = $sidebar_block->toHtml();
                    $response['toplink'] = $toplink;
                    $response['sidebar'] = $sidebar;
                }
            } catch (Mage_Core_Exception $e) {
                $msg = "";
                if ($this->_getSession()->getUseNotice(true)) {
                    $msg = $e->getMessage();
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    foreach ($messages as $message) {
                        $msg .= $message.'<br/>';
                    }
                }
 
				// -------------- NAS KOD ----------------------------------
                $response['status'] = 'ERROR';
                $response['message'] = $msg;
            } catch (Exception $e) {
				// -------------- NAS KOD ----------------------------------
                $response['status'] = 'ERROR';
                $response['message'] = $this->__('Cannot add the item to shopping cart.');
                Mage::logException($e);
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
            return;
        }else{
			// U slucaju da NIJE ajax odradi parent addAction() bez modifikacija
            return parent::addAction();
        }
    }
    
	// Method koji se koristi za configurable products, itd...
    public function optionsAction(){
		// setup
        $productId = $this->getRequest()->getParam('product_id');
        $viewHelper = Mage::helper('catalog/product_view'); // da bi renerovali catalog_product_view
 
		// getter/setter methode, magic
		// Povezano sa Mage_Catalog_Helper_Product, initProduct() > category_id param 
		// setSpecifyOptions > iz prepareAndRender()
        $params = new Varien_Object();
        $params->setCategoryId(false);
        $params->setSpecifyOptions(false);
 
        // Render page
        try {
			// Mage_Catalog_Helper_Product_View, 
			// prepareAndRender($productId, $controller, $params)
			// Tu se vrsi priprema layouta, neka podesavanja kao i render (catalog_product_view)
            $viewHelper->prepareAndRender($productId, $this, $params);

        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }
    
}