{literal}
    <style>
        .gallery-item2{
            margin-bottom: 20px;
            cursor:pointer; 
        }
    </style>
{/literal}

<!-- START ROW -->
{section name=i loop=$places}
    {literal}
        <style>
            .place-{/literal}{$places[i].place_id}{literal}:after{
                background-image: url({/literal}{$places[i].photos[0].src}{literal}) !important;
            }
        </style>

        <script type="text/javascript">
            $("{/literal}{$places[i].place_id}{literal}").click(function(){
                $("#placename").val({/literal}{$places[i].name}{literal});
            });
        </script>

    {/literal}
    <div class="col-md-4 col-xlg-4 gallery-item2" id="{$places[i].place_id}" >
        <div class="ar-1-1">
            <!-- START WIDGET widget_imageWidgetBasic-->
            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin place-{$places[i].place_id}">
<!--                 <div class="panel-heading">
                    <div class="panel-controls">
                        <ul>
                            <li><a class="widget-3-fav no-decoration" href="#" id="btnadddream"
                                   name="btnadddream"  event="click" url="explore"
                                   params="place_id={$places[i].place_id}">
                                    <i class="fa fa-heart-o fa-2x" style="color: red"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> -->
                <div class="panel-body">
                    <div class="pull-bottom bottom-left bottom-right padding-15">
                        <span class="label font-montserrat fs-11">Place</span>
                        <br>
                        <h3 class="text-white">{$places[i].name}</h3>
                        {if $places[i].formatted_address!=''}
                            <p class="text-white hint-text hidden-md">{$places[i].formatted_address}</p>
                        {/if}
                    </div>
                </div>
            </div>
            <!-- END WIDGET -->
        </div>

    </div>

{sectionelse}
<p> Nothing found... Try again!</p>
{/section}