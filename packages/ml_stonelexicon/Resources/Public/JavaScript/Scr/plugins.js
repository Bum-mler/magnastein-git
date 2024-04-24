// Funktion zum Behandeln des Klicks auf einen Farbbutton
function handleColorButtonClick(color) {
    // AJAX-Aufruf, um die ausgewählte Farbe zu senden
    var controllerUrl = $('#searchForm input[name="controllerUrl"]').val();
    $.ajax({
        method: 'POST',
        url: controllerUrl,
        data: {
            searchColor: color
        },
        success: function (response) {
            console.log('Erfolgreiche Antwort:', response);
        },
        error: function (error) {
            console.error('Fehlerhafte AJAX-Antwort:', error);
        }
    });
}

// jQuery verwenden, um Farbbuttons zu aktualisieren
$(document).ready(function() {
    // Funktion zum Markieren des ausgewählten Farbbuttons
    function updateColorButtons() {
        var searchColor = '{searchColor|raw}';
        console.log('searchColor:', searchColor);
        if (searchColor !== 'null') {
            // Markieren Sie den ausgewählten Farbbutton
            $('.btn-lexikon').removeClass('active');
            $('.btn-lexikon[value="' + searchColor + '"]').addClass('active');
        }
    }

    // Rufen Sie die Funktion beim Laden der Seite auf und immer wenn sich searchColor ändert
    updateColorButtons();
    $(document).on('change', 'input[name="searchColor"]', function() {
        var color = $(this).val();
        if (color !== null) {
            updateColorButtons();
            handleColorButtonClick(color);
        }
    });

    // Event Listener für onchange des Dropdowns hinzufügen
    $('#searchOrigin').change(function () {
        // Das Textsuchfeld leeren
        $('#searchString').val('');

        // Das Formular absenden
        $('#searchForm').submit();
    });

    // Event Listener für Änderungen im Farben-Dropdown
    $('#searchForm input[name="searchColor"]').change(function () {
        // Das Textsuchfeld leeren
        $('#searchString').val('');

        // Das Formular absenden
        $('#searchForm').submit();
    });
});
