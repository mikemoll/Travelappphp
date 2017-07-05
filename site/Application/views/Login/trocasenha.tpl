<div class="panel">
    <div class="panel-body">
        <!-- LINHA 2  -->
        <div class="row">
            {if $msg != ''}
                <div class="col-sm-12">
                    <div class="alert alert-info fade in">
                        <p>{$msg}
                        </p>
                    </div>
                </div>
            {/if}
        </div>
        <div class="col-sm-12">
            {$senhaAtual}
        </div>
        <div class="col-sm-12">
            {$senhaNova}
        </div>
        <div class="col-sm-12">
            {$senhaNovaAgain}
        </div>
        <div class="col-sm-12">
            {$btnTrocaSenha}
        </div>
    </div>
</div>

