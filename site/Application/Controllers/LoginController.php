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
        $element->setAttrib('maxlenght', '30');
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
        $element->setAttrib('maxlenght', '30');
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

        $button = new Ui_Element_Btn('btnEsqueci');
        $button->setDisplay('Forgot My Pass');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-info btn-cons m-t-10');
        $form->addElement($button);

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
            $br->setHtml('msg', '<strong>Atenção!</strong> <br>Usuário ou senha incorretos!');
            $br->setClass('msg', 'alert alert-danger');
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
            $msg = "Sua senha precisa ser trocada, por motivos de segurança.";
        }

        $form = new Ui_Form();
        $form->setName('formTrocaSenha');
        $form->setAction('Login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $element = new Ui_Element_Hidden('idUser');
        $element->setValue($id);
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaAtual', 'Senha Atual');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Senha Atual');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNova', 'Senha NOVA');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Senha Nova');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNovaAgain', 'Repita a senha NOVA');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Repita Senha Nova');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
        $form->addElement($element);

//		$element = new Ui_Element_Password('senhaAtual');
//		$element->setAttrib('maxlenght', '30');
//		$element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
//		$element->setAttrib('cript', '1');
//		$element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
//		$form->addElement($element);
//		$element = new Ui_Element_Password('senhaNova');
//		$element->setAttrib('maxlenght', '30');
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
        $view->assign('titulo', 'Alterar senha');
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
            $br->setAlert('Senha Incorreta', 'Há senha informada não confere com a do sistema. <br/>Tente novamente.', 300);
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
        Log::createLogFile('O usúario ' . Session_Control::getPropertyUserLogado('nomecompleto') . ' saiu do sistema');
        Zend_Registry::set('session', array());
        Zend_Session::destroy();
        $this->_redirect('./login');
    }

}

?>