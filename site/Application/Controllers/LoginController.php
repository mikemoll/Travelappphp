<?php

include_once 'AbstractController.php';

/**
 * Controller que cria e trata as requests da tela de login
 *
 * @author 	Leonardo Danieli
 * @copyright 	Work 4Coffee
 * @package     sistema
 * @subpackage	sistema.apllication.controllers
 * @version		1.0
 */
class LoginController extends AbstractController {

    public function init() {
//        parent::init();

        Browser_Control::setScript('js', 'md5', 'md5.js');
        Browser_Control::setScript('js', 'BorwserControl', '../Browser/Control.js');
    }

    public function indexAction() {
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formLogin');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $element = new Ui_Element_Checkbox('remember');
        $element->setAttrib('label', 'Lembre-me');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cFALSE);

        $element = new Ui_Element_Hidden('next');
        $element->setValue($post->next);
        $form->addElement($element);

        $element = new Ui_Element_Text('user');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setValue($_COOKIE['userName']);
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'user');
        $element->setAttrib('required', '');
        $element->setAttrib('autofocus', '');
        $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senha');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'pass');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnLogin');
        $button->setDisplay('Sign In');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-primary btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnLoginFacebook');
        $button->setDisplay('Login with FB');
        $button->setHref(HTTP_REFERER . $this->Action . 'login/facebooklogin');
        $button->setAttrib('class', 'btn btn-success btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnCreate');
        $button->setDisplay('Create an account');
        $button->setHref(HTTP_REFERER . $this->Action . 'login/newuser');
        $button->setAttrib('class', 'btn btn-danger btn-cons m-t-10');
        $form->addElement($button);

        // $button = new Ui_Element_Btn('btnEsqueci');
        // $button->setDisplay('Forgot My Pass');
        // $button->setAttrib('sendFormFields', '1');
        // $button->setAttrib('class', 'btn btn-info btn-cons m-t-10');
        // $form->addElement($button);

        $form->setDataSession('formLogin');

        $view = Zend_Registry::get('view');
        $view->assign('background',BASE_URL.'Public/assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg' );
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'Login');
        $view->assign('msg', $post->msg);
        $html = $form->displayTpl($view, 'Login/form.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');
//		$view->output('index.tpl');
    }

    public function btnloginclickAction() {
        $form = Session_Control::getDataSession('formLogin');

        $limpaSession = false;

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $post = Zend_Registry::get('post');

//        if ($post->remember) {
        $cookie_name = "userName";
        $cookie_value = $post->user;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//        }
        $users = new Usuario();
        $users->where('loginuser', $post->user);
        $users->where('senha', Format_Crypt::encryptPass($post->senha));
        $users->where('ativo', 'S');
        $user = $users->readLst()->getItem(0);
        if ($user) {
            $tempo = DataHora::daysBetween($user->getDataSenha(), date('d/m/Y'));


            $config = new Config();
            $config->read(1);
            if ($config->getTrocaSenhaTempo() == cTRUE && $config->getTempoTrocaSenha() <= $tempo) {
                $url = BASE_URL . 'login/trocasenha/id/' . $user->getID() . '/m/outdated';
                Log::createLogFile('O usuario ' . $user->getNomeCompleto() . ' Foi enviado para a Troca de Senha por tempo sem trocá-la');
            } else {
                if ($post->next != '') {
                    $url = base64_decode($post->next);
                } else if ($user->getPaginaInicial() != '') {
                    $url = BASE_URL . $user->getPaginaInicial();
                } else {
                    $url = BASE_URL . 'index';
                }
                Log::createLogFile('O usuário ' . $user->getNomeCompleto() . ' acessou o sistema');
            }
            $session = Zend_Registry::get('session');
            $session->usuario = $user;
            Zend_Registry::set('session', $session);

//            $br->setHtml('msg', 'Olá <strong>' . $user->getNomeCompleto() . '</strong>! <br>Seja bem-vindo!');
//            $br->setClass('msg', 'alert alert-success');
//            $br->setCommand('$("#loginbox").animate({
//                opacity: 0,
//                top: "-=50"
//                        // height: "toggle"
//            }, 400, function () {
//                window.location = "' . $url . '" ;
//            });');
            $br->setBrowserUrl($url);
            $limpaSession = true;
        } else {
            $br->addFieldValue('senha', '');
            $br->addFieldValue('user', '');
            $br->setDataForm('formLogin');
            $br->setMsgAlert("Whoops!", "User and password doesn't match");
        }
        $br->send();
        if ($limpaSession) {
            Session_Control::setDataSession('formLogin', '');
        }
    }

    public function trocasenhaAction() {

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
        $userId = Session_Control::getPropertyUserLogado('id');

        if ($userId != '') {
            $id = $userId;
        } else {
            $id = $post->id;
        }

        $m = $post->m;
        if ($m == 'outdated') {
            $msg = "Your password needs to be frequently changed by security reasons.";
        }

        $form = new Ui_Form();
        $form->setName('formTrocaSenha');
        $form->setAction('Login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $element = new Ui_Element_Hidden('idUser');
        $element->setValue($id);
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaAtual', 'Current password');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Current password');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNova', 'New password');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'New password');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNovaAgain', 'Confirm the new password');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Confirm the new password');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
        $form->addElement($element);

