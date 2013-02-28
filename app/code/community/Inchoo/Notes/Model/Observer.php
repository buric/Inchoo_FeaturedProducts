<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @authors       Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_Notes_Model_Observer
{
    public function preDispatch(Varien_Event_Observer $observer)
    {
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {

            $feedModel  = Mage::getModel('adminnotification/feed');

            $feedModel->checkUpdate();

        }

    }
}
