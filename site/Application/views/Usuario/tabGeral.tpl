<!-- LINHA 1  -->
<div class="col-sm-12">
    {$ativo}
</div>
<div class="col-sm-6">
    {$nomeCompleto}
</div>
<div class="col-sm-6">
    {$email}
</div>
{*<div class="col-sm-6">
{$loginUser}
</div>*}
<div class="col-sm-4">
    {$senha}
</div>
{if $idexterno != ''}
    <div class="col-sm-12">
        {$idexterno}
    </div>
{/if}
{if $dificuldade != ''}
    <div class="col-sm-12">
        {$dificuldade}
    </div>
{/if}
{if $grupo}
    <div class="col-sm-12">
        {$grupo}
    </div>
{/if}

{if $senhaEmail != ''}
    <div class="col-sm-12">
        {$senhaEmail}
    </div>
{/if}
{if $smtp != ''}
    <div class="col-sm-12">
        {$smtp}
    </div>
{/if}
{if $porta != ''}
    <div class="col-sm-12">
        {$porta}
    </div>
{/if}

{if $id_empresa != ''}
    <div class="col-sm-12">
        {$id_empresa}
    </div>
{/if}