//		$element = new Ui_Element_Password('senhaAtual');
//		$element->setAttrib('maxlength', '30');
//		$element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
//		$element->setAttrib('cript', '1');
//		$element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
//		$form->addElement($element);
//		$element = new Ui_Element_Password('senhaNova');
//		$element->setAttrib('maxlength', '30');
//		$element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
//		$element->setAttrib('cript', '1');
//		$element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
//		$form->addElement($element);

        $button = new Ui_Element_Btn('btnTrocaSenha');
        $button->setDisplay('Change password');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-md btn-primary');
        if ($id != '') {
            $button->setAttrib('params', 'id=' . $id);
        }
        $form->addElement($button);

//		$button = new Ui_Element_Btn('btnTrocaSenha');
//		$button->setDisplay('OK', PATH_IMAGES.'Buttons/Ok.png');
//		$button->setAttrib('sendFormFields', '1');
//		$form->addElement($button);

        $form->setDataSession('formLogin');

        $view = Zend_Registry::get('view');
//		$w = new Ui_Window('trocaSenha', 'Alterar senha', $form->displayTpl($view, 'Login/trocasenha.tpl'));
//		$w->setDimension('300', '140');
//		$w->setCloseOnEscape('false');
//		$w->setNotDraggable();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', 'Change password');
        $view->assign('msg', $msg);

        $view->assign('body', $form->displayTpl($view, 'Login/trocasenha.tpl'));
        $view->output('index.tpl');
    }

    public function btntrocasenhaclickAction() {
        $form = Session_Control::getDataSession('formLogin');

        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $valid = $form->processAjax($_POST);

        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $user = new Usuario();
        $user->read($post->idUser);

        if (Format_Crypt::encryptPass($post->senhaAtual) != $user->getSenha()) {
            $br->setAlert('Incorrect password', 'The password typed is incorrect.<br/>Try again.', 300);
            $br->send();
            exit;
        } else {
            $user->setSenha(Format_Crypt::encryptPass($post->senhaNova));
            $user->setDataSenha(date('m/d/Y'));

            $session = Zend_Registry::get('session');
            $session->usuario = $user;
            Zend_Registry::set('session', $session);

            $user->save();

//            Zend_Session::destroy();
        }
        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function logoutAction() {
        Log::createLogFile('The user ' . Session_Control::getPropertyUserLogado('nomecompleto') . ' logouts from the app.');
        Zend_Registry::set('session', array());
        Zend_Session::destroy();
        $this->_redirect('./login');
    }

    public function newuserAction() {
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance('newUser');

        $element = new Ui_Element_Text('nomeCompleto');
        $element->setAttrib('maxlength', '35');
        $element->setRequired();
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'First name');
        $element->setAttrib('autofocus', '');
        $form->addElement($element);


        $element = new Ui_Element_Text('lastname');
        $element->setAttrib('maxlength', '35');
        $element->setRequired();
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'Last name');
        $form->addElement($element);


        $element = new Ui_Element_Text('loginUser');
        $element->setAttrib('maxlength', '30');
        $element->setHideRemainingCharacters();
        $element->setRequired();
        $element->setAttrib('placeholder', 'User name');
        // $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senha');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('cript', '1');
        $element->setAttrib('placeholder', 'Password');
        $element->setRequired();
        //$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('confirmpassword');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('cript', '1');
        $element->setAttrib('placeholder', 'Confirm password');
        $element->setRequired();
        //$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('termsofuse');
        $element->setAttrib('label', 'I agree with the <a href="#" class="text-info">terms of use.</a>'); //
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnRegister');
        $button->setDisplay('Register');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnCancel');
        $button->setDisplay('Cancel');
        $button->setHref(HTTP_REFERER . $this->Action . 'login');
        $button->setAttrib('class', 'btn btn-cancel btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/1.jpg' );
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');
    }


    public function validDate($mdY) {
        $d = explode('/',$mdY);
        return (count($d) == 3) and checkdate($d[0],$d[1],$d[2]);
    }

    public function isFutureDate($mdY) {
        return strtotime($mdY) > strtotime(date('m/d/Y'));
    }

    public function btnregisterclickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');

