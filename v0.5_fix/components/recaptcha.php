<?php  
   // function recaptcha(){   
$recaptchaResponse = $_POST["g-recaptcha-response"];
    
    $secretKey = "6Leb4AwmAAAAABUgVe069cqMxvFIkoZtTWQCcOKL";
    
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $data = array(
        "secret" => $secretKey,
        "response" => $recaptchaResponse
    );
    $options = array(
        "http" => array(
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($recaptchaUrl, false, $context);
    $responseData = json_decode($response, true);
    
  /*  if ($responseData && $responseData["success"] === true) {
		
        echo "reCAPTCHA verification passed!";
		exit();
    } else {
        echo "reCAPTCHA verification failed!";
		exit();
    } */
    ?>