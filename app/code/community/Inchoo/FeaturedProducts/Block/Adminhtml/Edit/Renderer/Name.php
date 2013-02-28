<?php

/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @author        Domagoj Potkoc, Inchoo Team <web@inchoo.net>
 * @modified    Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_FeaturedProducts_Block_Adminhtml_Edit_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    protected $_values;

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row) {

        $action_name = $this->getRequest()->getActionName();

        if ($action_name == 'exportCsv' || $action_name == 'exportXml') {
            return $row->getName();
        }

        $href = $this->getUrl('*/catalog_product/edit', array(
            'store' => $this->getRequest()->getParam('store'),
            'id' => $row->getId()));

        $html = '<a href="' . $href . '">' . $row->getName() . '</a>';

        return $html;
    }

}
