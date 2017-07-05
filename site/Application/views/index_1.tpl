<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{$TituloPagina} - {$NomeSistema}</title>

        {*        <link rel="shortcut icon"  href="{$baseUrl}Public/Images/favicon/favicon.png" />*}
        <link rel="apple-touch-icon-precomposed" href="{$baseUrl}Public/Images/favicon/touch-icon-iphone.png">
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{$baseUrl}Public/Images/favicon/touch-icon-ipad.png">
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="{$baseUrl}Public/Images/favicon/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon-precomposed" sizes="167x167" href="{$baseUrl}Public/Images/favicon/touch-icon-ipad-retina.png">

        <link rel="icon" type="image/png" href="{$baseUrl}Public/Images/favicon/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="{$baseUrl}Public/Images/favicon/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="{$baseUrl}Public/Images/favicon/manifest.json">
        <link rel="mask-icon" href="{$baseUrl}Public/Images/favicon/safari-pinned-tab.svg" color="#5bbad5">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="grey">
        <meta name="apple-mobile-web-app-title" content="{$NomeSistema}">
        <meta name="theme-color" content="#ffffff">

        <script type="text/javascript">
            //var cBaseUrl = '/Projetos/Opertur/';
            eval("base = '{$baseUrl}'");
            var cBaseUrl = '{$baseUrl}';
            var HTTP_HOST = '{$HTTP_HOST}';
        </script>
        {$scripts}

        {literal}

            <style>
                @media (max-width: 770px) {
                    #burger{
                        display: none;
                    }
                }
                @media (max-width: 500px) {
                    .navbar-collapse{
                        position: relative !important;
                        width: 100% !important;
                    }
                    .nav > li > a {
                        padding-top: 5px !important;
                        padding-bottom: 5px !important;
                        font-size: 12px;
                    }
                    .navbar-brand{
                        overflow: hidden;
                        font-size: 14px !important;
                        padding: 5px !important;
                    }
                }
                #burger{
                    background-color: transparent;
                    background-image: none;
                    border: 0 none;
                }
                .alert{
                    border-radius: 1px !important;
                }
                .msgAlert{
                    position: fixed;
                    right: 0px;
                    top: 49px;
                    z-index: 999000;
                    border-radius: 1px !important;
                    min-width: 300px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                    /* box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); */
                    transition: all 0.2s ease-in-out;
                }
                .tarefa-topo{
                }
                legend{
                    font-size: 16px !important;
                    margin-bottom: 2px !important;
                }
                .select2-container--default .select2-selection--single{
                    border-radius: 0px !important;
                    border: 1px solid #ccc !important;
                }
                .select2-container--default .select2-selection--single .select2-selection__arrow{
                    background-color: #ccc;
                }
                .select2-container--default .select2-selection--single .select2-selection__clear{
                    background-color: #ccc;
                    color: #333;
                    cursor: pointer;
                    float: right;
                    font-weight: bold;
                    height: 18px;
                    line-height: 8px;
                    margin: 5px;
                    padding: 5px;
                }
                .badge-notify{
                    position:absolute;
                    background:red !important;
                    top:6px;
                    right: 6px;
                }
                .memory-usage{
                    position:fixed;
                    color: grey;
                    z-index: 99999999;
                    font-size: 9px;
                }
            </style>
        {/literal}
    </head>
    <body >
        <div>
            <!-- Bootstrap Core CSS -->
            {*        <link href="{$baseUrl}Public/Css/datepicker.css" rel="stylesheet">*}
            <link href="{$baseUrl}../Libs/Scripts/Datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

            <!-- Bootstrap Core CSS -->
            <link href="{$baseUrl}Public/Css/bootstrap.min.css" rel="stylesheet">

            <!-- MetisMenu CSS -->
            <link href="{$baseUrl}Public/Css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

            <!-- Timeline CSS -->
            {*        <link href="{$baseUrl}Public/Css/plugins/timeline.css" rel="stylesheet">*}

            <!-- Custom CSS -->
            <link href="{$baseUrl}Public/Css/sb-admin-2.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            {*        <link href="{$baseUrl}Public/Css/plugins/morris.css" rel="stylesheet">*}

            <!-- Custom Fonts -->
            {*        <link href="{$baseUrl}Public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet"  >*}
            {*            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"  >*}
            {*            <link rel="stylesheet" href="{$baseUrl}Public/font-awesome-4.5.0/css/font-awesome.min.css">*}
            <link rel="stylesheet" href="{$baseUrl}Public/font-awesome-4.7.0/css/font-awesome.min.css">

            <!-- DataTables CSS -->
            {*        <link rel="stylesheet" type="text/css" href="{$baseUrl}Public/Css/jquery.dataTables.css">*}
            {*            <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">*}

            <!-- Normatize CSS -->
            <link href="{$baseUrl}Public/Css/normalize.css" rel="stylesheet"  >
            <link href="{$baseUrl}Public/Css/padrao.css" rel="stylesheet"  >

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        </div>
        <div id="memory-usage" class="memory-usage">

        </div>
        <div id="wrapper">
            {* <div class="alert fade in" id="msgAlert" style="display: none">
            <strong></strong><br> <span></span>
            </div>*}

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top hidden-print " role=" " style="margin-bottom: 0;position: fixed;width: 100%">
                <div class=" ">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    {*                    <a class="navbar-brand" href="{$baseUrl}index"><img src="{$baseUrl}Public/Images/logo.png" title="{$title}" style="height: 180%;width:50%;margin-top: -10px "></a>*}
                    <div class="navbar-brand col-xs-7 col-sm-9" style="color:#232323">
                        <button type="button"  id="burger" title="Esconda e mostre o menu"  >
                            <i class="fa fa-bars"></i>
                        </button>
                        <a  href="#none" title="Voltar" onclick="window.history.go(-1);
                                return false;"><i class="fa fa-arrow-left"></i>
                        </a>
                        {$titulo}
                    </div>
                    {*                        <h3 class="">{$titulo}</h3>*}

                    <ul class="nav navbar-top-links navbar-right ">
                        {if $permissoesLst.proc_mensagens->a_ver != '' || $permissoesLst.all!=''}
                            <li class="dropdown  hidden-xs">
                                <a class="dropdown-toggle"  style="padding-top: 7px;" title="Você tem {$novasMensagens} novas mensagens!" data-toggle="dropdown" href="{$HTTP_REFERER}mensagem'">
                                    <i class="fa fa-bell-o fa-2x"></i>
                                    {if $novasMensagens >0}
                                        <span class="badge badge-notify">{$novasMensagens}</span>
                                    {/if}
                                </a>
                                <ul class="dropdown-menu dropdown-tasks" id="mensagens">
                                    {foreach from=$ListaMensagens item=mensagem}
                                        <li class="" >
                                            <a href="{$HTTP_REFERER}mensagem/view/id/{$mensagem->getID()}">
                                                <div class="row">
                                                    <div class="col-sm-10">

                                                         {$mensagem->getLabelNovaMensagem()}
                                                        
                                                        {$mensagem->getAssuntoComResumo()}
                                                    </div>
                                                    <div class="col-sm-2 small" style="color:#ccc">
                                                        {$mensagem->getDataCadastro()|truncate:10:''}
                                                       

                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <li class="divider"></li>
                                    {/foreach}
                                    <li class=" ">
                                        <div class="row">
                                            <a   href="{$HTTP_REFERER}mensagem" class="col-sm-6" >
                                                <i class="fa fa-tasks fa-fw"></i>   Ver Todas Mensagens
                                            </a>
                                            {if $permissoesLst.proc_mensagens->a_inserir != '' || $permissoesLst.all!=''}
                                                <a   href="{$HTTP_REFERER}mensagem/edit" class="col-sm-6">
                                                    <i class="fa fa-plus fa-fw"></i>   Nova mensagem
                                                </a>
                                            {/if}
                                        </div>
                                    </li>
                                </ul>
                                <!-- /.dropdown-tasks -->
                            </li>
                        {/if}
                        <a href="#" id="btnfavoritapagina" name="btnfavoritapagina" title="Marcar essa página como a página inicial do sistema!" event="click" url="usuario"><i class="fa fa-star"></i></a>
                            {* <li class="dropdown  hidden-xs">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="{$HTTP_REFERER}tarefa'">
                            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-tasks" id="ListaAcaoTopo">
                            <div style=" width: 50px;margin: auto;font-size: 17px">Tarefas</div>
                            <ul class="list-group" id="tarefastopo" event="load" name="tarefastopo" url="tarefa">
                            {$ListaAcaoTopo}
                            </ul>
                            <a   href="{$HTTP_REFERER}tarefa">
                            <i class="fa fa-tasks fa-fw"></i> </i>  Ver Todas Tarefas
                            </a>
                            |
                            <a   href="{$HTTP_REFERER}tarefa/edit">
                            <i class="fa fa-plus fa-fw"></i> </i>  Nova Tarefa
                            </a>
                            </div>
                            <!-- /.dropdown-tasks -->
                            </li> *}
                        <!-- /.dropdown -->
                        <li class="dropdown ">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <span class="hidden-sm hidden-xs">{$nomeUsuario}</span> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> Editar Perfil</a>
                                </li>
                                <li><a href="{$baseUrl}login/trocasenha"><i class="fa fa-gear fa-fw"></i> Trocar de Senha</a>
                                </li>
                                {if $permissoesLst.proc_cad_usuarios !='' || $permissoesLst.all!=''}
                                    <li><a href="{$baseUrl}usuario/users"><i class="fa fa-gear fa-fw"></i> Usuários</a>
                                    </li>
                                    <li><a href="{$baseUrl}usuario/grupos"><i class="fa fa-gear fa-fw"></i> Grupos</a>
                                    </li>
                                {/if}
                                {if $permissoesLst.all!=''}
                                    <li><a href="{$baseUrl}processo"><i class="fa fa-gear fa-fw"></i> Processos</a>
                                    </li>
                                {/if}
                                <li class="divider"></li>
                                <li><a href="{$baseUrl}../../beta/site/index"  ><i class="fa fa-flask fa-fw"></i> Ambiente de Testes</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="{$baseUrl}login/logout"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                </div>
            </nav>
            <!-- ======= MENU ======== -->
            <div class="navbar-default sidebar hidden-print " role="navigation" style="">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <form action="busca" id="formBusca" name="formBusca">
                                <div class="input-group custom-search-form">
                                    <input type="text" id="q"  name="q" class="form-control" placeholder="Procurar FT/OS...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" event="click" link="#none" type="info" href="#none" sendFormFields="1" id="btnBusca" name="btnBusca" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <!-- /input-group -->
                        </li>
                        {$menu}
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            <div id="page-wrapper" style=" ">
                <div class="hidden-print" style="height: 70px"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="visible-print">{$titulo}</p>
                    </div>
                    {* <div class="col-lg-8" >
                    <p>
                    <br>
                    <br>
                    {$sequenciaProcesso}
                    </p>
                    </div>*}
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        {*                        <div class="panel panel-default">*}
                        {$body}
                        {*                        </div>*}
                    </div>
                </div>
            </div>
        </div>

        <div id="alert" style="display: none;"></div>
        <!-- jQuery Version 1.11.0 -->
        <script src="{$baseUrl}Public/Js/jquery-1.11.0.js"></script>
        {* <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>*}
        <!-- Bootstrap Core JavaScript -->
        <script src="{$baseUrl}Public/Js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{$baseUrl}Public/Js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        {*   <script src="{$baseUrl}Public/Js/plugins/morris/raphael.min.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/morris/morris.min.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/morris/morris-data.js"></script>*}



        <!-- DataTables -->
        {*        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>*}


        <!-- DataTables JavaScript -->
        <script src="{$baseUrl}Public/Js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="{$baseUrl}Public/Js/jquery-ui.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{$baseUrl}Public/Js/sb-admin-2.js"></script>

        <!-- Bootstrap Datepicker JS-->
        {*        <script src="{$baseUrl}Public/Js/bootstrap-datepicker.js"></script>*}
        <script src="{$baseUrl}../Libs/Scripts/Datepicker/js/bootstrap-datepicker.min.js"></script>

        <script src="{$baseUrl}../Libs/Scripts/Principal.js"></script>
        {*        <script src="{$baseUrl}../Libs/Scripts/jquery.timer.js"></script>*}

        <link rel="stylesheet" href="{$baseUrl}../Libs/Scripts/Select2/select2.css">
        <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Select2/select2.min.js"></script>
        {*            <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Mask/jquery.mask.js"></script>*}
        {literal}
            <script type="text/javascript">

                            /*
                             * Faz os campos de select que tiverem o attr 'select2' virem um Select2

                             $(document).ready(function ($) {
                             $("select[select2]").select2({width: '100%'});
                             $("select[select2]").attr('data-times-focused', '1');
                             $(".select2-hidden-accessible").each(function () {

                             obrig = $(this).attr('obrig');
                             id = $(this).attr('id');
                             if (obrig == 'obrig') {
                             //                                        border-right: 2px solid rgb(193, 0, 5);
                             //aria-labelledby
                             //select2-AreaBanco-container
                             // $("span[aria-labelledby='select2-" + id + "-container']").parent().parent().css('border-right', '2px solid rgb(193, 0, 5)')
                             }
                             });

                             /*
                             $('select[select2][event="change"]').select2()
                             .on("change", function (e) {
                             console.log(  $(this));
                             // mostly used event, fired to the original element when the value changes
                             $(this).trigger('change');
                             });
                             
                             }); */

                            $("body").delegate("*[select2]", "focusin", function () {
                                times = $(this).attr('data-times-focused');
                                if (typeof times == 'undefined') {
                                    $(this).select2({width: '100%'});
                                    $(this).attr('data-times-focused', '1');

                                }
                            });



            </script>
        {/literal}

    </body>
</html>

