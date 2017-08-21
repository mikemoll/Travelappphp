<!-- START DAY -->

{*section name=i loop=$RecommendationLst*}

{literal}
<style>
    .card {
        margin-left: 10px;

    }
    .scroll-box-150 {
        height: 150px;
        overflow-y: auto;
        margin-bottom: 10px;

    }
    .fixed-height {
        height: 90px;
        overflow-y: hidden;
    }
</style>
{/literal}

{*
{literal}
    <style>

        .TripplaceLst-{/literal}{$TripplaceLst[i]->getID()}{literal}:after{
            background-image: url({/literal}{$TripplaceLst[i]->getPhotoPath()}{literal}) !important;
        }
    </style>
{/literal}
*}
<div class="row">
    <div class="col-lg-4 card padding-20">
        <div class="row">
            <span class="label font-montserrat fs-11">Place</span>
            <span class="label font-montserrat fs-11 text-white " style="background-color: #6D5CAE;">Nature</span>
            <span class="pull-right">$50.00 CAD</span>
        </div>

        <div class="fixed-height">
            <h3>Phi Phi Island</h3>
        </div>
        <div class="scroll-box-150">
            <p>Phi Phi Island is Thailand's island-superstar. It's been in the movies. It's the topic of conversation for travelers all over Thailand..</p>
        </div>
        <p><b>Recommended by Rômulo Berri</b></p>
        <a class="btn btn-secondary" href="#" role="button">View on maps</a>
    </div>
    <div class="col-lg-4 card padding-20">
        <div class="row">
            <span class="label font-montserrat fs-11">Activity</span>
            <span class="label font-montserrat fs-11 text-white " style="background-color: #6D5CAE;">City tour</span>
            <span class="pull-right">$70.00 CAD</span>
        </div>

        <div class="fixed-height">
            <h3>Bangkok by Night tour by Tuk-Tuk</h3>
        </div>
        <div class="scroll-box-150">
        <p>This 4-hour cultural night tour by tuk-tuk provides a great introduction to Bangkok for first-time visitors, but it also showcases a side of the city that most repeat visitors haven't seen. You get to bypass heavily trafficked areas and take off-the-beaten-track routes toward illuminated temples such as Wat Pho and a bustling, 24-hour flower market. Enjoy dinner, followed by dessert at a secret, mystery stop. This small-group tour is limited to 12 people.</p>
        </div>
        <p><b>Recommended by Jose Gutierrez</b></p>
        <a class="btn btn-secondary" href="#" role="button">View on maps</a>
    </div>
    <div class="col-lg-4 card padding-20">
        <div class="row">
            <span class="label font-montserrat fs-11">Activity</span>
            <span class="label font-montserrat fs-11 text-white " style="background-color: #6D5CAE;">Course</span>
            <span class="pull-right">$100.00 CAD</span>
        </div>
        <div class="fixed-height">
            <h3>Cooking Class in Bangkok</h3>
        </div>
        <div class="scroll-box-150">
            <p>You choose 5 Thai dishes plus a curry paste to make from scratch from the list below to learn in this half day cooking class. Enjoy learning in air-conditioning at a professional Thai culinary school, located next to a BTS station. Visit a local market, have fun cooking the dishes and then eating them.</p>
        </div>

        <p><b>Recommended by Leonardo Danieli</b></p>
        <a class="btn btn-secondary" href="#" role="button">View on maps</a>
    </div>
    <div class="col-lg-4 card padding-20">
        <div class="row">
            <span class="label font-montserrat fs-11">Events</span>
            <span class="label font-montserrat fs-11 text-white " style="background-color: #6D5CAE;">Martial Arts</span>
            <span class="pull-right">Free</span>
        </div>
        <div class="fixed-height">
            <h3>National Muay Thai Day</h3>
        </div>
        <div class="scroll-box-150">
            <p>In Thailand, March 17 is the day when those involved in Thai boxing (Muay Thai) celebrate a hero of the sport. Boxer’s Day isn’t a public holiday, but there are commemorative events at various Muay Thai stadiums and training camps and it is a day with particular significance for the town of Ayutthaya, the home of the legendary figure of Nai Khanom Tom.</p>
        </div>
        <p><b>Recommended by Rômulo Berri</b></p>
        <a class="btn btn-secondary" href="#" role="button">View on maps</a>
    </div>
</div>
{*/section*}