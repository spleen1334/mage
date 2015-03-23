<?php

class Acez_EavGrid_Block_Adminhtml_Eavent_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl(
				'acez_eavgrid_admin/eav/edit',
				array(
					'_current' => true,
					'continue' => 0,
				)
			),
			'method' => 'post',
		));
//		$form->setUseContainer(true);



		$fieldset = $form->addFieldset(
			'general', 
			array(
				'legend' => $this->__('EAV Details')
			)
		);

		          $fieldset->addField('name', 'text',
                    array(
                        'label' => 'name',
                        'class' => 'required-entry',
                        'required' => true,
                        'name' => 'name',
                 ));
//		$this->_addFieldsToFieldset($fieldset, array(
//			'title' => array(
//				'label' => $this->__('Title'),
//				'input' => 'text',
//				'required' => true,
//			),
//			'author' => array(
//				'label' => $this->__('Author'),
//				'input' => 'text',
//				'required' => true,
//			),
//		));
//		var_dump($fieldset);

		$form->setForm($form);
//		return $this;
		return parent::_prepareForm();
	}

	protected function _addFieldsToFieldset(Varien_Data_Form_Element_Fieldset $fieldset, $fields)
	{
		$requestData = new Varien_Object($this->getRequest()->getPost('eavData'));

		foreach ($fields as $name => $_data) {
			if ($requestValue = $requestData->getData($name)) {
				$_data['value'] = $requestValue;
			}

			$_data['name'] = "eavData[$name]";
			$_data['title'] = $_data['label'];

			if (!array_key_exists( 'value', $_data)) {
				$_data['value'] = $this->_getEav()->getData($name);
//				$_data['value'] = $this->getData($name);
			}

			$fieldset->addField($name, $_data['input'], $_data);
		}
		return $this;
	}

	protected function _getEav()
	{
		if (!$this->hasData('eav')) {
			$eav = Mage::registry('current_eav');

			if(!$eav instanceof Inchoo_Blog_Model_Post) {
				$eav = Mage::getModel('inchoo_blog/post');
			}
			$this->setData('eav', $eav);
		}
		return $this->getData('eav');
	}
}
