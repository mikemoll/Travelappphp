                        <div class="view bg-white" >
                            <!-- BEGIN View Header !-->
                            <div class="navbar navbar-default">
                                <div class="navbar-inner">
                                    <!-- BEGIN Header Controler !-->
                                    <a href="javascript:;" class="inline action p-l-10 link text-master" id="addFriend" name="addFriend" url="Usuario" event="click" >
                                        <i class="pg-plus"></i>
                                    </a>
                                    <!-- END Header Controler !-->
                                    <div class="view-heading">
                                        My Friends List
                                        <!-- <div class="fs-11">Show All</div> -->
                                    </div>
                                    <!-- BEGIN Header Controler !-->
                                    <a href="#" class="inline action p-r-10 pull-right link text-master">
                                        <i class="pg-more"></i>
                                    </a>
                                    <!-- END Header Controler !-->
                                </div>
                            </div>
                            <!-- END View Header !-->
                            <div data-init-list-view="ioslist" class="list-view boreded no-top-border" style="overflow-y: scroll;height: 94%;">
                                {foreach from=$friends key=letter item=friends_lst}
                                <div class="list-view-group-container">
                                    <div class="list-view-group-header text-uppercase">{$letter}</div>
                                    <ul>
                                        {foreach from=$friends_lst key=id_friend item=friend}
                                        <!-- BEGIN Chat User List Item  !-->
                                        <li class="chat-user-list clearfix">
                                            <a id="loadProfile" name="loadProfile" url="Usuario" {if $friend.isfriend eq 'S'} event="click" params="id={$id_friend}" {/if}>
                                                <span class="col-xs-height col-middle">
                                                    <span class="thumbnail-wrapper d32 circular bg-success">
                                                        <img width="34" height="34" alt="" data-src-retina="{$friend.Photo}" data-src="{$friend.Photo}" src="{$friend.Photo}" class="col-top">
                                                    </span>
                                                </span>
                                                <p class="p-l-10 col-xs-height col-middle col-xs-12">
                                                    <span class="text-master">{$friend.name}</span>
                                                    <span class="block text-master hint-text fs-12">{$friend.status}</span>
                                                </p>
                                            </a>
                                        </li>
                                        <!-- END Chat User List Item  !-->
                                        {/foreach}
                                    </ul>
                                </div>
                                {/foreach}
                            </div>
                        </div>