$(function() {
    $('#start_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('#end_date').datepicker({
        dateFormat: "yy-mm-dd"
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
        });
        $('#apartment, #start_date, #end_date').on('change', function () {
            $(document).trigger('apartments-get-price');
        });
    }
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
});
