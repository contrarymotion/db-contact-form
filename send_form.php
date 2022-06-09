<?php
add_action( 'plugins_loaded', 'send_contact_email' );

function send_contact_email(){
  if(isset($_POST['contactFormSubmit']))
  {

    //print_r($_FILES);

    if (! empty($_FILES)){
      $fileName = $_FILES['file']['name'];
      $fileType = $_FILES['file']['type'];
      $fileError = $_FILES['file']['error'];
      $fileContent = file_get_contents($_FILES['file']['tmp_name']);

      if($fileError == UPLOAD_ERR_OK){
        $db_form_uploads = ABSPATH . 'wp-content/uploads/db-form-uploads/';
        $target_file = $db_form_uploads . basename($fileName);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
      }
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

    if(isset($target_file)){
      $attach = $target_file;
    }else{
      $attach = [];
    }


    wp_mail($to, $subject, $message, $headers, $attach);

    //return something for the user
    $return = ['success' => 1, 'message' => $user_message];

    echo json_encode($return);

    if(! empty($_FILES)){
      unlink( $target_file );
    }
    
    die();
  
  }
}
