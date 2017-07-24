<h1>Adding {$tripname}</h1>
<h3>Ok, {$usuarioLogado}, where are you going to?</h3>
<p>(Multi city trip? don’t worry you can add another city/country later)</p>

<div class="row">
    {$search2}
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        {$btnSearch}
        {$btnFeelingLucky}
    </div>
</div>

<p> </p>

{literal}
<script type="text/javascript">
    // $("#search2").change(function(){
    //     $("#searchCity").attr('params','q='+$("#search2").val())
    // });
    // $("#search2").keypress(function(e) {
    //     if(e.which == 13) {
    //         $("#searchCity").click();
    //     }
    // });
    // $('#ckDreamplaces').click(function(){
    //     if ($(this).prop('checked') == true) {
    //         $('#btnSearch').attr('params','dreamplaces=true');
    //     } else {
    //         $('#btnSearch').attr('params','dreamplaces=false');
    //     }
    //     $('#btnSearch').click();
    // });

</script>
{/literal}

<div class="panel panel-transparent">

    <ul class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs" data-init-reponsive-tabs="dropdownfx">
        <li class="active">
            <a data-toggle="tab" href="#dreamboardtab"><span>Dreamboard</span></a>
        </li>
        <li>
            <a data-toggle="tab" href="#exploretab"><span>Explore</span></a>
        </li>
    </ul>
    <div class="tab-content" name="defaultplaces" url="Trip" event="load" params='id_trip={$id_trip}'>
        <div class="tab-pane active " id="dreamboardtab">
            <div id="dreamboarddiv" class="col-md-12"></div>
        </div>
        <div class="tab-pane" id="exploretab">
            <div id="placesdiv" class="col-md-12"></div>
        </div>
    </div>
</div>


