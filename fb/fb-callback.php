<?php
if(!session_id()) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '259150917920223', // Replace {app-id} with your app id
  'app_secret' => '44cee4dc7e3398728a3bdff897eac940',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
// echo '<h3>Access Token</h3>';
// var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// echo '<h3>Metadata</h3><pre>';
// var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('259150917920223'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  // echo '<h3>Long-lived</h3>';
  // var_dump($accessToken->getValue());
}

 try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name,email,hometown,first_name,middle_name,last_name,birthday,picture.type(large) ', $accessToken->getValue());
    //$picture = $fb->get('/me/picture?type=large', $accessToken->getValue());
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$userdata = $response->getGraphUser();
// echo '<h3>User Data</h3><pre>';
// var_dump($userdata);
//var_dump($picture);

// WARNING: If set a Facebook object on session Zend will try to autoload its class and it will crashes!!!!

$_SESSION['fb_access_token'] = (string) $accessToken->getValue();

$_SESSION['fb_tokenMetadata']['id'] = (string) $userdata['id'];
$_SESSION['fb_tokenMetadata']['name'] = (string) $userdata['name'];
$_SESSION['fb_tokenMetadata']['firstname'] = (string) $userdata['first_name'];
$_SESSION['fb_tokenMetadata']['lastname'] = (string) $userdata['last_name'];
$_SESSION['fb_tokenMetadata']['email'] = (string) $userdata['email'];
$_SESSION['fb_tokenMetadata']['photo'] = (string) $userdata['picture']['url'];

// echo '<h3>Session Metadata</h3><pre>';
// var_dump($_SESSION['fb_tokenMetadata']);


// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
$callbackurl = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../site/login/facebook';
header("Location: $callbackurl");
//
//