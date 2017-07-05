<!-- jQuery library (served from Google) -->
{*<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>*}
<!-- bxSlider Javascript file -->
<script src="{$HTTP_REFERER}Public/Js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="{$HTTP_REFERER}Public/Css/jquery.bxslider.css" rel="stylesheet" />

{literal}
    <script>
        $(document).ready(function() {
            $('.bxslider').bxSlider({
                // adaptiveHeight: true,
                auto: true
                        //  pagerCustom: '#bx-pager'
            });
        });
    </script>
{/literal}
{section name=i loop=$lista}

    <br>
    <div class="item-detalhe">
        <div class="item-content">
            {if $lista[i].galeria != ''}
                <div class="galery-container">
                    <ul class="bxslider">
                        {section name=j loop=$lista[i].galeria}
                            <li><img src="{$lista[i].galeria[j]}" /></li>
                            {/section}
                    </ul> 
                </div>
            {/if}


            <div class="info-container"  >
                <h3>
                    {$lista[i].titulobr} 
                </h3>
                {if $formContato != ''}
                    <div class="contato-container" style="float: right">
                        <p class="contato-chamada">Peça agora esse pacote!</p>
                        {$formContato}
                    </div>
                {/if}
                <p class="info-text">
                    {$lista[i].textobr}
                </p>
            </div>
        </div>
    </div>
{/section}