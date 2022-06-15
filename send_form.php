<?php
add_action( 'plugins_loaded', 'send_contact_email' );

function send_email($attach){
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

  wp_mail($to, $subject, $message, $headers, $attach);

  //return something for the user
  $return = ['success' => 1, 'message' => $user_message];

  echo json_encode($return);
}

function send_error_message($mess){
  $err_message = 'No file sent';
  $return = ['success' => 0, 'message' => $mess];
  echo json_encode($return);
}

function send_contact_email()
{
  if(isset($_POST['contactFormSubmit']))
  {

    //print_r($_FILES);

    if (! empty($_FILES))
    {
      $fileName = $_FILES['file']['name'];
      $fileType = $_FILES['file']['type'];
      $fileError = $_FILES['file']['error'];
      

      if($fileError == UPLOAD_ERR_OK){
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
        $db_form_uploads = ABSPATH . 'wp-content/uploads/db-form-uploads/';
        $target_file = $db_form_uploads . basename($fileName);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_file);

        send_email($target_file);

        if(! empty($_FILES)){
          unlink( $target_file );
        }
      }elseif($fileError == UPLOAD_ERR_NO_FILE){

        send_error_message('No file sent');
        
      }elseif($fileError == UPLOAD_ERR_INI_SIZE || $fileError == UPLOAD_ERR_FORM_SIZE){
        send_error_message('Upload exceeds file size');
      }else{
        send_error_message('Whoa!  I blacked out and don\'t know what happened.  Please let the site owner know about this issue');
      }
    }else{
      send_email(null);
    }
    
    
    
    die();
  
  }
}
