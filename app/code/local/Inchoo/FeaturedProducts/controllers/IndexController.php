<?php
/**
 *
 * @category   Inchoo
 * @package    Inchoo Featured Products
 * @author     Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 */
class Inchoo_FeaturedProducts_IndexController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
		$template = Mage::getConfig()->getNode('global/page/layouts/'.Mage::getStoreConfig("featuredproducts/general/layout").'/template');
		
		$this->loadLayout();		

		$this->getLayout()->getBlock('root')->setTemplate($template);
		$this->getLayout()->getBlock('head')->setTitle($this->__(Mage::getStoreConfig("featuredproducts/general/meta_title")));
		$this->getLayout()->getBlock('head')->setDescription($this->__(Mage::getStoreConfig("featuredproducts/general/meta_description")));
		$this->getLayout()->getBlock('head')->setKeywords($this->__(Mage::getStoreConfig("featuredproducts/general/meta_keywords")));
		
		$this->renderLayout();
	}

}