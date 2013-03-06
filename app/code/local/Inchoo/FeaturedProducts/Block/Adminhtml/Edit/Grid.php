<?php
/**
 *
 * @category   Inchoo
 * @package    Inchoo Featured Products
 * @author     Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 */
class Inchoo_FeaturedProducts_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setId('inchoo_featured_products');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
        
        $this->setRowClickCallback('FeaturedRowClick');
    }

    public function getProduct()
    {
        return Mage::registry('product');
    }

    protected function _addColumnFilterToCollection($column)
    {
      
 

      if($column->getId()=="featured")
      {
      	$productIds = $this->_getSelectedProducts();
		
      	if (empty($productIds)) {
               $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
            	$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            elseif(!empty($productIds)) {		         
        		$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
            }            
      	     	
      }else{
      
            parent::_addColumnFilterToCollection($column);
      }
       
        return $this;
    }

    protected function _prepareCollection()
    {
        
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('inchoo_featured_product')
            ->addStoreFilter($this->getRequest()->getParam('store'));
            //echo $collection->getSelect();
        $this->setCollection($collection);

       

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
       
       
            $this->addColumn('featured', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'featured',
                'values'    => $this->_getSelectedProducts(),
                'align'     => 'center',
                'index'     => 'entity_id'
            ));
                     
     
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width'     => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price'
        ));
    
		
        return parent::_prepareColumns();
    }

	
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    
    
    protected function _getSelectedProducts($json=false)
    {	
    	$temp = $this->getRequest()->getPost('featured_ids');
    	if($temp)
    	{
    		parse_str($temp, $featured_ids);
    		    		
    	}
    	
   
        
        
            
        	$_prod=Mage::getModel('catalog/product')->getCollection()
        	
            ->addAttributeToFilter('inchoo_featured_product','1')
            ->addStoreFilter($this->getRequest()->getParam('store'));
            
            $products=$_prod->getColumnValues('entity_id'); 
            $selected_products=array();
            
            
            
            if($json==true)
        		{        	
        		foreach($products as $key => $value)
        			{	 
        			$selected_products[$value]='1';
        			}
        		return Zend_Json::encode($selected_products); 
        	}        	
        	else
        		{
        			
        			foreach($products as $key => $value)
        			{	 
        				if((isset($featured_ids[$value]))&&($featured_ids[$value]==0))        				
        				{
        					
        				}else	          				
        				$selected_products[$value]='0';			
        			}
        			
				if(isset($featured_ids))        			
        			foreach($featured_ids as $key => $value)
        			{
        				if($value==1)
        				$selected_products[$key]='0';
        			}
        			
        			
        			
        			
        			
        		return array_keys($selected_products);
        	}
        	
        
        
        
        return $products;
    }
    
    //add javascript before/after grid html
    protected function _afterToHtml($html){
    	return $this->_prependHtml() . parent::_afterToHtml($html) . $this->_appendHtml();
    }

    
    private function _prependHtml(){
    		$gridName = $this->getJsObjectName();
    	
    	        	$html=
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
        //console.log("fields",fields);   
        
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
		
	   	$gridName.reloadParams = {'featured_ids':checkBoxes.toQueryString()};        		
    }

//]]>
		
		
		
		
        </script>
EndHTML;

    		return $html;
    }
    
    
    private function _appendHtml(){
    	$html=
'
		<script type="text/javascript">	
		var checkBoxes = $H();
        </script>
';

    return $html;
    }






}