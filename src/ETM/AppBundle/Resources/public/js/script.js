$(document).ready(function() {

    var iataCodes = [];

    var $originLocation = $('#originLocation');
    var $destinationLocation = $('#destinationLocation');
    var $departureDate = $('#departureDate');
    var $passengerType = $('#passengerType');
    var $passengerQuantity = $('#passengerQuantity');

    $.getJSON('/iata.json', function(data) {
        $.each(data, function (key, value) {
            iataCodes.push({label: value.name, value: value.iata});
        });
    });

    $.getJSON('/passenger_types.json', function (data) {
        $.each(data, function (key, value) {
            var $option = $(document.createElement('option'));
            $option.val(key);
            $option.text(value);

            $passengerType.append($option);
        });
    });


    $departureDate.datepicker({dateFormat: 'dd/mm/yy'});

    $originLocation.autocomplete({
        source: iataCodes,
        delay: 300,
        minLength: 2
    });
    $destinationLocation.autocomplete({
        source: iataCodes,
        delay: 300,
        minLength: 2
    });

    $('#doAirFareRQ').click(function() {
        $.ajax({
            type: 'POST',
            url: 'add_search_request',
            data: {
                from: $originLocation.val(),
                to: $destinationLocation.val(),
                departure_date: $departureDate.val(),
                passenger_type: $passengerType.val(),
                passenger_quantity: $passengerQuantity.val()
            },
            success: function(response) {

            }
        });
    });
});