(function($) {
    'use strict';
    $(document).ready(function (){
        var checkCountdownIsExists = $(document).find('#ays-prg-countdown-main-container');

        if ( checkCountdownIsExists.length > 0 ) {
            var second  = 1000,
                minute  = second * 60,
                hour    = minute * 60,
                day     = hour * 24;

            // var countdownEndTime = "DEC 31, 2022 23:59:59",
            var countdownEndTime = portfolioLangObj.prgBannerDate,
            countDown = new Date(countdownEndTime).getTime(),
            x = setInterval(function() {

                var now = new Date().getTime(),
                    distance = countDown - now;

                var countDownDays    = document.getElementById("ays-prg-countdown-days");
                var countDownHours   = document.getElementById("ays-prg-countdown-hours");
                var countDownMinutes = document.getElementById("ays-prg-countdown-minutes");
                var countDownSeconds = document.getElementById("ays-prg-countdown-seconds");

                if(countDownDays !== null || countDownHours !== null || countDownMinutes !== null || countDownSeconds !== null){
                    countDownDays.innerText = Math.floor(distance / (day)),
                    countDownHours.innerText = Math.floor((distance % (day)) / (hour)),
                    countDownMinutes.innerText = Math.floor((distance % (hour)) / (minute)),
                    countDownSeconds.innerText = Math.floor((distance % (minute)) / second);
                }

                //do something later when date is reached
                if (distance < 0) {
                    var headline  = document.getElementById("ays-prg-countdown-headline"),
                        countdown = document.getElementById("ays-prg-countdown"),
                        content   = document.getElementById("ays-prg-countdown-content");

                    // headline.innerText = "Sale is over!";
                    countdown.style.display = "none";
                    content.style.display = "block";

                    clearInterval(x);
                }
            }, 1000);
        }
    });
})(jQuery);