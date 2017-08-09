<?php
/**
 * Tumbleweed Gmail API
 * EmailImporter.php file
 * @author Rômulo Berri <romuloberri@gmail.com>
 * Mar 06 2017
 */

require_once __DIR__.'/vendor/autoload.php';

session_start();
// session_destroy();
// die();
require 'Config.php';
$cfg = new Config();


$client = new Google_Client();
$client->setAuthConfigFile($cfg->client_secret_path);
//$client->setAccessType("offline");
$client->addScope(Google_Service_Gmail::MAIL_GOOGLE_COM);



// if authenticated, returns the e-mails
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $gmail = new Google_Service_Gmail($client);
  //var_dump($gmail);
  $messages = listMessages($gmail,'me');
  //var_dump($messages);
  $jsons = get_json_messages($gmail,'me',$messages);
  //var_dump($jsons);
  $_SESSION['gmailapi_jsons'] = $jsons;

  //redirects to tumbleweed app
  //header('Location: ' . filter_var($cfg->result_uri, FILTER_SANITIZE_URL));

// if not authenticated yet, redirects to auth
} else {
  //$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/google/oauth2callback.php';
  header('Location: ' . filter_var($cfg->redirect_uri, FILTER_SANITIZE_URL));
}



/**
 * Get Message with given ID.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @param  string $messageId ID of Message to get.
 * @return Google_Service_Gmail_Message Message retrieved.
 */
function getMessage($service, $userId, $messageId) {
  try {
    $message = $service->users_messages->get($userId, $messageId);
    //print 'Message with ID: ' . $message->getId() . ' retrieved.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}

/**
 * Get list of Messages in user's mailbox.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @return array Array of Messages.
 */
function listMessages($service, $userId) {

  $opt_param = array();
    //////////////// temporary for test /////////////////

      if($_GET && array_key_exists('date', $_GET)) {
        $ini_date = date_create($_GET['date']);
        $end_date = date_add(date_create($_GET['date']), new DateInterval('P2D')) ;
      } else {
        $ini_date = date_create('02/28/2016');
        $end_date = date_create('03/01/2016');
      }
      $opt_param = array('q'=>'after:' . $ini_date->format('Y/m/d') . ' before:' . $end_date->format('Y/m/d') );
      //var_dump($opt_param);
    //////////////////////////////////////////////////////

  $pageToken = NULL;
  $messages = array();

  do {
    try {
      if ($pageToken) {
        $opt_param['pageToken'] = $pageToken;

      }
      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
      if ($messagesResponse->getMessages()) {
        $messages = array_merge($messages, $messagesResponse->getMessages());
        $pageToken = $messagesResponse->getNextPageToken();
      }
    } catch (Exception $e) {
      print 'An error occurred: ' . $e->getMessage();
    }
  } while ($pageToken);

  return $messages;
}


function dump_messages($messages) {
  foreach ($messages as $message) {
    $id = $message->getId();
    print 'Message with ID: ' . $id . '<br/>';
    $msg = getMessage($service, $userId, $id);

    foreach ($msg->payload->parts as $part) {
      $rawdata = $part->body->data;
      $sanitizedData = strtr($rawdata,'-_', '+/');
      $data = base64_decode($sanitizedData);
      echo '=======================================';
      var_dump($data);
    }
  }
}

function get_json_messages($service, $userId, $messages) {
  $result = array();
  foreach ($messages as $message) {
    $id = $message->getId();
    $msg = getMessage($service, $userId, $id);

    foreach ($msg->payload->parts as $part) {
      $rawdata = $part->body->data;
      $sanitizedData = strtr($rawdata,'-_', '+/');
      $data = base64_decode($sanitizedData);

      $pos_ini = strpos($data, '<script type="application/ld+json">');
      if ($pos_ini) {
        $pos_end = strpos($data,'</script>');
        $json = substr($data, $pos_ini + 35, $pos_end - $pos_ini - 35);
        $result[$id] = $json;
      }
    }
  }
  return $result;
}