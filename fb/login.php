
<?php

if(!session_id()) {
    session_start();
}
$_SESSION['fb_access_token'] = '';
$_SESSION['fb_tokenMetadata'] = '';

require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '259150917920223', // Replace {app-id} with your app id
  'app_secret' => '44cee4dc7e3398728a3bdff897eac940',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$callbackurl = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/fb-callback.php';
var_dump($callbackurl);die();
$loginUrl = $helper->getLoginUrl($callbackurl , $permissions);

header('Location:' . $loginUrl);
// echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a><br>';

// echo $callbackurl;


