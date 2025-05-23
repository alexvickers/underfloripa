jQuery(document).ready(function ($) {
	$('#city-filter-dropdown').on('change', function () {
		const cityId = $(this).val();

		$.ajax({
			url: ufEventAjax.ajax_url,
			type: 'POST',
			data: {
				action: 'uf_filter_events_by_city',
				city_id: cityId,
				nonce: ufEventAjax.nonce
			},
			success: function (response) {
				if (response.success && response.data.html) {
					$('.uf-widget-events').html(response.data.html);
				}
			}
		});
	});
});
