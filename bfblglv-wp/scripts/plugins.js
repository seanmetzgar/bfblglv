'use strict';
var $currentXhrGetPartners = null;
var $currentXhrAlert = [];
var $currentXhrError = [];
//Fluid Dialog Function
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
            if (wWidth < (parseInt(dialog.options.maxWidth) + 50)) {
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

//XHR Stuff
function xhrGetPartnersHandler(mainData) {
    var mapHTML = "";
    var resultsHTML = "";
    var resultsTotal = 0;
    var data = [];
    var specificData = [];
    var specificDataOptions = "";
    var $specificProductsSelect = $(".chosen-specific-products");

    if (typeof mainData === "object") {
        if (typeof mainData.partners === "object") {
            data = mainData.partners;
            resultsTotal = data.length;
        }

        if (typeof mainData.specific === "object") {
            specificData = mainData.specific;
        }
    }

    $(data).each(function () {
        var tempName = false;
        var tempURL = false;
        var tempLat = false;
        var tempLng = false;
        var tempCity = false;
        var tempHTML = "";
        var tempResultHTML = "";

        tempName = (this.name.length > 0) ? this.name : false;
        tempCity = (this.city.length > 0) ? ", " + this.city : "";
        tempURL = (this.url.length > 0) ? this.url : false;
        tempLat = !isNaN(this.lat) ? "" + this.lat : false;
        tempLng = !isNaN(this.lng) ? "" + this.lng : false;

        if (tempName && tempURL && tempLat && tempLng) {
            tempHTML = "<div class=\"marker\" data-lat=\"" + tempLat + "\" data-lng=\"" + tempLng + "\">";
            tempHTML = tempHTML + "<h4><a href=\"" + tempURL + "\">" + tempName + "</a></h4>";
            tempHTML = tempHTML + "</div>";
            mapHTML = mapHTML + tempHTML;
            tempHTML = "";
        }

        if (tempName && tempURL) {
            if (resultsHTML.indexOf("target=\"_blank\">" + tempName) === -1) {
                tempResultHTML = "<li><a href=\"" + tempURL + "\" target=\"_blank\">" + tempName + tempCity + "</a></li>";
                resultsHTML = resultsHTML + tempResultHTML;
            }
        }
    });

    $(".acf-map").empty().html(mapHTML).each(function () {
        $(this).trigger("re-render");
    });

    resultsTotal = $(".finder-search-results")
        .find(".results-list")
        .empty()
        .html(resultsHTML)
        .find("li")
        .length;
    
    $(".finder-search-results")
        .find(".results-total .count")
        .empty()
        .html(resultsTotal);

    if ($currentXhrAlert.length > 0 && $currentXhrError.length > 0) {
        $currentXhrAlert.removeClass("active");
        $currentXhrError.removeClass("active");
    }
}

function xhrGetPartnersError() {
    if ($currentXhrAlert.length > 0 && $currentXhrError.length > 0) {
        $currentXhrAlert.removeClass("active");
        $currentXhrError.addClass("active").delay(5).removeClass("active");
    }
}

function xhrGetPartners(formObject) {
    if ($currentXhrGetPartners && $currentXhrGetPartners.readyState !== 4){
        $currentXhrGetPartners.abort();
    }

    if ($currentXhrAlert.length > 0 && $currentXhrError.length > 0) {
        $currentXhrError.removeClass("active");
        $currentXhrAlert.addClass("active");
    }

    $currentXhrGetPartners = $.ajax({
        type: "post",
        dataType: "json",
        url: KuduAJAX.ajaxUrl,
        data: formObject,
        success: xhrGetPartnersHandler,
        error: xhrGetPartnersError,
        timeout: 60000
    });
}

// ACF MAP
(function ($) {
    /*
    *  render_map
    *
    *  This function will render a Google Map onto the selected jQuery element
    *
    *  @type    function
    *  @date    8/11/2013
    *  @since   4.3.0
    *
    *  @param   $el (jQuery element)
    *  @return  n/a
    */

    function render_map( $el ) {
        // var
        var $markers = $el.find('.marker');

        // vars
        var args = {
            zoom        : 6,
            center      : new google.maps.LatLng(40.6906001,-75.2158619),
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            scrollwheel : false,
            streetViewControl : false,
            mapTypeControl : false,
            styles      : [
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#FFBB00"
                        },
                        {
                            "saturation": 43.400000000000006
                        },
                        {
                            "lightness": 37.599999999999994
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#00ff6a"
                        },
                        {
                            "saturation": -1.0989010989011234
                        },
                        {
                            "lightness": 11.200000000000017
                        },
                        {
                            "gamma": 1
                        },
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#FFC200"
                        },
                        {
                            "saturation": -61.8
                        },
                        {
                            "lightness": 45.599999999999994
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#FF0300"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": 51.19999999999999
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#FF0300"
                        },
                        {
                            "saturation": -100
                        },
                        {
                            "lightness": 52
                        },
                        {
                            "gamma": 1
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#0078FF"
                        },
                        {
                            "saturation": -13.200000000000003
                        },
                        {
                            "lightness": 2.4000000000000057
                        },
                        {
                            "gamma": 1
                        }
                    ]
                }
            ]
        };

        // create map
        var map = new google.maps.Map( $el[0], args);

        // add a markers reference
        map.markers = [];

        // add markers
        $markers.each(function(){
            add_marker( $(this), map );

        });

        // center map
        center_map( map );

        google.maps.event.addListenerOnce(map, 'idle', function(){
            google.maps.event.trigger(map, 'resize');
            center_map(map);
        });
    }

    /*
    *  add_marker
    *
    *  This function will add a marker to the selected Google Map
    *
    *  @type    function
    *  @date    8/11/2013
    *  @since   4.3.0
    *
    *  @param   $marker (jQuery element)
    *  @param   map (Google Map object)
    *  @return  n/a
    */

    function add_marker( $marker, map ) {

        // var
        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
        var zoom = $marker.attr('data-zoom');

        // create marker
        var marker = new google.maps.Marker({
            position    : latlng,
            map         : map
        });

        // add to array
        map.markers.push( marker );

        // if marker contains HTML, add it to an infoWindow
        if( $marker.html() )
        {
            // create info window
            var infowindow = new google.maps.InfoWindow({
                content     : $marker.html()
            });

            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {

                infowindow.open( map, marker );

            });
        }
    }

    /*
    *  center_map
    *
    *  This function will center the map, showing all markers attached to this map
    *
    *  @type    function
    *  @date    8/11/2013
    *  @since   4.3.0
    *
    *  @param   map (Google Map object)
    *  @return  n/a
    */

    function center_map( map ) {

        // vars
        var bounds = new google.maps.LatLngBounds();

        // loop through all markers and create bounds
        $.each( map.markers, function( i, marker ){

            var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

            bounds.extend( latlng );

        });

        // only 1 marker?
        if( map.markers.length == 1 )
        {
            // set center of map
            map.setCenter( bounds.getCenter() );
            map.setZoom( 13 );
        }
        else
        {
            // fit to bounds
            map.fitBounds( bounds );
        }

    }

    function resize_map( map ) {
        google.maps.event.trigger(map, 'resize');
    }

    /*
    *  document ready
    *
    *  This function will render each map when the document is ready (page has loaded)
    *
    *  @type    function
    *  @date    8/11/2013
    *  @since   5.0.0
    *
    *  @param   n/a
    *  @return  n/a
    */

    $(document).ready(function(){
        $('.acf-map').each(function(){
            render_map( $(this) );
        }).on("re-render", function() {
            render_map( $(this) );
        });
    });

}(jQuery));
// END ACF Map

