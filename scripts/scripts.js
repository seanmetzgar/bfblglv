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

jQuery(document).ready(function($) {
    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut							


	// mobile menu button
	// (the menu button *only* opens the menu! It's covered up when the menu is already open)
	$('#bfblMenuBtn').click(function(e) {
		e.preventDefault(); // just in case ...
		$('#bfblDrawerWrap').addClass('menuActive');
		$('#bfblMenuOverlay').addClass('menuActive');
	}); // end #bfblMenuBtn click function

	function bfblCloseMenu() {
		$('#bfblDrawerWrap').removeClass('menuActive');
		$('#bfblMenuOverlay').removeClass('menuActive');		
	} // end bfblCloseMenu()

	// close the mobile menu when the 'close' button is clicked, *or* if the overlay is clicked
	$('#bfblMenuClose, #bfblMenuOverlay, #bfblDrawerWrap').click(function(e) {
		e.preventDefault();
		bfblCloseMenu();
	}); // end close menu function
	
	// prevent clicks inside #bfblMenuDrawer from propegating up to #bfblDrawerWrap and closing the menu
	$('#bfblMenuDrawer').click(function(e) {
		e.stopPropagation();
	});
		
	
	// show/hide the search box on desktop
	$('.buttonSearch').click(function(e) {
		e.preventDefault();
		$('.searchFormWrap').toggleClass('searchActive');
		$(this).toggleClass('btnActive');
	}); // end close menu function
	
	
	
// LIGHTBOXES / DIALOG BOXES

	// add input placeholders to the login inputs
	var labelUser = $("label[for='user_login']").text();
	$("#user_login").attr("placeholder", labelUser);
	
	var labelPass = $("label[for='user_pass']").text();
	$("#user_pass").attr("placeholder", labelPass);


	// show/hide the login lightbox
	var $loginLB = $( "#loginLB" );		
			
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
		maxWidth: 320,
	}); 
			
	// open the dialog box on click
	$('.buttonLogin').click(function(e) {
		e.preventDefault(); 
		$loginLB.dialog('open');
		// also, close the menu
		bfblCloseMenu();
	}); // end the .buttonLogin-click function

	// show/hide the newsletter lightbox
	var $newsletterLB = $( "#newsletterLB" );
		
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
		maxWidth: 320,
	}); 

	// open the dialog box on click
	$('.buttonNewsletter').click(function(e) {
		e.preventDefault(); 
		$newsletterLB.dialog('open');
		// also, close the menu
		bfblCloseMenu();
	}); // end the .buttonLogin-click function


	// clicking outside the lightbox closes it
	$('body').on('click', '.ui-widget-overlay', function(e) {
		$loginLB.dialog('close');
		$newsletterLB.dialog('close');
	}) // end the overlay click function


// lightbox dynamic width!
// source: http://stackoverflow.com/questions/16471890/responsive-jquery-ui-dialog-and-a-fix-for-maxwidth-bug

// on window resize run function
$(window).resize(function () {
    fluidDialog();
});

// catch dialog if opened within a viewport smaller than the dialog width
$(document).on("dialogopen", ".ui-dialog", function (event, ui) {
    fluidDialog();
});

function fluidDialog() {
    var $visible = $(".ui-dialog:visible");
    // each open dialog
    $visible.each(function () {
        var $this = $(this);
        var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
        // if fluid option == true
        if (dialog.options.fluid) {
            var wWidth = $(window).width();
            // check window width against dialog max width
            if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
                // keep dialog from filling entire screen
                $this.css("max-width", "87.5%");
            } else {
                // fix maxWidth bug
                $this.css("max-width", dialog.options.maxWidth + "px");
            }
            //reposition dialog
            dialog.option("position", dialog.options.position);
        }
    });

} // end fluidDialog()





}); // end document ready