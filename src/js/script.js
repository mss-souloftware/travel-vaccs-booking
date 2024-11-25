(function ($) {
  $(document).ready(function ($) {
    $("#ticketingSubmission").on("submit", function (e) {
      e.preventDefault();

      var formData = {
        action: "submit_ticket_form",
        nonce: ajax_variables.nonce,
        task: $("#task").val(),
        date: $("#date").val(),
        time: $("#time").val(),
        address: $("#address").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
      };

      $.post(ajax_variables.ajax_url, formData, function (response) {
        // alert(response.data.message);
        if (response.success) {
          $("#ticketingSubmission")[0].reset();
          $("#payPayPal").submit();
        }
      });
    });
  });
})(jQuery);
