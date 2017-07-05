<div class="item-list">

    {section name=i loop=$lista}


        <div class="item">
            <div class="item-content">
                <a href="{$HTTP_REFERER}web/pacDetalhes/id/{$lista[i].id_noticia}">
                    <div class="image-container">
                        {if $lista[i].imagem!=''}
                            <img src="{$lista[i].imagem}" alt="{$lista[i].titulobr}">
                        {/if}
                    </div>
                </a>


                <div class="info-container">
                    <h3>
                        <a href="{$HTTP_REFERER}web/pacDetalhes/id/{$lista[i].id_noticia}">{$lista[i].titulobr}</a>
                    </h3>
                    <p class="info-text">
                        {$lista[i].textobr|truncate:1000}
                    </p>
                    <p class="info-text">
                        <a href="{$HTTP_REFERER}web/pacDetalhes/id/{$lista[i].id_noticia}">
                            mais detalhes...
                        </a> 
                    </p>
                </div>
            </div>
        </div>




    {/section}
</div>