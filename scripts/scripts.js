var $animatedHeader = null;

//jQuery time
$(function () {
    "use strict";
    $animatedHeader = $(".animated-blocks");
    $animatedHeader.find("li").hover(function (e) {
        var $this = $(this);
        console.log(e);
        if (e.type === "mouseenter") {
            if (!$this.hasClass("map-link")) {
                $animatedHeader.addClass("has-active").find("li").removeClass("active");
                $this.addClass("active");
            }
        }
        if (e.type === "mouseleave") {
            $animatedHeader.removeClass("has-active").find("li").removeClass("active");
        }
    });

});