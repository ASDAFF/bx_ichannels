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
	}

	header('Location: ichannels_rss_manager.php');
}

$APPLICATION->SetTitle(GetMessage('�������������� ������'));

CModule::IncludeModule('bx_ichannels');

$APPLICATION->AddHeadScript('/bitrix/js/bx_ichannels/jquery-1.7.2.min.js');
$APPLICATION->SetAdditionalCSS('/bitrix/js/bx_ichannels/css/rss_edit.css');

$aTabs = array(
	array(
		'DIV' => 'tab1',
		'TAB' => '����� �������',
		'ICON' => '',
		'TITLE' => '����� �������',
	),
);
if ($new) $aTabs[0]['TITLE'] = '����� ����� �������';

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$tabControl->Begin();
$tabControl->BeginNextTab();
?>

<form action="" method="post">

	<input type="hidden" name="form_id" id="form_id" value="ichannels_edit_rss_channel" />

	<input type="hidden" name="channel_id" id="channel_id" value="<?=$id?>" />

	<tr class="heading">
		<td colspan="2" align="center">������ �����������</td>
	</tr>

	<tr>
		<td><label for="NAME">��� ������</label></td>
		<td><input type="text" id="NAME" name="NAME" class="strval strval-long" value="<?=$default['NAME']?>" /></td>
	</tr>

	<tr>
		<td><label for="URL">����� ������</label></td>
		<td><input type="text" id="URL" name="URL" class="strval strval-long" value="<?=$default['URL']?>" /></td>
	</tr>

	<tr class="heading">
		<td colspan="2" align="center">���� �����������</td>
	</tr>

	<tr>
		<td><label for='select-type'>��� ���������</label></td>
		<td>
			<select name='select-type' id='select-type' class="selectval">
					<option value="notype">--�������� ���--</option>
			</select>
		</td>
	</tr>

	<tr>
		<td>
			<label for="select-iblock">��������</label>
		</td>
		<td>
			<select name="select-iblock" id="select-iblock" class="selectval">
			</select>
		</td>
	</tr>

	<tr>
		<td>
			<label for="select-section">������ ���������</label>
		</td>
		<td>
			<select name="select-section" id="select-section" class="selectval">
			</select>
		</td>
	</tr>


	<? if ($default['IBLOCK_TYPE_ID'] != 'notype'): ?>
	<script type="text/javascript">
		$('#select-type').ajaxSuccess(function(event, request, options) {
			if (options.data == 'query=type') {
				$('#select-type').val("<?=$default['IBLOCK_TYPE_ID']?>").change();
			}
		});
		$('#select-iblock').ajaxSuccess(function(event, request, options) {
			if (options.data == 'query=iblock&iblock_type=<?=$default['IBLOCK_TYPE_ID']?>') {
				$('#select-iblock').val(<?=$default['IBLOCK_ID']?>).change();
			}
		});
		$('#select-section').ajaxSuccess(function(event, request, options) {
			if (options.data == 'query=section&iblock=<?=$default['IBLOCK_ID']?>') {
				$('#select-section').val(<?=$default['IBLOCK_SECTION_ID']?>);
			}
		});
	</script>
	<? endif; ?>
	
	<script type="text/javascript" src="/bitrix/js/bx_ichannels/select_iblock.js"></script>

	<tr class="heading">
		<td colspan="2" align="center">��������� �������</td>
	</tr>

	<tr>
		<td><label for="FREQUENCY">������� (� ��������)</label></td>
		<td><input type="text" name="FREQUENCY" id="FREQUENCY" class="intval" value="<?=$default['FREQUENCY']?>" /></td>
	</tr>

	<tr>
		<td><label for="select-mapper">���������� �����</label></td>
		<td>
			<select id="select-mapper" name="select-mapper" class="selectval" value="<?=$default['MAPPER']?>">
				<? foreach (CIChannels::getRssMappers() as $mapper): ?>
					<option id="<?=$mapper['id']?>"><?=$mapper['name']?></option>
				<? endforeach; ?>
			</select>
		</td>
	</tr>

<?
$tabControl->EndTab();
$tabControl->Buttons();
?>

<input type="submit" name="submit-save" id="submit-save" value="���������" />
<? if (!$new): ?>
<input type="submit" name="submit-delete" id="submit-delete" value="�������" />
<? endif; ?>
<h6 style="display:inline;"><a href="ichannels_rss_manager.php">� ������</a></h6>

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