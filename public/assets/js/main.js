$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//Select 2 initiate
$('select.select2').select2();
$("select.select2NoSearch").select2({
    minimumResultsForSearch: Infinity
});

function fa_icon_format(icon) {
    var originalOption = icon.element;
    return '<i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text;
}
$("select.select2icon").select2({
    formatResult: fa_icon_format
});


//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

/**
 * URL Encode Function
 * @param str
 * @returns {string}
 */
function rawurlencode(str) {
    str = (str + '').toString();
    return encodeURIComponent(str)
        .replace(/!/g, '%21')
        .replace(/'/g, '%27')
        .replace(/\(/g, '%28')
        .replace(/\)/g, '%29')
        .replace(/\*/g, '%2A');
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Make Sticky menu
 */

var make_sticky_menu = function () {
    if ($(document).scrollTop() > 52) {
        $('.navbar-static-top').addClass('sticky-menu');
    }
    else {
        $('.navbar-static-top').removeClass('sticky-menu');
    }
};
$(document).bind('scroll', make_sticky_menu);

function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}


$(document).ready(function () {
    var countDownWrap = $('.countdown');

    if (countDownWrap.length) {
        var i;
        for (i = 0; i < countDownWrap.length; i++) {
            var countDownItem = countDownWrap[i];

            var endtime = countDownItem.getAttribute('data-expire-date');

            if (endtime) {
                var timeinterval = setInterval(function (countDownItem, endtime) {
                    var t = getTimeRemaining(endtime);
                    var clockHtml = '<b>' + jsonData.time_remaining + '</b> ' + t.days + ' days ' + t.hours + ':' + t.minutes + ':' + t.seconds;

                    $(countDownItem).html(clockHtml);
                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                        $(countDownItem).html('Expired');
                    }
                }, 1000, countDownItem, endtime);
            } else {
                $(countDownItem).html('Always open');
            }
        }
    }
});