<h1>Step 2 of 2</h1>
<h3 class="light" style="padding-bottom: 50px;">Ok {$nomecompleto}, What kind of trips are you interested?</h3>
{literal}
    <script>
        $(document).ready(function (e) {
            $("input[type=checkbox]").click(function () {
                $(this).next().toggleClass("interests-check");
            });
        });
    </script>
    <style>

    </style>

{/literal}
{foreach from=$interests key=id_interest item=interest}

    <div>
        <input type="checkbox" class="hidden "  value="{$id_interest}" id="interest{$id_interest}" name="interests[]" autocomplete="off">
        <label class="interests-label btn m-t-10 m-r-10 " for="interest{$id_interest}" style="background-image: url( {$interest.icon} ) !important;   background-size: 100%;"   >
            {$interest.description}</label>
    </div>

{/foreach}

<div class="row">
    <div class="col-xs-12">
        {$btnSkip3}
        {$btnContinue3}
    </div>
</div>


