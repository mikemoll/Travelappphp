<div class="cards_container">
    <div class="header_background" style="background-image: url({$placephotopath});">
        <div class="opacity_frame">
            <div class="header_content">
                <h2>{$tripname}</h2>
                <p>{$startdate}</p>
                <p>{$enddate}</p>
                <p><span class="thumbnail-wrapper m-r-10">Trip Mates: </span>
                    {foreach from=$friends item=f}
                    <span class="thumbnail-wrapper d32 circular bg-success">
                        <img width="34" height="34" alt="{$f.username}" title="{$f.username}" data-src-retina="{$f.photourl}" data-src="{$f.photourl}" src="{$f.photourl}">
                    </span>
                    {/foreach}
                </p>
            </div>
        </div>
    </div>
    <div class="cards_row">
        <h3 class="m-t-30 m-b-30">Congrats on planning your trip.</h3>
        <p class="m-b-30"><strong class="text-black">What would you like to do next {$nomeUsuario}?</strong></p>
        <a href="{$baseUrl}explore/index/q/{$placename}">
            <div class="col3 m-b-10">
                <div class="card_fixed_height_tall purple">
                    <h3 class="semi-bold text-center text-white">Explore {$placename}.</h3><hr>
                    <p class="semi-bold text-center text-white">Explore the greatest places, activities, events curated from around the world.<br/>Save them to your dreamboard.<br/>Add them to your trip itinerary when you are ready.</p>
                </div>
            </div>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={$recommendationUrl}" id="fbrecommendation">
            <div class="col3 m-b-10">
                <div class="card_fixed_height_tall darkblue">
                    <h3 class="semi-bold text-center text-white">Ask friends for recommendations.</h3><hr>
                    <p class="semi-bold text-center text-white">Your friend and network are a powerful force when it comes to recommendations.<br/> Simply share your request to facebook or email.<br/>And receive recommendations that you can add right to your itinerary.</p>
                </div>
            </div>
        </a>
        <a class="" href="{$baseUrl}trip/detail/id/{$id_trip}">
            <div class="col3 m-b-10">
                <div class="card_fixed_height_tall green">
                    <h3 class="semi-bold text-center text-white">Keep planning my trip details.</h3><hr>
                    <p class="semi-bold text-center text-white">Use our powerful trip planner to:<br/>
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

