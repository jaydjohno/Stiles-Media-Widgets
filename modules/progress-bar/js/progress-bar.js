 (function ($) 
{   
    var SMWProgressBarWidgetHandler = function ($scope, trigger) 
    {
        var $progressbarElem = $scope.find(".progress-bar-container"),
            settings = $progressbarElem.data("settings"),
            length = settings.progress_length,
            speed = settings.speed,
            type = settings.type;


        if ("line" === type) 
        {
            var $progressbar = $progressbarElem.find(".progress-bar-bar");

            if (settings.gradient)
                $progressbar.css("background", "linear-gradient(-45deg, " + settings.gradient + ")");

            $progressbar.animate({
                width: length + "%"
            }, speed);

        } else if ("circle" === type) {
            if (length > 100)
                length = 100;

            $progressbarElem.prop({
                'counter': 0
            }).animate({
                counter: length
            }, {
                duration: speed,
                easing: 'linear',
                step: function (counter) 
                {
                    var rotate = (counter * 3.6);

                    $progressbarElem.find(".progress-bar-right-label span").text(Math.ceil(counter) + "%");

                    $progressbarElem.find(".progress-bar-circle-left").css('transform', "rotate(" + rotate + "deg)");
                    if (rotate > 180) {

                        $progressbarElem.find(".progress-bar-circle").css({
                            '-webkit-clip-path': 'inset(0)',
                            'clip-path': 'inset(0)',
                        });

                        $progressbarElem.find(".progress-bar-circle-right").css('visibility', 'visible');
                    }
                }
            });

        } else 
        {
            var $progressbar = $progressbarElem.find(".progress-bar-bar-wrap"),
                width = $progressbarElem.outerWidth(),
                dotSize = settings.dot || 25,
                dotSpacing = settings.spacing || 10,
                numberOfCircles = Math.ceil(width / (dotSize + dotSpacing)),
                circlesToFill = numberOfCircles * (length / 100),
                numberOfTotalFill = Math.floor(circlesToFill),
                fillPercent = 100 * (circlesToFill - numberOfTotalFill);

            $progressbar.attr('data-circles', numberOfCircles);
            $progressbar.attr('data-total-fill', numberOfTotalFill);
            $progressbar.attr('data-partial-fill', fillPercent);

            var className = "progress-segment";
            for (var i = 0; i < numberOfCircles; i++) {
                className = "progress-segment";
                var innerHTML = '';

                if (i < numberOfTotalFill) {
                    innerHTML = "<div class='segment-inner'></div>";
                } else if (i === numberOfTotalFill) {

                    innerHTML = "<div class='segment-inner'></div>";
                }

                $progressbar.append("<div class='" + className + "'>" + innerHTML + "</div>");

            }

            if ("frontend" !== trigger) {
                SMWProgressDotsHandler($scope);
            }

        }

    };

    var SMWProgressDotsHandler = function ($scope) 
    {
        var $progressbarElem = $scope.find(".progress-bar-container"),
            settings = $progressbarElem.data("settings"),
            $progressbar = $scope.find(".progress-bar-bar-wrap"),
            data = $progressbar.data(),
            speed = settings.speed,
            increment = 0;

        var numberOfTotalFill = data.totalFill,
            numberOfCircles = data.circles,
            fillPercent = data.partialFill;

        dotIncrement(increment);

        function dotIncrement(inc) {

            var $dot = $progressbar.find(".progress-segment").eq(inc),
                dotWidth = 100;

            if (inc === numberOfTotalFill)
                dotWidth = fillPercent

            $dot.find(".segment-inner").animate({
                width: dotWidth + '%'
            }, speed / numberOfCircles, function () {
                increment++;
                if (increment <= numberOfTotalFill) {
                    dotIncrement(increment);
                }

            });
        }
    };

    var SMWProgressBarScrollWidgetHandler = function ($scope, $) 
    {
        var $progressbarElem = $scope.find(".progress-bar-container"),
            settings = $progressbarElem.data("settings"),
            type = settings.type;

        if ("dots" === type) {
            SMWProgressBarWidgetHandler($scope, "frontend");
        }

        elementorFrontend.waypoint($scope, function () 
        {
            if ("dots" !== type) {
                SMWProgressBarWidgetHandler($(this));
            } else {
                SMWProgressDotsHandler($(this));
            }

        }, {
            offset: Waypoint.viewportHeight() - 150,
            triggerOnce: true
        });
    };
    
    $(window).on('elementor/frontend/init', function () 
    {
        if (elementorFrontend.isEditMode()) 
        {
            elementorFrontend.hooks.addAction(
                "frontend/element_ready/stiles-progress-bar.default", SMWProgressBarWidgetHandler);
        } else {
            elementorFrontend.hooks.addAction(
                "frontend/element_ready/stiles-progress-bar.default", SMWProgressBarScrollWidgetHandler);
        }
    });
    
})(jQuery);
