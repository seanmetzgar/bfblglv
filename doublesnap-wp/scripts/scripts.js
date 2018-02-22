//@prepros-prepend plugins.js"

"use strict";
var $hero = null;
jQuery(function () {
	jQuery(".menu-toggler").on("click", function (e) {
		e.preventDefault();
		var $this = jQuery(this);
		var $menu = $this.siblings(".menu-wrapper");

		if ($menu.hasClass("active")) {
			$menu.removeClass("active");
			$this.removeClass("active");
		} else {
			$menu.addClass("active");
			$this.addClass("active");
		}
	});

	$hero = jQuery(".site-header").find(".hero").eq(0);
	if ($hero.length > 0) {
		jQuery(window).on("resize scroll", function() {
			var scrollTop = jQuery(window).scrollTop();
			var heroHeight = $hero.innerHeight();

			if (scrollTop >= heroHeight) {
				jQuery("body").addClass("fixed-nav");
			} else { jQuery("body").removeClass("fixed-nav"); }
		}).trigger("resize");
	}

	$(".countup-number").each(function () {
        var $this = $(this);

        $this.one("inview", function (e, v) {
            var $that = $(this);

            if (v) {
                $that.css("visibility", "visible").spincrement({
                    fade: true,
                    duration: 2000
                });
            }
        }).css("visibility", "hidden");
    });

    $(".goal-link").on("click", function() {
    	if ($(this).parents(".site-navigation").length) {
    		linkLocation = "header";
    	} else if ($(this).parents(".site-footer").length) {
    		linkLocation = "footer";
    	} else {
    		linkLocation = "page content";
    	}

    	if (typeof __gaTracker === "function") {
    		__gaTracker('send', 'event', 'goal-link', 'ticket sales', linkLocation, 1);
    	} else if (typeof ga === "function") {
    		ga('send', 'event', 'goal-link', 'ticket sales', linkLocation, 1);
    	}

    	return true;
    });

});