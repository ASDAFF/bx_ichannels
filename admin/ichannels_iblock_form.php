	<!-- begin iblock settings form fragment -->

	<? $APPLICATION->AddHeadScript('/bitrix/js/bx_ichannels/jquery-1.7.2.min.js'); ?>
	
	<tr>
		<td><label for='select-type'>Тип инфоблока</label></td>
		<td>
			<select name='select-type' id='select-type' class="selectval">
					<option value="notype">--Выберите тип--</option>
			</select>
		</td>
	</tr>

	<tr>
		<td>
			<label for="select-iblock">Инфоблок</label>
		</td>
		<td>
			<select name="select-iblock" id="select-iblock" class="selectval">
			</select>
		</td>
	</tr>

	<tr>
		<td>
			<label for="select-section">Раздел инфоблока</label>
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

	<!-- end iblock settings form fragment -->