<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

CModule::IncludeModule('bx_ichannels');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$id = intval($id);

$new = false;

if ($id == 0) {
	$new = true;
} else {
	$new = false;
	$channel = CIChannelsRssRep::GetRssChannelById($id);
}

$default = array(
	'NAME' => '',
	'URL' => '',
	'IBLOCK_TYPE_ID' => 'notype',
	'IBLOCK_ID' => '',
	'IBLOCK_SECTION_ID' => '',
	'FREQUENCY' => '84600',
	'MAPPER' => 'default',
);

if (!$new and isset($channel)) {
	$default = $channel;
}

if (array_key_exists('form_id', $_POST) && $_POST['form_id'] == 'ichannels_edit_rss_channel') {

	$arSave['ID'] = filter_input(INPUT_POST, 'channel_id', FILTER_SANITIZE_STRING);
	$arSave['NAME'] = filter_input(INPUT_POST, 'NAME', FILTER_SANITIZE_STRING);
	$arSave['URL'] = filter_input(INPUT_POST, 'URL', FILTER_SANITIZE_STRING);
	$arSave['IBLOCK_TYPE_ID'] = filter_input(INPUT_POST, 'select-type', FILTER_SANITIZE_STRING);
	$arSave['IBLOCK_ID'] = filter_input(INPUT_POST, 'select-iblock', FILTER_SANITIZE_STRING);
	$arSave['IBLOCK_SECTION_ID'] = filter_input(INPUT_POST, 'select-section', FILTER_SANITIZE_STRING);
	$arSave['FREQUENCY'] = filter_input(INPUT_POST, 'FREQUENCY', FILTER_SANITIZE_STRING);
	$arSave['MAPPER'] = filter_input(INPUT_POST, 'select-mapper', FILTER_SANITIZE_STRING);
 
	$arSave['ID'] = intval($arSave['ID']);

	if ($arSave['ID'] == 0) {
		$DB->Query("
			INSERT INTO b_ichannels_rss (
				NAME, 
				URL, 
				IBLOCK_TYPE_ID, 
				IBLOCK_ID, 
				IBLOCK_SECTION_ID, 
				FREQUENCY, 
				MAPPER
			) VALUES(
				'{$arSave['NAME']}',
				'{$arSave['URL']}',
				'{$arSave['IBLOCK_TYPE_ID']}',
				{$arSave['IBLOCK_ID']},
				{$arSave['IBLOCK_SECTION_ID']},
				{$arSave['FREQUENCY']},
				'{$arSave['MAPPER']}'
			)");
		$arSave['ID'] = $DB->LastID();
	} else if ($arSave['ID'] > 0) {
		$DB->Query("
			UPDATE b_ichannels_rss
			SET
				NAME = '{$arSave['NAME']}',
				URL = '{$arSave['URL']}',
				IBLOCK_TYPE_ID = '{$arSave['IBLOCK_TYPE_ID']}',
				IBLOCK_ID = {$arSave['IBLOCK_ID']},
				IBLOCK_SECTION_ID = {$arSave['IBLOCK_SECTION_ID']},
				FREQUENCY = {$arSave['FREQUENCY']},
				MAPPER = '{$arSave['MAPPER']}'
			WHERE
				ID={$arSave['ID']}
			");
		// here we should remove agent
		CAgent::RemoveAgent(
			sprintf('CIChannelsRssAgent::ImportFromID(%d);', intval($arSave['ID'])),
			'bx_ichannels'
		);
	}

	// here we do agent
	CAgent::AddAgent(
		sprintf('CIChannelsRssAgent::ImportFromID(%d);', intval($arSave['ID'])),
		'bx_ichannels',
		'N',
		intval($arSave['FREQUENCY']),
		'',
		'Y',
		'',
		'500'
	);

	header('Location: ichannels_rss_manager.php');
}

$APPLICATION->SetTitle(GetMessage('Редактирование канала'));

CModule::IncludeModule('bx_ichannels');

// $APPLICATION->AddHeadScript('/bitrix/js/bx_ichannels/jquery-1.7.2.min.js');
$APPLICATION->SetAdditionalCSS('/bitrix/js/bx_ichannels/css/rss_edit.css');

$aTabs = array(
	array(
		'DIV' => 'tab1',
		'TAB' => 'Канал импорта',
		'ICON' => '',
		'TITLE' => 'Канал импорта',
	),
);
if ($new) $aTabs[0]['TITLE'] = 'Новый канал импорта';

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$tabControl->Begin();
$tabControl->BeginNextTab();
?>

<form action="" method="post">

	<input type="hidden" name="form_id" id="form_id" value="ichannels_edit_rss_channel" />

	<input type="hidden" name="channel_id" id="channel_id" value="<?=$id?>" />

	<tr class="heading">
		<td colspan="2" align="center">Откуда импортируем</td>
	</tr>

	<tr>
		<td><label for="NAME">Имя канала</label></td>
		<td><input type="text" id="NAME" name="NAME" class="strval strval-long" value="<?=$default['NAME']?>" /></td>
	</tr>

	<tr>
		<td><label for="URL">Адрес потока</label></td>
		<td><input type="text" id="URL" name="URL" class="strval strval-long" value="<?=$default['URL']?>" /></td>
	</tr>

	<tr class="heading">
		<td colspan="2" align="center">Куда импортируем</td>
	</tr>

	<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/ichannels_iblock_form.php'); ?>

	<tr class="heading">
		<td colspan="2" align="center">Настройки импорта</td>
	</tr>

	<tr>
		<td><label for="FREQUENCY">Частота (в секундах)</label></td>
		<td><input type="text" name="FREQUENCY" id="FREQUENCY" class="intval" value="<?=$default['FREQUENCY']?>" /></td>
	</tr>

	<tr>
		<td><label for="select-mapper">Обработчик полей</label></td>
		<td>
			<select id="select-mapper" name="select-mapper" class="selectval">
				<? foreach (CIChannels::getRssMappers() as $mapper): ?>
					<option value="<?=$mapper['id']?>"><?=$mapper['name']?></option>
				<? endforeach; ?>
			</select>

			<? if (!$new): ?>
			<script type="text/javascript">
				$('#select-mapper')
				.val("<?=$default['MAPPER']?>");
			</script>
			<? endif; ?>

		</td>
	</tr>

<?
$tabControl->EndTab();
$tabControl->Buttons();
?>

<input type="submit" name="submit-save" id="submit-save" value="Сохранить" />
<? if (!$new): ?>
<input type="submit" name="submit-delete" id="submit-delete" value="Удалить" />
<? endif; ?>
<h6 style="display:inline;"><a href="ichannels_rss_manager.php">к списку</a></h6>

<script type="text/javascript">
	$('#submit-delete').on('click', function(event) {
		event.preventDefault();
		document.location = "ichannels_rss_delete.php?id=<?=$channel['ID']?>";
	});
</script>

<?
$tabControl->End();
?>

</form>

<?
require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>