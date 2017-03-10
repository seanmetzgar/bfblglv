//jQuery time
"use strict";
var form_wrapper_selector = ".form-wrapper",
    form_selector = ".email-form",
    form_blocks_selector = ".email-blocks",
    fixTabIndex = function (refocus) {
        refocus = (refocus === true) ?  true : false;
        $("body").find("input, select, textarea, button").filter(":not(:hidden)").each(function (index) {
            $(this).prop('tabindex', index + 1);
        });
        if (refocus) {
            $("body").find("input, select, textarea, button").filter(":not(:hidden)").eq(0).focus();
        }
        fixRequireds();
    },
    validateActive = function() {
        var isGood = true;
        var tempString = "";
        $("body").find("input, select, textarea").filter(":not(:hidden)").each(function () {
            if ($(this).attr("data-type") === "username" && $(this).val() !== "") {
                tempString = $(this).val();
                tempString = tempString.replace(/[^a-zA-Z0-9_\-]/g, "");
                if (tempString != $(this).val()) {
                    $(this).val(tempString);
                }
            }
            if ($(this).attr("data-required") === "true") {
                if ($(this).is("[type=checkbox]")) {
                    if (!$(this).is(":checked")) {
                        $(this).addClass("missing");
                        isGood = false;
                    }
                } else {
                    if ($(this).val() === "") {
                        $(this).addClass("missing");
                        isGood = false;
                    }
                }
            }
            if ($(this).attr("data-type") === "email" && $(this).val() !== "") {
                if (!validateEmail($(this).val())) {
                    $(this).addClass("missing");
                    isGood = false;
                }
            }
        });
        return isGood;
    },
    validateEmail = function(email) {
        var regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i;
        return regex.test(email);
    },
    fixRequireds = function() {
        $("input, textarea, select").filter("[data-required=true]").each(function () {
            var $this = $(this),
                $label = $this.parents("label"),
                $labelText = $label.find(".label-text");

            $labelText.addClass("required");
        });
    },
    prepFields = function($form) {
        var counter = 0;
        $form.find("[data-original-name]").each(function() {
            var original_name = $(this).attr("data-original-name");
            $(this).removeAttr("data-original-name");
            $(this).attr("name", original_name);
        });
        $form.find(".email-block").each(function() {
            counter++;
            $(this).find("[name^='block_#']").each(function() {
                var original_name = $(this).attr("name");
                var updated_name = original_name.replace("#", counter);
                $(this).attr("data-original-name", original_name).attr("name", updated_name);
            });
            $(this).find("[name^='photocheck_block_#']").each(function() {
                var original_name = $(this).attr("name");
                var updated_name = original_name.replace("#", counter);
                $(this).attr("data-original-name", original_name).attr("name", updated_name);
            });
        });
        $form.find("[name=number_email_blocks]").val(counter);
    },
    trumbowygSettings = {
        semantic: true,
        removeformatPasted: true,
        btns: [["bold", "italic", "underline"], ["link"]]
    };
