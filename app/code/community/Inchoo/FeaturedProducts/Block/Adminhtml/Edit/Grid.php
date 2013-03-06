<?php

/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();

        $this->setId('inchoo_featured_products');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);

        $this->setRowClickCallback('FeaturedRowClick');
    }

    public function getProduct() {
        return Mage::registry('product');
    }

    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _addColumnFilterToCollection($column) {

        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {

                $this->getCollection()->joinField('websites', 'catalog/product_website', 'website_id', 'product_id=entity_id', null, 'left');
            }
        }


        if ($column->getId() == "featured") {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
            }
        } else {

            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection() {
        $store = $this->_getStore();
        
                
        $collection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('sku')
                ->addAttributeToSelect('inchoo_featured_product')
                ->addAttributeToSelect('type_id')
                ->addAttributeToFilter('visibility', array('nin' => array(1,3)));


        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $collection->addStoreFilter($store);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', 1, 'inner', $store->getId());
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        } else {
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('status');
            $collection->addAttributeToSelect('visibility');
        }


        
        $this->setCollection($collection);



        parent::_prepareCollection();
        
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    protected function _prepareColumns() {


        $this->addColumn('featured', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'featured',
            'values' => $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'entity_id'
        ));

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '60',
            'index' => 'entity_id'
        ));
        
        $this->addColumn('name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'name'
        ));
        
        $this->addColumn('type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
        
        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('SKU'),
            'width' => '140',
            'index' => 'sku'
        ));

        $this->addColumn('visibility', array(
            'header' => Mage::helper('catalog')->__('Visibility'),
            'width' => '140',
            'index' => 'visibility',
            'filter'    => false,
            'renderer'  => 'featuredproducts/adminhtml_edit_renderer_visibility',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites', array(
                'header' => Mage::helper('catalog')->__('Websites'),
                'width' => '100px',
                'sortable' => false,
                'index' => 'websites',
                'type' => 'options',
                'options' => Mage::getModel('core/website')->getCollection()->toOptionHash(),
            ));
        }
        
        /*
        $this->addColumn('visibility',
            array(
                'header'=> Mage::helper('catalog')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));
        */


        
        $store = $this->_getStore();
        $this->addColumn('price',
            array(
                'header'=> Mage::helper('catalog')->__('Price'),
                'type'  => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
        ));
        
        /*
        $this->addColumn('price', array(
            'header' => Mage::helper('catalog')->__('Price'),
            'type' => 'currency',
            'width' => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        */



        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    protected function _getSelectedProducts($json=false) {
        $temp = $this->getRequest()->getPost('featured_ids');
        $store = $this->_getStore();

        if ($temp) {
            parse_str($temp, $featured_ids);
        }

        $_prod = Mage::getModel('catalog/product')->getCollection()
                ->joinAttribute('inchoo_featured_product', 'catalog_product/inchoo_featured_product', 'entity_id', null, 'left', $store->getId())
                ->addAttributeToFilter('inchoo_featured_product', '1');

        $products = $_prod->getColumnValues('entity_id');
        $selected_products = array();


        if ($json == true) {
            foreach ($products as $key => $value) {
                $selected_products[$value] = '1';
            }
            return Zend_Json::encode($selected_products);
        } else {

            foreach ($products as $key => $value) {
                if ((isset($featured_ids[$value])) && ($featured_ids[$value] == 0)) {
                    
                }else
                    $selected_products[$value] = '0';
            }

            if (isset($featured_ids))
                foreach ($featured_ids as $key => $value) {
                    if ($value == 1)
                        $selected_products[$key] = '0';
                }

            return array_keys($selected_products);
        }

        return $products;
    }

    //add javascript before/after grid html
    protected function _afterToHtml($html) {
        return $this->_prependHtml() . parent::_afterToHtml($html) . $this->_appendHtml();
    }

    private function _prependHtml() {
        $gridName = $this->getJsObjectName();

        $html =
                <<<EndHTML
		<script type="text/javascript">
		//<![CDATA[

    categoryForm = new varienForm('featured_edit_form');
	categoryForm.submit= function (url) {
    
	this._submit();
           
            return true;
        
        
    };

    function categorySubmit(url) {
        
    	var params = {};
        var fields = $('featured_edit_form').getElementsBySelector('input', 'select');   
        
        categoryForm.submit();
    }
    
    function FeaturedRowClick(grid, event)
    {	
    	var trElement = Event.findElement(event, 'tr');
    	var isInput   = Event.element(event).tagName == 'INPUT';

    	var checkbox = Element.getElementsBySelector(trElement, 'input.checkbox').first();
        if(!checkbox) return;
		        
		if(checkbox.checked) checkBoxes.set(checkbox.value, 1);
		else checkBoxes.set(checkbox.value, 0);
		
		//else checkBoxes.unset(checkbox.value);
				
		       
		$("in_featured_products").value = checkBoxes.toQueryString();
		//console.log("Products", checkBoxes);
	   	$gridName.reloadParams = {'featured_ids':checkBoxes.toQueryString()};        		
    }
    
//]]>
		
		
		
		
        </script>
EndHTML;

        return $html;
    }

    private function _appendHtml() {
        $html =
                '
		<script type="text/javascript">	
		var checkBoxes = $H();
		
		var checkbox_all = $$("#inchoo_featured_products_table thead input.checkbox").first();
    	var everycheckbox = $$("#inchoo_featured_products_table tbody input.checkbox");
		
		checkbox_all.observe("click", function(event) {
		
		if(checkbox_all.checked)
		{
    	everycheckbox.each(function(element, index) {
			checkBoxes.set(element.value, 1)
			});
    	} else
    	{
    		everycheckbox.each(function(element, index) {
  			checkBoxes.set(element.value, 0)
			});
    	}
    	$("in_featured_products").value = checkBoxes.toQueryString();
		});	
        </script>
';

        return $html;
    }

}