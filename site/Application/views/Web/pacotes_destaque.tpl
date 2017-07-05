{if $textoBusca !=''}
    {if $textoBusca!= ''}<p class="texto">Resultados da busca por "{$textoBusca}" - <a href="{$HTTP_REFERER}web/pacotes">Mostar todos</a></p>{/if}

{/if}
<div class="item-list-destaque">

    {section name=i loop=$lista}


        <div class="item">
            <div class="item-content">
                <div class="image-container">
                    {if $lista[i].imagem != ''}
                        <a href="{$HTTP_REFERER}web/pacDetalhes/id/{$lista[i].id_noticia}">
                            {*                            <img src="{$HTTP_REFERER}web/resizeImage/caminho/{$lista[i].imagem}/l_max/150/a_max/150" alt="{$lista[i].titulobr}">*}
                            <img src="{$lista[i].imagem}" width="150" alt="{$lista[i].titulobr}">
                        </a>
                    {/if}
                </div>
                <div class="info-container">
                    <h3>
                        <a href="{$HTTP_REFERER}web/pacDetalhes/id/{$lista[i].id_noticia}">{$lista[i].titulobr}</a>
                    </h3>

                </div>
            </div>
        </div>




    {/section}
</div>