                        <!-- BEGIN Profile View  !-->
                        <div class="view chat-view bg-white clearfix">
                            <!-- BEGIN Header  !-->
                            <div class="navbar navbar-default">
                                <div class="navbar-inner">
                                    <a href="javascript:;" class="link text-master inline action p-l-10 p-r-10"  name="friendslist" url="Usuario" event="click" >
                                        <i class="pg-arrow_left"></i>
                                    </a>
                                    <div class="view-heading">
                                        {$name}
                                        <div class="fs-11 hint-text"><i class="fa fa-map-marker"></i> {$livein}</div>
                                    </div>

                                </div>
                            </div>
                            <!-- END Header  !-->
                            <div style="padding: 20px 20px 20px 20px;">
                                <span class="col-xs-height col-middle" >
                                    <span class="thumbnail-wrapper circular bg-success" style="">
                                        <img width="34" height="34" alt="" data-src-retina="{$Photo}" data-src="{$Photo}" src="{$Photo}" class="col-top">
                                    </span>
                                </span>
                            </div>
                            <div style="padding: 0px 20px 20px 20px;">
                                <p class="fs-12">{$bio}</p>

                                <p align="center">
                                    {foreach from=$interests item=it}
                                        <img alt="it.name" src="{$it.icon}" />
                                    {/foreach} &nbsp; 
                                    {foreach from=$travelertypes item=it}
                                        <img alt="it.name" src="{$it.icon}" />
                                    {/foreach}
                                </p>
                                <p class="fs-12">Traveled to:<br> <span>{$traveledto}</span></p>
                                <p class="fs-12">Hometown: <span class="fs-12">{$hometown}</span></p>
                                <p class="fs-12">Relationship: <span class="fs-12">{$relationship}</span></p>
                                <p class="fs-12">Education: <span class="fs-12">{$education}</span></p>
                                <p class="fs-12">Occupation: <span class="fs-12">{$occupation}</span></p>
                                <p class="fs-12">Dreamjob: <span class="fs-12">{$dreamjob}</span></p>
                                <p align="center">
                                    <a class="btn btn-primary" type="button" href="https://facebook.com/{$facebook}" target="_blank">
                                        <span class="pull-left"><i class="fa fa-facebook"></i></span>
                                    </a>
                                    <a class="btn btn-complete" type="button" href="https://twitter.com/{$twitter}" target="_blank">
                                        <span class="pull-left"><i class="fa fa-twitter"></i></span>
                                    </a>
                                    <a class="btn btn-info" type="button" href="https://instagram.com/{$instagram}" target="_blank">
                                        <span class="pull-left"><i class="fa fa-instagram"></i></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- END Profile View  !-->