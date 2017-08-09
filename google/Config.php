<?php
/**
 * Tumbleweed Gmail API
 * config.php file
 * @author Rômulo Berri <romuloberri@gmail.com>
 * Mar 06 2017
 */

/**
* Google API configurations
*/
class Config
{
    public $client_secret_path;
    public $redirect_uri;
    public $result_uri;

    function __construct()
    {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            ini_set('display_errors',1);
            ini_set('display_startup_erros',1);
            error_reporting(E_ALL);

            $this->redirect_uri = 'http://localhost/traveltrack/google/oauth2callback.php';
            $this->result_uri = 'http://localhost/traveltrack/site/gmailapi/testresult';
        } else {
            $this->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/google/oauth2callback.php';//TODO: verify this
            $this->result_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/site/gmailapi/testresult';
        }

        $this->client_secret_path = __DIR__ . '/client_secret_oAuth.json';
    }
}