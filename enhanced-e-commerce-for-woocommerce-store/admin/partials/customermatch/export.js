(function ($, window) {
  var userExportForm = function ($form) {
    this.$form = $form;
    this.xhr = false;

    this.$form.find(".conv-user-exporter-progress").val(0);
    this.processStep = this.processStep.bind(this);
    $form.on("submit", { userExportForm: this }, this.onSubmit);
  };

  userExportForm.prototype.onSubmit = function (event) {
    event.preventDefault();

    $("html, body").animate({ scrollTop: 0 }, "slow");

    var currentDate = new Date(),
      day = currentDate.getDate(),
      month = currentDate.getMonth() + 1,
      year = currentDate.getFullYear(),
      timestamp = currentDate.getTime(),
      filename =
        "user-export-" +
        day +
        "-" +
        month +
        "-" +
        year +
        "-" +
        timestamp +
        ".csv";

    event.data.userExportForm.$form.find(".conv-user-exporter-progress").val(0);
    event.data.userExportForm.$form
      .find(".user-exporter-progress-value")
      .text(conv_export_js_object.starting_process + " - 0%");
    event.data.userExportForm.processStep(1, $(this).serialize(), "", filename);
  };

  userExportForm.prototype.processStep = function (step, data, filename) {
    var $this = this;
    // var frontend = $('[name="conv_frontend_export"]').val();
    // var convert_timestamp,
    //   order_fields_alphabetically,
    //   double_encapsulate_serialized_values,
    //   display_arrays_as_comma_separated_list_of_values;

    // if (frontend == 1) {
    //   convert_timestamp = $this.$form.find('[name="convert_timestamp"]').val();
    //   order_fields_alphabetically = $this.$form
    //     .find('[name="order_fields_alphabetically"]')
    //     .val();
    //   double_encapsulate_serialized_values = $this.$form
    //     .find('[name="double_encapsulate_serialized_values"]')
    //     .val();
    //   display_arrays_as_comma_separated_list_of_values = $this.$form
    //     .find('[name="display_arrays_as_comma_separated_list_of_values"]')
    //     .val();
    // } else {
    //   convert_timestamp = $this.$form
    //     .find('[name="convert_timestamp"]')
    //     .is(":checked");
    //   order_fields_alphabetically = $this.$form
    //     .find('[name="order_fields_alphabetically"]')
    //     .is(":checked");
    //   double_encapsulate_serialized_values = $this.$form
    //     .find('[name="double_encapsulate_serialized_values"]')
    //     .is(":checked");
    //   display_arrays_as_comma_separated_list_of_values = $this.$form
    //     .find('[name="display_arrays_as_comma_separated_list_of_values"]')
    //     .is(":checked");
    // }
    jQuery("#accordionExample").hide();
    jQuery("#update-segment").prop("disabled", true);
    jQuery("#delete-segment").prop("disabled", true);
    if ($this.$form.find("#conv_export_type").val() == "api") {
      jQuery("#apiModal").removeClass("d-none");
    } else {
      jQuery("form.conv_exporter").addClass("user-exporter__exporting");
    }
    if ($this.$form.find("#conv_export_type").val() == "api") {
      $.ajax({
        type: "POST",
        url: conv_export_js_object.ajaxurl,
        data: {
          form: data,
          action: "conv_export_users_csv",
          current_url: window.location.href,
          // step: step,
          // filename: filename,
          // delimiter: $this.$form.find('[name="delimiter"]').val(),
          exportType: $this.$form.find("#conv_export_type").val(),
          segmentId: $this.$form.find("#segment_id").val(),
          role: $this.$form.find('[name="role"]').val(),
          from: $this.$form.find('[name="from"]').val(),
          to: $this.$form.find('[name="to"]').val(),
          // convert_timestamp: convert_timestamp,
          // datetime_format: $this.$form.find('[name="datetime_format"]').val(),
          // order_fields_alphabetically: order_fields_alphabetically,
          // double_encapsulate_serialized_values:
            // double_encapsulate_serialized_values,
          // display_arrays_as_comma_separated_list_of_values:
            // display_arrays_as_comma_separated_list_of_values,
          columns: $this.$form.find('[name="columns"]').val(),
          // orderby: $this.$form.find('[name="orderby"]').val(),
          // order: $this.$form.find('[name="order"]').val(),
          security: $this.$form.find("#security").val(),
        },
        dataType: "json",
        success: function (response) {
          var parsedResponse = JSON.parse(response.data.response);
          if (parsedResponse.error == false) {
            alert("Success! The operation was completed successfully.");    
          } else {
            alert(
              "Customer sync failed. Please check whether the role you selected has users."
            );
          }
          location.href = jQuery("#gotobackurl").val();
        },
      }).fail(function (response) {
        console.log("here");
      });
    }
  };

  $.fn.user_export_form = function () {
    new userExportForm(this);
    return this;
  };

  $(".conv_exporter").each(function (index, element) {
    $(element).user_export_form();
  });
})(jQuery, window);
