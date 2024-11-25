<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
*/

// PayPal Payment form
require_once plugin_dir_path(__DIR__) . '/payment/paypal.php';

function vaccination_frontend()
{
    ob_start(); ?>

<div class="formWrapper">
    <form id="ticketingSubmission">
        <div class="formControl">
            <label for="task">Task</label>
            <input id="task" type="text" name="task" placeholder="Task">
        </div>

        <div class="formControl">
            <label for="date">Date</label>
            <input id="date" type="date" name="date" placeholder="Date">
        </div>

        <div class="formControl">
            <label for="time">Time</label>
            <input id="time" type="time" name="time" placeholder="Time">
        </div>

        <div class="formControl">
            <label for="address">Address</label>
            <input id="address" type="text" name="address" placeholder="Address">
        </div>

        <div class="formControl">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" placeholder="Email">
        </div>

        <div class="formControl">
            <label for="phone">Phone</label>
            <input id="phone" type="text" name="phone" placeholder="Phone">
        </div>

        <div class="formSubmit">
            <input type="submit" value="Pay & Submit Request">
        </div>

    </form>
    <?php paypalConfigForm();?>
</div>

<?php
    return ob_get_clean();
}