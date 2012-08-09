<?
class CIChannelsRssMapperConventional {

	public static function getRssMapper() {
		return array(
			'class' => __CLASS__,
			'id' => 'conventional',
			'name' => 'Условный',
			'method' => 'map',
		);
	}

	public static function map($arItem) {
		$arFields = array();
		$arFields['NAME'] = $arItem['title'];
		$arFields['PREVIEW_TEXT'] = $arItem['description'];
		$arFields['PROPERTY_VALUES']['LINK'] = $arItem['link'];
		return $arFields;
	}
}