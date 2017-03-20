var dateArray = [];
$(function() {
    var d = new Date();
    $('#start_date').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: d,
        onSelect: function () {
            var endDate = $('#end_date');
            var date = $(this).datepicker('getDate');
            endDate.datepicker('setDate', date);
            endDate.datepicker('option', 'minDate', date);
        },
        beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [$.inArray(string, dateArray) == -1];
        }
    });
    $('#end_date').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: d,
        beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [$.inArray(string, dateArray) == -1];
        }
    });
    //Calendar Table
    $('.calendar').on('click', 'td.free, td.booked', function () {
        var apartmentId = $(this).parents('tr').attr('data-attr-apartment_id'),
            date = $(this).attr('data-attr-date');
        if ($(this).hasClass('free')) {
            location.href = '/bookings/create/' + apartmentId + '/' + date;
        } else {
            var bookingId = $(this).attr('data-attr-booking_id');
            location.href = '/bookings/edit/' + bookingId;
        }
    });
    //Bookings Table
    $('.bookings').on('click', 'tr', function () {
        var bookingId = $(this).attr('data-attr-booking_id');
        if (!bookingId) {
            return;
        }
        location.href = '/bookings/edit/' + bookingId;
    });
    //Apartments Table
    $('.apartments').on('click', '.delete', function () {
        var apartmentId = $(this).attr('data-attr-apartment_id');
        if (apartmentId) {
            if (confirm("Do you want to delete this apartment?")) {
                location.href = '/apartments/delete/' + apartmentId;
            }
        }
    });
    //Fairs Table
    $('.fairs').on('click', '.delete', function () {
        var fairId = $(this).attr('data-attr-fair_id');
        if (fairId) {
            if (confirm("Do you want to delete this fair?")) {
                location.href = '/fairs/delete/' + fairId;
            }
        }
    });
    //fair create form
    var fairCreateForm = $('.create-fair');
    if (fairCreateForm.length) {

    }
    //booking create form
    var bookingCreateForm = $('.create-booking');
    if (bookingCreateForm.length) {
        $(bookingCreateForm).ready(function() {
            $(document).trigger('apartments-get-price');
            $(document).trigger('apartments-get-booked-dates', [$('#apartment').val()]);
        });
        $('#apartment, #start_date, #end_date').on('change', function () {
            $(document).trigger('apartments-get-price');
            if ($(this).attr('id') == 'apartment') {
                $(document).trigger('apartments-get-booked-dates', [$(this).val()]);
            }
        });
    }
    $(document).on('apartments-get-booked-dates', function (ev, apartmentId) {
        $.get(
            '/apartments/getBookedDates',
            {"apartmentId": apartmentId},
            function (response) {
                if (response.success) {
                    window.dateArray = response.dateArray;
                }
            },
            'json'
        );
    });
    $(document).on('apartments-get-price', function () {
        var data = {
            'apartment_id' : $('#apartment').val(),
            'start_date' : $('#start_date').val(),
            'end_date' : $('#end_date').val()
        };
        $.post(
            '/apartments/getPrice',
            data,
            function (response) {
                if (response.success) {
                    $('#calculated_price').html(response.price);
                    $('#calc_text').html(response.priceText);
                    $('#to_pay').val(response.price);
                    $('#to_pay_show').val(response.price);
                } else {
                    alert(response.error);
                }
            },
            'json'
        );
    });

    $('.search').on('click', '#search', function() {
        $(document).trigger('search');
    });

    $('.search').on('keyup', '[name="search"]', function(ev) {
        if (ev.keyCode == '13') {
            $(document).trigger('search');
        }
    });
    $('.buttons').on('click', '#cancel', function() {
        history.back();
    });
    $(document).on('search', function () {
        var search = $('[name="search"]').val().trim();
        if (!search) {
            return;
        }
        location.href = '/bookings/search/?search=' + search;
    });
    $(document).on('show-loading', function() {
        if (!$("#loading").length) {
            $(document).append('<div id="loading"><div></div></div>');
        }
    });
    $(document).on('hide-loading', function() {
        if ($("#loading").length) {
            $("#loading").remove();
        }
    });
});
