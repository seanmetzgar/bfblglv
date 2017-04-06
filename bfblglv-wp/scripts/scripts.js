var $animatedHeader = null;
var $findLocalFoodForm = null;
var $currentSearchXHR = null;
var $chips = null;

jQuery(document).ready(function ($) {
    "use strict";
    $animatedHeader = $(".animated-blocks");
    $animatedHeader.find("li").hover(function (e) {
        var $this = $(this);

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

    //Initialise Chosen
    $(".chosen-specific-products").chosen({
        "placeholder_text_multiple": "Select Products"
    });

    $(".county-select").chosen({
        "disable_search": true,
        "allow_single_deselect" : true,
        "placeholder_text_single": "County"
    });

    // mobile menu button
    // (the menu button *only* opens the menu! It's covered up when the menu is already open)
    $('#bfblMenuBtn').click(function (e) {
        e.preventDefault(); // just in case ...
        $('#bfblDrawerWrap').addClass('menuActive');
        $('#bfblMenuOverlay').addClass('menuActive');
    }); // end #bfblMenuBtn click function

    function bfblCloseMenu() {
        $('#bfblDrawerWrap').removeClass('menuActive');
        $('#bfblMenuOverlay').removeClass('menuActive');
    } // end bfblCloseMenu()

    // close the mobile menu when the 'close' button is clicked, *or* if the overlay is clicked
    $('#bfblMenuClose, #bfblMenuOverlay, #bfblDrawerWrap').click(function (e) {
        e.preventDefault();
        bfblCloseMenu();
    }); // end close menu function

    // prevent clicks inside #bfblMenuDrawer from propegating up to #bfblDrawerWrap and closing the menu
    $('#bfblMenuDrawer').click(function (e) {
        e.stopPropagation();
    });

    // show/hide the search box on desktop
    $('.buttonSearch').click(function (e) {
        e.preventDefault();
        $('.searchFormWrap').toggleClass('searchActive');
        $(this).toggleClass('btnActive');
    }); // end close menu function

// SPONSOR SLIDER
    // if ($('.sponsors-list').length > 0) {

    //     // $('.sponsors-list ul').slick({
    //     //     infinite: true,
    //     //     speed: 250,
    //     //     slidesToShow: 1, // with variableWidth turned on, the slides to the left and right of the center slide are shown automatically
    //     //     centerMode: true,
    //     //     variableWidth: true
    //     // }); // end slick() initialization

    // } // end the is-there-a-sponsor-list test

// LIGHTBOXES / DIALOG BOXES

    // add input placeholders to the login inputs
    var labelUser = $("label[for='user_login']").text();
    $("#user_login").attr("placeholder", labelUser);

    var labelPass = $("label[for='user_pass']").text();
    $("#user_pass").attr("placeholder", labelPass);

    // show/hide the login lightbox
    var $loginLB = $("#loginLB");

    // initialize the dialog box, with options
    $loginLB.dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        closeOnEscape: true,
        show: 400,
        hide: 0,
        fluid: true, //new option; see dynamic width notes below
        width: 'auto',
        maxWidth: 320
    });

    // open the dialog box on click
    $('.buttonLogin').click(function (e) {
        e.preventDefault();
        $loginLB.dialog('open');
        // also, close the menu
        bfblCloseMenu();
    }); // end the .buttonLogin-click function

    // show/hide the newsletter lightbox
    var $newsletterLB = $("#newsletterLB");

    // initialize the dialog box, with options
    $newsletterLB.dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        closeOnEscape: true,
        show: 400,
        hide: 0,
        fluid: true, //new option; see dynamic width notes below
        width: 'auto',
        maxWidth: 320
    });

    // open the dialog box on click
    $('.buttonNewsletter').click(function (e) {
        e.preventDefault();
        $newsletterLB.dialog('open');
        // also, close the menu
        bfblCloseMenu();
    }); // end the .buttonLogin-click function

    // clicking outside the lightbox closes it
    $('body').on('click', '.ui-widget-overlay', function (e) {
        e.preventDefault();
        $loginLB.dialog('close');
        $newsletterLB.dialog('close');
    }); // end the overlay click function

    // lightbox dynamic width!
    // source: http://stackoverflow.com/questions/16471890/responsive-jquery-ui-dialog-and-a-fix-for-maxwidth-bug

    // on window resize run function
    $(window).resize(fluidDialog); //function in plugins.js

    // catch dialog if opened within a viewport smaller than the dialog width
    $(document).on("dialogopen", ".ui-dialog", fluidDialog); //function in plugins.js

    // bfbl slider (used on partner pages and the find local food form)
    $('.bfblSlider .greenHeader').click(function (e) {
        e.preventDefault(); // clicking on these should never do anything anyway, but just in case ...

        var $slider = $(this).parent('.bfblSlider');
        var $slideContents = $slider.children('.bfblSlideWrap');

        // deal with any sliders that were visually hidden on page load
        if ($slider.hasClass('initialClosed')) {
            $slider.addClass("sliderClosed").removeClass('initialClosed');
        }

        if ($slider.hasClass('sliderOpen')) {
            // if it's open, close it
            $slideContents.stop(true).slideUp(250);
            $slider.removeClass('sliderOpen');
            $slider.addClass('sliderClosed');
        } else {
            // if it's closed, open it
            $slideContents.stop(true).slideDown(250);
            $slider.removeClass('sliderClosed');
            $slider.addClass('sliderOpen');
        }
    }); // end the .greenHeader click function

    //Find Local Food Form
    $findLocalFoodForm = $("#find-local-food-form").eq(0);
    $findLocalFoodForm.on("blur change", "input, textarea, select", function () {
        var formObject = false;
        var $productTypesSection = $findLocalFoodForm.find(".product-types-section");
        var locationTypes = $findLocalFoodForm.find("[name='location_type[]'],[name='csa'],[name='farm_share'],[name='farm-share'],[name='agritourism']").filter(":checked").serializeArray();
        var locationTypeValues = Array();
        for (var i = 0; i < locationTypes.length; i = i + 1) {
            switch(locationTypes[i].name) {
                case "csa":
                    locationTypeValues.push("csa");
                    break;
                case "farm_share":
                case "farm-share":
                    locationTypeValues.push("farm-share");
                    break;
                case "agritourism":
                    locationTypeValues.push("agritourism");
                    break;
                case "location_type[]":
                    locationTypeValues.push(locationTypes[i].value);
                    break;
            }
        }
        if (locationTypeValues.length === 0 ||
            (locationTypeValues.indexOf("farm") !== -1 ||
            locationTypeValues.indexOf("csa") !== -1 ||
            locationTypeValues.indexOf("farm-share") !== -1 ||
            locationTypeValues.indexOf("agritourism") !== -1)) {
            $productTypesSection.show().find("input,select,textarea").prop("disabled", false).removeProp("disabled");
        } else {
            $productTypesSection.hide().find("input,select,textarea").prop("disabled", true);
        }
        formObject = $findLocalFoodForm.serializeObject();
        formObject.action = "xhrGetPartners";

        xhrGetPartners(formObject);
    }).find("input").eq(0).trigger("blur");
    $findLocalFoodForm.on("submit", function(e) {
        e.preventDefault();
        $findLocalFoodForm.find("input").eq(0).trigger("blur");
        return false;
    });

    $(".entry-content,.entry-header").find("h1, h2, h3").filter(function () {
        var testRegex = /\bcsas\b/ig;
        return testRegex.test($(this).html());
    }).each(function () {
        var tempText = $(this).html();
        var testRegex = /\bcsas\b/ig;

        tempText = tempText.replace(testRegex, "CSA<span class=\"lower-case\">s</span>");
        tempText = $(this).html(tempText);
    });

    $chips = $(".chips-block").find(".chip");
    if ($chips.length > 1) {
        $(window).on("resize", function () {
            var maxTextHeight = 0;
            var $chipsDescr = $chips.find(".chipDescr");
            $chipsDescr.height("auto").each(function() {
                var $this = $(this);
                maxTextHeight = ($this.height() > maxTextHeight) ? $this.height() : maxTextHeight;
            });
            if (maxTextHeight > 0) { $chipsDescr.height(maxTextHeight); }
        }).trigger("resize");
    }

    $(".filter-list").find("a").on("click", function (e) {
        var $this = $(this);
        var product = $this.data("product");
        var $partnerBlocks = $(".partners-blocks");
        e.preventDefault();

        if (product === "all") {
            $partnerBlocks.find("li").show();
        } else {
            $partnerBlocks.find("li").each(function () {
                var $that = $(this);
                var products = $that.data("products");
                if (typeof products === "object" && products.indexOf(product) !== -1) {
                    $that.show();
                } else { $that.hide(); }
            });
        }
    });

}); // end document ready