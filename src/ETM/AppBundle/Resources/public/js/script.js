$(document).ready(function() {

    var iataCodes = [];

    var $originLocation = $('#originLocation');
    var $destinationLocation = $('#destinationLocation');
    var $departureDate = $('#departureDate');
    var $passengerType = $('#passengerType');
    var $passengerQuantity = $('#passengerQuantity');
    var $doAirFareRQ = $('#doAirFareRQ');

    var $originLocationGroup = $('#originLocationGroup');
    var $destinationLocationGroup = $('#destinationLocationGroup');
    var $departureDateGroup = $('#departureDateGroup');
    var $passengerQuantityGroup = $('#passengerQuantityGroup');

    var requestId;

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

    var timerId;

    function getSearchResult() {
        $.getJSON('get_request_result/' + requestId, function (data) {
            if (data.Success !== undefined && data.Success.Code === 0) {
                clearInterval(timerId);
                enableSearchButton();
                window.location.href = 'output_result/' + requestId;
            }
        });
    }

    function blockSearchButton() {
        $doAirFareRQ.text('Searching...');
        $doAirFareRQ.prop('disabled', true);
    }

    function enableSearchButton() {
        $doAirFareRQ.text('Search');
        $doAirFareRQ.attr('disabled', false);
    }

    function validate() {
        if ($originLocation.val() === '') {
            $originLocationGroup.addClass('has-error');
            $originLocation.focus();
            return false;
        }

        if ($destinationLocation.val() === '') {
            $destinationLocationGroup.addClass('has-error');
            $destinationLocation.focus();
            return false;
        }

        if ($departureDate.val() === '') {
            $departureDateGroup.addClass('has-error');
            $departureDate.focus();
            return false;
        }

        if ($passengerQuantity.val() === '') {
            $passengerQuantityGroup.addClass('has-error');
            $passengerQuantity.focus();
            return false;
        }

        removeErrorClasses();

        return true;
    }

    function removeErrorClasses() {
        $originLocationGroup.removeClass('has-error');
        $destinationLocationGroup.removeClass('has-error');
        $departureDateGroup.removeClass('has-error');
        $passengerQuantityGroup.removeClass('has-error');
    }

    $doAirFareRQ.click(function() {

        if (validate()) {

            blockSearchButton();

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
                    requestId = response.RequestId;
                    timerId = setInterval(getSearchResult, 1000);
                }
            });
        }
    });
});
