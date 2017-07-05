<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
{literal}
    <script type="text/javascript">
    $(document).ready(function(){
	  
            $('#conteudo1').hide();
            $('#conteudo2').hide();
            $('#conteudo3').hide();
   
            $('a#exibir1').toggle(function(){
                $('#conteudo1').show('slow');
            },function(){
                $('#conteudo1').hide('slow');
            });
            $('a#exibir2').click(function(){
                $('#conteudo2').show('slow');
            },function(){
                $('#conteudo2').hide('slow');
            });
            $('a#exibir3').click(function(){
                $('#conteudo3').show('slow');
            },function(){
                $('#conteudo3').hide('slow');
            });
   
            //                $('a#ocultar').click(function(){
            //							   
            //                    $('#conteudo').hide('slow');
            //                })
        });
    </script>
{/literal} 
<table width="100%" border="0" cellpadding="3" cellspacing="0" align="center" >
    {section name=i loop=$lista}

        {if $lista[i].titulo == ''}
        {php} echo $sep; $sep = '';{/php}

        <tr>
            <td class="SubTitulosUsuario" title="Clique para ver a lista de cursos disponíveis">
                <a id="exibir{$lista[i].id_tipo}" href="#" onClick="return false;" title="Clique para ver a lista de cursos disponíveis" class="SubTitulosUsuario">
                    {$lista[i].tipo}
                </a>
                 
            </td>
        </tr>

        <tr>
            <td>
                <div id="conteudo{$lista[i].id_tipo}" >

                    <table width="100%" border="0" cellpadding="3" cellspacing="0" align="center" class="TabelasCursos">
                        <tbody>
                            <tr>
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Titulo
                                </td>
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Coordenação
                                </td>
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Duração
                                </td>
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Vagas
                                </td>
                                <!--td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Início / Término
                                </td-->
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Frequência
                                </td>
                                <!--td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Matrícula
                                </td-->
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Investimento
                                </td>
                                <td nowrap="nowrap" class="TitulosTabelasCursos">
                                    Pré-inscrição
                                </td>
                            </tr>
                        {elseif $lista[i].titulo != 'FIM'}
                            {php} $sep = "    </tbody>
                        </table>


                    </div>  
                            
                </td>
            </tr>";
                            {/php}
                            <tr>
                                <td nowrap="nowrap" align="left" class="TitulosTabelasCursosListaBold">
                                    <b>
                                    	{$lista[i].titulo}
                                    </b>
                                </td>
                                <td nowrap="nowrap" align="left" class="TitulosTabelasCursosLista">
                                    {$lista[i].docente}
                                </td>
                                <td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    {$lista[i].duracao}
                                </td>
                                <td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    {$lista[i].vagas}
                                </td>
                                <!--td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    {$lista[i].dataInicio}&nbsp;/&nbsp;{$lista[i].datafim}
                                </td-->
                                <td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    {$lista[i].frequencia}
                                </td>
                                <!--td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    {$lista[i].matricula}
                                </td-->
                                <td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    R$ {$lista[i].investimento|number_format:2:",":"."}
                                </td>
                                <td nowrap="nowrap" align="center" class="TitulosTabelasCursosLista">
                                    <a title="Clique para fazer sua inscrição no curso: " href="{$lista[i].link}">
                                        <img border="0" src="img/FrmInscricao.png">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap" colspan="9" class="TitulosTabelasCursos" align="left">
                                    Descrição / Mais detalhes:<br />
                                    <span style="color: #333333;    font-family: Arial,Helvetica,sans-serif;font-size: 10px;">{$lista[i].detalhes}<br /><br /><br /><br /></span>
                                </td>
                            </tr>
                       </tr>

                        {else}
                        </tbody>
                    </table>


                </div>  

            </td>
        </tr>
    {/if}



{/section}
</table>