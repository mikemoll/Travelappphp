<h1>Adding {$tripname}</h1>
<h3>Ok, {$usuarioLogado}, where are you going to?</h3>
<p>(Multi city trip? don’t worry you can add another city/country later)</p>

<div class="row text-center">
    {$search2}<br>
    {$btnSearch}
    {$btnFeelingLucky}
    
</div>
<p> </p>


<!-- <div class="  p-t-20 p-b-10">
    <ul class="list-inline text-right">
        <li class="col-md-6 col-sm-12">

            <div class="input-group transparent">
                <span class="input-group-addon">
                    <a href="javascript:;" class="inline action p-l-10 link text-master" id="searchCity" name="searchCity" url="Trip" event="click" params="">
                        <i class="pg-search"></i>
                    </a>
                </span>
                <input name="search2" id="search2" class="form-control" type="text" placeholder="Search for cities and countries" >
            </div>

            {literal}
            <script type="text/javascript">
                $("#search2").change(function(){
                    $("#searchCity").attr('params','q='+$("#search2").val())
                });
                $("#search2").keypress(function(e) {
                    if(e.which == 13) {
                        $("#searchCity").click();
                    }
                });
            </script>
            {/literal}
        </li>
    </ul>
</div>
 -->
<div id="placesdiv" class="col-md-12" name="defaultplaces" url="Trip" event="load" params='id_trip={$id_trip}'></div>



