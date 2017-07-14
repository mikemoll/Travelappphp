{literal}
    <style>
        .activity-1:after{
            background-image: url(http://www.thedoubleclicks.com/wp-content/uploads/2016/12/museums1fourseasons.jpg) !important;
        }
        .activity-2:after{
            background-image: url(https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg) !important;
        }
    </style>
{/literal}
<!-- START ROW -->
<div class="col-sm-12 m-b-10">
    <div class="ar-1-1">
        <!-- START WIDGET widget_imageWidgetBasic-->
        <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin activity-{$item->getID()}">
            <div class="panel-heading">
                <div class="panel-controls">
                    <ul>
                        <li><a href="#" params="id_activity={$item->getID()}" id="btnbookmarkit"  name="btnbookmarkit"  event="click" url="Dreamboard"  class="portlet-refresh" data-toggle="refresh"><i
                                    class="fa fa-heart-o fa-2x" style="color: red"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="pull-bottom bottom-left bottom-right padding-25">
                    <span class="label font-montserrat fs-11">Activity</span>
                    <br>
                    <h3 class="text-white">{$item->getActivityName()}</h3>
                    <p class="text-white hint-text hidden-md">{$item->getDescription()|truncate:50:''}</p>
                </div>

            </div>
        </div>
        <!-- END WIDGET -->
    </div>
</div>