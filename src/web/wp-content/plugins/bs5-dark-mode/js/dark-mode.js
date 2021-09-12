jQuery(function ($) {

    //Create the cookie object
    var cookieStorage = {
        setCookie: function setCookie(key, value, time, path) {
            var expires = new Date();
            expires.setTime(expires.getTime() + time);
            var pathValue = '';
            if (typeof path !== 'undefined') {
                pathValue = 'path=' + path + ';';
            }
            document.cookie = key + '=' + value + ';' + pathValue + 'expires=' + expires.toUTCString();
        },
        getCookie: function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        },
        removeCookie: function removeCookie(key) {
            document.cookie = key + '=; Max-Age=0; path=/';
        }
    };

    //Click on dark-mode switch. Add dark-theme classto body. Store user preference through sessions
    $('#dark-mode').click(function () {
        //Show either moon or sun
        $('#dark-mode').toggleClass('active');
        //If dark mode is selected
        if ($('#dark-mode').hasClass('active')) {
            //Add dark mode class to the body
            $('body').addClass('dark-theme');
            cookieStorage.setCookie('bS-Dark-Mode', 'true', 2628000000, '/');
        } else {
            $('body').removeClass('dark-theme');
            setTimeout(function () {
                cookieStorage.removeCookie('bS-Dark-Mode');
            }, 100);
        }
    })

    //Check Storage. Display user preference 
    if (cookieStorage.getCookie('bS-Dark-Mode')) {
        $('body').addClass('dark-theme');
        $('#dark-mode').addClass('active');
        $('#dark-mode').prop('checked', true);
    }
});