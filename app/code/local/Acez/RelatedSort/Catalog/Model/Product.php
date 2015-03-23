<?php
class Acez_RelatedSort_Catalog_Model_Product
  extends Mage_Catalog_Model_Product
{
  public function getRelatedProductCollection()
  {
    $collection = $this->getLinkInstance()->useRelatedLinks()
      ->getProductCollection()
      ->setIsStrongMode();
    $collection->setProduct($this);
    $collection->setOrder('name', 'DESC'); // nas kod
    return $collection;
  }
}
