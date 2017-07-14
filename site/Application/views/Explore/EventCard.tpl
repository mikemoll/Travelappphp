{literal}
    <style>
        .event-1:after{
            background-image: url(http://tripintour.com/blog/wp-content/uploads/2013/07/maracana-inauguracao-28-size-5981.jpg) !important;
        }

    </style>
{/literal}
<!-- START ROW -->
<div class="col-sm-12 m-b-10">
    <div class="ar-1-1">
        <!-- START WIDGET widget_imageWidgetBasic-->
        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin event-{$item->getID()}">
            <div class="panel-heading">
                <div class="panel-controls">
                    <ul>
                        <li><a href="#" params="id_event={$item->getID()}" id="btnbookmarkit"  name="btnbookmarkit"  event="click" url="Dreamboard"  class="portlet-refresh" data-toggle="refresh"><i
                                    class="fa fa-heart-o fa-2x" style="color: red"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="pull-bottom bottom-left bottom-right padding-25">
                    <span class="label font-montserrat fs-11">Event</span>
                    <br>
                    <h3 class="text-white">{$item->getEventName()}</h3>
                    <p class="text-white hint-text hidden-md">{$item->getDescription()|truncate:50:''}</p>
                </div>

            </div>
        </div>
        <!-- END WIDGET -->
    </div>
</div>