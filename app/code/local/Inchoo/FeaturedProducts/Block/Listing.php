<?php
/**
 *
 * @category   Inchoo
 * @package    Inchoo Featured Products
 * @author     Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 */
class Inchoo_FeaturedProducts_Block_Listing extends Mage_Catalog_Block_Product_Abstract
{	
	protected $_limit;
    protected $_sort_by;		
	
	
	public function __construct()
	{
    	$this->_limit = (int)Mage::getStoreConfig("featuredproducts/general/number_of_items");
        $sort_by = Mage::getStoreConfig("featuredproducts/general/product_sort_by");
        
        
    	switch ($sort_by) {
   		
    		case 0:
        		$this->_sort_by = "rand()";
        	break;
    		case 1:
        		$this->_sort_by = "created_at desc";
        	break;
        	default:
        		$this->_sort_by = "rand()"; 	
		}
    }

    protected function _beforeToHtml()
    {
        $limit = (int)Mage::getStoreConfig("featuredproducts/general/number_of_items");
        $sort_by = Mage::getStoreConfig("featuredproducts/general/product_sort_by");
        	
        $collection = Mage::getResourceModel('catalog/product_collection');

            $attributes = Mage::getSingleton('catalog/config')
                ->getProductAttributes();

            $collection->addAttributeToSelect($attributes)
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToFilter('inchoo_featured_product', 1)
                ->addStoreFilter()
                ->getSelect()->order($this->_sort_by)->limit($this->_limit);


            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);

            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

            $this->_productCollection = $collection;
            
        $this->setProductCollection($collection);
        return parent::_beforeToHtml();
    }

}