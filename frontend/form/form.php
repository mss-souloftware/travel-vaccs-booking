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
                                            <li>

                                                <div class="item">
                                                    <div class="left" bis_skin_checked="1">
                                                        <div class="top" bis_skin_checked="1">
                                                            <p class="name">CityDoc - London Bridge</p>
                                                        </div>
                                                        <div class="address" bis_skin_checked="1">
                                                            <span class="wpsl-street">2 Kentish Buildings, 125 Borough High
                                                                Street</span>

                                                            <span>London SE1 1NP</span>
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
                                                        <input type="radio" name="location" value="150"
                                                            class="check-custom">
                                                        <span class="check-toggle"></span>
                                                    </label>
                                                </div>

                                            </li>


                                            <li>

                                                <div class="item">
                                                    <div class="left" bis_skin_checked="1">
                                                        <div class="top" bis_skin_checked="1">
                                                            <p class="name">CityDoc - London Bridge</p>
                                                        </div>
                                                        <div class="address" bis_skin_checked="1">
                                                            <span class="wpsl-street">2 Kentish Buildings, 125 Borough High
                                                                Street</span>

                                                            <span>London SE1 1NP</span>
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
                                                        <input type="radio" name="location" value="150"
                                                            class="check-custom">
                                                        <span class="check-toggle"></span>
                                                    </label>
                                                </div>

                                            </li>


                                            <li>

                                                <div class="item">
                                                    <div class="left" bis_skin_checked="1">
                                                        <div class="top" bis_skin_checked="1">
                                                            <p class="name">CityDoc - London Bridge</p>
                                                        </div>
                                                        <div class="address" bis_skin_checked="1">
                                                            <span class="wpsl-street">2 Kentish Buildings, 125 Borough High
                                                                Street</span>

                                                            <span>London SE1 1NP</span>
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
                                                        <input type="radio" name="location" value="150"
                                                            class="check-custom">
                                                        <span class="check-toggle"></span>
                                                    </label>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" /> <input type="button"
                                name="previous" class="previous action-button-previous" value="Previous" />
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
                            </div>
                            <input type="button" name="next" class="next action-button" value="Next" /> <input type="button"
                                name="previous" class="previous action-button-previous" value="Previous" />
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