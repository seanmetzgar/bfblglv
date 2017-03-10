//@prepros-prepend plugins.js"
'use strict';
function bfblglv_blc_email_validation($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,63})?$/;
  return emailReg.test( $email );
}

function xhr_bfblglv_blc_add_data(formObject) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: BFBLGLV_BLC_AJAX.ajaxUrl,
        data: formObject,
        success: xhr_bfblglv_blc_add_data_handler
    });
}

function xhr_bfblglv_blc_add_data_handler(data) {
    var $form = jQuery(".blc-form");
    var $insert = jQuery(".blc-form-success.insert");
    var $update = jQuery(".blc-form-success.update");
    var $failure = jQuery(".blc-form-failure");
    if (data.status === "success") {
    	if (data.type === "update") {
    		$update.addClass("active");
    	} else { $insert.addClass("active"); }
    	$form.addClass("inactive");
    } else {
    	if (typeof data.code === "string") {
    		$failure.find(".code").empty().html(data.code);
    	} else {
    		$failure.find(".code").empty();
    	}
    	$failure.addClass("active");
    	$form.addClass("inactive");
    }
}
jQuery(document).ready(function() {
	var $sliderAmount = jQuery(".slider-label input[name=amount]");
	var $sliderPeople = jQuery(".slider-label input[name=people]");

	if ($sliderAmount.length > 0) {
		jQuery(".slider-label input[name=amount]").slider({
			ticks: [1, 5, 10, 20, 50, 100, 200],
			ticks_labels: ["$1", "$5", "$10", "$20", "$50", "$100", "$200"],
			ticks_positions: [0, 10, 30, 50, 70, 90, 100],
			value: 10,
			id: "blc-amount-slider"
		}).siblings(".slider").find(".slider-tick:eq(0), .slider-tick:eq(6), .slider-tick-label:eq(0), .slider-tick-label:eq(6)").hide();
	}

	if ($sliderPeople.length > 0) {
		jQuery(".slider-label input[name=people]").slider({
			ticks: [1, 10],
			ticks_labels: ["1", "10"],
			ticks_positions: [0, 100],
			value: 1,
			id: "blc-people-slider"
		});
	}

	jQuery(".blc-form").on("submit", function (e) {
		var $this = jQuery(this);
		var tester = true;
		var formObject = "";
		var messages = new Array();
		e.preventDefault();


		if ($this.find("input[name=pledge]").is(":not(:checked)")) {
			tester = false;
			$this.find("input[name=pledge]").parents("label").addClass("alarmed");
		}
		if ($this.find("input[name=name]").val() == "") {
			tester = false;
			$this.find("input[name=name]").addClass("alarmed");
		}
		if ($this.find("input[name=phone]").val() == "") {
			tester = false;
			$this.find("input[name=phone]").addClass("alarmed");
		}
		if ($this.find("input[name=zip]").val() == "") {
			tester = false;
			$this.find("input[name=zip]").addClass("alarmed");
		}
		if ($this.find("input[name=amount]").val() == "") {
			tester = false;
			$this.find("input[name=amount]").parents("label").addClass("alarmed");
		}
		if ($this.find("input[name=people]").val() == "") {
			tester = false;
			$this.find("input[name=people]").parents("label").addClass("alarmed");
		}
		if ($this.find("input[name=email]").val() == "" || !bfblglv_blc_email_validation($this.find("input[name=email]").val())) {
			tester = false;
			$this.find("input[name=email]").addClass("alarmed");
		}

		if (!tester) {
			alert("Please verify all fields");
		} else {
			formObject = $this.serializeObject();
			formObject.action = "xhr_bfblglv_blc_add_data";
			xhr_bfblglv_blc_add_data(formObject);
		}

	}).blur().on("change blur focus", ".alarmed", function () {
		jQuery(this).removeClass("alarmed");
	});

	jQuery(".carrot-chart").each(function() {
		var $this = jQuery(this);
		var $mask = null;
		var $graph = null;
		var $fill = null;
		var $goal = null;
		var $total = null;
		var $total_text = null;
		var invert_total = false;

		var goal = $this.data("goal");
		var total = $this.data("total");
		var goal_pretty = $this.data("goal-pretty");
		var total_pretty = $this.data("total-pretty");

		var percentage = 0;
		var texturePosition = 100;
		var textPosition = "50%";
		percentage = (total >= goal) ? 100 : parseFloat((total / goal) * 100).toFixed(5);
		if (percentage > 0 && percentage < 5) {
			percentage = 5;
		} else if (percentage >= 100) {
			percentage = 100;
		}
		texturePosition = (100 - percentage) + "%";

		if (percentage < 50 || percentage > 95) {
			textPosition = "50%";
			if (percentage > 95) {
				invert_total = true;
			} else { invert_total = false; }
		} else {
			textPosition = percentage + "%";
			invert_total = false;
		}

		$mask = jQuery("<div></div>").appendTo($this).addClass("mask");
		$graph = jQuery("<div></div>").appendTo($this).addClass("graph");
		$fill = jQuery("<div></div>").appendTo($graph).addClass("fill").css("top", texturePosition);
		$goal = jQuery("<div></div>").appendTo($this).addClass("goal").text("$" + goal_pretty);
		$total = jQuery("<div></div>").appendTo($this).addClass("total");
		$total_text = jQuery("<div></div>").appendTo($total).addClass("total-text").css("bottom", textPosition).text("$" + total_pretty);
		if (invert_total) { $total_text.addClass("invert"); }
	});
});