(function ($) {
  function updateLabels() {
    const mediaVal = $('[data-key="field_XXXXXX"] select').val(); // media_type

    const labels = {
      Album: {
        album_name: "Álbum",
        artist_name: "Artista",
        record_label: "Gravadora",
      },
      Movie: {
        album_name: "Filme",
        artist_name: "Diretor",
        record_label: "Estúdio",
      },
      Book: {
        album_name: "Livro",
        artist_name: "Autor",
        record_label: "Editora",
      },
    };

    const selected = labels[mediaVal];
    if (selected) {
      $('[data-key="album_name"] .acf-label label').text(selected.album_name);
      $('[data-key="artist_name"] .acf-label label').text(
        selected.artist_name
      );
      $('[data-key="record_label"] .acf-label label').text(
        selected.record_label
      );
    }
  }

  acf.addAction("ready", updateLabels);
  acf.addAction("change", function (el) {
    if ($(el).attr("name") === "acf[media_type]") {
      updateLabels();
    }
  });
})(jQuery);
