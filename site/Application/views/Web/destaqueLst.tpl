{literal}<style>
        #destaques2{
            width:100%;
        }
        #destaques2 .TextoDestaqueData{
            font-size: 9px;
            line-height: 10px;
        } 
    </style>{/literal}
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

    <table id="destaques2" border="0" >

        <tbody>
            {section name=i loop=$lista}
                <tr>
                    <td align="center" valign="middle">
                        <img src="img/DivideDestaque.png" />
                    </td>
                </tr>
                <tr >
                    <td   >
                        <span class="TextoDestaque TextoDestaqueData">{$lista[i].dataCadastro}</span>
                        <p  style="margin-top:0px;margin-left: 10px" ><a class="TextoDestaque" href="{$lista[i].link}">{$lista[i].titulo}</a></p>
                    </td>
                </tr>
            {/section}
        </tbody>
    </table>
