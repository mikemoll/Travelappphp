<!-- LINHA 1  -->
<div class="row">
    <div class="col-sm-2">
        {$ativo}
    </div>
    <div class="col-sm-10">
        {$nomeCompleto}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {$loginUser}
    </div>
    <div class="col-sm-6">
        {$senha}
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        {$email}
    </div>

    <div class="col-sm-6">
        {$recebecomunicacaointerna}
    </div>
</div>


<div class="row">

    {if $idexterno != ''}
        <div class="col-sm-12">
            {$idexterno}
        </div>
    {/if}
</div>

<div class="row">
    {if $dificuldade != ''}
        <div class="col-sm-12">
            {$dificuldade}
        </div>
    {/if}
</div>

<div class="row">
    {if $grupo}
        <div class="col-sm-12">
            {$grupo}
        </div>
    {/if}
</div>
<div class="row">

    {if $smtp != ''}
        <div class="col-sm-4">
            {$smtp}
        </div>
    {/if}
    {if $porta != ''}
        <div class="col-sm-4">
            {$porta}
        </div>
    {/if}

    {if $senhaEmail != ''}
        <div class="col-sm-4">
            {$senhaEmail}
        </div>
    {/if}
</div>
<div class="row">


    {if $id_empresa != ''}
        <div class="col-sm-12">
            {$id_empresa}
        </div>
    {/if}
</div>
