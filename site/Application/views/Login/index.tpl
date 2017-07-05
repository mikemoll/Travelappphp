<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{$TituloPagina}</title>

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

        <!-- Bootstrap core CSS -->
        <link href="{$baseUrl}Public/Css/bootstrap.min.css" rel="stylesheet">
        {*        <link href="{$baseUrl}Public/Css/login.css" rel="stylesheet">*}

        <!-- MetisMenu CSS -->
        {*        <link href="{$baseUrl}Public/Css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">*}

        {*<!-- Timeline CSS -->
        <link href="{$baseUrl}Public/Css/plugins/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{$baseUrl}Public/Css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{$baseUrl}Public/Css/plugins/morris.css" rel="stylesheet">*}
        {*        <link href="{$baseUrl}Public/Css/padrao.css" rel="stylesheet"  >*}

        <!-- Custom Fonts -->
        {*        <link href="{$baseUrl}Public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet"  >*}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            //var cBaseUrl = '/Projetos/Opertur/';
            eval("base = '{$baseUrl}'");
            var cBaseUrl = '{$baseUrl}';
        </script>
        {literal}
            <style>

                body {
                    padding-top: 40px;
                    padding-bottom: 40px;
                    background-color: #eee;
                }

                .form-signin {
                    max-width: 330px;
                    margin: 0 auto;
                }
                .form-control {
                    font-size: 16px;
                    margin-bottom: 10px;
                }
                .form-control,.input-group-addon,.btn,.panel {
                    border-radius: 1px;
                }
                .backgound-login{
                    background: url('{/literal}{$baseUrl}{literal}Public/Images/fundo_login.jpg'); background-repeat: no-repeat;
                    background-size: cover;
                    padding: 0;
                    margin: 0;
                }
                .container2{
                    width: 100%;
                }
                html{
                    height: 100%;
                }
                body {
                    min-height: 100%;
                }
                .logo{
                    width: 251px;
                    height: 74px;
                }
            </style>
        {/literal}
        {$scripts}
        <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Select2/select2.min.js"></script>
    </head>
    <body class="backgound-login">


        {*        <h2 class="form-signin-heading">Por favor, faça login.</h2>*}
        <div class="container">
{*            <img class="logo" src="{$baseUrl}Public/Images/logo_sombra.png">*}
            {$body}
        </div>

    </body>
</html>
