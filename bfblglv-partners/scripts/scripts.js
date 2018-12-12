"use strict";
var version = "1.5.3",
    current_stage = null,
    next_stage = null,
    previous_stage = null,
    signup_wrapper_selector = ".signup-wrapper",
    signup_form_selector = ".signup-form",
    signup_stage_selector = ".signup-stage",
    signup_progress_selector = ".signup-progress",
    signup_extra_data_selector = ".extra-form-data",
    signup_category_questions_selector = ".category-specific-container",
    left = null,
    opacity = null,
    scale = null,
    animating = false,
    $partners_table = null,
    partnerTable = null,
    $footer = null,
    fixTabIndex = function (refocus) {
        refocus = (refocus === true) ?  true : false;
        $("body").find("input, select, textarea, button").filter(":not(:hidden)").each(function (index) {
            $(this).prop('tabindex', index + 1);
        });
        if (refocus) {
            $("body").find("input, select, textarea, button").filter(":not(:hidden)").eq(0).focus();
        }
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
    };

$(function () {
    $(signup_wrapper_selector).each(function () {
        var $wrapper = $(this),
            $form = $wrapper.find(signup_form_selector).eq(0),
            $progress = $wrapper.find(signup_progress_selector),
            $extra_content = $wrapper.find(signup_extra_data_selector),
            $category_questions = $wrapper.find(signup_category_questions_selector);

        if ($form.length > 0) {
            $form.find("button.next").on("click", function (e) {
                e.preventDefault();
                if (!animating && validateActive()) {
                    animating = true;

                    current_stage = $(this).parents(signup_stage_selector);
                    next_stage = $(this).parents(signup_stage_selector).next(signup_stage_selector);

                    //activate next step on progressbar using the index of next_stage
                    $progress.find("li").eq($form.find(signup_stage_selector).index(next_stage)).addClass("active");

                    //show the next fieldset
                    next_stage.show();
                    //hide the current fieldset with style
                    current_stage.animate({opacity: 0}, {
                        step: function (now) {
                            //as the opacity of current_stage reduces to 0 - stored in "now"
                            //1. scale current_stage down to 80%
                            scale = 1 - (1 - now) * 0.2;
                            //2. bring next_stage from the right(50%)
                            left = (now * 50) + "%";
                            //3. increase opacity of next_stage to 1 as it moves in
                            opacity = 1 - now;
                            current_stage.css({'transform': 'scale(' + scale + ')'});
                            next_stage.css({'left': left, 'opacity': opacity});
                        },
                        duration: 800,
                        complete: function () {
                            current_stage.hide();
                            animating = false;
                            fixTabIndex(true);
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                } else {
                    $(this).trigger("blur");
                }
            });

            $form.find("button.previous").on("click", function (e) {
                e.preventDefault();
                if (!animating) {
                    animating = true;

                    current_stage = $(this).parents(signup_stage_selector);
                    previous_stage = $(this).parents(signup_stage_selector).prev(signup_stage_selector);

                    //de-activate current step on progressbar
                    $progress.find("li").eq($form.find(signup_stage_selector).index(current_stage)).removeClass("active");

                    //show the previous fieldset
                    previous_stage.show();
                    //hide the current fieldset with style
                    current_stage.animate({opacity: 0}, {
                        step: function (now) {
                            //as the opacity of current_stage reduces to 0 - stored in "now"
                            //1. scale previous_stage from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_stage to the right(50%) - from 0%
                            left = ((1 - now) * 50) + "%";
                            //3. increase opacity of previous_stage to 1 as it moves in
                            opacity = 1 - now;
                            current_stage.css({'left': left});
                            previous_stage.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                        },
                        duration: 800,
                        complete: function () {
                            current_stage.hide();
                            animating = false;
                            fixTabIndex(true);
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                } else {
                    $(this).trigger("blur");
                }
            });
        }

        $form.on("submit", function () {
            var returnValue = false;
            if (validateActive()) {
                returnValue = true;
            }
            return returnValue;
        });

        $form.find("select[name=partner_category]").on("change blur", function () {
            var $this = $(this);
            switch ($this.val()) {
                case "csa-farm-share":
                case "farm":
                    if ($category_questions.find(".farms-questions").length === 0) {
                        $category_questions.empty();
                        $extra_content.find(".farms-questions").clone().appendTo($category_questions);
                    }
                    break;
                case "vineyard":
                    if ($category_questions.find(".vineyard-questions").length === 0) {
                        $category_questions.empty();
                        $extra_content.find(".vineyard-questions").clone().appendTo($category_questions);
                    }
                    break;
                case "farmers-market":
                    if ($category_questions.find(".farmers-market-questions").length === 0) {
                        $category_questions.empty();
                        $extra_content.find(".farmers-market-questions").clone().appendTo($category_questions);
                    }
                    break;
                case "":
                    $category_questions.empty();
                    break;
                default:
                    if ($category_questions.find(".other-questions").length === 0) {
                        $category_questions.empty();
                        $extra_content.find(".other-questions").clone().appendTo($category_questions);
                    }
            }
            fixTabIndex();
        }).trigger("change");

        $form.on("change blur", ".csa-toggle-1,.csa-toggle-2", function () {
            var $toggle1 = $form.find(".csa-toggle-1"),
                $toggle2 = $form.find(".csa-toggle-2"),
                $toggleBox = $form.find(".csa-specific-container");

            if ($toggle1.is(":checked") || $toggle2.is(":checked")) {
                if ($toggleBox.find(".csa-specific").length === 0) {
                    $toggleBox.empty();
                    $extra_content.find(".csa-specific").clone().appendTo($toggleBox);
                }
            } else {
                $toggleBox.empty();
            }
            fixTabIndex();
        }).trigger("change");

        $form.on("change blur", ".other-products-toggle", function () {
            var $this = $(this),
                $otherProducts = $form.find(".other-products");

            if ($this.is(":checked")) {
                $otherProducts.show();
            } else {
                $otherProducts.hide().find("textarea").val("");
            }
        }).trigger("change");

        $form.on("change blur", ".reliant-toggle", function () {
            var $this = $(this),
                $reliantBox = $this.parents("label").nextAll(".reliant");

            if ($this.is(":checked")) {
                $reliantBox.show();
            } else {
                $reliantBox.hide().find("input,select,textarea").filter(":not([type=checkbox],[type=radio])").val("");
            }
        });

        $("body").on("click", ".pseudo-select a", function (e) {
            var $option = $(this),
                $parent = $option.parents(".dropdown-menu"),
                $parentGroup = $parent.parents(".input-group"),
                enableReliantValue = false,
                valueName = $parent.attr("data-value-name"),
                $valueField = ($parentGroup.length === 1) ? $parentGroup.find("input[name=" + valueName + "]") : false,
                value = ($option.is("[data-value]")) ? $option.attr("data-value") : $option.text();
            e.preventDefault();

            enableReliantValue = ($parent.is("[data-reliant-value]")) ? $parent.attr("data-reliant-value") : false;

            if ($valueField !== false) {
                $valueField.val(value);
                if (enableReliantValue !== false && enableReliantValue === value) {
                    $valueField.removeAttr("readonly").val("");
                } else {
                    $valueField.attr("readonly", "readonly");
                }
            }
        });

        $form.on("focus", ".missing", function () {
            $(this).removeClass("missing");
        });
        $form.addClass("initialized").find(signup_stage_selector + ":gt(0)").hide();
        $progress.find("li").eq(0).addClass("active");

        $form.on("click", ".hours-add-day", function (e) {
            var $this = $(this),
                $hours_repeater = $this.prev(".hours-day"),
                $hours_repeater_clone = $hours_repeater.clone();

            e.preventDefault();

            $hours_repeater_clone.find("input, select, textarea").each(function () {
                var $input = $(this),
                    input_name = $input.attr("name"),
                    regex = /^(.*?)(\d*?)$/i,
                    matches = null,
                    name_part = false,
                    number_part = false;

                matches = regex.exec(input_name);
                if (typeof matches === "object" && Array.isArray(matches) && matches.length === 3) {
                    name_part = matches[1];
                    number_part = parseInt(matches[2]);
                    number_part = number_part + 1;
                    input_name = "" + name_part + number_part;
                    $input.attr("name", input_name);
                }
                if ($input.is("[type=radio], [type=checkbox]")) {
                    $input.prop("checked", false);
                } else { $input.val(""); }
            });
            $hours_repeater_clone.insertAfter($hours_repeater).find("input[type=checkbox]").trigger("blur");
            fixTabIndex();
        });

        fixTabIndex(true);
    });

    $partners_table = $(".partners-table");
    partnerTable = $partners_table.addClass("table-striped").addClass("table-bordered").DataTable({ pageLength: 100, searching: false });

    $("#agree-terms").on("change blur", function () {
        var $this = $(this),
            $paymentForm = $("#payment-form");
        if ($this.is(":checked")) {
            $paymentForm.show();
        } else {
            $paymentForm.hide();
        }
    }).trigger("blur");

    $("#register-pfb").on("change blur", function () {
        var $this = $(this),
            pfbDifference = 50,
            $amountOwedText = $("span.amount-owed"),
            $amountOwedField = $("input[name=amount]"),
            amountOwedDefault = $amountOwedField.data('default'),
            amountOwedValue = $amountOwedField.val();
        if ($this.is(":checked")) {
            amountOwedValue = amountOwedDefault + pfbDifference;
        } else {
            amountOwedValue = amountOwedDefault;
        }
        $amountOwedField.val(amountOwedValue);
        $amountOwedText.text("$" + parseFloat(amountOwedValue).toFixed(2));
    }).trigger("blur");

    $(".pseudo-select").each(function () {
        $(this).find("a").eq(0).trigger("click");
    });

    $("input, textarea, select").filter("[data-required=true]").each(function () {
        var $this = $(this),
            $label = $this.parents("label"),
            $labelText = $label.find(".label-text");

        $labelText.addClass("required");
    });

    if(window.location.href.indexOf("/admin") > -1) {
        $("<div style=\"clear: both; height: 1px; overflow: hidden;\">&nbsp;</div>").appendTo(".site-wrapper");
        $footer = $("<footer></footer>").appendTo("body");
        $footer.addClass("site-footer");
        $("<p>Version: " + version + "</p>").appendTo($footer);
    }
    $("select").select2();
});