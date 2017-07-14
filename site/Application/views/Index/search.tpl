{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            /*$('#search').keyup(function () {
             //                alert($(this).val());

             search($(this).val());
             });
             */

            // passing in `null` for the `options` arguments will result in the default
            // options being used
            $('#search').typeahead(null, {
                name: 'countries',
                //  display: 'value',
                source: countries
            });
        });
        function search(q) {
            $.ajax({
                url: "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=" + q + "&type=(regions)&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0",
            }).success(function (result) {

                $('#result').html(result);
            });
        }

        var countries = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=%QUERY&type=(regions)&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0",
                , wildcard: '%QUERY'
            }
        });

    </script>   
{/literal}
<script src="{$baseUrl}Public/assets/plugins/bootstrap-typehead/typeahead.bundle.min.js"></script>
<script src="{$baseUrl}Public/assets/plugins/bootstrap-typehead/typeahead.jquery.min.js"></script>
{$search}
<div id="result"></div>
{$btnSearch}