{if not $hideTopBtns}
<div class="row">
    {if $public}
        <a class="btn btn-success" href="{$baseUrl}web/addrecommendation/p/{$pubUrl}"><i class="fa fa-plus"></i> &nbsp Add a recommendation</a>
    {else}
        <a class="btn btn-facebook"><i class="fa fa-facebook"></i> &nbsp Ask for recommendations on Facebook</a>
    {/if}
    <a class="btn btn-secondary" href="#" role="button"><i class="fa fa-map-marker"></i> &nbsp View on maps</a>
</div>
{/if}
<div class="row">
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