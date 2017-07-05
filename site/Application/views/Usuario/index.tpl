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
    
    {$filtros}
    <div class="panel panel-default">
        {if $btnNovo !=''}
            <div class="panel-heading text-right">
                {$btnNovo}

            </div> 
        {/if}
        <div class="panel-body">
    {$gridUsers}
    {$gridGrupos}
        </div>
    </div>

</div>
