document.addEventListener('DOMContentLoaded', function() {
	const citySelect = document.getElementById('uf-event-city-filter');

	if (citySelect) {
		citySelect.addEventListener('change', function () {
			const city = citySelect.value;

			const data = new FormData();
			data.append('action', 'uf_filter_events_by_city');
			data.append('city', city);

			fetch(ufEvents.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data,
      })
        .then((response) => response.text())
        .then((html) => {
          const eventsList = document.querySelector(".uf-widget-events");
          if (eventsList) eventsList.innerHTML = html;
        });
		});
	}
});
