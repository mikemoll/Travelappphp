<?php

class WebController extends Zend_Controller_Action {

    public function triprecommendationAction() {
        $post = Zend_Registry::get('post');
        if ( empty($post->p)) {
            $this->tripNotFound();
            exit;
        }

        // looks for the trip
        $TripLst = new Trip();
        $TripLst->where('publicurl',$post->p);
        $TripLst->readLst();

        if ( $TripLst->countItens() == 0) {
            $this->tripNotFound();
            exit;
        }
        $trip = $TripLst->getItem(0);

        // looks for the first trip place
        $tripplaces = new Tripplace();
        $tripplaces->where('id_trip', $trip->getID());
        $tripplaces->readLst();
        if ( $tripplaces->countItens() == 0) {
            $this->tripNotFound();
            exit;
        }

        // load the place
        $place = new Place;
        $place->read($tripplaces->getItem(0)->getid_place());

        // load the trip friends
        foreach ($trip->TripUserLst as $user) {
            $friends[] = array(
                'id'=>$user->id_usuario,
                'username'=>$user->username,
                'photourl'=>Usuario::makephotoPath($user->id_usuario, $user->photo));
        }

        $view = Zend_Registry::get('view');

        // load the recommendations
        $lst = $trip->getTripRecommendationLst()->getItens();
        $view->assign('RecommendationLst',$lst);
        $view->assign('public', true);
        $view->assign('pubUrl',$post->p);
        $recommendations_html = $view->fetch('Trip/app/detail/tabs/recommendation.tpl');
        $view->assign('recommendations', $recommendations_html);

        // builds the page
        $view->assign('tripname', $trip->gettripname());
        $view->assign('startdate', date_format(date_create($trip->getstartdate()),'F d, Y'));
        $view->assign('enddate', date_format(date_create($trip->getenddate()),'F d, Y'));
        $view->assign('friends',$friends);
        //$view->assign('formatted_address', $place->getformatted_address());
        $view->assign('placephotopath', $place->getPhotoPath());

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $view->fetch('Web/triprecommendation.tpl');
        $view->assign('body', $html);
        $view->output('index_clear.tpl');
    }


    public function tripNotFound() {
        echo 'TODO: a beautiful not found';
        die();
    }

