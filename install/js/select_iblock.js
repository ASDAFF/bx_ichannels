var ichannels = (function() {

	function update_types() {
		$.ajax({
			data: {
				query: 'type',
			},
			success: function(result) {
				$('#select-type')
				.append(result)
				.change();
			}
		});
	}

	function update_iblocks() {
		$.ajax({
			data: {
				query: 'iblock',
				iblock_type: $('#select-type').val()
			},
			success: function(result) {
				$('#select-iblock')
				.html(result)
				.change();
			}
		});
	}

	function update_sections() {
		$.ajax({
			data: {
				query: 'section',
				iblock: $('#select-iblock').val()
			},
			success: function(result) {
				$('#select-section')
				.html(result)
				.change();
			}
		});
	}

	return {
		update_types: update_types,
		update_iblocks: update_iblocks,
		update_sections: update_sections,
	};

})();

;(function(){

	$.ajaxSetup({
		url: '/bitrix/admin/ichannels_iblock.php',
		type: 'POST',
	});

	ichannels.update_types();

	$('#select-type')
	.on('change', function() {
		ichannels.update_iblocks();
	});

	$('#select-iblock')
	.on('change', function() {
		ichannels.update_sections();
	});

})();
