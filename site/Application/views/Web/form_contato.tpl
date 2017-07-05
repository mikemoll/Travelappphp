 
<div class="form-contato">


    <table border="0" style="width: 100%">

        <tbody>
            <tr >
                <td style="width:110px">Nome: </td>
                <td style=" ">{$nome} </td>
            </tr>
            <tr >
                <td style=" ">Email: </td>
                <td style=" ">{$email} </td>
            </tr>
            <tr >
                <td style=" ">Telefone: </td>
                <td style=" ">{$telefone} </td>
            </tr>
            {if $qtdAdultos != ''}
                <tr >
                    <td style=" ">Passageiros: </td>
                    <td style=" ">{$qtdAdultos} Adultos</td>
                </tr>
            {/if}
            {if $qtdChild != ''}
                <tr >
                    <td style=" ">Passageiros: </td>
                    <td style=" ">{$qtdChild} Crianças (2 a 12 anos) </td>
                </tr>
            {/if}
            {if $qtdInf != ''}
                <tr >
                    <td style=" ">Passageiros: </td>
                    <td style=" ">{$qtdInf} Crianças (0 a 23 meses) </td>
                </tr>
            {/if}
            {if $CidadeOrigem != ''}
                <tr >
                    <td style=" ">Cidade Origem: </td>
                    <td style=" ">{$CidadeOrigem}  </td>
                </tr>
            {/if}
            {if $CidadeDestino != ''}
                <tr >
                    <td style=" ">Cidade Destino: </td>
                    <td style=" ">{$CidadeDestino}  </td>
                </tr>
            {/if}
            {if $DataInicio != ''}
                <tr >
                    <td style=" ">Data Inicio Viagem: </td>
                    <td style=" ">{$DataInicio}  </td>
                </tr>
            {/if}
            {if $DataFim != ''}
                <tr >
                    <td style=" ">Data Fim Viagem: </td>
                    <td style=" ">{$DataFim}  </td>
                </tr>
            {/if}
            {if $assunto !=''}
                <tr >
                    <td style=" ">Assunto: </td>
                    <td style=" ">{$assunto} </td>
                </tr>
            {/if}
            {if $msg!=''}
                <tr >
                    <td style=" ">Mensagem: </td>
                    <td style=" ">{$msg} </td>
                </tr>
            {/if}
            <tr >
                <td style=" ">   </td>
                <td style=" "> {$btnEnviar} {$btnCancelar} </td>
            </tr>
        </tbody>
    </table>
</div>