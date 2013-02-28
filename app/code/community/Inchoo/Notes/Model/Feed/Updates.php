<?php
/**
 * @category     Inchoo
 * @package     Inchoo Featured Products
 * @authors       Mladen Lotar <mladen.lotar@surgeworks.com>, Vedran Subotic <vedran.subotic@surgeworks.com>
 */
class Inchoo_Notes_Model_Feed_Updates extends Inchoo_Notes_Model_Feed_Abstract
{

	public function getFeedUrl()
	{
		return Mage::helper('inchoo_notes/config')->getInchooFeedUrl();
	}

	public function check()
	{
		if((time() - Mage::app()->loadCache('inchoo_notes_updates_feed_lastcheck')) > Mage::getStoreConfig('inchoo_notes_general/feed/check_frequency')){
			return $this->refresh();
		}
	}

	public function refresh()
	{
		$feedData = array();
		try {
			$Node = $this->getFeedData();

			if ($Node) {
				foreach ($Node->children() as $item) {
					$date = strtotime((string)$item->itemdate);
					$feedData[] = array(
						'severity' => 4,
						'date_added' => $this->getDate((string)$item->item->pubDate),
						'title' => (string)$item->item->title,
						'description' => (string)$item->item->description,
						'url' => (string)$item->item->link,
					);
				}
			}

			if ($feedData) {
				Mage::getModel('adminnotification/inbox')->parse($feedData);
			}
			Mage::app()->saveCache(time(), 'inchoo_notes_updates_feed_lastcheck');
			return true;
		} catch (Exception $E) {
			return false;
		}
	}

	public function getDate($rssDate)
	{
		return gmdate('Y-m-d H:i:s', strtotime($rssDate));
	}


}