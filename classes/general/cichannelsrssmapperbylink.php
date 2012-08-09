<?
class CIChannelsRssMapperByLink {

	public static function getRssMapper() {
		return array(
			'class' => __CLASS__,
			'id' => 'bylink',
			'name' => 'По ссылке',
			'method' => 'map',
		);
	}

	public static function map($arItem, $arChannel = array()) {

		if (self::checkExistsByLink($arItem, $arChannel)) return false;

		$arFields = array();
		$arFields['NAME'] = $arItem['title'];
		$arFields['PREVIEW_TEXT'] = $arItem['description'];
		$arFields['PROPERTY_VALUES']['LINK'] = $arItem['link'];

		return $arFields;
	}

	public static function checkExistsByLink($arItem, $arChannel) {
		$rResult = CIBlockElement::GetList(
			array('SORT' => 'ASC'),
			array(
				'IBLOCK_ID' => $arChannel['IBLOCK_ID'],
				'IBLOCK_TYPE' => $arChannel['IBLOCK_TYPE_ID'],
				'PROPERTY_LINK' => $arItem['link'],
			),
			false,
			false,
			array(
				'PROPERTY_LINK',
			)
		);
		while (false !== ($element = $rResult->GetNext())) {
			return true;
		}
	}
}