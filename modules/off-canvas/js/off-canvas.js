(function ($) 
{
	window.SMWOffcanvasContent = function ($scope) 
    {
		this.node = $scope;
		if ($scope.find(".smw-offcanvas-toggle").length < 1) return;

		this.wrap = $scope.find(".smw-offcanvas-content-wrap");
		this.content = $scope.find(".smw-offcanvas-content");
		this.button = $scope.find(".smw-offcanvas-toggle");
		this.settings = this.wrap.data("settings");
		this.id = this.settings.content_id;
		this.transition = this.settings.transition;
		this.esc_close = this.settings.esc_close;
		this.body_click_close = this.settings.body_click_close;
		this.open_offcanvas = this.settings.open_offcanvas;
		this.direction = this.settings.direction;
		this.duration = 500;

		this.init();
	};

	SMWOffcanvasContent.prototype = 
    {
		id: "",
		node: "",
		wrap: "",
		content: "",
		button: "",
		settings: {},
		transition: "",
		duration: 400,
		initialized: false,
		animations: ["slide", "slide-along", "reveal", "push"],

		init: function () {
			if (!this.wrap.length) {
				return;
			}

			$("html").addClass("smw-offcanvas-content-widget");

			if ($(".smw-offcanvas-container").length === 0) {
				$("body").wrapInner('<div class="smw-offcanvas-container smw-offcanvas-container-' + this.id + '" />');
				this.content.insertBefore(".smw-offcanvas-container");
			}

			if (this.wrap.find(".smw-offcanvas-content").length > 0) {
				if ($(".smw-offcanvas-container > .smw-offcanvas-content-" + this.id).length > 0) {
					$(".smw-offcanvas-container > .smw-offcanvas-content-" + this.id).remove();
				}
				if ($("body > .smw-offcanvas-content-" + this.id).length > 0) {
					$("body > .smw-offcanvas-content-" + this.id).remove();
				}
				$("body").prepend(this.wrap.find(".smw-offcanvas-content"));
			}

			this.bindEvents();
		},

		destroy: function () 
        {
			this.close();

			this.animations.forEach(function (animation) {
				if ($("html").hasClass("smw-offcanvas-content-" + animation)) {
					$("html").removeClass("smw-offcanvas-content-" + animation);
				}
			});

			if ($("body > .smw-offcanvas-content-" + this.id).length > 0) {
				//$('body > .smw-offcanvas-content-' + this.id ).remove();
			}
		},

		bindEvents: function () 
        {
			if (this.open_offcanvas === "yes") {
				this.show();
			}
			this.button.on("click", $.proxy(this.toggleContent, this));

			$("body").delegate(".smw-offcanvas-content .smw-offcanvas-close", "click", $.proxy(this.close, this));

			if (this.esc_close === "yes") {
				this.closeESC();
			}
			if (this.body_click_close === "yes") {
				this.closeClick();
			}
		},

		toggleContent: function () 
        {
			if (!$("html").hasClass("smw-offcanvas-content-open")) {
				this.show();
			} else {
				this.close();
			}
		},

		show: function () 
        {
			$(".smw-offcanvas-content-" + this.id).addClass("smw-offcanvas-content-visible");
			// init animation class.
			$("html").addClass("smw-offcanvas-content-" + this.transition);
			$("html").addClass("smw-offcanvas-content-" + this.direction);
			$("html").addClass("smw-offcanvas-content-open");
			$("html").addClass("smw-offcanvas-content-" + this.id + "-open");
			$("html").addClass("smw-offcanvas-content-reset");
		},

		close: function () 
        {
			$("html").removeClass("smw-offcanvas-content-open");
			$("html").removeClass("smw-offcanvas-content-" + this.id + "-open");
			setTimeout(
				$.proxy(function () {
					$("html").removeClass("smw-offcanvas-content-reset");
					$("html").removeClass("smw-offcanvas-content-" + this.transition);
					$("html").removeClass("smw-offcanvas-content-" + this.direction);
					$(".smw-offcanvas-content-" + this.id).removeClass("smw-offcanvas-content-visible");
				}, this),
				500
			);
		},

		closeESC: function () 
        {
			var self = this;

			if ("" === self.settings.esc_close) {
				return;
			}

			// menu close on ESC key
			$(document).on("keydown", function (e) {
				if (e.keyCode === 27) {
					// ESC
					self.close();
				}
			});
		},

		closeClick: function () 
        {
			var self = this;

			$(document).on("click", function (e) 
			{
				if (
					$(e.target).is(".smw-offcanvas-content") ||
					$(e.target).parents(".smw-offcanvas-content").length > 0 ||
					$(e.target).is(".smw-offcanvas-toggle") ||
					$(e.target).parents(".smw-offcanvas-toggle").length > 0
				) {
					return;
				} else {
					self.close();
				}
			});
		},
	};
})(jQuery);