<?php

// require 'send_form.php';

function db_contact_form(){
    $db_form_html = '<div id="form-container">';

    $db_form_html .= '<form id="contact-form" enctype="multipart/form-data" method="post" name="myemailform" action="send_form.php">';

    $db_form_html .= '<div class="flex-row">';
    $db_form_html .= '<div class="flex-col required">';
    $db_form_html .= '<label for="fname">First Name</label>';
    $db_form_html .= '<input id="fname" type="text" name="fname" value="David"/>';
    $db_form_html .= '<span class="error"></span>';
    $db_form_html .= '</div>';
    
    $db_form_html .= '<div class="flex-col required">';
    $db_form_html .= '<label for="lname">Last Name</label>';
    $db_form_html .= '<input id="lname" type="text" name="lname" value="Boden"/>';
    $db_form_html .= '<span class="error"></span>';
    $db_form_html .= '</div>';
    $db_form_html .= '</div>';

    $db_form_html .= '<div class="flex-row">';
    $db_form_html .= '<div class="flex-col required">';
    $db_form_html .= '<label for="email">Email</label>';
    $db_form_html .= '<input id="user-email" type="email" name="email" value="test@gmail.com"/>';
    $db_form_html .= '<span class="error"></span>';
    $db_form_html .= '</div>';

    $db_form_html .= '<div class="flex-col required">';
    $db_form_html .= '<label for="phone">Phone Number</label>';
    $db_form_html .= '<input id="user-phone" type="phone" name="phone" value="616-259-3923"/>';
    $db_form_html .= '<span class="error"></span>';
    $db_form_html .= '</div>';
    $db_form_html .= '</div>';

    $db_form_html .= '<div>';
    $db_form_html .= '<label>Upload Images</label>';
    $db_form_html .= '<input id="files" name="files" type="file" />';      
    $db_form_html .= '</div>';

    $db_form_html .= '<input id="submit" type="submit" name="contact-submit" value="Submit" onclick="submitContactForm()"/>';

    $db_form_html .= '<div class="form-sending">Sending.....</div>';

    $db_form_html .= '</div>';

   

    $db_form_html .= '</form>';
    
    $db_form_html .= '</div>';

    return $db_form_html;
}
add_shortcode('db_contact_form','db_contact_form');



?>