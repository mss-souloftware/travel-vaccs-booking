<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
*/

function paypalConfigForm(){

// PayPal Configuration
define('PAYPAL_EMAIL', 'sb-hjjsi25330300@business.example.com');
define('RETURN_URL', "http://localhost/membership/sample-page/?payment=true");
define('CANCEL_URL', "http://localhost/membership/sample-page/");
define('NOTIFY_URL', "http://localhost/membership/sample-page/");
define('PAYPAL_CURRENCY', 'EUR');
define('SANDBOX', TRUE);
define('LOCAL_CERTIFICATE', FALSE);

$paypal_url = SANDBOX ? "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr" : "https://ipnpb.paypal.com/cgi-bin/webscr";
define('PAYPAL_URL', $paypal_url);

?>
<div  class="chocoletrasPlg__wrapperCode-payment-buttons-left">
    <form style="display:none;" id="payPayPal" action="<?php  echo $paypal_url; ?>" method="post">
        <!-- PayPal business email to collect payments -->
        <input type='hidden' name='business' value="<?php echo PAYPAL_EMAIL; ?>">

        <input type="hidden" name="item_name" value="<?php echo 'Msufyan' ?>">
        <input type="hidden" name="item_number" value="<?php echo '1222' ?>">
        <input type="hidden" name="amount" value="<?php echo '12.22' ?>">

        <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
        <input type='hidden' name='no_shipping' value='1'>
        <input type="hidden" name="lc" value="" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="page_style" value="paypal" />
        <input type="hidden" name="charset" value="utf-8" />


        <input type='hidden' name='return' value="<?php echo RETURN_URL; ?>">
        <input type='hidden' name='cancel_return' value="<?php echo CANCEL_URL; ?>">
        <input type='hidden' name='notify_url' value="<?php echo NOTIFY_URL; ?>">

        <input type="hidden" name="cmd" value="_xclick">
        <input type="submit" value="Pay">

    </form>

</div>

<?php } ?>