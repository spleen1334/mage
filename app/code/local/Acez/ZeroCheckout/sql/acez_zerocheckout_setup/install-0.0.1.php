<?php
$this->startSetup();

$this->addAttribute('catalog_product', 'zero_price', array(
    'group'         => 'General',
	'type'          => 'varchar',
    'label'         => 'ZERO_PRICE',
    'input'         => 'select',
	'option' => array(
				// ovo verovatno treba malo procistiti i pronaci listu properties
				'label' => array('one' => 1, 'two' => 2, 'three' => 3),
				'value' => array(
					'one' => array(0 => 'Zero Price ON', 2 => 'Alt One'),
					'two' => array(0 => 'Zero Price OFF', 2 => 'Alt Two'),
					// 2 =>... je store id (npr english, german itd..)
				),
	),
	'is_visible_on_front' => true,
	'required'      => false
));

$this->endSetup();