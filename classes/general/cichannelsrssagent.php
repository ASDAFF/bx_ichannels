<?
class CIChannelsRssAgent {

	public function ImportFromID($id = 0) {
		global $USER;
		if (!is_object($USER)) $USER = new CUser;

		$channel = CIChannelsRssRep::GetRssChannelById($id);
		if (!$channel) return;

		$arUrl = parse_url($channel['URL']);

		if (!array_key_exists('port', $arUrl)) $arUrl['port'] = 80;
		if (!array_key_exists('path', $arUrl)) $arUrl['path'] = '';
		if (!array_key_exists('query', $arUrl)) $arUrl['query'] = '';

		CModule::IncludeModule('iblock');

		$rChannel = CIBlockRSS::GetNewsEx(
			$arUrl['host'],
			$arUrl['port'],
			$arUrl['path'],
			$arUrl['query']
		);

		$arChannel = CIBlockRSS::FormatArray($rChannel);

		$mapper = CIChannels::getRssMapperByID($channel['MAPPER']);

		$ins = new $mapper['class'];

		foreach ($arChannel['item'] as $item) {
			$arFields = $ins->{$mapper['method']}($item);
			$arFields['IBLOCK_TYPE_ID'] = $channel['IBLOCK_TYPE_ID'];
			$arFields['IBLOCK_ID'] = $channel['IBLOCK_ID'];

			if ($channel['IBLOCK_SECTION_ID'] != '0') {
				$arFields['IBLOCK_SECTION_ID'] = $channel['IBLOCK_SECTION_ID'];
			}

			$arFields['ACTIVE'] = 'Y';
			$arFields['MODIFIED_BY'] = 1;

			$iblockElement = new CIBlockElement();
			$iNewElementID = $iblockElement->Add($arFields);
		}

		return sprintf('%s(%d);', __METHOD__, $id);
	}

}