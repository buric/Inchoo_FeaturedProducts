<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_IndexController extends Mage_Core_Controller_Front_Action
{
	/*
	 * Check settings set in System->Configuration and apply them for featured-products page
	 * */
	public function indexAction()
	{
		$template = Mage::getConfig()->getNode('global/page/layouts/'.Mage::getStoreConfig("featuredproducts/general/layout").'/template');
		
		$this->loadLayout();

		$this->getLayout()->getBlock('root')->setTemplate($template);
		$this->getLayout()->getBlock('head')->setTitle($this->__(Mage::getStoreConfig("featuredproducts/general/meta_title")));
		$this->getLayout()->getBlock('head')->setDescription($this->__(Mage::getStoreConfig("featuredproducts/general/meta_description")));
		$this->getLayout()->getBlock('head')->setKeywords($this->__(Mage::getStoreConfig("featuredproducts/general/meta_keywords")));
		
                $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
                $breadcrumbsBlock->addCrumb('featured_products', array(
                    'label'=>Mage::helper('featuredproducts')->__(Mage::helper('featuredproducts')->getPageLabel()),
                    'title'=>Mage::helper('featuredproducts')->__(Mage::helper('featuredproducts')->getPageLabel()),
                ));
                
		$this->renderLayout();
	}
}