<?php
/**
 * Plugin Name:       DB Simple Contact Form
 * Plugin URI:        https:www.db-websites.com
 * Description:       Add a contact form to your website
 * Version:           1.0
 * Author:            David
 * Author URI:        https:www.db-websites.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 */

// ini_set('display_errors', 1); 
// error_reporting(E_ALL);

function db_contact_form_options_page()
{

    add_menu_page(
        'Contact Form Settings',
        'Contact Form',
        'manage_options',
        'contact-form-settings',
        'contact_form_settings_html'
    );
}
add_action('admin_menu', 'db_contact_form_options_page');

if ( ! is_dir( ABSPATH . 'wp-content/uploads/db-form-uploads' ) ) {
    wp_mkdir_p( ABSPATH . 'wp-content/uploads/db-form-uploads' );
}

function add_contact_form_admin_styles(){
    wp_enqueue_style('contact-form-admin-styles', plugins_url( '/admin-menu-style.css', __FILE__ ));
}
add_action('admin_enqueue_scripts', 'add_contact_form_admin_styles');

require 'send_form.php';
require 'db-form-html.php';

function contact_form_settings_html()
{

    if(array_key_exists('submit-settings', $_POST))
    {
        //updating button options
        update_option('to-email', $_POST['to-email']);
        update_option('subject', $_POST['subject']);
        update_option('user-message', $_POST['user-message']);

    }

    //variables to hold widget settings
    $to_email = get_option('to-email', '');
    $subject = get_option('subject', '');
    $user_message = get_option('user-message', '');
?>
    <div id="db-admin" class="wrap">
        <form method="post" action="">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <div id="act_settings_container">
                <div id="tab_information_container">
                    
                    <div class="settings_tab_info open">
                    <h2>Contact Form Settings</h2>

                        <div class="col">
                            <div>

                                <label for="to-email">Email (to receive the form information)</label>
                                <input type="text" name="to-email" value="<?php print $to_email ?>"/>

                                <label for="subject">Subject of the Email</label>
                                <input type="text" name="subject" value="<?php print $subject ?>"/>

                                <label for="user-message">Message to display when form is submitted</label>
                                <textarea rows="5" name="user-message"><?php print $user_message ?></textarea>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" name="submit-settings" value="Submit Settings" class="button button-primary" id="db-settings-submit-button"/>
        </form> 
    </div>
<?php
}
