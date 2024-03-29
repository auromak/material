<?PHP
  //Form handler
  if ( $_SERVER['REQUEST_METHOD']=='GET') {
    echo "You cannot access this page directly";
    die();
  } else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {   //removed  && isset($_POST['contactus'])
      if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        if (!$captcha) {
          //Send back to form with error message;
          header("Location: /compare.html");
        }
        else {
          $captcha_resp=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeDkdYUAAAAAC-ICf5fNB4ERbUB-wF4bB22n9G6&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
          $captcha_verify = json_decode($captcha_resp);
          if ($captcha_verify->success) {
            $name = $_POST['online_name'];
            $phone = $_POST['phone_number'];
            $email = $_POST['email_address'];
            $notes = $_POST['comments'];
            //API Url
            $url = 'https://hwrescue.erpnext.com/api/resource/Online';
            //Initiate cURL.
            $ch = curl_init($url);
            //The JSON data.
            $jsonData = array(
              'online_name' => $name,
              'phone_number' => $phone,
              'email_address' => $email,
              'comments' => $notes
            );
            //Encode the array into JSON.
            $jsonDataEncoded = json_encode($jsonData);
            //Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POST, 1);
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            //Execute the request
            $result = curl_exec($ch);
            //Redirect
            header("Location: /thanks.html");

          }
          else {
            //Send back please re-do captcha
            header("Location: /about-us.html");
          }
        }
      }
    }
    exit;
  }
?>
