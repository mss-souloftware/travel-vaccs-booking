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
        <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-5 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <form id="msform">
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">Which service do you require?</h2>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="fs-title">Which service do you require?</h2>
                                </div>
                            </div> <label class="fieldlabels">Email: *</label> <input type="email" name="email"
                                placeholder="Email Id" /> <label class="fieldlabels">Username: *</label> <input
                                type="text" name="uname" placeholder="UserName" /> <label class="fieldlabels">Password:
                                *</label> <input type="password" name="pwd" placeholder="Password" /> <label
                                class="fieldlabels">Confirm Password: *</label> <input type="password" name="cpwd"
                                placeholder="Confirm Password" />
                        </div> <input type="button" name="next" class="next action-button" value="Next" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="fs-title">Personal Information:</h2>
                                </div>
                            </div> <label class="fieldlabels">First Name: *</label> <input type="text" name="fname"
                                placeholder="First Name" /> <label class="fieldlabels">Last Name: *</label> <input
                                type="text" name="lname" placeholder="Last Name" /> <label class="fieldlabels">Contact
                                No.: *</label> <input type="text" name="phno" placeholder="Contact No." /> <label
                                class="fieldlabels">Alternate Contact No.: *</label> <input type="text" name="phno_2"
                                placeholder="Alternate Contact No." />
                        </div> <input type="button" name="next" class="next action-button" value="Next" /> <input
                            type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="fs-title">Image Upload:</h2>
                                </div>
                            </div> <label class="fieldlabels">Upload Your Photo:</label> <input type="file" name="pic"
                                accept="image/*"> <label class="fieldlabels">Upload Signature Photo:</label> <input
                                type="file" name="pic" accept="image/*">
                        </div> <input type="button" name="next" class="next action-button" value="Submit" /> <input
                            type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="fs-title">Finish:</h2>
                                </div>
                            </div> <br><br>
                            <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                            <div class="row justify-content-center">
                                <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image"> </div>
                            </div> <br><br>
                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    return ob_get_clean();
}