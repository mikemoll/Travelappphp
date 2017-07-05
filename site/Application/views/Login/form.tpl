{literal}
    <script>
        $(document).ready(function () {
            $("#loginbox").css('top', '-200');
            $("#loginbox").animate({
                opacity: 1,
                top: "+=50"
                        // height: "toggle"
            }, 400, function () {
                // Animation complete.
            });
        });
    </script>
{/literal}
{*            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    *}
<div id="loginbox" style="opacity: 0; " class=" col-md-12 col-sm-12">
    <div class="panel panel-info" >
        <div style="" class="panel-body" >
            {*            <div class="panel-title">Olá</div>*}
            {*            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">esqueci minha senha</a></div>*}

            <div style="padding-top:10px"  >
                <div id="msg" class="hide" role="alert">
                </div>
                {$user}
                {$senha}
                {$remember}
                {$btnLogin}
            </div>
        </div>                     
        {* <div class="text-right" style="padding: 5px wi">
        {$btnEsqueci}
        </div>*}
    </div>  
</div>
