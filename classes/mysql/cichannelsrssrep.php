<?
class CIChannelsRssRep {

	public static function GetRssChannels() {
		global $DB;
		$arChannels = array();
		$result = $DB->Query("SELECT * FROM b_ichannels_rss", false);
		while (false !== ($channel = $result->GetNext())) {
			$arChannels[] = $channel;
		}
		return $arChannels;
	}

	public static function GetRssChannelByID($id) {
		global $DB;
		$id = intval($id);
		$result = $DB->Query("SELECT * FROM b_ichannels_rss WHERE ID=$id", false);
		return $result->GetNext();
	}
}