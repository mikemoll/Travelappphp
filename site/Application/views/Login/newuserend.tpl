{literal}
<style type="text/css">
    .cards_container {
        background-image: url("{/literal}{$background}{literal}");
        background-position: 100% center;
    }
</style>
{/literal}
<div class="cards_container">
    <h1 class="text-white text-center">You're in!<br/>So what would you like to do first:</h1>
    <div class="cards_row m-t-100">

        <a href="{$baseUrl}Trip/newtrip">
            <div class="col3 m-b-10">
                <div class="card_fixed_height">
                    <h2 class="semi-bold text-center">Plan a trip</h2>
                </div>
                <div class="card_transparent">
                    <p class="text-white semi-bold text-center text-black">Use our powerful trip planner to:<br/>
                    Organize your itinerary<br/>
                    Ask for recommendations<br/>
                    Plan budget<br/>
                    Solo or group travel<br/>
                    To do list and more</p>
                </div>
            </div>
        </a>
        <a href="{$baseUrl}explore/index" id="fbrecommendation">
            <div class="col3 m-b-10">
                <div class="card_fixed_height">
                    <h2 class="semi-bold text-center">Get Inspired</h2>
                </div>
                <div class="card_transparent">
                    <p class="text-white semi-bold text-center text-black">Explore the greatest places, activities, events curated from around the world.<br/>Save them to your dreamboard.<br/>Add them to your trip itinerary when you are ready.</p>
                </div>
            </div>
        </a>
    </div>
</div>

