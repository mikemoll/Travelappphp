 
{section name=i loop=$lista}

    <table border="0" width="100%">
        <tr>
            <td class="SubTitulosHistorico">
               {$lista[i].foto}
            </td>
        </tr>
        <tr>
            <td class="SubTitulosHistorico">
               {$lista[i].descricao}
            </td>
        </tr>
    </table>
{/section}


