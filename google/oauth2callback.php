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
//$client->setApplicationName("Tumbleweed");
$client->setAuthConfigFile($cfg->client_secret_path);
$client->setRedirectUri($cfg->redirect_uri);
$client->setAccessType("offline");
$client->setIncludeGrantedScopes(true);
//$client->addScope(Google_Service_Gmail::MAIL_GOOGLE_COM);
$client->setScopes($cfg->scopes);

// google redirects to this php sending a code by get
if (isset($_GET['code']) && !empty($_GET['code'])) {

    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/google/email_import.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

// else is the app that asked to authenticate, so redirect to google to authenticate.
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

}