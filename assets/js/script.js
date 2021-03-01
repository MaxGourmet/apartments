var dateArray = [];
$(function () {
    if ($('.month').length > 0) {
        $('.month').prev('h1').hide();
    }
    var d = new Date();
    $('#start_date').datepicker({
        dateFormat: "dd.mm.yy",
        minDate: d,
		firstDay: 1,
        onSelect: function () {
            var endDate = $('#end_date');
            var date = $(this).datepicker('getDate');
            endDate.datepicker('setDate', date);
            endDate.datepicker('option', 'minDate', date);
        },
        beforeShowDay: function (date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [$.inArray(string, dateArray) == -1];
        }
    });
    $('#end_date').datepicker({
        dateFormat: "dd.mm.yy",
        minDate: d,
		firstDay: 1,
        beforeShowDay: function (date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [$.inArray(string, dateArray) == -1];
        }
    });
    $('#last_clean_date').datepicker({
        dateFormat: "dd.mm.yy",
		firstDay: 1,
        maxDate: d
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
    $('.bookings').on('click', 'tr', function (e) {
        if ($(e.target).hasClass('payed_confirm')) {
            return;
        }
        var bookingId = $(this).attr('data-attr-booking_id');
        if (!bookingId) {
            return;
        }
        location.href = '/bookings/edit/' + bookingId;
    });
    $('.bookings').on('click', '.payed_confirm', function () {
        var data = $(this).data();
        if (typeof data['id'] == 'undefined') {
            return;
        }
        var el = $(this).parent(),
            to_pay = $(el).siblings('.to_pay'),
            payed = $(el).siblings('.payed'),
            diff = $(el).siblings('.diff');
        if (confirm('Do you want to confirm payment?')) {
            $(document).trigger('show-loading');
            $(payed).html($(to_pay).html());
            $(diff).html("0");
            $.post(
                '/bookings/confirmPayment',
                data,
                function() {
                    $(document).trigger('hide-loading');
                    location.reload();
                },
                'json'
            );
        }
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
    //Customers Table
    $('.customers').on('click', '.delete', function () {
        var customer_id = $(this).attr('data-attr-customer_id');
        if (customer_id) {
            if (confirm("Do you want to delete this customer?")) {
                location.href = '/customers/delete/' + customer_id;
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
        $(bookingCreateForm).ready(function () {
            if ($('[name="id"]').length == 0) {
                $(document).trigger('apartments-get-price');
            }
            $(document).trigger('apartments-get-booked-dates', [$('#apartment').val(), $('[name="id"]').val()]);
        });
        $('#apartment, #start_date, #end_date').on('change', function () {
            var data = {
                'apartment_id': $('#apartment').val(),
                'start_date': $('#start_date').val(),
                'end_date': $('#end_date').val(),
                'people_count': parseInt($('[name="people_count"]:checked').val())
            };
            if (typeof window.totalPeopleCount != 'undefined' && typeof window.totalPeopleCount[data.apartment_id] != 'undefined') {
                var newCount = parseInt(window.totalPeopleCount[data.apartment_id]),
                    oldCount = $('[name="people_count"]').length,
                    newPeopleCount = newCount >= data.people_count ? data.people_count : newCount;
                newCount = newCount > 1 ? newCount : 1;
                if (newCount < oldCount) {
                    for (var i = newCount + 1; i <= oldCount; i++) {
                        $('span.people_count' + i).remove();
                    }
                } else if (newCount > oldCount) {
                    var original = $('span.people_count1');
                    for (var i = oldCount + 1; i <= newCount; i++) {
                        var clone = $(original).clone();
                        $(clone).attr('class', 'people_count' + i);
                        $(clone).find('input').attr('id', 'people_count' + i);
                        $(clone).find('input').val(i);
                        $(clone).find('label').attr('for', 'people_count' + i);
                        $(clone).find('label').html(i);
                        $(original).parent().append(clone);
                    }
                }
                $('#people_count' + newPeopleCount).click();
            }
            $(document).trigger('apartments-get-price');
            if ($(this).attr('id') == 'apartment') {
                $(document).trigger('apartments-get-booked-dates', [$(this).val(), $('[name="id"]').val()]);
            }
        });
        $(bookingCreateForm).on('click', '[name="people_count"]', function () {
            $(document).trigger('apartments-get-price');
        });
        $(bookingCreateForm).on('click', '#payed_confirm', function () {
            var toPay = parseFloat($('#to_pay').val()),
                alreadyPayed = parseFloat($('#payed').val()),
                newAlreadyPayed = 0;
            if (toPay > alreadyPayed) {
                newAlreadyPayed = toPay - alreadyPayed;
                $('#payed').val(newAlreadyPayed);
                if (confirm('Do you want to confirm payment?')) {
                    $('#submit').click();
                } else {
                    $('#payed').val(alreadyPayed);
                }
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
            'apartment_id': $('#apartment').val(),
            'start_date': $('#start_date').val(),
            'end_date': $('#end_date').val(),
            'people_count': parseInt($('[name="people_count"]:checked').val())
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

    $('.search').on('click', '#search', function () {
        $(document).trigger('search');
    });

    $('.search').on('keyup', '[name="search"]', function (ev) {
        if (ev.keyCode == '13') {
            $(document).trigger('search');
        }
    });
    $('.buttons').on('click', '#cancel', function () {
        history.back();
    });
    $(document).on('search', function () {
        var search = $('[name="search"]').val().trim();
        if (!search) {
            return;
        }
        location.href = '/bookings/search/?search=' + search;
    });
    $(document).on('show-loading', function () {
        if (!$("#loading").length) {
            $('body').append('<div id="loading"><div></div></div>');
        }
    });
    $(document).on('hide-loading', function () {
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

    $('.month').on('click', 'a', function () {
        var href = $(this).attr('data-attr-href');
        if (href) {
            location.href = href;
        }
    });

    function do_nothing() {
        return false;
    }
    $('.calendar tr th.date, .floatThead-table tr th').live('click touchstart', function(e) {
        $(e.target).click(do_nothing);
        setTimeout(function(){
            $(e.target).unbind('click touchstart', do_nothing);
        }, 500);
        // alert('some text');
        var cellIndex = $(this).index() + 1;
        if(($('.calendar th.date.marked-start').length < 1 && $('.calendar th.date.marked-end').length < 1) || ($('.calendar th.date.marked-start').length > 0) && $('.calendar th.date.marked-end').length > 0 ) {
            $('tfoot th').removeClass('marked-start marked-end marked');
            $(this).closest('.calendar-wrap').find('tfoot th:nth-child(' + cellIndex + ')').addClass('marked-start');
        } else if(($('.calendar th.date.marked-start').length > 0 && $('.calendar th.date.marked-end').length < 1)) {
            if($('tfoot th.marked-start').index() > cellIndex) {
                $(this).closest('.calendar-wrap').find('tfoot th.marked-start').removeClass('marked-start').addClass('marked-end');
                $(this).closest('.calendar-wrap').find('tfoot th:nth-child(' + cellIndex + ')').addClass('marked-start');
                $(this).closest('.calendar-wrap').find('tfoot th.marked-start').nextUntil('.marked-end').addClass('marked');
            } else if(cellIndex === $(this).closest('.calendar-wrap').find('tfoot th.marked-start').index() + 1) {
                $('tfoot th').removeClass('marked-start marked-end marked');
            } else {
                $(this).closest('.calendar-wrap').find('tfoot th:nth-child(' + cellIndex + ')').addClass('marked-end');
                $(this).closest('.calendar-wrap').find('tfoot th.marked-start').nextUntil('.marked-end').addClass('marked');
            }
        }
    });

    $('.calendar tbody tr td:first-child, .calendar tbody tr td:last-child').live('click touchstart', function(e) {
        $(e.target).click(do_nothing);
        setTimeout(function(){
            $(e.target).unbind('click touchstart', do_nothing);
        }, 500);
        var rowIndex = $(this).closest('tr').index() + 1;
        if(($('.calendar tr.marked-start').length < 1 && $('.calendar tr.marked-end').length < 1) || ($('.calendar tr.marked-start').length > 0) && $('.calendar tr.marked-end').length > 0){
            $('tbody tr').removeClass('marked-start marked-end marked');
            $(this).closest('tbody').find('tr:nth-child(' + rowIndex + ')').addClass('marked-start');
        } else if(($('.calendar tr.marked-start').length > 0 && $('.calendar tr.marked-end').length < 1)) {
            if($('tbody tr.marked-start').index() > rowIndex) {
                $(this).closest('tbody').find('tr.marked-start').removeClass('marked-start').addClass('marked-end');
                $(this).closest('tbody').find('tr:nth-child(' + rowIndex + ')').addClass('marked-start');
                $(this).closest('tbody').find('tr.marked-start').nextUntil('.marked-end').addClass('marked');
            } else if(rowIndex === $(this).closest('.calendar-wrap').find('tr.marked-start').index() + 1) {
                $('tbody tr').removeClass('marked-start marked-end marked');
            } else {
                $(this).closest('tbody').find('tr:nth-child(' + rowIndex + ')').addClass('marked-end');
                $(this).closest('tbody').find('tr.marked-start').nextUntil('.marked-end').addClass('marked');
            }
        }
    });

    function detectswipe(el,func) {
        swipe_det = new Object();
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
        var min_x = 250;  //min x swipe for horizontal swipe
        var max_x = 40;  //max x difference for vertical swipe
        var min_y = 40;  //min y swipe for vertical swipe
        var max_y = 50;  //max y difference for horizontal swipe
        var direc = "";
        var ele = document.getElementById(el);
        ele.addEventListener('touchstart',function(e){
            //console.log(e);return;
            var t = e.touches[0];
            swipe_det.sX = t.screenX;
            swipe_det.sY = t.screenY;
        },false);
        //ele.addEventListener('touchmove',function(e){
        //    // e.preventDefault();
        //},false);
        ele.addEventListener('touchend',function(e){
            //console.log(e);return;
            var t = e.changedTouches[0];
            swipe_det.eX = t.screenX;
            swipe_det.eY = t.screenY;
            //horizontal detection
            if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y)))) {
                if(swipe_det.eX > swipe_det.sX) direc = "r";
                else direc = "l";
            }

            if (direc != "") {
                if(typeof func == 'function') func(el,direc);
            }
            direc = "";
        },false);
    }

    detectswipe('body',function (el,d) {
        var href = '';
        if(d === 'l'){
            href = $('#next_month').attr('data-attr-href');
        } else if(d === 'r'){
            href = $('#prev_month').attr('data-attr-href');
        }
        if (href)  {
            location.href = href;
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
                var td = $(calendarTable).find('td[data-attr-booking_id=' + bookingId + ']'),
                    firstPosition = false,
                    tdIndexToDelte = [];
                for (var i = 0; i < td.length; i++) {
                    if ($(td[i]).hasClass('first-day') || $(td[i]).hasClass('last-day')) {
                        continue;
                    }
                    if (firstPosition === false) {
                        firstPosition = i;
                    } else {
                        tdIndexToDelte.push(i);
                    }
                }
                var cnt = tdIndexToDelte.length,
                    width = $(td[0]).width();
                for (var k in tdIndexToDelte) {
                    if (!tdIndexToDelte.hasOwnProperty(k)) {
                        continue;
                    }
                    $(td[tdIndexToDelte[k]]).remove();
                }
                $(td[firstPosition]).attr('colspan', cnt + 1);
                //text.substr(0, 4*(cnt + 1));
                $(td[firstPosition]).html("<div class='booking_info'>" + text + "</div>");
                $(td[firstPosition]).find('.booking_info').width(width * (cnt + 1));
            }
        }
        if (typeof fairs != undefined) {
            for (var fairId in fairs) {
                if (!fairs.hasOwnProperty(fairId)) {
                    continue;
                }
                var text = fairs[fairId].trim();
                if (text == '') {
                    continue;
                }
                var td = $(calendarTable).find('td[data-fair-id=' + fairId + ']'),
                    firstPosition = false,
                    tdIndexToDelte = [];
                for (var i = 0; i < td.length; i++) {
                    if (firstPosition === false) {
                        firstPosition = i;
                    } else {
                        tdIndexToDelte.push(i);
                    }
                }
                var cnt = tdIndexToDelte.length,
                    width = $(td[0]).width();
                for (var k in tdIndexToDelte) {
                    if (!tdIndexToDelte.hasOwnProperty(k)) {
                        continue;
                    }
                    $(td[tdIndexToDelte[k]]).remove();
                }
                $(td[firstPosition]).attr('colspan', cnt + 1);
                //text.substr(0, 4*(cnt + 1));
                $(td[firstPosition]).html("<div class='fair_info'>" + text + "</div>");
                $(td[firstPosition]).find('.fair_info').width(width * (cnt + 1));
            }
        }
    }

    var $table = $('table.calendar');
    $table.floatThead({
        top: 66,
        scrollContainer: function ($table) {
            return $table.closest('.inner');
        },
        position: 'absolute'
    });

    $('.apartments .sort').on('click', function () {
    	var orderDirection = $(this).data('order'),
			newDirection = orderDirection === 'asc' ? 'desc' : 'asc',
			orderElement = $(this).data('element'),
			sign = orderDirection === 'asc' ? 1 : -1;
		$(this).data('order', newDirection);
		var rows = $('.apartment-entity');
		rows.sort(function (rowA, rowB) {
			var v1 = $(rowA).find("td[data-sort='" + orderElement + "']")[0].innerText,
				v2 = $(rowB).find("td[data-sort='" + orderElement + "']")[0].innerText;

			if (orderElement == 'days') {
				v1 = v1 == '' ? 0 : parseInt(v1);
				v2 = v2 == '' ? 0 : parseInt(v2);
			}

			return v1 > v2 ? sign : sign * (-1);
		});
		$('.apartments tbody').append(rows);
	});
	$(document).on('click', '.update-customer-list', function (ev) {
		$(document).trigger('show-loading');
		$.get(
			'/customers/updateCustomersList',
			{},
			function (response) {
				$(document).trigger('hide-loading');
				if (response.success) {
					$('#customer_id').empty();
					$.each(response.customers, function(key,value) {
						$('#customer_id').append($("<option></option>")
							.attr("value", value).text(key));
					});
				}
			},
			'json'
		);
	});
});
