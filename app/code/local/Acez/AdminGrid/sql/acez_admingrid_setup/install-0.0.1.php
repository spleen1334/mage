<?php

$installer = $this;
$installer->startSetup();


// uzmi iz configa vrednost
$table = $installer->getConnection()->newTable($installer->getTable('acez_admingrid/color'));


$table->addColumn(
	'entity_id',
	Varien_Db_Ddl_Table::TYPE_INTEGER,
	10,
	array(
		'auto_increment' => true,
		'unsigned'       => true,
		'nullable'       =>false,
		'primary'        =>true
	)
);

$table->addColumn(
	'name',
	Varien_Db_Ddl_Table::TYPE_VARCHAR,
	255,
	array(
		'nullable'       =>false,
	)
);


$table->addColumn(
	'description',
	Varien_Db_Ddl_Table::TYPE_TEXT,
	null,
	array(
		'nullable'       =>false,
	)
);


$table->addColumn(
	'color_type',
	Varien_Db_Ddl_Table::TYPE_BOOLEAN,
	null,
	array(
		'nullable'       =>false,
	)
);

// settings nije obavezno
//$table->setOption('type', 'InnoDB');
//$table->setOption('charset', 'utf8');

$installer->getConnection()->createTable($table);
$installer->endSetup();
