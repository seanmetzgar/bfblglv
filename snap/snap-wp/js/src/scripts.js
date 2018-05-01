var $animatedHeader = null;
var $findLocalFoodForm = null;
var $currentSearchXHR = null;
var $chips = null;

jQuery(document).ready(function ($) {
    "use strict";

    var formObject = new Object();

    //Find Local Food Form
    if ($('.acf-map').length) {

        formObject.doublesnap = "true";
        formObject.action = "xhrGetPartners";
        xhrGetPartners(formObject);
    }

}); // end document ready