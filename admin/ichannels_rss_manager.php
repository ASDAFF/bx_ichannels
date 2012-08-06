<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

$APPLICATION->SetTitle(GetMessage('������ �� RSS'));

CModule::IncludeModule('bx_ichannels');

$sTableID = 'ichannesl_rss_importers';
$oSort = new CAdminSorting($sTableID, "name", "desc");
$lAdmin = new CAdminList($sTableID, $oSort);

$lAdmin->AddHeaders(array(
	array(
		'id' => 'name',
		'content' => '���',
		'default' => true,
	),
	array(
		'id' => 'iblock_type',
		'content' => '��� ���������',
		'default' => true,
	),
	array(
		'id' => 'iblock',
		'content' => '��������',
		'default' => true,
	),
	array(
		'id' => 'section',
		'content' => '������',
		'default' => true,
	),
));




$aContext = array(
	array(
		'TEXT' => '�������� ����� �����',
		'LINK' => 'ichannels_rss_edit.php?id=0',
		'TITLE' => '�������� ����� �����',
	),
);
$lAdmin->AddAdminContextMenu($aContext, false, false);









$lAdmin->Display();

require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>