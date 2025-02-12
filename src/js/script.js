(function ($) {
  $(document).ready(function ($) {

    $(document.body).on("click", ".firstStep .typeCard", function () {
      $(".firstStep .typeCard").removeClass("active");
      $(this).addClass("active");
      let vaccTypeVal = $(this).attr("data-id");
      $("#vccsType").val(vaccTypeVal);
    })

    $(document.body).on("change", "#adults", function () {
      if ($(this).val() != "") {
        $("#adultsBtn").removeAttr("disabled");
      }
    })

    $(document.body).on("click", ".thirdStep ul li .item", function () {
      let locationTitle = $(this).find(".name").text();
      $("#locationTItle").text(locationTitle)
      if ($("locationId").val() != "") {
        $("#locationIdPass").removeAttr("disabled");
      }
    })

    $(document.body).on("click", ".daySlotBox .timeSlots li", function () {
      $(".daySlotBox .timeSlots li").removeClass("active");
      $(this).addClass("active");
      $("#adultsBtn").removeAttr("disabled");
      $("#schedule").val(`${$(this).text()},${$(this).attr("data-id")}`);
    })

    $('#msform').on('submit', function (e) {
      e.preventDefault(); // Prevent default form submission

      // Gather form data
      const formData = {
        action: 'submit_vaccination_form',
        nonce: $('input[name="nonce"]').val(),
        vccsType: $('input[name="vccsType"]').val(),
        adults: $('#adults').val(),
        locationId: $('input[name="locationId"]').val(),
        schedule: $('input[name="schedule"]').val(),
        fname: $('input[name="fname"]').val(),
        lname: $('input[name="lname"]').val(),
        email: $('input[name="email"]').val(),
        phone: $('input[name="phone"]').val(),
        sAddress: $('input[name="sAddress"]').val(),
        address2: $('input[name="address2"]').val(),
        city: $('input[name="city"]').val(),
        country: $('input[name="country"]').val(),
        postal: $('input[name="postal"]').val(),
        comment: $('textarea[name="comment"]').val(),
        paymentStatus: 0,
      };

      // Make AJAX request
      $.ajax({
        url: ajax_variables.ajax_url, // WordPress global AJAX URL
        type: 'POST',
        data: formData,
        beforeSend: function () {
          console.log('Submitting...');
        },
        success: function (response) {
          console.log('Response:', response); // Log the full response
          if (response.success) {
            alert(response.data.message);
            $('#msform')[0].reset();
          } else {
            alert('Error: ' + (response.data?.message || 'Unknown error occurred.'));
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', status, error);
          alert('An error occurred. Please try again.');
        },
        complete: function () {
          console.log('Submission complete.');
        },
      });
    });



    $(document).on("click", ".thirdStep ul li .item", function () {
      $(".thirdStep ul li .item").removeClass("active");
      $(this).addClass("active");
      $(this).find(".check-custom").prop("checked", true);

      let checkedValue = $(this).find(".check-custom").val();
      $("#locationId").val(checkedValue);
    });

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function () {
      current_fs = $(this).parents("fieldset");
      next_fs = $(this).parents("fieldset").next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative",
            });
            next_fs.css({ opacity: opacity });
          },
          duration: 500,
        }
      );
      setProgressBar(++current);
    });

    $(".previous").click(function () {
      current_fs = $(this).parents("fieldset");
      previous_fs = $(this).parents("fieldset").prev();

      //Remove class active
      $("#progressbar li")
        .eq($("fieldset").index(current_fs))
        .removeClass("active");

      //show the previous fieldset
      previous_fs.show();

      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative",
            });
            previous_fs.css({ opacity: opacity });
          },
          duration: 500,
        }
      );
      setProgressBar(--current);
    });

    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar").css("width", percent + "%");
    }

    $(".submit").click(function () {
      return false;
    });

    $(document).on("click", "#locationIdPass", function () {
      let locationId = $("#locationId").val();

      if (locationId) {
        // Show the loader
        $("#loaderScreen").show();

        $.post(
          ajax_variables.ajax_url,
          {
            action: "fetch_slots",
            location_id: locationId,
            nonce: ajax_variables.nonce,
          },
          function (response) {
            if (response.success) {
              let slotsHtml = "";

              response.data.slots.forEach((day) => {
                slotsHtml += `<li>
                                <h2>${day.day} ${day.date}</h2>
                                <ul class="timeSlots">
                                    ${day.slots
                    .map((slot) => `<li data-id="${day.date}">${slot}</li>`)
                    .join("")}
                                </ul>
                              </li>`;
              });

              $(".slots .daySlotBox").html(slotsHtml); // Update slots dynamically
            } else {
              $(".slots .daySlotBox").html("<p>No slots available.</p>");
            }
          }
        )
          .fail(function () {
            $(".slots .daySlotBox").html("<p>An error occurred while fetching slots.</p>");
          })
          .always(function () {
            // Hide the loader when the request completes
            $("#loaderScreen").hide();
          });
      }
    });

  });
})(jQuery);
