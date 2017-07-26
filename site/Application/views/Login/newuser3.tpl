<h1>Step 2 of 2</h1>
<h3 class="light" style="padding-bottom: 50px;">Ok {$nomecompleto}, What kind of trips are you interested?</h3>

{foreach from=$interests key=id_interest item=interest}
<div class="form-group form-group-default col-xs-4">
    <div class="checkbox check-primary">
        <input type="checkbox" value="{$id_interest}" id="interest{$id_interest}" name="interests[]">
        <label for="interest{$id_interest}">{$interest.description}<br/>
            <img alt="{$interest.description}" title="{$interest.description}" src="{$interest.icon}"  style="width: 100%;" />
        </label>
    </div>
</div>
{/foreach}

<div class="row">
    <div class="col-xs-12">
        {$btnSkip3}
        {$btnContinue3}
    </div>
</div>


