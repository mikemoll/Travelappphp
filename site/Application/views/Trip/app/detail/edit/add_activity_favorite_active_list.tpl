
{section name=i loop=$activityLst}

    {literal}
        <style>
            .activity-{/literal}{$activityLst[i]->getID()}{literal}:after{
                background-image: url({/literal}{$activityLst[i]->getPhotoPath()}{literal}) !important;
            }
        </style>
    {/literal}

    <div class="col-md-4 col-xlg-12 m-b-10  m-r-10 pointer" >
        <div class="ar-1-1">
            <!-- START WIDGET widget_imageWidgetBasic-->
            <div class="widget-2 panel no-border bg-primary widget widget-loader-circle-lg no-margin activity-{$activityLst[i]->getID()}">
                <div class="panel-heading">
                    <div class="panel-controls">
                        <ul>
                            <li>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body gallery-item2" data-id="{$activityLst[i]->getID()}"  event="click" name="galeryItem" url='explore'   params="id_activity={$activityLst[i]->getID()}">
                    <div class="pull-bottom bottom-left bottom-right padding-15">
                        <h3 class="text-white">{$activityLst[i]->getActivityName()}</h3>
                        {if $activityLst[i]->getCity()!=''}
                            <p class="text-white hint-text hidden-md">{$activityLst[i]->getCity()}, {$activityLst[i]->getCountry()}</p>
                        {/if}
                        <h3 class="text-white hidden-md  bold">${$activityLst[i]->getPrice()}</h3>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group form-group-default  input-group"> <input type="text" style="padding-right: 25px; border-right: 2px solid rgb(193, 0, 5); z-index: 2;" name="start_at" id="start_at" value="10/01/2017" buttonimageonly="1" showon="button" dateformat="mm/dd/yyyy" placeholder="__/__/_____" buttontext="" autosize="1" constraininput="" minviewmode="0" class="form-control datepicker" data-mask-format="99/99/9999" label="Date" data-date-min-view-mode="0" data-date-today-btn="true" data-date-language="en" obrig="obrig" spellcheck="false" data-times-focused="1" data-times-mask-focused="1"><div class="ginger-module-inputHandlerGhost ginger-module-inputHandlerGhost-textarea" style="height: 25px; width: 372px; top: 26px; left: 0px; position: absolute; z-index: 1;"></div><span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span> </div>
                            </div>
                            <div class="col-md-4">
                                <div class=" btn btn-sm" url="trip" name='addActivity' event='click' params='id_activity={$activityLst[i]->getID()}'>
                                    <i class="fa fa-plus">Add</i>
                                </div>
                            </div>
                        </div>
                        {*                                <span class="label font-montserrat fs-11">Activity</span>*}
                        {*                        <span class="label font-montserrat fs-11 text-white " style='background-color: #FF50FF;  '>{$activityLst[i]->getactivitytypename()}</span>*}

                        {*                        <span class=" pull-right fs-11">{$activityLst[i]->getRatingHtml()}</span>*}
                    </div>
                </div>
            </div>
            <!-- END WIDGET -->
        </div>

    </div>
{/section}
