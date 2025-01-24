<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
 */

function custom_plugin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_vaccination_plugin';

    // Fetch all rows from the custom ticket plugin table
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY currentDate DESC");

    if ($results) { ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Submitted Tickets</h1>
            <table class="wp-list-table widefat fixed striped" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th class="manage-column column-cb check-column">
                            <input type="checkbox" id="select-all" />
                        </th>
                        <th class="manage-column column-primary">Vaccination Type</th>
                        <th>Persons</th>
                        <th>Location</th>
                        <th>Full Name</th>
                        <th>City</th>
                        <th>Created Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $row) {
                        // print_r($row);
                        ?>
                        <tr class="accordion-header" data-index="<?php echo $index; ?>" style="border-bottom: 1px solid #000;">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="ticket[]" value="<?php echo esc_attr($row->id); ?>" />
                            </th>
                            <td class="column-primary">
                                <button type="button">
                                    <strong><?php if ($row->vccsType == "1") {
                                        echo 'Travel Vaccination';
                                    } else {
                                        echo 'General Vaccination';
                                    } ?></strong>
                                </button>
                            </td>
                            <td><?php echo esc_html($row->persons); ?></td>
                            <td><?php echo esc_html(get_the_title($row->locationId)); ?></td>
                            <td><?php echo esc_html($row->fname) . ' ' . esc_html($row->lname); ?></td>
                            <td><?php echo esc_html($row->city); ?></td>
                            <td>
                                <?php
                                $currentDate = $row->currentDate;
                                $timestamp = strtotime($currentDate);
                                echo esc_html(date('F j, Y, g:i A', $timestamp));
                                ?>
                            </td>
                            <td>
                                <strong class="paymentStatus status-<?php echo esc_html($row->paymentStatus) ?>">
                                    <?php if ($row->paymentStatus === '0') {
                                        echo 'Pending';
                                    } else if ($row->paymentStatus === '1') {
                                        echo 'Accepted';
                                    } else {
                                        echo 'Rejected';
                                    }
                                    ?>

                                </strong>
                            </td>
                        </tr>
                        <tr class="accordion-content" id="accordion-content-<?php echo $index; ?>"
                            style="display: none; background-color: #f9f9f9;">
                            <td colspan="8" style="padding: 10px; border-top: 1px solid #000;">
                                <div class="columnRow">
                                    <div class="columnData">
                                        <h2>Booking Details</h2>
                                        <p><strong>Vaccination Type:</strong> <?php
                                        if ($row->vccsType == "1") {
                                            echo 'Travel Vaccination';
                                        } else {
                                            echo 'General Vaccination';
                                        }
                                        ?></p>
                                        <p><strong>Persons:</strong> <?php echo esc_html($row->persons); ?></p>
                                        <p><strong>Location:</strong> <?php echo esc_html(get_the_title($row->locationId)); ?></p>
                                        <p><strong>Schedule:</strong>
                                            <?php
                                            $schedule = $row->schedule;
                                            $timestamp = strtotime($schedule);
                                            echo esc_html(date('F j, Y, g:i A', $timestamp));
                                            ?>
                                        </p>
                                        <p><strong>Full Name:</strong>
                                            <?php echo esc_html($row->fname) . ' ' . esc_html($row->lname); ?></p>
                                        <p><strong>Email:</strong> <?php echo esc_html($row->email); ?></p>
                                        <p><strong>Phone:</strong> <?php echo esc_html($row->phone); ?></p>
                                        <p><strong>Street Address:</strong> <?php echo esc_html($row->sAddress); ?></p>
                                        <p><strong>Address Line:</strong> <?php echo esc_html($row->address2); ?></p>
                                        <p><strong>City:</strong> <?php echo esc_html($row->city); ?></p>
                                        <p><strong>Postal:</strong> <?php echo esc_html($row->postal); ?></p>
                                        <p><strong>Country:</strong> <?php echo esc_html($row->country); ?></p>
                                        <p><strong>Comment:</strong> <?php echo esc_html($row->comment); ?></p>
                                        <p><strong>Submission Date:</strong> <?php
                                        $currentDate = $row->currentDate;
                                        $timestamp = strtotime($currentDate);
                                        echo esc_html(date('F j, Y, g:i A', $timestamp));
                                        ?></p>
                                        <p><strong>Status:</strong>
                                            <?php if ($row->paymentStatus === '0') {
                                                echo 'Pending';
                                            } else if ($row->paymentStatus === '1') {
                                                echo 'Accepted';
                                            } else {
                                                echo 'Rejected';
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <div class="columnData">

                                        <div class="columnDataStatus">
                                            <h2>Change Status</h2>
                                            <select class="ticket-status" id="ticketStatus-<?php echo esc_attr($row->id); ?>">
                                                <option disabled selected value="">Change Status</option>
                                                <option value="1">Accept</option>
                                                <option value="2">Reject</option>
                                                <option value="0">Pending</option>
                                            </select>
                                            <div class="buttonColumns">
                                                <button type="button" class="save-status-ticket"
                                                    row-id="<?php echo esc_attr($row->id); ?>">Save Status</button>
                                                <button row-id="<?php echo $row->id; ?>" id="deletThisTicket">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php
    } else {
        echo '<p>No bookings found.</p>';
    }
}