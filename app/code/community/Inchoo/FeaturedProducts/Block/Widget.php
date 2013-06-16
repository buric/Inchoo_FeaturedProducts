<?php

/**
 * Widget
 *
 * PHP version 5
 *
 * @category Deployment
 * @package  Application
 * @author   Sven Varkel <sven.varkel@eepohs.com>
 * @license  http://eepohs.com/ Eepohs Special License
 * @link     http://esc.eepohs.com/ Eepohs Software Channel
 */
//namespace Application;

/**
 * Widget
 *
 * @category Deployment
 * @package  Application
 * @author   Sven Varkel <sven.varkel@eepohs.com>
 * @license  http://eepohs.com/ Eepohs Special License
 * @link     http://esc.eepohs.com/ Eepohs Software Channel
 */
class Inchoo_FeaturedProducts_Block_Widget extends Inchoo_FeaturedProducts_Block_Listing
    implements Mage_Widget_Block_Interface
{

    public function addData(array $arr)
    {
        $this->_data = array_merge($this->_data, $arr);
    }

    public function setData($key, $value = null)
    {
        $this->_data[$key] = $value;
    }

    protected function _toHtml()
    {
        return parent::_toHtml();
    }

}
