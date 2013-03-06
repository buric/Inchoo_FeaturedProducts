<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_Model_System_Config_Source_Sort
{
	/*
	 * Prepare data for System->Configuration dropdown
	 * */
	public function toOptionArray()
	{
		return array(
			0 => Mage::helper('adminhtml')->__('Random'),
			1 => Mage::helper('adminhtml')->__('Last Added')
		);
	}
}
