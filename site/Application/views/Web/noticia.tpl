<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
{literal}
    <style>
        #curso .TextoDestaqueData{
            font-size: 9px;
            line-height: 10px;
        } 
    </style>
{/literal}
<table border="0" id="curso">

    <tbody>
        {section name=i loop=$lista}
            <tr >
                <td   >
                    {$lista[i].fotos}
                </td>
            </tr>
            <tr >
                <td   >
                    <span class="TitulosNoticiasDetalhes TextoDestaqueData">{$lista[i].dataCadastro}</span>
                    <p  class="TitulosNoticiasDetalhes" > {$lista[i].titulo} </p>
                    <p class="TextosNoticiasDetalhes">{$lista[i].texto }  </p>

                </td>
            </tr>


        {/section}
    </tbody>
</table>
