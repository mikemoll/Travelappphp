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
                $(this).next().toggleClass("check");
            });
        });
    </script>
    <style>

        .check{
            outline: 3px solid #ccc;
        }

        label {
            padding-top:50px;
            padding-left: auto;
            padding-right: auto;
            height: 150px;
            width: 150px;
            display: block;
            font-weight: bold !important;
            color: white !important;
            font-size: 14px !important;
            background-color: #eee ;
            float: left;
            overflow: hidden;
        }
    </style>

{/literal}

{foreach from=$triptypes key=id_triptype item=tt}

     <div>
        <input type="checkbox" class="hidden "  value="{$id_triptype}" id="interest{$id_triptype}" name="triptypes[]" autocomplete="off">
        <label class="btn m-t-10 m-r-10" for="interest{$id_triptype}" style="background-image: url( {$tt.icon} ) !important;   background-size: 100%;"   >
            {$tt.description}</label>
    </div>

{/foreach}

