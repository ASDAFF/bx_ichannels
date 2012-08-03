<?
class CIChannelsRss {
	public function getImporter() {
		return array(
			'class' => __CLASS__,
			'name' => 'Импортировать из RSS',
			'id' => __CLASS__,
			'link' => '/bitrix/admin/ichannels_rss_manager.php',
		);
	}
}