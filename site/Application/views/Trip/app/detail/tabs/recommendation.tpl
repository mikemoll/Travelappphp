
{if $public}
{else}
    <a class="  m-b-10 " href="{$baseUrl}web/triprecommendation/p/{$pubUrl}">See the Public Recommendation page</a>
{/if}
<div class="row">
    {if not $hideTopBtns}
        <div class="col-lg-4 m-b-10">
            <a class="btn btn-success m-b-10 " href="{$baseUrl}web/addrecommendation/p/{$pubUrl}"><i class="fa fa-plus"></i> &nbsp Add a recommendation</a>
            {if $public}
            {else}
                {*            <a class="btn btn-facebook"><i class="fa fa-facebook"></i> &nbsp Ask for recommendations on Facebook</a>*}
                <a href="https://www.facebook.com/sharer/sharer.php?u={$recommendationUrl}" id="fbrecommendation">
                    <div class="col-lg-12 m-b-10">
                        <div class="card_fixed_height darkblue">
                            <h3 class="semi-bold text-center text-white">Ask friends for recommendations.</h3><hr>
                            <p class="semi-bold text-center text-white">Your friend and network are a powerful force when it comes to recommendations.<br/> Simply share your request to facebook or email.<br/>And receive recommendations that you can add right to your itinerary.</p>
                        </div>
                    </div>
                </a>
            {/if}
        </div>
        {*        <a class="btn btn-secondary" href="#" role="button"><i class="fa fa-map-marker"></i> &nbsp View on maps</a>*}
        {*    </div>*}
    {/if}
    {section name=i loop=$RecommendationLst}
        <div class="col-lg-4 card padding-20">
            <div class="row">
                <span class="label font-montserrat fs-11">{ $RecommendationLst[i]->getDecodedType()}</span>
                {if $RecommendationLst[i]->getType() neq 'P'}
                    <span class="label font-montserrat fs-11 text-white purple">{ $RecommendationLst[i]->activityOrEventType()}</span>
                {/if}
                <span class="pull-right">{ $RecommendationLst[i]->formattedCost()}</span>
            </div>

            <div class="fixed-height">
                <h3>{ $RecommendationLst[i]->getTitle() }</h3>
            </div>
            <div class="scroll-box-150">
                <p>{ $RecommendationLst[i]->getNotes() }</p>
            </div>
            <p><b>Recommended by { $RecommendationLst[i]->getFriendfullname() }</b></p>
            <a class="btn btn-default" href="#" role="button"><i class="fa fa-plus"></i> &nbsp Add to itinerary</a>
        </div>
    {/section}

</div>