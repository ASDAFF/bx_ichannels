<?
class CIChannelsRssMapperDefault {

	public function getRssMapper() {
		return array(
			'class' => __CLASS__,
			'name' => 'По умолчанию',
			'id' => 'default',
			'method' => 'map',
		);
	}

	public function map($arItem) {
		$arFields = array();
		return $arItem;
	}
}