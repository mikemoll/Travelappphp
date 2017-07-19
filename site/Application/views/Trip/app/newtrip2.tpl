<h1>Adding {$tripname}</h1>
<h3>Ok, {$usuarioLogado}, what sort of trip are you planning?</h3>

<div class="col-xs-12">
    {$id_trip}
    {$btnNext2}
</div>
{foreach from=$triptypes key=id_triptype item=tt}
<div class="form-group form-group-default col-xs-6 col-sm-4 col-md-2">
    <div class="checkbox check-primary">
        <input type="checkbox" value="{$id_triptype}" id="triptype{$id_triptype}" name="triptypes[]">
        <label for="triptype{$id_triptype}">{$tt.description}<br/>
            <img alt="{$tt.description}" title="{$tt.description}" src="{$tt.icon}"  style="width: 100%;" />
        </label>
    </div>
</div>
{/foreach}

