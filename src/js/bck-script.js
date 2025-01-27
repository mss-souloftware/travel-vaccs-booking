(function ($) {
  // Toggle accordion content
  $(".accordion-header .column-primary button").on("click", function () {
    var index = $(this).parents(".accordion-header").data("index");
    $("#accordion-content-" + index).slideToggle();
  });

  // Select all checkboxes
  $("#select-all").on("click", function () {
    $('input[name="ticket[]"]').prop("checked", this.checked);
  });



  $('.save-status-ticket').on('click', function () {
    const ticketId = $(this).attr('row-id');
    const newStatus = $(`#ticketStatus-${ticketId}`).val();

    if (!newStatus) {
      alert('Please select a status before saving.');
      return;
    }

    // AJAX request
    $.ajax({
      url: ajax_variables.ajax_url, // Use localized `ajax_url` from wp_localize_script
      type: 'POST',
      data: {
        action: 'update_ticket_status', // Action name defined in PHP
        ticket_id: ticketId,
        status: newStatus,
        security: ajax_variables.nonce // Use a nonce for security
      },
      success: function (response) {
        // console.log("Response: ", response);
        if (response.success) {
          alert('Status updated successfully.');
          location.reload();
        } else {
          alert('Error updating status: ' + response.data);
        }
      },
      error: function () {
        alert('An error occurred while updating the status.');
      }
    });
  });



  $(document.body).on('click', '#deletThisTicket', function () {
    const ticketId = $(this).attr('row-id');

    if (!confirm('Are you sure you want to delete this ticket?')) return;

    // AJAX request
    $.ajax({
      url: ajax_variables.ajax_url,
      type: 'POST',
      data: {
        action: 'delete_ticket',
        ticket_id: ticketId,
        security: ajax_variables.nonce,
      },
      success: function (response) {
        if (response.success) {
          alert('Ticket deleted successfully.');
          location.reload();
        } else {
          alert('Error deleting ticket: ' + response.data);
        }
      },
      error: function () {
        alert('An error occurred while deleting the ticket.');
      }
    });
  });



})(jQuery);
