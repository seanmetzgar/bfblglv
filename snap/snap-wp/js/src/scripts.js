var $animatedHeader = null;
var $findLocalFoodForm = null;
var $currentSearchXHR = null;
var $chips = null;

jQuery(document).ready(function ($) {
    "use strict";

    //Find Local Food Form
    var formObject = new Object();
    formObject.doublesnap = "true";
    formObject.action = "xhrGetPartners";
    xhrGetPartners(formObject);

}); // end document ready