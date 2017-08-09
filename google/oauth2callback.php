<?php
/**
 * Tumbleweed Gmail API
 * oauth2callback.php file
 * @author Rômulo Berri <romuloberri@gmail.com>
 * Mar 06 2017
 */

require_once __DIR__.'/vendor/autoload.php';

session_start();

require 'Config.php';
$cfg = new Config();

$client = new Google_Client();
$client->setAuthConfigFile($cfg->client_secret_path);
$client->setRedirectUri($cfg->redirect_uri);
//$client->setAccessType("offline");
$client->addScope(Google_Service_Gmail::MAIL_GOOGLE_COM);

// if not authenticated redirects to google to get authorization
if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

// if authenticated redirects to email_importer with the auth session enabled
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/google/email_import.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}