<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_Block_Listing extends Mage_Catalog_Block_Product_Abstract
{
	/*
	 * Check sort option and limits set in System->Configuration and apply them
	 * Additionally, set template to block so call from CMS will look like {{block type="featuredproducts/listing"}}
	 */
	public function __construct()
	{
		$this->setTemplate('inchoo/featuredproducts/block_featured_products.phtml');

		$this->setLimit((int)Mage::getStoreConfig("featuredproducts/general/number_of_items"));
		$sort_by = Mage::getStoreConfig("featuredproducts/general/product_sort_by");
		$this->setItemsPerRow((int)Mage::getStoreConfig("featuredproducts/general/number_of_items_per_row"));

		switch ($sort_by) {
			case 0:
				$this->setSortBy("rand()");
			break;
			case 1:
				$this->setSortBy("created_at desc");
			break;
			default:
				$this->setSortBy("rand()");
		}
	}

	/*
	 * Load featured products collection
	 * */
	protected function _beforeToHtml()
	{
		$collection = Mage::getResourceModel('catalog/product_collection');

			$attributes = Mage::getSingleton('catalog/config')
				->getProductAttributes();

			$collection->addAttributeToSelect($attributes)
				->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				->addAttributeToFilter('inchoo_featured_product', 1, 'left')
				->addStoreFilter()
				->getSelect()->order($this->getSortBy())->limit($this->getLimit());

			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		
			$this->_productCollection = $collection;

		$this->setProductCollection($collection);
		return parent::_beforeToHtml();
	}

	/*
	 * Return label for CMS block output
	 * */
	protected function getBlockLabel()
	{
		return $this->helper('featuredproducts')->getCmsBlockLabel();
	}

}