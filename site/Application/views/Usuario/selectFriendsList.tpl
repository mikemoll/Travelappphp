                        <div class="view bg-white" >
                            <div data-init-list-view="ioslist" class="list-view boreded no-top-border" style="overflow-y: scroll;height: 94%;">
                                {foreach from=$friends key=letter item=friends_lst}
                                <div class="list-view-group-container">
                                    <div class="list-view-group-header text-uppercase">{$letter}</div>
                                    <ul>
                                        {foreach from=$friends_lst key=id_friend item=friend}
                                        <!-- BEGIN Chat User List Item  !-->
                                        <li class="chat-user-list clearfix">

    <div class="checkbox check-primary">
        <input type="checkbox" value="{$friend.id_usuario_friend}" id="friend{$friend.id_usuario_friend}" name="id_usuario_friend[]">
        <label for="friend{$friend.id_usuario_friend}">
                                                <span class="col-xs-height col-middle">
                                                    <span class="thumbnail-wrapper d32 circular bg-success">
                                                        <img width="34" height="34" alt="" data-src-retina="{$friend.Photo}" data-src="{$friend.Photo}" src="{$friend.Photo}" class="col-top">
                                                    </span>
                                                </span>
                                                <p class="p-l-10 col-xs-height col-middle col-xs-12">
                                                    <span class="text-master">{$friend.name}</span>
                                                    <span class="block text-master hint-text fs-12">{$friend.status}</span>
                                                </p>
        </label>
    </div>

                                        </li>
                                        <!-- END Chat User List Item  !-->
                                        {/foreach}
                                    </ul>
                                </div>
                                {/foreach}
                            </div>
                        </div>




