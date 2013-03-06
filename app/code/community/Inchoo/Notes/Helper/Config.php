<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @authors       Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_Notes_Helper_Config extends Mage_Core_Helper_Abstract
{
	const UPDATES_FEED_URL = 'inchoo_notes_general/feed/feed_url';

	public function getInchooFeedUrl()
	{
		return Mage::getStoreConfig(self::UPDATES_FEED_URL);
	}
}
