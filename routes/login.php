<?php

$webmail = trim(htmlspecialchars($_POST["webid"]));
$password = trim(htmlspecialchars($_POST["pass"]));
$data = [
  'email' => $webmail,
  'password'=>$password
];
$httpcode= httpPost("http://localhost:4000/api/students/login",$data);// use LDAP url here


if($httpcode == 200)
{
    echo "success!!!";
    session_start();
    $_SESSION['webmail'] = $webmail;
    echo "<script> location.href='../routes/userDetails.php'; </script>";
}else{
    echo "Invalid Credentials";
}
//using php curl (sudo apt-get install php-curl) 
function httpPost($url, $data){
  $curl = curl_init($url);
// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// Set the CURLOPT_POST option to true for POST request
curl_setopt($curl, CURLOPT_POST, true);
// Set the request data as JSON using json_encode function
curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json'
]);
  
  $response = curl_exec($curl);
  $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);

  return $httpcode;
}

?>