<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

CModule::IncludeModule('bx_ichannels');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$id = intval($id);

$channel = CIChannelsRssRep::GetRssChannelById($id);

if (array_key_exists('form_id', $_POST) && $_POST['form_id'] == 'ichannels_delete_rss_channel') {
	if ($_POST['confirm-delete'] == 'Y') {
		$DB->Query("DELETE FROM b_ichannels_rss WHERE ID=$id");
		// CAdminMessage::ShowMessage(array(
		// 	'MESSAGE' => 'Удаление',
		// 	'DETAIL' => 'Канал успешно удален',
		// 	'TYPE' => 'OK',
		// 	'HTML' => false,
		// ));
		header('Location: ichannels_rss_manager.php');
	}
}

$APPLICATION->SetTitle(GetMessage('Удаление канала'));
$APPLICATION->AddHeadScript('/bitrix/js/bx_ichannels/jquery-1.7.2.min.js');

$aTabs = array(
	array(
		'DIV' => 'tab1',
		'TAB' => 'Удаление канала',
		'ICON' => '',
		'TITLE' => 'Удаление канала',
	),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$tabControl->Begin();

$tabControl->BeginNextTab();
?>

<form action="" method="post">

<input type="hidden" id="form_id" name="form_id" value="ichannels_delete_rss_channel" />

<tr>
	<td colspan="2">
		Вы уверены, что хотите удалить канал "<?=$channel['NAME']?>"?
	</td>
</tr>


<?
$tabControl->EndTab();
$tabControl->Buttons();
?>

<input type="hidden" name="confirm-delete" id="confirm-delete" value="N" />

<input type="submit" name="submit-delete" id="submit-delete" value="Да" />
<input type="submit" name="submit-keep" id="submit-keep" value="Нет" />

<script type="text/javascript">
	$('#submit-delete').on('click', function() {
		$('#confirm-delete').val('Y');
	});
	$('#submit-keep').on('click', function(event) {
		event.preventDefault();
		document.location = "ichannels_rss_edit.php?id=<?=$channel['ID']?>";
	});
</script>

<?
$tabControl->End();
?>

</form>

<?
require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>