<?php
add_action( 'plugins_loaded', 'send_contact_email' );

function send_contact_email(){
  if(isset($_POST['contactFormSubmit']))
  {

    //print_r($_FILES);
    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    $fileContent = file_get_contents($_FILES['file']['tmp_name']);

    if($fileError == UPLOAD_ERR_OK){
      //Processes your file here
      $target_dir = WP_PLUGIN_DIR . '/db-contact-form/uploaded-files/';
      $target_file = $target_dir . basename($fileName);
      move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
   }

    // get info from post submit 
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $to = get_option('to-email', '');
    $subject = get_option('subject', '');
    $user_message = get_option('user-message', '');
    $headers = 'From: DB Websites <david.boden@db-websites.com>';

    $message = "Name: ".$fname." ".$lname."\n";
    $message .= "Email: ".$email."\n";
    $message .= "Phone: ".$phone."\n";

    $attach = $target_file;


    wp_mail($to, $subject, $message, $headers, $attach);

    //return something for the user
    $return = ['success' => 1, 'message' => $user_message];

    echo json_encode($return);

    unlink( $target_file );
  
  }
}