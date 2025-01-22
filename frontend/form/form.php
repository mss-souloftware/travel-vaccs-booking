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


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <form id="msform">
                    <fieldset class="firstStep">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">Which service do you require?</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="typeCard next">
                                        <h2 class="fs-title">Travel vaccination</h2>
                                        <p>
                                            Book a consultation with a nurse, who will administer any vaccinations you
                                            may
                                            need after discussing your requirements
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="typeCard next">
                                        <h2 class="fs-title">General vaccination</h2>
                                        <p>
                                            This includes non-travel vaccinations such as HPV and flu.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="bottomText">
                                        <p>If you need to book multiple services, please book separate
                                            appointments or call us on 020 8261 7548</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="secondStep">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">How many people are you booking for?</h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6 text-center">
                                    <label for="adults" class="fieldlabels">Number of people
                                    </label>

                                    <select name="adults" id="adults" class="select-hidden">
                                        <option value="">Please Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="bottomText">
                                        <p>All appointments are subject to a consultation fee.
                                            See our pricing page for more details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" /> <input type="button"
                            name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset class="thirdStep">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">Select location</h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6 text-center">
                                    <label for="postcode" class="fieldlabels">Enter your postcode for your nearest
                                        clinics</label>
                                    <input type="text" name="postcode" id="postcode" placeholder="e.g. WC1X 8BP" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <ul>
                                        <?php
$args = array(
    'post_type'      => 'locations',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
);

$query = new WP_Query($args);
$postDetails = $query->posts;

if ($postDetails) {
    foreach ($postDetails as $post) {
        setup_postdata($post);

        // Fetch custom fields
        $start_time    = get_post_meta($post->ID, 'start_time', true); // e.g., "09:00"
        $end_time      = get_post_meta($post->ID, 'end_time', true);   // e.g., "17:00"
        $slot_duration = get_post_meta($post->ID, 'slot_duration', true); // e.g., 30 (minutes)
        $days          = get_post_meta($post->ID, 'days', true);

        // Convert times to DateTime objects
        $start = DateTime::createFromFormat('H:i', $start_time);
        $end = DateTime::createFromFormat('H:i', $end_time);

        // Handle $days as string or array
        if (is_array($days)) {
            $days_array = $days; // Use array directly
        } elseif (is_string($days)) {
            $days_array = explode(', ', $days); // Convert comma-separated string to array
        } else {
            $days_array = []; // Default to empty array
        }
        ?>
                                        <?php /*
                                        <li>
                                            <p>Available Slots for <?php echo $post->post_title; ?>:</p>
                                        <?php if ($start && $end && $slot_duration && $days_array) : ?>
                                        <ul>
                                            <?php foreach ($days_array as $day) : ?>
                                            <li>
                                                <strong><?php echo $day; ?>:</strong>
                                                <ul>
                                                    <?php
                                // Generate slots for the day
                                $slots = [];
                                $current_time = clone $start; // Clone the start time to avoid overwriting
                                while ($current_time < $end) {
                                    $slots[] = $current_time->format('H:i'); // Add slot
                                    $current_time->modify("+{$slot_duration} minutes"); // Increment by slot duration
                                }
                                ?>
                                                    <?php foreach ($slots as $slot) : ?>
                                                    <li><?php echo $slot; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php else : ?>
                                        <p>No slots available.</p>
                                        <?php endif; */     ?>
                                        <li>
                                            <div class="item">
                                                <div class="left" bis_skin_checked="1">
                                                    <div class="top" bis_skin_checked="1">
                                                        <p class="name"><?php echo $post->post_title;?></p>
                                                    </div>
                                                    <div class="address" bis_skin_checked="1">
                                                        <span
                                                            class="wpsl-street"><?php  echo $post->post_content; ?></span>
                                                    </div>

                                                    <div class="meta" bis_skin_checked="1">
                                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M19.7,3.3A1.1,1.1,0,0,0,19,3H16V1a1,1,0,0,0-2,0V3H6V1A1.1,1.1,0,0,0,5,0,1.1,1.1,0,0,0,4,1V3H1A1.1,1.1,0,0,0,0,4V19a1.1,1.1,0,0,0,1,1H19a1.1,1.1,0,0,0,1-1V4A.9.9,0,0,0,19.7,3.3ZM18,18H2V10H18ZM18,8H2V5H18Z">
                                                            </path>
                                                        </svg>
                                                        <span class="slots-no">101</span> appointments available this
                                                        week
                                                    </div>
                                                </div>
                                                <label>
                                                    <input type="radio" name="location" value="<?php echo $post->ID;?>"
                                                        class="check-custom">
                                                    <span class="check-toggle"></span>
                                                </label>
                                            </div>

                                        </li>
                                        <?php
                                            }
                                        } else {
                                            echo '<p>No locations found.</p>';
                                        }

                                        // Restore original post data
                                        wp_reset_postdata();
                                        ?>




                                    </ul>
                                    <input type="hidden" id="locationId">
                                </div>
                            </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" id="locationIdPass" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset class="fourthStep">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">Select time</h2>
                                    <p>
                                        CityDoc - London Bridge
                                    </p>
                                </div>
                            </div>

                            <div class="slots">
                                <ul class="daySlotBox"></ul>
                            </div>

                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" /> <input type="button"
                            name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset class="finalStep">
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="fs-title">Confirmation</h2>
                                    <p>
                                        Please double check your appointment before confirming.
                                        <br>
                                        Please fill out your details, any other people’s details will be recorded in
                                        clinics.
                                    </p>
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="formCol">
                                    <label class="fieldlabels">First Name: *</label>
                                    <input type="text" name="fname" placeholder="First Name" />
                                </div>
                                <div class="formCol">
                                    <label class="fieldlabels">Last Name: *</label>
                                    <input type="text" name="lname" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="formCol">
                                    <label class="fieldlabels">Email *</label>
                                    <input type="email" name="email" placeholder="Email" />
                                </div>
                                <div class="formCol">
                                    <label class="fieldlabels">Confrim Email *</label>
                                    <input type="email" name="cemail" placeholder="Confrim Email" />
                                </div>
                            </div>
                            <div class="formRow">
                                <div class="formColFull">
                                    <label class="fieldlabels">Mobile *</label>
                                    <input type="number" name="mobile" placeholder="Mobile" />
                                </div>
                            </div>

                            <div class="formRow">
                                <div class="formCol">
                                    <label class="fieldlabels">
                                        Street Address *</label>
                                    <input type="text" name="address" placeholder="Street Address" />
                                </div>
                                <div class="formCol">
                                    <label class="fieldlabels">
                                        Address Line 2 *</label>
                                    <input type="text" name="address2" placeholder="Address Line 2" />
                                </div>
                            </div>

                            <div class="formRow">
                                <div class="formColThree">
                                    <label class="fieldlabels">
                                        City *</label>
                                    <input type="text" name="city" placeholder="City" />
                                </div>
                                <div class="formColThree">
                                    <label class="fieldlabels">
                                        Country *</label>
                                    <input type="text" name="country" placeholder="Country" />
                                </div>
                                <div class="formColThree">
                                    <label class="fieldlabels">
                                        Postal Code *</label>
                                    <input type="text" name="postal" placeholder="Postal Code" />
                                </div>
                            </div>

                            <div class="formRow">
                                <div class="formColFull">
                                    <label class="fieldlabels">Comment</label>
                                    <textarea name="comment" placeholder="Write your comment here."></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="next" class="action-button" value="Next" />
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    return ob_get_clean();
}