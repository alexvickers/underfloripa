(function ($) {
  function updateLabels(mediaVal) {
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
    if (!selected) return;

    const albumField = acf.getField('field_67ddda75cb96c');
    const artistField = acf.getField('field_67ddda99cb96d');
    const labelField = acf.getField('field_67dddaa8cb970');

    if (albumField) albumField.$el.find('.acf-label label').text(selected.album_name);
    if (artistField) artistField.$el.find('.acf-label label').text(selected.artist_name);
    if (labelField) labelField.$el.find('.acf-label label').text(selected.record_label);
  }

  acf.addAction('ready', function () {
    const field = acf.getField('field_67f2e62b647ba');
    if (field) {
      updateLabels(field.val());
    }
  });

  acf.addAction('change_value/key=field_67f2e62b647ba', function (value) {
    updateLabels(value);
  });
})(jQuery);
