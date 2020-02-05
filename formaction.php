<?PHP
  //Form handler
  if ( $_SERVER['REQUEST_METHOD']=='GET') {
    echo "You cannot access this page directly";
    die();
  } else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      //Error Log
      var_dump($jsonData);
      //Redirect
      //header("Location: /thanks.html");
      exit;
    }
  }


?>