//jQuery serializeObject
/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.5.0
 */
(function(root, factory) {
    // AMD
    if (typeof define === "function" && define.amd) {
        define(["exports", "jquery"], function(exports, $) {
            return factory(exports, $);
        });
    }

    // CommonJS
    else if (typeof exports !== "undefined") {
        var $ = require("jquery");
        factory(exports, $);
    }

    // Browser
    else {
        factory(root, (root.jQuery || root.Zepto || root.ender || root.$));
    }

}(this, function(exports, $) {

    var patterns = {
        validate: /^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,
        key:      /[a-z0-9_]+|(?=\[\])/gi,
        push:     /^$/,
        fixed:    /^\d+$/,
        named:    /^[a-z0-9_]+$/i
    };

    function FormSerializer(helper, $form) {

        // private variables
        var data     = {},
                pushes   = {};

        // private API
        function build(base, key, value) {
            base[key] = value;
            return base;
        }

        function makeObject(root, value) {

            var keys = root.match(patterns.key), k;

            // nest, nest, ..., nest
            while ((k = keys.pop()) !== undefined) {
                // foo[]
                if (patterns.push.test(k)) {
                    var idx = incrementPush(root.replace(/\[\]$/, ''));
                    value = build([], idx, value);
                }

                // foo[n]
                else if (patterns.fixed.test(k)) {
                    value = build([], k, value);
                }

                // foo; foo[bar]
                else if (patterns.named.test(k)) {
                    value = build({}, k, value);
                }
            }

            return value;
        }

        function incrementPush(key) {
            if (pushes[key] === undefined) {
                pushes[key] = 0;
            }
            return pushes[key]++;
        }

        function encode(pair) {
            switch ($('[name="' + pair.name + '"]', $form).attr("type")) {
                case "checkbox":
                    return pair.value === "on" ? true : pair.value;
                default:
                    return pair.value;
            }
        }

        function addPair(pair) {
            if (!patterns.validate.test(pair.name)) return this;
            var obj = makeObject(pair.name, encode(pair));
            data = helper.extend(true, data, obj);
            return this;
        }

        function addPairs(pairs) {
            if (!helper.isArray(pairs)) {
                throw new Error("formSerializer.addPairs expects an Array");
            }
            for (var i=0, len=pairs.length; i<len; i++) {
                this.addPair(pairs[i]);
            }
            return this;
        }

        function serialize() {
            return data;
        }

        function serializeJSON() {
            return JSON.stringify(serialize());
        }

        // public API
        this.addPair = addPair;
        this.addPairs = addPairs;
        this.serialize = serialize;
        this.serializeJSON = serializeJSON;
    }

    FormSerializer.patterns = patterns;

    FormSerializer.serializeObject = function serializeObject() {
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serialize();
    };

    FormSerializer.serializeJSON = function serializeJSON() {
        return new FormSerializer($, this).
            addPairs(this.serializeArray()).
            serializeJSON();
    };

    if (typeof $.fn !== "undefined") {
        $.fn.serializeObject = FormSerializer.serializeObject;
        $.fn.serializeJSON   = FormSerializer.serializeJSON;
    }

    exports.FormSerializer = FormSerializer;

    return FormSerializer;
}));

jQuery(document).ready( function () {
    $currentXhrAlert = jQuery("<div class='xhrAlert'></div>").appendTo(jQuery("body")).html("Loading... Please wait.");
    $currentXhrError = jQuery("<div class='xhrError'></div>").appendTo(jQuery("body")).html("Error: Please try again later.");
});