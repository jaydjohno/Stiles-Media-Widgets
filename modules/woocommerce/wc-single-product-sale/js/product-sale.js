;(function($)
{
    "use strict";

    // Countdown
    var finalTime, daysTime, hours, minutes, second;
    $('.sm-product-countdown').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown');
        var customlabel = $(this).data('customlabel');
        $this.countdown(finalDate, function(event) 
        {
            $this.html(event.strftime('<div class="cd-single"><div class="cd-single-inner"><h3>%D</h3><p>' + customlabel.daytxt + '</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%H</h3><p>' + customlabel.hourtxt + '</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%M</h3><p>' + customlabel.minutestxt + '</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%S</h3><p>' + customlabel.secondstxt + '</p></div></div>'));
        });
    });

})(jQuery);