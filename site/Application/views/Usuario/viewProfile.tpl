            <div class="row full-height no-margin">
                <div class="col-md-3 no-padding b-r b-grey sm-b-b full-height">
                    <div class="full-height">
                    <!-- BEGIN Profile View  !-->
                        <div style="padding-right: 20px;">
                            <span class="col-xs-height col-middle" >
                                <span class="thumbnail-wrapper circular bg-success" style="">
                                    <img width="34" height="34" alt="" data-src-retina="{$Photo}" data-src="{$Photo}" src="{$Photo}" class="col-top">
                                </span>
                            </span>
                        </div>
                        <div>
                            <p class="fs-12">{$bio}</p>

                            <p align="center">
                                {foreach from=$interests item=it}
                                    <img alt="{$it.name}" title="{$it.name}" src="{$it.icon}" />
                                {/foreach} &nbsp; 
                                {foreach from=$travelertypes item=it}
                                    <img alt="{$it.name}" title="{$it.name}" src="{$it.icon}" />
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
                            <p> </p>
                            {if $myprofile eq TRUE}
                            <p align="center"><a class="btn btn-warning" type="button" href="{$baseUrl}usuario/profileedit">Edit Profile</a></p>
                            {/if}
                        </div>
                    <!-- END Profile View  !-->
                    </div>
                </div>
                <div class="col-md-9 no-padding full-height">
                    <div class="placeholder full-height">
                        <!-- BEGIN Header  !-->
                        <div class="full-width col-middle">
                            <h1 align="center">{$name}</h1>
                            <p align="center"><i class="fa fa-map-marker"></i> {$livein}</p>
                        </div>
                        <!-- END Header  !-->
                    </div>
                </div>
            </div>