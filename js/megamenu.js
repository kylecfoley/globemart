// Item Name : Responsive Mega Menu Complete Set
// Item URI : http://codecanyon.net/item/mega-menu-complete-set/152825
// Author URI : http://codecanyon.net/user/Pixelworkshop/
// Version : 4.02



;(function($) {
    

    $.megaMenuCompleteSet = function(element, options) {


        var settings = {
            menu_speed_show:300, // Time (in milliseconds) to show a drop down
            menu_speed_hide:200, // Time (in milliseconds) to hide a drop down
            menu_speed_delay:200, // Time (in milliseconds) before showing a drop down
            menu_effect:'hover_fade', // Drop down effect, choose between 'hover_fade', 'hover_slide', 'click_fade', 'click_slide', 'open_close_fade', 'open_close_slide'
            menu_click_outside:0, // Clicks outside the drop down close it (1 = true, 0 = false)
            menu_show_onload:0, // Drop down to show on page load (type the number of the drop down, 0 for none)
            menu_responsive:1 // 1 = Responsive, 0 = Not responsive
        };
        
        var plugin = this;
        
        plugin.options = {};

        var $element = $(element);
        var element = element;

        var menuItem = $element.children('li'),
            menuItemLink = $(menuItem).children('.megamenu_drop'),
            menuDropDownContainer = $(menuItem).find('.dropdown_container'),
            menuDropDownContainerVertical = $('.megamenu_container_vertical'),
            menuDropDownFullWidth = $(menuItem).find('.dropdown_fullwidth'),
            menuDropDown = $(menuDropDownContainer).add(menuDropDownFullWidth),
            menuDropDownFirst = $('.dropdown_first'),
            menuItemFlyOut = $(menuItem).find('.dropdown_parent'),
            menuItemFlyOutLink = $(menuItemFlyOut).children('a'),
            menuItemFlyOutDropDown = $(menuItemFlyOut).find('.dropdown_flyout_level'),
            menuItemFlyOutDropDownLeft = $(menuItemFlyOut).find('.dropdown_flyout_level_left'),
            menuButton = $('.megamenu_button'),
            menuItemElement = $(menuItem).add(menuItemFlyOut),
            menuDropDownElement = $(menuDropDown).add(menuItemFlyOutDropDown).add(menuItemFlyOutDropDownLeft);


        plugin.init = function() {

            settings = $.extend(1, settings, options);

            hoverIntentConfig = {
                over: megaMenuOver, // function = onMouseOver callback (REQUIRED)
                out: megaMenuOut, // function = onMouseOut callback (REQUIRED)
                timeout: 200, // number = milliseconds delay before onMouseOut
                sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
                interval:settings.menu_speed_delay // number = milliseconds for onMouseOver polling interval
            };

            megaMenuDropDownInit();

            if ($("#megamenu_form").length > 0){
                contactForm();
            }            

        }


        var megaMenuDropDownInit = function(){

            if (("ontouchstart" in document.documentElement) && (settings.menu_responsive === 1)) {

                if ($(document).width() < 991) {
                    $(menuDropDown).css({'left':'-1px', 'top':'auto'}).hide();
                    $(menuItemFlyOutDropDown).css({'left':'0', 'top':'0'}).hide();
                    $(menuItem).hide(0);
                    $(menuButton).show(0);

                } else {
                    megaMenuDropDownPosition();
                }

                $(menuButton).hammer().on('tap', function () {
                    $(this).toggleClass('megamenu_button_active');
                    $(menuItem).not(":eq(0)").toggle(0);
                });

                $(menuItemElement).toggleClass('noactive');

                // Event attached to the link instead of the LI element
                // to prevent the drop down from being closed if a touch
                // event occurs within its area.

                $(menuItemLink).hammer().on('tap', function () {
                    var $this = $(this);
                    $this.parent(menuItem).toggleClass('active noactive')
                        .find(menuDropDown).toggle(0);
                    // No chaining here, the horizontal and vertical
                    // versions don't use the exact same structure.
                    $this.parent(menuItem).siblings().addClass('noactive').removeClass('active')
                        .find(menuDropDown).hide(0);
                    $(menuItemFlyOut).addClass('noactive').removeClass('active').find(menuItemFlyOutDropDown).hide(0);
                    return false;
                });

                $(menuItemFlyOutLink).hammer().on('tap', function () {
                    var $this = $(this);
                    $this.parent(menuItemFlyOut)
                        .toggleClass('active noactive')
                        .find(menuItemFlyOutDropDown).first()
                        .toggle(0);
                    $this.parent(menuItemFlyOut).siblings().addClass('noactive').removeClass('active')
                        .find(menuItemFlyOutDropDown).hide(0);
                    $this.parent(menuItemFlyOut).siblings()
                        .find(menuItemFlyOut).addClass('noactive').removeClass('active');
                    return false;
                });

                $(document).hammer().on('tap', function () {
                    $(menuItemElement).addClass('noactive');
                    $(menuDropDownElement).hide(0);
                });
                $element.hammer().on('tap', function (event) {
                    event.stopPropagation();
                });
                $(window).bind('orientationchange', function () {
                    $(menuItemElement).addClass('noactive');
                    $(menuDropDownElement).hide(0);
                    if ($(document).width() < 991) {
                        $(menuItem).hide(0);
                        $(menuButton).show(0);
                    } else {
                        $(menuItem).show(0);
                        $(menuButton).hide(0);
                    }
                });

                return;


            } else {

                megaMenuDropDownPosition();

                $(window).resize(function() {
                    $(menuButton).removeClass('megamenu_button_active');
                    megaMenuDropDownPosition();
                });

                $(menuButton).children('a').click(function () {
                    $(menuButton).toggleClass('megamenu_button_active');
                    $(menuItem).not(":eq(0)").toggle(0);
                });

                if (settings.menu_click_outside === 1) {

                    $(document).click(function () {
                        $(menuItemElement).removeClass('active');
                        $(menuDropDownElement).hide(0);
                    });
                    $element.click(function (event) {
                        event.stopPropagation();
                    });
                }

                switch (settings.menu_effect) {

                    case 'open_close_fade':
                    var menuEffectShow = 'fadeToggle',
                        menuEffectHide = 'fadeOut';
                        break;
                    case 'open_close_slide':
                    var menuEffectShow = 'slideToggle',
                        menuEffectHide = 'slideUp';
                        break;
                    case 'open_close_toggle':
                    var menuEffectShow = 'toggle',
                        menuEffectHide = 'hide';
                        break;

                }
                
                switch (settings.menu_effect) {

                    case 'hover_fade':
                    case 'hover_slide':
                    case 'hover_toggle':
                    case 'click_fade':
                    case 'click_slide':
                    case 'click_toggle':
                        $(menuItemElement).hoverIntent(hoverIntentConfig);
                        break;

                    case 'open_close_fade':
                    case 'open_close_slide':
                    case 'open_close_toggle':

                        $('.megamenu > li:nth-child(' + (1 + settings.menu_show_onload) + ')')
                            .find(menuDropDown).show()
                            .closest(menuItem).toggleClass('active');

                        $(menuItem).unbind('mouseenter mouseleave').click(function () {

                            var $this = $(this);
                            $this.siblings().removeClass('active')
                                .find(menuDropDown)[menuEffectHide](settings.menu_speed_hide);
                            $this.toggleClass('active')
                                .find(menuDropDown).first()
                                .delay(settings.menu_speed_delay)[menuEffectShow](settings.menu_speed_show)
                                .click(function (event) {
                                    event.stopPropagation();
                                });

                        });

                        $(menuItemFlyOut).unbind('mouseenter mouseleave').click(function () {

                            var $this = $(this);
                            $this.siblings().removeClass('active')
                                .find(menuItemFlyOutDropDown)[menuEffectHide](settings.menu_speed_hide);
                            $this.siblings().find('li').removeClass('active');
                            $this.toggleClass('active')
                                .find(menuItemFlyOutDropDown).first()
                                .delay(settings.menu_speed_delay)[menuEffectShow](settings.menu_speed_show)
                                .click(function (event) {
                                    event.stopPropagation();
                                });

                        });

                        break;

                }

            }

        }
        

        var megaMenuDropDownPosition = function(){

            // This part uses CSS so the drop downs remain opened when using the effects
            // 'open_close_fade', 'open_close_slide' and 'open_close_fade'.
            // Without those top and left values, the drop downs would be hidden
            // when not hovered.

            if (($(document).width() < 991) && (settings.menu_responsive === 1)) {
                $(menuDropDown).css({'left':'-1px', 'top':'auto'}).hide();
                $(menuDropDownFirst).css({'left':'0'}).hide();
                $(menuItemFlyOutDropDown).css({'left':'0', 'top':'0'}).hide();
                $element.children('li').hide(0);
                $(menuButton).show(0);
            }

            else {

                $(menuDropDownContainer).css({'left':'auto', 'top':'auto'}).hide();
                $(menuDropDownFullWidth).css({'left':'-1px', 'top':'auto'}).hide();
                $(menuItemFlyOutDropDown).css({'left':'95%', 'top':'-21px'}).hide();
                $(menuItemFlyOutDropDownLeft).css({'left':'-108%', 'right':'100%'}).hide();
                $element.children('li').show(0);
                $(menuButton).hide(0);
            
            }

            $(menuDropDownContainerVertical).find(menuDropDown).css({'top':'0'});

        }
        

        function megaMenuOver() {

            var $this = $(this);

            switch (settings.menu_effect) {
                case 'hover_fade':
                    $this.find(menuDropDownElement).first().fadeIn(settings.menu_speed_show);
                    break;
                case 'hover_slide':
                    $this.find(menuDropDownElement).first().slideDown(settings.menu_speed_show);
                    break;
                case 'hover_toggle':
                    $this.find(menuDropDownElement).first().show(settings.menu_speed_show);
                    break;
                case 'click_fade':
                    $this.click(function() {
                        $this.find(menuDropDownElement).first().fadeIn(settings.menu_speed_show);
                    });
                    break;
                case 'click_slide':
                    $this.click(function() {
                        $this.find(menuDropDownElement).first().slideDown(settings.menu_speed_show);
                    });
                    break;
                case 'click_toggle':
                    $this.click(function() {
                        $this.find(menuDropDownElement).first().show(settings.menu_speed_show);
                    });
                    break;

            }

        }


        function megaMenuOut() {

            var $this = $(this).find(menuDropDownElement);
        
            switch (settings.menu_effect) {
                case 'hover_fade':
                case 'click_fade':
                    $this.fadeOut(settings.menu_speed_hide);
                    break;
                case 'hover_slide':
                case 'click_slide':
                    $this.slideUp(settings.menu_speed_hide);
                    break;
                case 'hover_toggle':
                case 'click_toggle':
                    $this.hide(settings.menu_speed_hide);
                    break;

            }

        }    


        function contactForm() {

            $('#megamenu_form').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true
                    },
                    captcha: {
                        required: true,
                        answercheck: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Your name should contain at least 2 characters"
                    },
                    email: {
                        required: "Please enter your email address"
                    },
                    message: {
                        required: "Please enter your message",
                        minlength: "This is too short"
                    },
                    captcha: {
                        required: "Wrong answer !"
                    }
                },
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        type:"POST",
                        data: $(form).serialize(),
                        url:"contact.php",
                        success: function() {
                            $('#megamenu_form fieldset').fadeTo( "slow", 0.3, function() {
                                $('#success').fadeIn();
                            });
                        },
                        error: function() {
                            $('#megamenu_form fieldset').fadeTo( "slow", 0.3, function() {
                                $('#error').fadeIn();
                            });
                        }
                    });
                }
            });

            jQuery.validator.addMethod('answercheck', function (value, element) {
                return this.optional(element) || /^\b5\b$/.test(value);
            }, "Please type the correct answer");


        }

       
        plugin.init();


    }


    $.fn.megaMenuCompleteSet = function(options) {


        return this.each(function() {

            if (undefined == $(this).data('megaMenuCompleteSet')) {

                var plugin = new $.megaMenuCompleteSet(this, options);
                $(this).data('megaMenuCompleteSet', plugin);

            }

        });


    }


})(jQuery);


