<?php
/**
 *
 * @category   Inchoo
 * @package    Inchoo Featured Products
 * @author     Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 */
class Inchoo_FeaturedProducts_Block_Product_List extends Mage_Catalog_Block_Product_List //Mage_Catalog_Block_Product_Abstract
{


    protected $_productCollection;
    protected $_sort_by;
  

    public function __construct()
    {
    }

    protected function _beforeToHtml()
    {

        parent::_beforeToHtml();

        $toolbar = $this->getToolbarBlock();

        $toolbar->removeOrderFromAvailableOrders('position');

        return $this;

    }


    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {

            $collection = Mage::getResourceModel('catalog/product_collection');

            $attributes = Mage::getSingleton('catalog/config')
                ->getProductAttributes();

            $collection->addAttributeToSelect($attributes)
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToFilter('inchoo_featured_product', 1)
                ->addStoreFilter();
                
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

            $this->_productCollection = $collection;

        }
        return $this->_productCollection;
    }

    
    protected function _toHtml()
    {
        if ($this->_getProductCollection()->count()){
            return parent::_toHtml();
        }
        return '';
    }

}