//        $usuario = $session->usuario;
        $br = new Browser_Control();

        // validating user
        $form = Session_Control::getDataSession('formNewuser');

        //Validations:
        $valid = $form->processAjax($_POST);
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            return;
        } else if (($post->senha != '') && ($post->senha != $post->confirmpassword)) {
            $br->setAlert("Error","The password doesn't match the confirm password.");
            $br->send();
            return;
        } else if (strlen($post->senha) < 6) {
            $br->setAlert("Error","The password must contain at least 6 characters.");
            $br->send();
            return;
        // } else if (!filter_var($post->email, FILTER_VALIDATE_EMAIL)) {
        //     $br->setAlert("Error","The email informed is not valid.");
        //     $br->send();
        //     return;
        } else if ( Usuario::usernameExists($post->loginUser) ) {
            $br->setAlert("Error","This username has already being choosen. Please choose another.");
            $br->send();
            return;
        // } else if (!$this->validDate($post->birthdate)) {
        //     $br->setAlert("Error","The bithdate must be a valid date in the format month/day/year.");
        //     $br->send();
        //     return;
        // } else if ($this->isFutureDate($post->birthdate)) {
        //     $br->setAlert("Error","The bithdate must not be in the future.");
        //     $br->send();
        //     return;
        } else if ($post->termsofuse != 'S') {
            $br->setAlert("Error","You must agree with the term of use to proceed!");
            $br->send();
            return;
        }

        $user = Usuario::getInstance('newUser');
        $user->setDataFromRequest($post);

        //sets the password expiration date
        $user->setdatasenha(date('m/d/Y'));

        //sets user type
        $user->settipo('user');

        //sets Active user
        $user->setativo('S');

        //sets user permission group
        $user->setgrupo(2);

        //sets user homepage
        $user->setpaginainicial('index');


        // generates the random number to confirm the account
        // WE WON'T NEED THIS CONFIRMATION ON FIRST VERSION....
        // srand();
        // $lObj->setconfirmurl(substr(str_pad(dechex(rand(12345678,99994595)).
        //                              dechex(rand(10003001,95964595)).
        //                              dechex(rand(10003001,95964595)),16,'0',STR_PAD_LEFT),0,16));
        // $link = HTTP_REFERER . 'login/confirmaccount/id/' . $lObj->getconfirmurl().$lObj->getID();
        // $message ='<h1>Welcome to TravelTrack '.$lObj->getnomecompleto.'</h1><p>Confirm your account accessing the link: <a href="'.$link.'" target="_blank">'.$link.'</a></p>';

        //saving the user data
        try {
            $user->save();
            $user->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        //Login the user

//        if ($post->remember) {
        $cookie_name = "userName";
        $cookie_value = $user->getusername;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//        }

        Log::createLogFile('The user ' . $user->getNomeCompleto() . ' Sign Up');

        $session = Zend_Registry::get('session');
        $session->usuario = $user;
        Zend_Registry::set('session', $session);

        $limpaSession = true;




        //$subject = 'Welcome to TravelTrack';
        //$enviaEmail = new SendEmail();
        //$enviaEmail->sendEmailComunicacaoInterna($message, $subject, $lObj->getemail()); //, $emailFrom, $nameFrom);

        //$msg = 'An e-mail was sent to you to confirm your account!';
        //$br->setMsgAlert('Please check your e-mail and confirm your registration to proceed!', $msg);
        $br->setBrowserUrl(BASE_URL . 'login/newuser2');
        $br->send();
    }

    public function newuser2Action() {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $this->_redirect('./login');
            exit;
        }

        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        $obj->read($id);
        $form->setDataForm($obj);

        $obj->setInstance('newUser');

        $element = new Ui_Element_Text('hometowncity');
        $element->setAttrib('maxlength', '50');
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'The city you were raised');
        $form->addElement($element);

        $element = new Ui_Element_Text('hometowncountry');
        $element->setAttrib('maxlength', '50');
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'The country you were raised');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSkip2');
        $button->setDisplay('Skip');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnContinue2');
        $button->setDisplay('Continue');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/2.jpg' );

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser2.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');
    }

    public function btnskip2clickAction($enviar = false) {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'login/newuser3');
        $br->send();
    }

    public function btncontinue2clickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
        $br = new Browser_Control();

        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $br->setBrowserUrl(BASE_URL . 'login/');
            $br->send();
            exit;
        }

        $lObj = new Usuario();
        $lObj->read($id);
        $lObj->sethometowncity($post->hometowncity);
        $lObj->sethometowncountry($post->hometowncountry);

        //saving the user data
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setBrowserUrl(BASE_URL . 'login/newuser3/');
        $br->send();
    }

    public function newuser3Action() {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $this->_redirect('./login');
            exit;
        }

        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        $obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newUser');


        $element = new Ui_Element_Text('liveincity');
        $element->setAttrib('maxlength', '50');
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', "City where you're currently living");
        $form->addElement($element);

        $element = new Ui_Element_Text('liveincountry');
        $element->setAttrib('maxlength', '50');
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', "City where you're currently living");
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSkip3');
        $button->setDisplay('Skip');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnContinue3');
        $button->setDisplay('Continue');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/3.jpg' );

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser3.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');

    }

    public function btnskip3clickAction($enviar = false) {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'login/newuser4');
        $br->send();
    }

    public function btncontinue3clickAction($enviar = false) {

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');

        $br = new Browser_Control();

        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $br->setBrowserUrl(BASE_URL . 'login/');
            $br->send();
            exit;
        }

        $lObj = new Usuario();
        $lObj->read($id);
        $lObj->setliveincity($post->liveincity);
        $lObj->setliveincountry($post->liveincountry);

        //saving the user data
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setBrowserUrl(BASE_URL . 'login/newuser4');
        $br->send();
    }


    public function newuser4Action() {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $this->_redirect('./login');
            exit;
        }
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        $obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newUser');

        $element = new Ui_Element_Textarea('traveledto');
        $element->setAttrib('rows', 8);
        $element->setAttrib('maxlength', 255);
        $element->setAttrib('placeholder', 'Let your friends know the awesome places you traveled to!');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSkip4');
        $button->setDisplay('Skip');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnContinue4');
        $button->setDisplay('Continue');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/4.jpg' );
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser4.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');

    }

    public function btnskip4clickAction($enviar = false) {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'login/newuser5');
        $br->send();
    }

    public function btncontinue4clickAction($enviar = false) {

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');

        $br = new Browser_Control();
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $br->setBrowserUrl(BASE_URL . 'login/');
            $br->send();
            exit;
        }

        $lObj = new Usuario();
        $lObj->read($id);
        $lObj->settraveledto($post->traveledto);

        //saving the user data
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setBrowserUrl(BASE_URL . 'login/newuser5');
        $br->send();
    }


    public function newuser5Action() {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $this->_redirect('./login');
            exit;
        }

        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        $obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newUser');

        $element = new Ui_Element_Textarea('bio');
        $element->setAttrib('rows', 4);
        $element->setAttrib('maxlength', 140);
        $element->setAttrib('placeholder', 'Tell us how awesome you are, your favourite quote etc.');
        $form->addElement($element);

        $element = new Ui_Element_Text('occupation');
        $element->setAttrib('maxlength', 60);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'We all got bills to pay');
        $form->addElement($element);

        $element = new Ui_Element_Text('dreamjob');
        $element->setAttrib('maxlength', 60);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'bungee jumping instuctor, panda cuddler, self-made millionaire');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSkip5');
        $button->setDisplay('Skip');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnContinue5');
        $button->setDisplay('Continue');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/5.jpg' );
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser5.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');

    }

    public function btnskip5clickAction($enviar = false) {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'login/newuser6');
        $br->send();
    }

    public function btncontinue5clickAction($enviar = false) {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $br->setBrowserUrl(BASE_URL . 'login/');
            $br->send();
            exit;
        }

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');

        $br = new Browser_Control();

        $lObj = new Usuario();
        $lObj->read($id);
        $lObj->setbio($post->bio);
        $lObj->setoccupation($post->occupation);
        $lObj->setdreamjob($post->dreamjob);

        //saving the user data
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setBrowserUrl(BASE_URL . 'login/newuser6/');
        $br->send();
    }

    public function newuser6Action() {
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $this->_redirect('./login');
            exit;
        }

        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewuser');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Usuario;
        $obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newUser');

        $element = new Ui_Element_Text('instagram');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'your_instagram_username');
        $form->addElement($element);

        $element = new Ui_Element_Text('twitter');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'your_twitter_username');
        $form->addElement($element);

        $element = new Ui_Element_Text('facebook');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'your.facebook.profile');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSkip6');
        $button->setDisplay('Skip');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnContinue6');
        $button->setDisplay('Continue');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('background',BASE_URL.'Public/Images/signup/6.jpg' );
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser6.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');

    }

    public function btnskip6clickAction($enviar = false) {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function btncontinue6clickAction($enviar = false) {

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');

        $br = new Browser_Control();
        $id = Usuario::getIDUsuarioLogado();
        if (($id == '')||($id == NULL)) {
            $br->setBrowserUrl(BASE_URL . 'login/');
            $br->send();
            exit;
        }


        $lObj = new Usuario();
        $lObj->read($id);
        $lObj->setinstagram($post->instagram);
        $lObj->settwitter($post->twitter);
        $lObj->setfacebook($post->facebook);

        //saving the user data
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function confirmaccountAction() {
        $get = Zend_Registry::get('post');

        $id = $get->id;
        $id_usuario = substr($id,16);
        $confirmurl = substr($id,0,16);

        $user = new Usuario;
        $user->setid_usuario($id_usuario);

        if (($id_usuario != '') && ($user->read()) && ($user->getconfirmurl() == $confirmurl)) {
            $user->setativo('S');
            $user->save();
            $msg = 'Your account has been confirmed!';
        } else {
            $msg = 'This confirmation link has expired...';
        }

        $this->_redirect('./login/index/msg/'.$msg);
    }

}