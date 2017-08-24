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
</div>
<div class="container">
    {$recommendations}
</div>