    public function addrecommendationAction() {
        $post = Zend_Registry::get('post');
        if ( empty($post->p)) {
            $this->tripNotFound();
            exit;
        }

        // looks for the trip
        $TripLst = new Trip();
        $TripLst->where('publicurl',$post->p);
        $TripLst->readLst();

        if ( $TripLst->countItens() == 0) {
            $this->tripNotFound();
            exit;
        }
        $trip = $TripLst->getItem(0);

        // looks for the first trip place
        $tripplaces = new Tripplace();
        $tripplaces->where('id_trip', $trip->getID());
        $tripplaces->readLst();
        if ( $tripplaces->countItens() == 0) {
            $this->tripNotFound();
            exit;
        }

        // load the place
        $place = new Place;
        $place->read($tripplaces->getItem(0)->getid_place());

        // load the trip friends
        // foreach ($trip->TripUserLst as $user) {
        //     $friends[] = array(
        //         'id'=>$user->id_usuario,
        //         'username'=>$user->username,
        //         'photourl'=>Usuario::makephotoPath($user->id_usuario, $user->photo));
        // }

        $view = Zend_Registry::get('view');

        // load the add recommendation form
        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('friendfullname', "Your full name");
        $element->setAttrib('maxlength', 35);
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('title', "Title of the recommendation");
        $element->setAttrib('maxlength', 25);
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Select('type', "Recommendation type");
        $element->addMultiOption('P', 'Place to visit');
        $element->addMultiOption('A', 'Activity to do');
        $element->addMultiOption('E', 'Event to go');
       // $element->setMultiSelect();
        $form->addElement($element);

        $ActTypes = new Activitytype();
        $element = new Ui_Element_Select('id_activitytype', "Activity type");
        $element->addMultiOptions($ActTypes->getOptionList('id_activitytype', 'activitytypename', $ActTypes));
        $form->addElement($element);

        $EvtTypes = new Eventtype();
        $element = new Ui_Element_Select('id_eventtype', "Event type");
        $element->addMultiOptions($EvtTypes->getOptionList('id_eventtype', 'description', $EvtTypes));
        $form->addElement($element);

        $element = new Ui_Element_Hidden('google_place_id');
        $element->setValue($post->google_place_id);
        $form->addElement($element);

        $element = new Ui_Element_Hidden('lat');
        $element->setValue($post->google_place_id);
        $form->addElement($element);

        $element = new Ui_Element_Hidden('lng');
        $element->setValue($post->google_place_id);
        $form->addElement($element);

        $element = new Ui_Element_Text('cost', "Cost");
        $element->setAttrib('maxlength', 10);
        $element->setRequired();
        $form->addElement($element);

        $Currencies = new Currency();
        $element = new Ui_Element_Select('id_currency', "Currency");
        $element->addMultiOptions($Currencies->getOptionList('id_currency', 'name', $Currencies, false));
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('isfree', "Free");
        $element->setCheckedValue(1);
        $element->setUncheckedValue(0);
        $form->addElement($element);


        $obj = new Triprecommendation();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance('Triprecommendation');

        $button = new Ui_Element_Btn('btnSaveRecommendation');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancel = new Ui_Element_Btn('btnCancel');
        //$cancel->setAttrib('params', 'IdWindowEdit=AddTripRecommendation';
        $cancel->setDisplay('Cancel', 'times');
        $cancel->setHref(HTTP_REFERER . 'addrecommendation');
        $form->addElement($cancel);

        $form->setDataSession('AddRecommendationForm');

        $view->assign('hideTopBtns', true);
        $recommendations_html = $form->displayTpl($view, 'Web/tripaddrecommendation.tpl');
        $view->assign('recommendations', $recommendations_html);

        // builds the page
        $view->assign('tripname', $trip->gettripname());
        $view->assign('startdate', date_format(date_create($trip->getstartdate()),'F d, Y'));
        $view->assign('enddate', date_format(date_create($trip->getenddate()),'F d, Y'));
        $view->assign('friends',$friends);
        //$view->assign('formatted_address', $place->getformatted_address());
        $view->assign('placephotopath', $place->getPhotoPath());

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $view->fetch('Web/triprecommendation.tpl');
        $view->assign('body', $html);
        $view->output('index_clear.tpl');
    }


//===============================TRASH======================================== 
    public function indexAction() {
        $this->redirect('/index');
        $view = Zend_Registry::get('view');
//
        $lPacotes = new Noticia();
        $lPacotes->where('tipo', 2);
        $lPacotes->where('destaque', 'S');
        $lPacotes->readLst('array');
        $lPacotes = $lPacotes->getItens();

        foreach ($lPacotes as $key => $value) {
            $fotos = Arquivo::getNomeArquivos($value['id_noticia'], 1);
//            $lPacotes[$key]['imagem'] = str_replace('/', '**', $fotos[0]);
            $lPacotes[$key]['imagem'] = $fotos[0];
            $lPacotes[$key]['textobr'] = nl2br($value['textobr']);
        }


        $view->assign('lista', $lPacotes);
        $view->assign('pacotes_destaque', $view->fetch('Web/pacotes_destaque.tpl'));
//
        $view->assign('imagensBanner1', Arquivo::getBanner('99991'));
//        $view->assign('imagensBanner2',  Arquivo::getBanner2());
        $view->assign('titulo', 'INÍCIO');
        $view->assign('menu', WebController::getMenu());
        $view->assign('conteudo', $view->fetch('Web/centro_home.tpl'));
        $view->output('Web/index.tpl');
    }

    public function pacdetalhesAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $lIdPacote = $post->id;

        $lPacote = new Noticia();
        $lPacote = $lPacote->read($lIdPacote, 'array');

        $tipo = new Tipo();
        $tipo->read($lPacote[0]['id_tipo']);

        foreach ($lPacote as $key => $value) {
            $fotos = Arquivo::getNomeArquivos($value['id_noticia']);
            $lPacote[$key]['galeria'] = (count($fotos) > 0 ? $fotos : '');
            $lPacote[$key]['textobr'] = nl2br($value['textobr']);
        }

        $view->assign('lista', $lPacote);

        $titulo = 'Pacotes ' . $tipo->getDescricao() . ' > ' . $lPacote[0]['titulobr'];

        $view->assign('formContato', WebController::getFormSeguro($titulo));
        $view->assign('conteudo', $view->fetch('Web/pacoteDetalhe.tpl'));