$.trumbowyg.svgPath = '/images/vendor/trumbowyg/icons.svg';
$(document).ready(function () {

    $(form_wrapper_selector).each(function () {
        var $wrapper = $(this),
            $form = $wrapper.find(form_selector).eq(0),
            $emailBlocks = null;

        if ($form.length > 0) {
            $emailBlocks = $form.find(form_blocks_selector);

            $form.on("change blur", ".reliant-toggle", function () {
                var $this = $(this),
                    $reliantBox = $this.parents("label").nextAll(".reliant");

                if ($this.is(":checked")) {
                    $reliantBox.show();
                } else {
                    $reliantBox.hide().find("input,select,textarea").filter(":not([type=checkbox],[type=radio])").val("");
                }
            });

            $emailBlocks.on("click", ".panel-title", function (e) {
                var $this = $(this);
                e.preventDefault();

                $this.parents(".email-block").find(".panel-body").slideToggle();

            });

            $form.on("click", ".new-email-block", function (e) {
                var $this = $(this);
                var blockType = $this.data("block-type");
                var $blockPanel = null;
                var $blockPanelHeader = null;
                var $blockPanelTitle = null;
                var $blockPanelBody = null;
                var $tempColumn = null;
                e.preventDefault();

                $blockPanel = $("<div></div>").appendTo($emailBlocks).addClass("panel").addClass("panel-default").addClass("email-block");
                $blockPanelHeader = $("<div></div>").appendTo($blockPanel).addClass("panel-heading");
                $blockPanelTitle = $("<h3></h3>").appendTo($blockPanelHeader).addClass("panel-title");
                $blockPanelBody = $("<div></div>").appendTo($blockPanel).addClass("panel-body");
                $('<input type="hidden" name="block_#_type" value="' + blockType + '">').appendTo($blockPanelBody);
                switch(blockType) {
                    case "double-chips":

                        $blockPanelTitle.text("Double Article: Two Column");
                        $tempColumn = $('<div class="col-md-6"></div>').appendTo($blockPanelBody);
                        $('<h4 class="hidden-md hidden-lg hidden-xl">Left Article</h4>').appendTo($tempColumn);
                        $('<label><span class="label-text">Photo<br><em>(Recommended Size: 630 x 280)</em></span><input type="file" name="block_#a_photo" data-required="true"><input name="photocheck_block_#a" value="hello" type="hidden"></label>').appendTo($tempColumn);
                        $('<label><span class="label-text">Title</span><input type="text" name="block_#a_title" class="form-control"></label><label><span class="label-text">Link URL</span><input type="text" name="block_#a_url" class="form-control" data-required="true"></label>').appendTo($tempColumn);

                        $tempColumn = $('<div class="col-md-6"></div>').appendTo($blockPanelBody);
                        $('<h4 class="hidden-md hidden-lg hidden-xl">Right Article</h4>').appendTo($tempColumn);
                        $('<label><span class="label-text">Photo<br><em>(Recommended Size: 630 x 280)</em></span><input type="file" name="block_#b_photo" data-required="true"><input name="photocheck_block_#b" value="hello" type="hidden"></label>').appendTo($tempColumn);
                        $('<label><span class="label-text">Title</span><input type="text" name="block_#b_title" class="form-control"></label><label><span class="label-text">Link URL</span><input type="text" name="block_#b_url" class="form-control" data-required="true"></label>').appendTo($tempColumn);
                        break;
                    default:
                        if (blockType === "single-two-col") {
                            $blockPanelTitle.text("Single Article: Two Column");
                            $('<label><span class="label-text">Photo <em>(Recommended Size: 400 x 400)</em></span><input type="file" name="block_#_photo"><input name="photocheck_block_#" value="hello" type="hidden"></label>').appendTo($blockPanelBody);
                        } else {
                            $blockPanelTitle.text("Single Article: Full Width");
                            $('<label><span class="label-text">Photo <em>(Recommended Size: 630 x 280)</em></span><input type="file" name="block_#_photo"><input name="photocheck_block_#" value="hello" type="hidden"></label>').appendTo($blockPanelBody);
                        }

                        $('<label><span class="label-text">Title</span><input type="text" name="block_#_title" class="form-control"></label><label><span class="label-text">Subtitle</span><input type="text" name="block_#_subtitle" class="form-control"></label><label><span class="label-text">Text</span><textarea name="block_#_text" class="wysiwyg form-control"></textarea></label><label><span class="label-text">Button Text</span><input type="text" name="block_#_cta" class="form-control"></label><label><span class="label-text">Link URL</span><input type="text" name="block_#_url" class="form-control"></label>').appendTo($blockPanelBody);
                        $blockPanelBody.find("textarea.wysiwyg").trumbowyg(trumbowygSettings);
                }
                fixTabIndex();
            });
        }
        $form.on("submit", function () {
            var rVal = false;
            if (validateActive()) {
                prepFields($form);
                rVal = true;
            }
            return rVal;
        });

        fixTabIndex(true);
    });

    $("textarea.wysiwyg").trumbowyg(trumbowygSettings);

    $(".toggler").on("click", function(e) {
        $(".toggler").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        e.preventDefault();
        $(".display-layer").removeClass("active");
        
        if ($(this).hasClass("toggle-code")) {
            $(".display-layer.code-display").addClass("active");
        }
        if ($(this).hasClass("toggle-preview")) {
            $(".display-layer.email-display").addClass("active");
        }
    });

});