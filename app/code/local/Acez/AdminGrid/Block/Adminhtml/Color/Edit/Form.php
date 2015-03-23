<?php

class Acez_AdminGrid_Block_Adminhtml_Color_Edit_Form
	extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		// Instaciranje form objekta, za editovanje
        $form = new Varien_Data_Form( array(
			'id' => 'edit_form',
			// mnogo detaljnije objasnjeno u Magento video
			'action' => $this->getUrl(
				'acez_admingrid_admin/color/edit', array(
				'_current' => true,
				'continue' => 0,
				)
			),
			'method' => 'post',
		) );
		$form->setUseContainer(true);
		$this->setForm($form);

		// Fieldset je <legend> element
		$fieldset = $form->addFieldSet(
			'general',
			array(
				'legend' => $this->__('Color Details')
			)
		);


		// Ucini dostupnim f() iz modela
		$colorSingleton = Mage::getSingleton('acez_admingrid/color');


		// polja koja mozemo da editujemo
		$this->_addFieldsToFieldset( $fieldset, array(
			'name'  => array(
				'label'  => $this->__('Name'),
				'input'  => 'text',
				'required' => true,
			),
			'description'  => array(
				'label'  => $this->__('Description'),
				'input'  => 'textarea',
				'required' => true,
			),

			'color_type'  => array(
				'label'  => $this->__('Color types'),
				'input'  => 'select',
				'required' => true,
				'options'  => $colorSingleton->getColorTypes(),
			),
		));

		return $this;
	}

	/*
	 * Ovo je samo method koji sluzi za olaksavanje generisanja $_POST podataka,
	 * mozemo ga u potpunosti ignorisati
	 */
	protected function _addFieldsToFieldset( Varien_Data_Form_Element_Fieldset $fieldset, $fields)
	{
		$requestData = new Varien_Object($this->getRequest()->getPost('colorData'));


		foreach ($fields as $name => $_data) {
			if ($requestValue = $requestData->getData($name)) {
				$_data['value'] = $requestValue;
			}

			// sve ubacijuemo u colorData grupu u post array
			$_data['name'] = "colorData[$name]";

			// label === title u vecini slucajeva
			$_data['title'] = $_data['label'];

			// ukoliko ne postoji vrednost u post, koristi postojece podatke
			if( ! array_key_exists('value', $_data)) {
				$_data['value'] = $this->_getColor()->getData($name);
			}

			// OVO JE JEDINA BITNA FUNKCIJA, moglo je rucno da se poziva u _prepareForm
			$fieldset->addField($name, $_data['input'], $_data);
		}

		return $this;
	}

	/*
	 * Nasa funkcija za prepopulation of form fields.
	 * Za novi color entry vraca prazan objekat.
	 */
	protected function _getColor()
	{
		// ukoliko vec postoji objekat ucitaj sa odgovarajucim podacima 
		if ( ! $this->hasData('color')) {
			// ovaj registry podesavamo iz ctrl
			$color = Mage::registry('current_color');

			if ( ! $color instanceof Acez_AdminGrid_Model_Color) {
				$color = Mage::getModel('acez_admingrid/color');
			}

			$this->setData('color', $color);
		}

		// Ukoliko nema objekta onda vrati samo prazan objekat
		return $this->getData('color');

	}
}
