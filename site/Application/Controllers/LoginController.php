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
//        Browser_Control::setScript('css', 'Login', 'assets/plugins/pace/pace-theme-flash.css');
//    Browser_Control::setScript('css', 'Login', 'assets/plugins/bootstrapv3/css/bootstrap.min.css');
//    Browser_Control::setScript('css', 'Login', 'assets/plugins/font-awesome/css/font-awesome.css');
//    Browser_Control::setScript('css', 'Login', 'assets/plugins/jquery-scrollbar/jquery.scrollbar.css', "screen");
//    Browser_Control::setScript('css', 'Login', 'assets/plugins/select2/css/select2.min.css', "screen");
//    Browser_Control::setScript('css', 'Login', 'assets/plugins/switchery/css/switchery.min.css', "screen");
//    Browser_Control::setScript('css', 'Login', 'pages/css/pages-icons.css', "screen");
//    ;


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

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'Login');
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
            $br->setMsgAlert("Whoops!","User and password doesn't match");
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
        $button->setDisplay('Trocar Senha');
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
            $user->setDataSenha(date('d/m/Y'));

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
        $element->setAttrib('size', '21');
        $element->setRequired();
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'First name');
        $element->setAttrib('required', '');
        $element->setAttrib('autofocus', '');
        $form->addElement($element);


        $element = new Ui_Element_Text('lastname');
        $element->setAttrib('maxlength', '35');
        $element->setAttrib('size', '21');
        $element->setRequired();
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Last name');
        $element->setAttrib('required', '');
        $form->addElement($element);


        $element = new Ui_Element_Text('email');
        $element->setAttrib('maxlength', '255');
        $element->setAttrib('size', '21');
        $element->setAttrib('type', 'email');
        $element->setRequired();
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Email');
        $element->setAttrib('required', '');
        $form->addElement($element);

        $element = new Ui_Element_Date('birthdate');
        $element->setRequired();
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('required', '');
        $form->addElement($element);

        $element = new Ui_Element_Select('gender');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->addMultiOption('', '- Select your gender -');
        $element->addMultiOption('F', 'Female');
        $element->addMultiOption('M', 'Male');
        $form->addElement($element);

        $element = new Ui_Element_Text('education');
        $element->setAttrib('maxlength', '100');
        $element->setAttrib('size', '21');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Education');
        $form->addElement($element);

        $element = new Ui_Element_Text('hometowncity');
        $element->setAttrib('maxlength', '50');
        $element->setAttrib('size', '21');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Hometown (city)');
        $form->addElement($element);

        $element = new Ui_Element_Text('hometowncountry');
        $element->setAttrib('maxlength', '50');
        $element->setAttrib('size', '21');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Hometown (country)');
        $form->addElement($element);


        $element = new Ui_Element_Text('loginUser');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
//      $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'user name');
        $element->setAttrib('required', '');
       // $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senha');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
//      $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'password');
        $element->setAttrib('required', '');
        $element->setRequired();
        //$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('confirmpassword');
        $element->setAttrib('maxlength', '30');
        $element->setAttrib('size', '21');
//      $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'confirm password');
        $element->setAttrib('required', '');
        $element->setRequired();
        //$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('termsofuse');
        $element->setAttrib('label', 'I agree with the <a href="#" class="text-info">terms of use.</a>');//
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $form->addElement($element);

        $element = new Ui_Element_Hidden('next');
        $element->setValue($post->next);
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnRegister');
        $button->setDisplay('Register');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-primary btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnCancel');
        $button->setDisplay('Cancel');
        $button->setHref(HTTP_REFERER . $this->Action . 'login');
        $button->setAttrib('class', 'btn btn-cancel btn-cons m-t-10');
        $form->addElement($button);

        // $button = new Ui_Element_Btn('btnEsqueci');
        // $button->setDisplay('Forgot My Pass');
        // $button->setAttrib('sendFormFields', '1');
        // $button->setAttrib('class', 'btn btn-info btn-cons m-t-10');
        // $form->addElement($button);

        $form->setDataSession('formNewuser');

        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New user');
        $html = $form->displayTpl($view, 'Login/newuser.tpl');
        $view->assign('body', $html);
        $view->output('Login/index.tpl');
//      $view->output('index.tpl');
    }

//   public function btnregisterclickAction() {
//         $post = Zend_Registry::get('post');
//         $br = new Browser_Control();

//         $form = Session_Control::getDataSession('formNewuser');

//         $valid = $form->processAjax($_POST);

//         $br = new Browser_Control();
//         if ($valid != 'true') {
//             $br->validaForm($valid);
//             $br->send();
//             exit;
//         }

//         $user = Usuario::getInstance('formNewuser');
//         $user->setDataFromRequest($post);
//         $user->save();


// //        $br->setBrowserUrl(BASE_URL);
//         $br->setRemoveWindow('newuser');
//         $br->setUpdateDataTables('gridUsers');
//         $br->setUpdateDataTables('gridGrupos');
//         $br->send();

//         Session_Control::setDataSession('formNewuser', '');
//     }

    public function btnregisterclickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();

        // validating user
        $form = Session_Control::getDataSession('formNewuser');
        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        // saving the user
        $lObj = Usuario::getInstance('newUser');
        $lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance('newUser');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = 'An e-mail was sent to you to confirm your account!';
        $br->setMsgAlert('Please check your e-mail and confirm your registration to proceed!', $msg);
        $br->setBrowserUrl(BASE_URL . 'login');
        $br->send();

    }
}
?>