<?
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_admin_after.php');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$id = intval($id);

$new = false;

if ($id == 0) {
	$new = true;
} else {
	//
}

if (array_key_exists('form_id', $_POST) && $_POST['form_id'] == 'ichannels_edit_rss_channel') {
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
		'TITLE' => '����� ����� �������',
	),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

$tabControl->Begin();
$tabControl->BeginNextTab();
?>

<form action="" method="post">

	<input type="hidden" name="form_id" id="form_id" value="ichannels_edit_rss_channel" />

	<tr class="heading">
		<td colspan="2" align="center">������ �����������</td>
	</tr>

	<tr>
		<td><label for="channel_name">��� ������</label></td>
		<td><input type="text" id="channel_name" name="channel_name" class="strval strval-long" value="" /></td>
	</tr>

	<tr>
		<td><label for="channel_url">����� ������</label></td>
		<td><input type="text" id="channel_url" name="channel_url" class="strval strval-long" value="" /></td>
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

	<script type="text/javascript" src="/bitrix/js/bx_ichannels/select_iblock.js"></script>

	<tr class="heading">
		<td colspan="2" align="center">��������� �������</td>
	</tr>

	<tr>
		<td><label for="import_frequency">������� (� ��������)</label></td>
		<td><input type="text" name="import_frequency" id="import_frequency" value="86400" class="intval" /></td>
	</tr>

	<tr>
		<td><label for="select-mapper">���������� �����</label></td>
		<td>
			<select id="select-mapper" name="select-mapper" class="selectval">
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

<input type="submit" name="submit" id="submit" value="���������" />

<?
$tabControl->End();
?>

</form>

<?
require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');
?>