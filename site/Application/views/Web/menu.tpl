<ul class="menu">
    <li><a href="{$HTTP_REFERER}">Início</a></li>
    <li><a href="{$HTTP_REFERER}web/agencia">A Agência</a></li>
    {section name=i loop=$tipoPacote}
        <li><a href="{$HTTP_REFERER}web/pacotes/t/{$tipoPacote[i].id_tipo}">{$tipoPacote[i].descricao}</a></li>
        {/section}

    <li><a href="{$HTTP_REFERER}web/seguro">Seguro</a></li>
    <li><a href="{$HTTP_REFERER}web/hotel">Hotel</a></li>
    <li><a href="{$HTTP_REFERER}web/aluguelCarro">Aluguel de Carro</a></li>
    <li><a href="{$HTTP_REFERER}web/passAerea">Passagem Aérea</a></li>
    <li><a href="#">Informações
            <ul class="sub">

                {section name=i loop=$dicas}
                    <li><a href="{$HTTP_REFERER}web/dicas/id/{$dicas[i].id_noticia}">  {$dicas[i].titulobr}</a></li>
                    {/section}
            </ul>
        </a></li>
    <li><a href="{$HTTP_REFERER}web/cadastrese">Cadastre-se</a></li>
    <li><a href="{$HTTP_REFERER}web/contato">Contato</a></li>

</ul>