(function($) 
{
	SMWAdvancedMenu = function( $scope ) 
	{
		this.node = $scope;
		this.menu_wrap = $scope.find('.smw-advanced-menu-main-wrapper');
		this.wrap = $scope.find('.smw-advanced-menu__container');
		this.menu = $scope.find('.smw-advanced-menu');
		this.dropdownMenu = $scope.find('.smw-advanced-menu__container.smw-advanced-menu--dropdown');
		this.menuToggle = $scope.find('.smw-menu-toggle'); // hamburger icon
		this.settings = $scope.find('.smw-advanced-menu__container').data('settings');
		this.menuId = this.settings.menu_id;
		this.menuType = this.settings.menu_type;
		this.menuLayout = this.settings.menu_layout;
		this.onepage_menu = this.settings.onepage_menu;
		this.duration = 400;

		this.init();
	};

	SMWAdvancedMenu.prototype = {
		stretchElement: null,

		init: function () {

			if ( ! this.menu.length ) {
				return;
			}
            
            if ( jQuery.fn.smartmenus ) {
                jQuery.SmartMenus.prototype.isCSSOn = function() {
                    return true;
                };

                if ( elementorFrontend.config.is_rtl  ) {
                    jQuery.fn.smartmenus.defaults.rightToLeftSubMenus = true;
                }
            }

			if ( 'horizontal' === this.menuLayout ) {
				if ('undefined' !== typeof $.fn.smartmenus) {
					this.menu.smartmenus({
						subIndicatorsText: '',
						subIndicatorsPos: 'asmwend',
						subMenusMaxWidth: '1000px',
						subMenusMinWidth: ''
					});
				}
			}

			if ( 'vertical' === this.menuLayout ) {
				if ('undefined' !== typeof $.fn.smartmenus) {
					this.menu.smartmenus({
						subIndicatorsText: '',
						subIndicatorsPos: 'asmwend',
					});
				}
			}

			if ( 'default' === this.menuType ) {
				this.initStretchElement();
				this.stretchMenu();
			}

			if ('off-canvas' === this.menuType) {
				this.initOffCanvas();
			}

			if ('full-screen' === this.menuType) {
				this.initFullScreen();
			}

			this.bindEvents();
			
			$(window).on('load', $.proxy(this.resetDimensions, this))
			
			this.menu.smartmenus('refresh');
		},

		getElementSettings: function( setting ) {
			if ( 'undefined' !== typeof this.settings[setting] ) {
				return this.settings[setting];
			}

			return false;
		},

		bindEvents: function () {
			var self = this;

			if ( ! this.menu.length ) {
				return;
			}

			this.menuToggle.on('click', $.proxy( this.toggleMenu, this ));

			if ( 'yes' === this.onepage_menu ) {
				this.menu.on( 'click', '.menu-item > a[href*="#"]', function(e) {
					var $href = $(this).attr('href'),
						$targetID = '';

					if ( $href !== '#' ) {
						$targetID = $href.split('#')[1];

						if ( $('body').find('#' +  $targetID).length > 0 ) {
							e.preventDefault();
							$( this ).toggleClass( 'smw-active' );
							setTimeout(function() {
								$('html, body').animate({
									scrollTop: $('#'+ $targetID).offset().top
								}, 200, function() {
									window.location.hash = $targetID;
								});
							}, 500);
						}
					}

					self.closeMenu();
				});
			}

			if ('default' === this.menuType) {
				elementorFrontend.addListenerOnce(this.node.data('model-cid'), 'resize', $.proxy( this.stretchMenu, this) );
			}

			//self.panelUpdate();

			this.closeMenuESC();
		},

		panelUpdate: function() {
			var self = this;

			if ('undefined' !== typeof elementor && $('body').hasClass('elementor-editor-active')) {
				elementor.hooks.addAction('panel/open_editor/widget/smw-advanced-menu', function (panel, model, view) {
					panel.$el.find('select[data-setting="dropdown"]').on('change', function () {
						if (model.attributes.id === self.menuId) {
							if ($(this).val() === 'all') {
								self.node.find('.smw-advanced-menu--main').hide();
							}
							if ($(this).val() !== 'all') {
								self.node.find('.smw-advanced-menu--main').show();
							}
						}
					});

					if (model.attributes.id === self.menuId && 'all' === self.settings.breakpoint) {
						self.toggleMenu();
					}
				});
			}
		},

		initStretchElement: function () {
			this.stretchElement = new elementorFrontend.modules.StretchElement({ element: this.dropdownMenu });
		},

		stretchMenu: function () {
			if (this.getElementSettings('full_width')) { 
				this.stretchElement.stretch();

				this.dropdownMenu.css('top', this.menuToggle.outerHeight());
			} else {
				this.stretchElement.reset();
			}
		},

		initOffCanvas: function () {
			$('.smw-menu-' + this.settings.menu_id).each(function(id, el) {
				if ($(el).parent().is('body') ) {
					$(el).remove();
				}
			});
			
			if ( $('.smw-offcanvas-container').length === 0 ) {
				$('body').wrapInner( '<div class="smw-offcanvas-container" />' );
				this.node.find( '.smw-menu-' + this.settings.menu_id ).insertBefore('.smw-offcanvas-container');
			}

			if ( this.menu_wrap.find('.smw-menu-off-canvas').length > 0 ) {
                if ( $('.smw-offcanvas-container > .smw-menu-' + this.settings.menu_id).length > 0 ) {
                    $('.smw-offcanvas-container > .smw-menu-' + this.settings.menu_id).remove();
                }
                if ( $('body > .smw-menu-' + this.settings.menu_id ).length > 0 ) {
                    $('body > .smw-menu-' + this.settings.menu_id ).remove();
                }
                $('body').prepend(this.node.find( '.smw-menu-' + this.settings.menu_id ) );
			}

			$('.smw-menu-clear').fadeOut(400, function() {
				$(this).remove();
			});

			$('.smw-menu-' + this.settings.menu_id).css('height', window.innerHeight + 'px');
			$('.smw-menu-' + this.settings.menu_id).find('.smw-menu-close').on( 'click', $.proxy( this.closeMenu, this ));
		},

		initFullScreen: function () {
			$('body').addClass('smw-menu--full-screen');
			$('.smw-menu-' + this.settings.menu_id).css('height', window.innerHeight + 'px');
			$('.smw-menu-' + this.settings.menu_id).find('.smw-menu-close').on('click', $.proxy(this.closeMenu, this));
			//$('.smw-menu-' + this.settings.menu_id).find('.menu-item a').on('click', $.proxy(this.closeMenu, this));
		},
		
		resetDimensions: function() {
			if ( 'full-screen' === this.menuType ) {
				$('.smw-menu-' + this.settings.menu_id).css('height', window.innerHeight + 'px');
			}
		},

		toggleMenu: function () {
			this.menuToggle.toggleClass('smw-active');

			var menuType = this.getElementSettings('menu_type');
			var isActive = this.menuToggle.hasClass('smw-active');
			
			$('html').removeClass('smw-menu-toggle-open');

			if ( isActive ) {
				$('html').addClass('smw-menu-toggle-open');
			}

			if ('default' === menuType) {
				var $dropdownMenu = this.dropdownMenu;

				if (isActive) {
					$dropdownMenu.hide().slideDown(250, function () {
						$dropdownMenu.css('display', '');
					});
					
					this.stretchMenu();
				} else {
					$dropdownMenu.show().slideUp(250, function () {
						$dropdownMenu.css('display', '');
					});
				}
			}

			if ('off-canvas' === menuType) {
				this.toggleOffCanvas();
			}
			if ('full-screen' === menuType) {
				this.toggleFullScreen();
			}
		},

		toggleOffCanvas: function()
		{
			var isActive = this.menuToggle.hasClass('smw-active'),
				element = $('body').find('.smw-menu-' + this.menuId),
				time = this.duration,
				self = this;

			$('html').removeClass('smw-menu-toggle-open');

			if ( isActive ) {
				$('body').addClass('smw-menu--off-canvas');
				$('html').addClass('smw-menu-toggle-open');
				time = 0;
			} else {
				time = this.duration;
			}

			$('.smw-menu-open').removeClass('smw-menu-open');
			$('.smw-advanced-menu--toggle .smw-menu-toggle').not(this.menuToggle).removeClass('smw-active');

			setTimeout(function() {
				$('.smw-menu-off-canvas').removeAttr('style');

				if (isActive) {
					$('body').addClass('smw-menu-open');
					element.addClass('smw-menu-open').css('z-index', '999999');
					if ( $('.smw-menu-clear').length === 0 ) {
						$('body').asmwend('<div class="smw-menu-clear" style="transition: none !important;"></div>');
					}
					$('.smw-menu-clear').off('click').on('click', $.proxy(self.closeMenu, self));
					$('.smw-menu-clear').fadeIn();
				} else {
					$('.smw-menu-open').removeClass('smw-menu-open');
					$('body').removeClass('smw-menu--off-canvas');
					$('html').removeClass('smw-menu-toggle-open');
					$('.smw-menu-clear').fadeOut();
				}
			}, time);
		},

		toggleFullScreen: function() {
			var isActive = this.menuToggle.hasClass('smw-active'),
				element = $('body').find('.smw-menu-' + this.menuId);

			$('html').removeClass('smw-menu-toggle-open');

			if ( isActive ) {
				$('html').addClass('smw-menu-toggle-open');
				this.node.find('.smw-menu-full-screen').addClass('smw-menu-open');
				this.node.find('.smw-menu-full-screen').attr('data-scroll', $(window).scrollTop());
				$(window).scrollTop(0);
			}
		},

		closeMenu: function() {
			if ( 'default' !== this.menuType ) {
				$('.smw-menu-open').removeClass('smw-menu-open');
				this.menuToggle.removeClass('smw-active');

				$('html').removeClass('smw-menu-toggle-open');

				if ( 'full-screen' === this.menuType ) {
					var scrollTop = this.node.find('.smw-menu-full-screen').data('scroll');
					$(window).scrollTop(scrollTop);
				}

				$('.smw-menu-clear').fadeOut();
			}
		},

		closeMenuESC: function() {
			var self = this;

			// menu close on ESC key
			$(document).on('keydown', function (e) {
				if (e.keyCode === 27) { // ESC
					self.closeMenu();
				}
			});
		}

	};
	
	var AdvancedMenuHandler = function ($scope, $) 
    {
    	new SMWAdvancedMenu( $scope );
    };

    $(window).on('elementor/frontend/init', function () 
    {
        if ( elementorFrontend.isEditMode() ) 
        {
    		isEditMode = true;
    	}
    
        elementorFrontend.hooks.addAction('frontend/element_ready/stiles_advanced_menu.default', AdvancedMenuHandler);
    });

})(jQuery);