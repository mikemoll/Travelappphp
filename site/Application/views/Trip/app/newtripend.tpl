{literal}
<style>
    .cards_container{
        width: 100%;
        padding: 20px;
    }
    .cards_row{
        display: block;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
    .card_fixed_height{
        background: #939393;
        height: 250px;
        width: 280px;
        padding: 25px;
        display: table-cell;
        vertical-align: middle;
    }
    .card_transparent{
        width: 280px;
        margin: auto;
        padding: 25px;
    }
    .col3 {
        float:left;
        margin-right: 30px;
    }
    .cards_row a {
        display: inline-block;
        vertical-align: top;

    }
</style>
{/literal}

<div class="cards_container">
    <h1 class="text-center">Congrats on planning your {$tripname} Trip, {$nomeUsuario}</h1>

    <div class="cards_row m-t-100">

        <a href="{$baseUrl}explore/index">
            <div class="col3 m-b-10">
                <div class="card_fixed_height">
                    <h2 class="text-white semi-bold text-center">Explore Places, Events and activities in {$placename}.</h2>
                </div>
                <div class="card_transparent">
                    <p class="semi-bold text-center text-black">Explore the greatest places, activities, events curated from around the world.<br/>Save them to your dreamboard.<br/>Add them to your trip itinerary when you are ready.</p>
                </div>
            </div>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={$recommendationUrl}" id="fbrecommendation">
            <div class="col3 m-b-10">
                <div class="card_fixed_height">
                    <h2 class="text-white semi-bold text-center">Ask for a recommendation from friends.</h2>
                </div>
                <div class="card_transparent">
                    <p class="semi-bold text-center text-black">Your friend and network are a powerful force when it comes to recommendations.<br/> Simply share your request to facebook or email.<br/>And receive recommendations that you can add right to your itinerary.</p>
                </div>
            </div>
        </a>
        <a class="" href="{$baseUrl}trip/detail/id/{$id_trip}">
            <div class="col3 m-b-10">
                <div class="card_fixed_height">
                    <h2 class="text-white semi-bold text-center">Keep planning my trip details.</h2>
                </div>
                <div class="card_transparent">
                    <p class="semi-bold text-center text-black">Use our powerful trip planner to:<br/>
                    Organize your itinerary<br/>
                    Ask for recommendations<br/>
                    Plan budget<br/>
                    Solo or group travel<br/>
                    To do list and more</p>
                </div>
            </div>
        </a>
    </div>

</div>

