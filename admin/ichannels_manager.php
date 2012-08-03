<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

$APPLICATION->SetTitle(GetMessage('Каналы импорта'));

CModule::IncludeModule('bx_ichannels');

$arImporters = CIChannels::getImporters();


$sTableID = 'ichannels_importers_list_table';
$oSort = new CAdminSorting($sTableID, "name", "desc");
$lAdmin = new CAdminList($sTableID, $oSort);

$lAdmin->AddHeaders(array(
	array(
		'id' => 'name',
		'content' => 'Тип',
		// 'sort' => 'name',
		'default' => true,
	),
	array(
		'id' => 'class',
		'content' => 'Класс',
		'default' => true,
	)
));

foreach ($arImporters as $importer) {
	$row = $lAdmin->AddRow($importer['id'], $importer);
	$row->AddViewField(
		'name', 
		sprintf('<a href="%s">%s</a>', $_SERVER['DOCUMENT_ROOT'] . $importer['link'], $importer['name'])
	);
	$row->AddViewField('class', $importer['class']);
}


$lAdmin->Display();

require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>