<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

$APPLICATION->SetTitle(GetMessage('Импорт из RSS'));

CModule::IncludeModule('bx_ichannels');

$sTableID = 'ichannesl_rss_importers';
$oSort = new CAdminSorting($sTableID, "name", "desc");
$lAdmin = new CAdminList($sTableID, $oSort);

$lAdmin->AddHeaders(array(
	array(
		'id' => 'name',
		'content' => 'Имя',
		'default' => true,
	),
	array(
		'id' => 'iblock_type',
		'content' => 'Тип инфоблока',
		'default' => true,
	),
	array(
		'id' => 'iblock',
		'content' => 'Инфоблок',
		'default' => true,
	),
	array(
		'id' => 'section',
		'content' => 'Раздел',
		'default' => true,
	),
));




$aContext = array(
	array(
		'TEXT' => 'Добавить новый канал',
		'LINK' => 'ichannels_rss_edit.php?id=0',
		'TITLE' => 'Добавить новый канал',
	),
);
$lAdmin->AddAdminContextMenu($aContext, false, false);









$lAdmin->Display();

require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>