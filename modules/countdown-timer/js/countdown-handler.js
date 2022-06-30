(function ($) 
{
    var SMWCountDownHandler = function ($scope, $) 
    {
        var countDownElement = $scope.find(".countdown-timer").each(function () {
            var countDownSettings = $(this).data("settings");
            var label1 = countDownSettings["label1"],
                label2 = countDownSettings["label2"],
                newLabe1 = label1.split(","),
                newLabe2 = label2.split(",");
            if (countDownSettings["event"] === "onExpiry") {
                $(this).find(".countdown-timer-init").pre_countdown({
                    labels: newLabe2,
                    labels1: newLabe1,
                    until: new Date(countDownSettings["until"]),
                    format: countDownSettings["format"],
                    padZeroes: true,
                    timeSeparator: countDownSettings["separator"],
                    onExpiry: function () {
                        $(this).html(countDownSettings["text"]);
                    },
                    serverSync: function () {
                        return new Date(countDownSettings["serverSync"]);
                    }
                });
            } else if (countDownSettings["event"] === "expiryUrl") {
                $(this).find(".countdown-timer-init").pre_countdown({
                    labels: newLabe2,
                    labels1: newLabe1,
                    until: new Date(countDownSettings["until"]),
                    format: countDownSettings["format"],
                    padZeroes: true,
                    timeSeparator: countDownSettings["separator"],
                    expiryUrl: countDownSettings["text"],
                    serverSync: function () {
                        return new Date(countDownSettings["serverSync"]);
                    }
                });
            }
            times = $(this).find(".countdown-timer-init").pre_countdown("getTimes");

            function runTimer(el) {
                return el == 0;
            }
            if (times.every(runTimer)) {
                if (countDownSettings["event"] === "onExpiry") {
                    $(this).find(".countdown-timer-init").html(countDownSettings["text"]);
                }
                if (countDownSettings["event"] === "expiryUrl") {
                    var editMode = $("body").find("#elementor").length;
                    if (editMode > 0) {
                        $(this).find(".countdown-timer-init").html(
                            "<h1>You can not redirect url from elementor Editor!!</h1>");
                    } else {
                        window.location.href = countDownSettings["text"];
                    }
                }
            }
        });
    };
    
    $(window).on('elementor/frontend/init', function () 
    {
        if ( elementorFrontend.isEditMode() ) 
        {
    		isEditMode = true;
    	}
    
        elementorFrontend.hooks.addAction("frontend/element_ready/stiles-countdown-timer.default", SMWCountDownHandler);
    });
    
})(jQuery);  