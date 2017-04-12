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
    //Fairs Table
    $('.create-booking').on('click', '#delete', function () {
        var bookingId = $('[name="id"]').val();
        if (bookingId) {
            if (confirm("Do you want to delete this booking?")) {
                location.href = '/bookings/delete/' + bookingId;
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
            $(document).trigger('apartments-get-booked-dates', [$('#apartment').val(), $('[name="id"]').val()]);
        });
        $('#apartment, #start_date, #end_date').on('change', function () {
            $(document).trigger('apartments-get-price');
            if ($(this).attr('id') == 'apartment') {
                $(document).trigger('apartments-get-booked-dates', [$(this).val(), $('[name="id"]').val()]);
            }
        });
    }
    $(document).on('apartments-get-booked-dates', function (ev, apartmentId, bookingId) {
        $(document).trigger('show-loading');
        $.get(
            '/apartments/getBookedDates',
            {"apartmentId": apartmentId, "bookingId": bookingId},
            function (response) {
                $(document).trigger('hide-loading');
                if (response.success) {
                    window.dateArray = response.dateArray;
                }
            },
            'json'
        );
    });
    $(document).on('apartments-get-price', function () {
        $(document).trigger('show-loading');
        var data = {
            'apartment_id' : $('#apartment').val(),
            'start_date' : $('#start_date').val(),
            'end_date' : $('#end_date').val()
        };
        $.post(
            '/apartments/getPrice',
            data,
            function (response) {
                $(document).trigger('hide-loading');
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
            $('body').append('<div id="loading"><div></div></div>');
        }
    });
    $(document).on('hide-loading', function() {
        if ($("#loading").length) {
            $("#loading").remove();
        }
    });

    //Скрывам дропдауны по клику вне списков
    $('body').click(function () {
        $('#menu-trigger').prop('checked', false);
    });
    $(".menu,#menu-trigger-label,#menu-trigger").click(function (e) {
        e.stopPropagation();
    });

    $('.month').on('click', 'a', function() {
        var href = $(this).attr('data-attr-href');
        if (href)  {
            location.href = href;
        }
    });

    function detectswipe(el,func) {
        swipe_det = new Object();
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
        var min_x = 20;  //min x swipe for horizontal swipe
        var max_x = 40;  //max x difference for vertical swipe
        var min_y = 40;  //min y swipe for vertical swipe
        var max_y = 50;  //max y difference for horizontal swipe
        var direc = "";
        var ele = document.getElementById(el);
        ele.addEventListener('touchstart',function(e){
            var t = e.touches[0];
            swipe_det.sX = t.screenX;
            swipe_det.sY = t.screenY;
        },false);
        ele.addEventListener('touchmove',function(e){
            // e.preventDefault();
            var t = e.touches[0];
            swipe_det.eX = t.screenX;
            swipe_det.eY = t.screenY;
        },false);
        ele.addEventListener('touchend',function(e){
            //horizontal detection
            if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y)))) {
                if(swipe_det.eX > swipe_det.sX) direc = "r";
                else direc = "l";
            }
            //vertical detection
            if ((((swipe_det.eY - min_y > swipe_det.sY) || (swipe_det.eY + min_y < swipe_det.sY)) && ((swipe_det.eX < swipe_det.sX + max_x) && (swipe_det.sX > swipe_det.eX - max_x)))) {
                if(swipe_det.eY > swipe_det.sY) direc = "d";
                else direc = "u";
            }

            if (direc != "") {
                if(typeof func == 'function') func(el,direc);
            }
            direc = "";
        },false);
    }

    detectswipe('body',function (el,d) {
        if(d === 'l'){
            $('#next_month').click();
        } else if(d === 'r'){
            $('#prev_month').click();
        }
    });

    var calendarTable = $('table.calendar');
    if ($(calendarTable).length) {
        //var td = $(calendarTable).find('td[data-info]');
        //var currentId = 0,
        //    currentText = '';
        //for (var i = 0; i < td.length; i++) {
        //    if ($(td[i]).hasClass('first-day') || $(td[i]).hasClass('last-day')) {
        //        continue;
        //    }
        //    var bId = $(td[i]).attr('data-attr-booking_id');
        //}
        if (typeof bookingsInfo != undefined) {
            for (var bookingId in bookingsInfo) {
                if (!bookingsInfo.hasOwnProperty(bookingId)) {
                    continue;
                }
                var text = bookingsInfo[bookingId].trim();
                if (text == '') {
                    continue;
                }
                var td = $(calendarTable).find('td[data-attr-booking_id='+ bookingId +']');
                for (var i = 0; i < td.length; i++) {
                    if ($(td[i]).hasClass('first-day') || $(td[i]).hasClass('last-day')) {
                        continue;
                    }
                    var pos = i-1;
                    if (!$(td[0]).hasClass('first-day')) {
                        pos = i;
                    }
                    var t = text.substr(4*(pos), 4);
                    //$(td[i]).html(t);
                }
            }
        }
    }
});
