<?php

/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Grid_Container {

    protected $_saveButtonLabel = 'Save Featured Products';
    protected $_inchooUrl = 'http://inchoo.net';

    public function __construct() {


        $this->_blockGroup = 'featuredproducts';
        $this->_controller = 'adminhtml_edit';


        $this->_headerText = Mage::helper('adminhtml')->__('Featured products');

        parent::__construct();

        $this->_removeButton('add');

        $this->_addButton('save', array(
            'label' => $this->_saveButtonLabel,
            'onclick' => 'categorySubmit(\'' . $this->getSaveUrl() . '\')',
            'class' => 'Save',
        ));
    }

    public function getSaveUrl() {
        return $this->getUrl('*/*/save', array('store' => $this->getRequest()->getParam('store')));
    }

    protected function _afterToHtml($html) {
        return $this->_prependHtml() . parent::_afterToHtml($html) . $this->_appendHtml();
    }

    private function _prependHtml() {
        $html = '
    	
    	<form id="featured_edit_form" action="' . $this->getSaveUrl() . '" method="post" enctype="multipart/form-data">
    	<input name="form_key" type="hidden" value="' . $this->getFormKey() . '" />
    		<div class="no-display">
        		<input type="hidden" name="featured_products" id="in_featured_products" value="" />
    		</div>
		</form>
    	';

        return $html;
    }

    private function _appendHtml() {
        $html =
                '
		<style type="text/css">
		<!--
		#logo_wrapp a{ 
			display:block; 
			width:75px;  
			float:right;
			padding:0px 0px 0px 0px;
			margin:5px 0px 0px 0px;
			background:url(' . $this->getSkinUrl('images/inchoo/inchoo-small-logo.png') . ') no-repeat 0px 0px;
			text-indent: -9999px;
			font-size: 0px;
			line-height: 0px;
			height:13px;	
    	}
    	#logo_wrapp a:hover {background:url(' . $this->getSkinUrl('images/inchoo/inchoo-small-logo.png') . ') no-repeat 0px -13px; }
		-->
		</style>			
		<div style="text-align:right;">Community version of <a href="' . $this->_inchooUrl . '/ecommerce/magento/featured-products-on-magento-frontpage/" target="_blank">Featured Products Extension</a></div>
		<div id="logo_wrapp"><a href="' . $this->_inchooUrl . '" target="_blank">Inchoo</a></div>
		';
        return $html;
    }

    public function getHeaderHtml() {
        return '<h3 style="background-image: url(' . $this->getSkinUrl('images/product_rating_full_star.gif') . ');" class="' . $this->getHeaderCssClass() . '">' . $this->getHeaderText() . '</h3>';
    }

    protected function _prepareLayout() {
        $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher', 'store_switcher')->setUseConfirm(false)
        );
        return parent::_prepareLayout();
    }

    public function getGridHtml() {

        return $this->getChildHtml('store_switcher') . $this->getChildHtml('grid');
    }

}