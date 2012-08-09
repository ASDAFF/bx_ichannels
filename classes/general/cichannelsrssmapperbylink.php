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

		if (!self::checkLinkField($arChannel['IBLOCK_ID'])) {
			$link_field = self::addLinkField($arChannel['IBLOCK_ID']);
			if ($link_field === false) return false;
		}

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

	public static function checkLinkField($iblock_id) {
		$rResult = CIBlockProperty::GetList(
			array('SORT' => 'ASC'),
			array(
				'IBLOCK_ID' => $iblock_id,
				'CODE' => 'LINK',
				'ACTIVE' => 'Y',
			)
		);
		$arResult = array();
		while (false != ($property = $rResult->GetNext())) {
			$arResult[] = $property;
		}
		return !empty($arResult);
	}

	public static function addLinkField($iblock_id) {
		$iblock_property = new CIBlockProperty;
		return $iblock_property->Add(
			array(
				'NAME' => 'Ссылка',
				'ACTIVE' => 'Y',
				'SORT' => 500,
				'CODE' => 'LINK',
				'PROPERTY_TYPE' => 'S',
				'IBLOCK_ID' => $iblock_id,
			)
		);
	}
}