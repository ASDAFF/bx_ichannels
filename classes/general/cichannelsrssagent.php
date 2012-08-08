<?
class CIChannelsRssAgent {

	public function ImportFromID($id = 0) {
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
			AddMessage2Log(var_export($arFields, true), 'bx_ichannels');
		}

		return sprintf('%s(%d);', __METHOD__, $id);
	}

}