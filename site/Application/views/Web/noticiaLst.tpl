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
                <td  style="padding-left: 10px; border-bottom: 1px dotted #A0B246;vertical-align: top">
                    {$lista[i].fotos}
                </td>
                <td  style="border-bottom: 1px dotted #A0B246;vertical-align: top">
                    <span class="TitulosNoticias TextoDestaqueData">{$lista[i].dataCadastro}</span>
                    <p   ><a class="TitulosNoticias" href="{$lista[i].link}">{$lista[i].titulo}</a></p>
                </td>
            </tr>
            

        {/section}
    </tbody>
</table>
