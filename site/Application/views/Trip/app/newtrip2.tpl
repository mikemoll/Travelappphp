<h1>Adding {$tripname}</h1>
<h3>Ok, {$usuarioLogado}, what sort of trip are you planning?</h3>

<div class="col-xs-12">
    {$id_trip}
    {$btnNext2}
</div>


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

{foreach from=$triptypes key=id_triptype item=tt}

     <div>
        <input type="checkbox" class="hidden "  value="{$id_triptype}" id="interest{$id_triptype}" name="triptypes[]" autocomplete="off">
        <label class="interests-label btn m-t-10 m-r-10" for="interest{$id_triptype}" style="background-image: url( {$tt.icon} ) !important;   background-size: 100%;"   >
            {$tt.description}</label>
    </div>

{/foreach}

