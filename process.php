<?php

	// Replace this with your own email address
	$to="zachschneider@gmail.com";

	// Extract form contents
	$friend_id = $_POST['friend_id'];
		
	// Return errors if present
	$errors = "";
	
	if($friend_id =='') { $errors .= "friend_id,"; }

	// Send email
	if($errors =='') {

		$headers = 'MIME-Version: 1.0' . 
					'Content-type: text/plain; charset=iso-8859-1' . 
					'From: Learnapalooza <no-reply@learnapaloozachi.com>'. "\r\n" .
					'Reply-To: '.$email.'' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		$email_subject = "Test Case";
		$message="Friend ID: $friend_id";
	
		mail($to, $email_subject, $message, $headers);
		echo "true";
	
	} else {
		echo $errors;
	}
	
?>