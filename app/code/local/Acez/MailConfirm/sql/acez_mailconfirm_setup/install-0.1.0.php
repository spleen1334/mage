<?php
$this->startSetup();

$this->addAttribute('catalog_product', 'mail_confirm', array(
    'group'         => 'General',
	'type'          => 'varchar',
    'label'         => 'Mail Confirmation?',
    'input'         => 'text',
	'is_visible_on_front' => true,
	'required'      => false
));

$this->endSetup();