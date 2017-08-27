<div class="row m-b-20">
{if $public}
    <a class="btn btn-success" href="{$baseUrl}web/addrecommendation/p/{$pubUrl}"><i class="fa fa-plus"></i> &nbsp Add a recommendation</a>
{else}
    <a class="btn btn-facebook" id="share_fb" href="{$HTTP_HOST}{$baseUrl}web/triprecommendation/p/{$pubUrl}"><i class="fa fa-facebook"></i> &nbsp Ask for recommendations on Facebook</a>
    {literal}
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '259150917920223',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.10'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        document.getElementById("share_fb").addEventListener("click",function(event){
            FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: '{/literal}{$HTTP_HOST}{$baseUrl}web/triprecommendation/p/{$pubUrl}{literal}',
            }, function(response){});
            event.preventDefault();
            return false;
        });

    </script>
    {/literal}
    <a class="btn btn-success" href="{$baseUrl}web/triprecommendation/p/{$pubUrl}">See the Public Recommendation page</a>
{/if}
    <a class="btn btn-secondary" href="#" role="button"><i class="fa fa-map-marker"></i> &nbsp View on maps</a>
</div>
<div class="row">
    {section name=i loop=$RecommendationLst}
        <div class="col-lg-4 card padding-20">
            <div class="row">
                <span class="label font-montserrat fs-11">{ $RecommendationLst[i]->getDecodedType()}</span>
                {if $RecommendationLst[i]->getType() neq 'P'}
                    <span class="label font-montserrat fs-11 text-white purple">{ $RecommendationLst[i]->activityOrEventTypeName()}</span>
                {/if}
                <span class="pull-right">{ $RecommendationLst[i]->formattedCost()}</span>
            </div>

            <div>
                <h3 class="unique-line m-b-0">{ $RecommendationLst[i]->getTitle() }</h3>
            </div>
            <div>
                <p class="unique-line small-text"><i class="fa fa-map-marker"></i> { $RecommendationLst[i]->getLocation() }</p>
            </div>
            <div class="scroll-box-150">
                <p>{ $RecommendationLst[i]->getNotes() }</p>
            </div>
            <p class="unique-line"><b>Recommended by { $RecommendationLst[i]->getFriendfullname() }</b></p>
            {if not $public}
            <a class="btn btn-default" href="#" role="button"><i class="fa fa-plus"></i> &nbsp Add to itinerary</a>
            {/if}
        </div>
    {/section}

</div>