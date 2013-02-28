<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @authors       Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_Notes_Model_Feed extends Mage_AdminNotification_Model_Feed
{
    const XML_USE_HTTPS_PATH    = 'notes/feed/use_https';
    const XML_FEED_URL_PATH     = 'notes/feed/url';
    const XML_FREQUENCY_PATH    = 'notes/feed/check_frequency';
	const XML_FREQUENCY_ENABLE    = 'notes/feed/enabled';
    const XML_LAST_UPDATE_PATH  = 'notes/feed/last_update';

	public static function check()
	{
		if(!Mage::getStoreConfig(self::XML_FREQUENCY_ENABLE)){
			return;
		}
		return Mage::getModel('inchoo_notes/feed')->checkUpdate();
	}
}
