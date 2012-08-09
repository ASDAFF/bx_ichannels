<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/prolog.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_js.php");

if (!CModule::IncludeModule('iblock')) die();

$sQuery = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);

switch ($sQuery) {
	case 'type':
		print getTypesFormatted();
		break;
	case 'iblock':
		print getIBlocksFormatted();
		break;
	case 'section':
		print getSectionsFormatted();
		break;
}

function getTypesFormatted() {
	$out = '';
	$rResuls = CIBlockType::GetList();
	while (false !== ($type = $rResuls->GetNext())) {
		$arType = CIBlockType::GetByIDLang($type['ID'], LANGUAGE_ID, true);
		$out .= sprintf('<option value="%s">%s</option>', $type['ID'], $arType['NAME']);
	}
	return $out;
}

function getIBlocksFormatted() {
	$out = '';

	$type = filter_input(INPUT_POST, 'iblock_type', FILTER_SANITIZE_STRING);

	if ($type == 'notype') {
		return $out;
	}

	$rResult = CIBlock::GetList(
		array('SORT' => 'ASC'),
		array(
			'TYPE' => $type,
			'ACTIVE' => 'Y',
		)
	);
	while (false !== ($iblock = $rResult->GetNext())) {
		$out .= sprintf('<option value="%s">%s</option>', $iblock['ID'], $iblock['NAME']);
	}
	return $out;
}

function getSectionsFormatted() {
	$out = '<option value="0">.Корневой каталог</option>';
	$rResult = CIBlockSection::GetList(
		array('SORT' => 'ASC'),
		array(
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => filter_input(INPUT_POST, 'iblock', FILTER_SANITIZE_STRING),
		)
	);
	while (false !== ($section = $rResult->GetNext())) {
		$out .= sprintf('<option value="%s">%s</option>', $section['ID'], $section['NAME']);
	}
	return $out;
}