        $view->assign('titulo', $titulo);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');
    }

    public function pacotesAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $tipoPagina = $post->t;
        $busca = $post->q;

        $lPacotes = new Noticia();
        $lPacotes->where('tipo', 2);
        if ($tipoPagina) {
            $lPacotes->where('id_tipo', $tipoPagina);
        }
        if ($busca != '') {
            $lPacotes->where('upper(textobr)', strtoupper($busca), 'like');
            $lPacotes->where('upper(titulobr)', strtoupper($busca), 'like', 'or');
            $tituloPagina = "Busca por Pacotes";

            $view->assign('textoBusca', $post->q);
        } else if ($tipoPagina) {
            $tipo = new Tipo();
            $tipo->read($tipoPagina);
            $tituloPagina = $tipo->getDescricao();
        } else {
            $tituloPagina = "Todos nossos pacotes";
        }
        $lPacotes->readLst('array');
        $lPacotes = $lPacotes->getItens();

        foreach ($lPacotes as $key => $value) {
            $fotos = Arquivo::getNomeArquivos($value['id_noticia'], 1);
//            $lPacotes[$key]['imagem'] = str_replace('/', '**', $fotos[0]);
            $lPacotes[$key]['imagem'] = $fotos[0];
            $lPacotes[$key]['textobr'] = nl2br($value['textobr']);
        }


        $view->assign('lista', $lPacotes);
        if (count($lPacotes) > 0) {
            $view->assign('conteudo', $view->fetch('Web/pacotes_destaque.tpl'));
        } else {
            $view->assign('conteudo', "Nenum pacote por aqui, ainda!");
        }

        $view->assign('titulo', $tituloPagina);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');
    }

    public function dicasAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $id = $post->id;

        $lDicas = new Noticia();
        $lDicas->where('id_noticia', $id);
        $lDicas->readLst('array');
        $lDicas = $lDicas->getItens();

        foreach ($lDicas as $key => $value) {
            $lDicas[$key]['textobr'] = nl2br($value['textobr']);
        }

        $view->assign('lista', $lDicas);
        $view->assign('conteudo', $view->fetch('Web/pacoteDetalhe.tpl'));


        $view->assign('titulo', 'Informações > ' . $value['titulobr']);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');
    }

    public function agenciaAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'A AGÊNCIA');
        $view->assign('menu', WebController::getMenu());
        $view->assign('conteudo', $view->fetch('Web/agencia.tpl'));

        $view->output('Web/index.tpl');
    }

    public function cadastreseAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Cadastre-se');
        $view->assign('menu', WebController::getMenu());
        $view->assign('formContato', WebController::getFormContato("Cadastro", false));
        $view->assign('conteudo', $view->fetch('Web/cadastrese.tpl'));

        $view->output('Web/index.tpl');
    }

    public function seguroAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Seguro de Viagem');
        $view->assign('menu', WebController::getMenu());
        $view->assign('imagem', HTTP_REFERER . "Public/Images/seguro.jpg");
        $view->assign('texto', "Para fazer uma viagem segura preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
        $view->assign('formContato', WebController::getFormSeguro("Seguro"));
        $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));

        $view->output('Web/index.tpl');
    }

    public function passaereaAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Compra de Passagens Aéreas');
        $view->assign('menu', WebController::getMenu());
        $view->assign('imagem', HTTP_REFERER . "Public/Images/aviao.jpg");
        $view->assign('texto', "Para comprar passagens aéreas preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
        $view->assign('formContato', WebController::getFormSeguro("Passagem Aérea"));
        $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));

        $view->output('Web/index.tpl');
    }

    public function hotelAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Reserva de Hotel');
        $view->assign('menu', WebController::getMenu());
        $view->assign('imagem', HTTP_REFERER . "Public/Images/hotel.jpg");
        $view->assign('texto', "Para fazer sua reserva de hospedagem preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
        $view->assign('formContato', WebController::getFormSeguro("Reserva de Hotel"));
        $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));

        $view->output('Web/index.tpl');
    }

    public function aluguelcarroAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Aluguel de Carros');
        $view->assign('menu', WebController::getMenu());
        $view->assign('imagem', HTTP_REFERER . "Public/Images/carro.jpg");
        $view->assign('texto', "Para alugar seu carro preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
        $view->assign('formContato', WebController::getFormSeguro("Aluguel de Carros"));
        $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));

        $view->output('Web/index.tpl');
    }

    public function contatoAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $view->assign('titulo', 'Entre em Contato');
        $view->assign('menu', WebController::getMenu());
        $view->assign('formContato', WebController::getFormContato());
        $view->assign('conteudo', $view->fetch('Web/contato.tpl'));

        $view->output('Web/index.tpl');
    }

    public static function getMenu() {
        $view = Zend_Registry::get('view');

        // Pacotes
        $tipo = new Tipo();
        $tipo->readLst('array');
        $view->assign('tipoPacote', $tipo->getItens());

        // Dicas
        $dica = new Noticia;
        $dica->sortOrder('titulobr');
        $dica->where('tipo', 1);
        $dica->readLst('array');


        $view->assign('dicas', $dica->getItens());
        return $view->fetch('Web/menu.tpl');
    }

    /**
     * 
     * @param type $assunto
     * @param type $mostraMsg
     * @return type
     */
    public static function getFormSeguro($assunto = '') {
        $view = Zend_Registry::get('view');


        $form = new Ui_Form();
        $form->setAction('Web');
        $form->setName('formPedidoEdit');

        $element = new Ui_Element_Text('nome');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('email');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('telefone');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Hidden('assunto');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
//        $element->setAttrib('size', '30');
        $element->setValue($assunto);
//        $element->setReadOnly(($assunto != ''));
        $form->addElement($element);


        $element = new Ui_Element_Select('qtdAdultos');
        $element->addMultiOption('0', '0');
        $element->addMultiOption('1', '1');
        $element->addMultiOption('2', '2');
        $element->addMultiOption('3', '3');
        $element->addMultiOption('4', '4');
        $element->addMultiOption('5', '5');
        $element->addMultiOption('6', '6');
        $element->addMultiOption('7', '7');
        $element->addMultiOption('8', '8');
        $element->addMultiOption('9', '9');
        $element->addMultiOption('10', '10');
        $form->addElement($element);

        $element = new Ui_Element_Select('qtdChild');
        $element->addMultiOption('0', '0');
        $element->addMultiOption('1', '1');
        $element->addMultiOption('2', '2');
        $element->addMultiOption('3', '3');
        $element->addMultiOption('4', '4');
        $element->addMultiOption('5', '5');
        $element->addMultiOption('6', '6');
        $element->addMultiOption('7', '7');
        $element->addMultiOption('8', '8');
        $element->addMultiOption('9', '9');
        $element->addMultiOption('10', '10');
        $form->addElement($element);

        $element = new Ui_Element_Select('qtdInf');
        $element->addMultiOption('0', '0');
        $element->addMultiOption('1', '1');
        $element->addMultiOption('2', '2');
        $element->addMultiOption('3', '3');
        $element->addMultiOption('4', '4');
        $element->addMultiOption('5', '5');
        $element->addMultiOption('6', '6');
        $element->addMultiOption('7', '7');
        $element->addMultiOption('8', '8');
        $element->addMultiOption('9', '9');
        $element->addMultiOption('10', '10');
        $form->addElement($element);

        $element = new Ui_Element_Text('CidadeOrigem');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('CidadeDestino');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Date('DataInicio');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '20');
        $form->addElement($element);

        $element = new Ui_Element_Date('DataFim');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '20');
        $form->addElement($element);

        $element = new Ui_Element_Textarea('msg');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
        $element->setAttrib('cols', '22');
        $element->setAttrib('rows', '3');
        $form->addElement($element);



        $salvar = new Ui_Element_Btn('btnEnviar');
        $salvar->setDisplay('Solicitar', PATH_IMAGES . 'Buttons/Ok.png');
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);

        $form->setDataSession();
        Browser_Control::setScript('css', 'Date', ''); // não sei porque, mas tem que tirar esses scripts para o calendário funcionar....
        Browser_Control::setScript('js', 'Date', ''); // não sei porque, mas tem que tirar esses scripts para o calendário funcionar....

        $view->assign('scripts', Browser_Control::getScripts());
        return $form->displayTpl($view, 'Web/form_contato.tpl');
    }

    /**
     * 
     * @param type $assunto
     * @param type $mostraMsg
     * @return type
     */
    public static function getFormContato($assunto = '', $mostraMsg = true) {
        $view = Zend_Registry::get('view');


        $form = new Ui_Form();
        $form->setAction('Web');
        $form->setName('formPedidoEdit');

        $element = new Ui_Element_Text('nome');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('email');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('telefone');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $form->addElement($element);

        $element = new Ui_Element_Text('assunto');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', '30');
        $element->setValue($assunto);
        $element->setReadOnly(($assunto != ''));
        $form->addElement($element);

        $element = new Ui_Element_Textarea('msg');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setVisible($mostraMsg);
        $element->setAttrib('cols', '22');
        $element->setAttrib('rows', '3');
        $form->addElement($element);



        $salvar = new Ui_Element_Btn('btnEnviar');
        $salvar->setDisplay('Enviar', PATH_IMAGES . 'Buttons/Ok.png');
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);

        $form->setDataSession();

        $view->assign('scripts', Browser_Control::getScripts());
        return $form->displayTpl($view, 'Web/form_contato.tpl');
    }

    public function resizeimageAction() {
        // Na tag img o código de redimensionamento será chamado assim:
// <img src='resize_img.php?caminho=fotos/arquivo.gif&l_max=120&a_max=120' /> 
        $post = Zend_Registry::get('post');
//        print '<pre>';
//        die(print_r(str_replace('**', '/', $post->caminho)));

        $filename = str_replace('**', '/', $post->caminho); // caminho do arquivo de imagem
        $width = $post->l_max; // largura máxima
        $height = $post->a_max; // altura máxima
//// Get new dimensions
        list($width_orig, $height_orig) = getimagesize($filename);

        if ($width && ($width_orig < $height_orig)) {
            $width = ($height / $height_orig) * $width_orig;
        } else {
            $height = ($width / $width_orig) * $height_orig;
        }

// Resample
        $image_p = imagecreatetruecolor($width, $height);

//====================================
// Esta parte eu acrescentei
//        preg_match("/\.[a-zA-Z]+/", $filename, $_array);
        $_array = explode(".", $filename);

        switch (strtolower(end($_array))) {
            case "jpg":
                // Content type
                header('Content-type: image/jpeg');
                $image = imagecreatefromjpeg($filename);
                break;
            case "png":
                // Content type
                header('Content-type: image/png');
                $image = imagecreatefrompng($filename);
                break;
            case "gif":
                // Content type
                header('Content-type: image/gif');
                $image = imagecreatefromgif($filename);
                break;
        }
//====================================
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// Output
        imagejpeg($image_p, null, 100);
    }

    public function btnenviarclickAction() {
//        $view = Zend_Registry::get('view');

        $post = Zend_Registry::get('post');

        $authDetails = array(
            'port' => 2525, //or 465 
            'auth' => 'login',
            'username' => 'carlos@dupresviagens.com.br',
            'password' => 'uneworld2014'
        );
        $transport = new Zend_Mail_Transport_Smtp('mx1.hostinger.com.br', $authDetails);
        Zend_Mail::setDefaultTransport($transport);


        $email .= '<p> Novo contato pelo site! </p>';
        $email .= '<fieldset>';
        $email .= '<p> Assunto: ' . $post->assunto . '</p>';
        $email .= '<p> Nome:' . $post->nome . '</p>';
        $email .= '<p> Email: ' . $post->email . '</p>';
        $email .= '<p> Telefone: ' . $post->telefone . '</p>';
        if ($post->qtdAdultos) {
            $email .= '<p> Quantidade de Adultos: ' . $post->qtdAdultos . '</p>';
        }
        if ($post->qtdChild) {
            $email .= '<p> Quantidade de Crianças (02 a 12): ' . $post->qtdChild . '</p>';
        }
        if ($post->qtdInf) {
            $email .= '<p> Quantidade de Crianças (0 a 23 meses): ' . $post->qtdInf . '</p>';
        }
        if ($post->CidadeOrigem) {
            $email .= '<p> Cidade Origem: ' . $post->CidadeOrigem . '</p>';
        }
        if ($post->CidadeDestino) {
            $email .= '<p> Cidade Destino: ' . $post->CidadeDestino . '</p>';
        }
        if ($post->DataInicio) {
            $email .= '<p> Data Inicio: ' . $post->DataInicio . '</p>';
        }
        if ($post->DataFim) {
            $email .= '<p> Data Fim: ' . $post->DataFim . '</p>';
        }
        $email .= '<p> Mensagem: ' . $post->msg . '</p>';
        $email .= '</fieldset>';


        $mail = new Zend_Mail();
        $mail->setBodyHtml($email);
        $mail->setFrom('carlos@dupresviagens.com.br', 'Site Dupres');
//        $mail->addTo('leonardodanieli@gmail.com', 'Leo');
        $mail->addTo('carlos@dupresviagens.com.br', 'Carlos');
        $mail->setSubject(utf8_decode('Contato via Site. ' . html_entity_decode($post->assunto)));

        try {
            // your code here  
            $mail->send($transport);

            $obj = new Pedido();
            $obj->setDataFromRequest($post);
            $obj->setDataEnvio(date('d/m/Y'));
            $obj->save();

            $br = new Browser_Control();
            $br->resetForm('formPedidoEdit');
            $br->setCommand('alert("Sua mensagem foi enviada com sucesso!  Em brave entraremos em contato!")');
            $br->send();
            exit;
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

}
