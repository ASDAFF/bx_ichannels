;(function(){

	$.ajaxSetup({
		url: '/bitrix/admin/ichannels_iblock.php',
		type: 'POST',
	});

	$.ajax({
		data: {
			query: 'type',
		},
		success: function(result) {
			$('#select-type').append(result);
		}
	});

	$('#select-type')
	.on('change', function() {
		$.ajax({
			data: {
				query: 'iblock',
				iblock_type: $(this).val()
			},
			success: function(result) {
				$('#select-iblock')
				.html(result)
				.change();
			}
		});
	});

	$('#select-iblock')
	.on('change', function() {
		$.ajax({
			data: {
				query: 'section',
				iblock: $(this).val()
			},
			success: function(result) {
				$('#select-section')
				.html(result)
				.change();
			}
		});
	});

})();