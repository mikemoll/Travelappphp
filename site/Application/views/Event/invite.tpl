
<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<div class="row">
    <div class="col-lg-12">
        {$firstname}
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        {$email}
    </div>
</div>
{literal}

    <script>
        $(document).ready(function () {
            // passing in `null` for the `options` arguments will result in the default
            // options being used
            $('#firstname').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'countries',
                source: countries
            });
        });
    </script>
{/literal}


<div class="row">
    <div class="col-lg-12">
        {$btnSendInvitation} {$btnClose}
    </div>
</div>
