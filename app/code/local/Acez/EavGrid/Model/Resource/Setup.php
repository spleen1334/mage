<?php

class Acez_EavGrid_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
	// Podesavanje EAV atributa, bice snimljeni u db
	public function getDefaultEntities()
		{
			$entities = array(
				'acez_eavgrid_entity' => array(
					'entity_model' => 'acez_eavgrid/eav',
					'attribute_model' => '',
					'table' => 'acez_eavgrid/eavgrid_entity',
					'attributes' => array(
						'title' => array(
							'type' => 'varchar',
							'backend' => '',
							'frontend' => '',
							'label' => 'Title',
							'input' => 'text',
							'class' => '',
							'source' => '',
							'global' => 0,
							'visible' => true,
							'required' => true,
							'user_defined' => true,
							'default' => '',
							'searchable' => false,
							'filterable' => false,
							'comparable' => false,
							'visible_on_front' => true,
							'unique' => false,
						),
						'author' => array(
							'type' => 'varchar',
							'backend' => '',
							'frontend' => '',
							'label' => 'Author',
							'input' => 'text',
							'class' => '',
							'source' => '',
							'global' => 0,
							'visible' => true,
							'required' => true,
							'user_defined' => true,
							'default' => '',
							'searchable' => false,
							'filterable' => false,
							'comparable' => false,
							'visible_on_front' => false,
							'unique' => false,
						),
					),
				)
			);
			return $entities;
		}
}
