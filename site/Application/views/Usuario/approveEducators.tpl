
<div class="panel-body">

    {if $descricao != ''}
        {* <div class="panel panel-info">
        <div class=" panel-body ">*}
        <div class="alert alert-info" role="alert">
            <i class="glyphicon glyphicon-info-sign"></i> &nbsp;&nbsp;
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {$descricao}
        </div>
        {* </div> 
        </div> *}
    {/if}
    {if $destaqueFiltro != ''}
        <div class="panel panel-default">
            <div class="panel-heading">
                Filtros
            </div> 
            <div class="panel-body">
                <p><label for="destaqueFiltro">Destaque?:</label>{$destaqueFiltro}</p>
                <p><label for="destaqueFiltro">Tipo de Pacote:</label>{$id_tipoFiltro}</p>
            </div> 
            <div class="panel-footer  text-right">
                {$btnFiltrar} {$btnLimparFiltros}
            </div>
        </div> 
    {/if}
    <div class="panel panel-default">
        <div class="panel-body">
            {$educatorsGrid}
        </div>
    </div>

</div>
