<div class="view chat-view bg-white clearfix b-l b-grey chat-height-500">
    <!-- BEGIN Header  !-->
    <div class="h4 p-l-50 b-b b-info">
        Let's talk
    </div>
    <!-- END Header  !-->
    <!-- BEGIN Conversation  !-->
    {*            <div class="" id="conversation5"  name="conversation5" params="id_trip={$trip->getID()}" event="load"></div>*}
    <div class="chat-inner " id="messages5"  name="messages5" >
        <!--  ======= THE MESSAGES WILL APPEAR HERE!! ===== -->
    </div>
    <!-- BEGIN Conversation  !-->
    <!-- BEGIN Chat Input  !-->
    <div class="b-t b-grey bg-white clearfix p-l-10 p-r-10">
        <div class="row">
            {*<div class="col-xs-1 p-t-15">
            <a href="#" class="link text-master"><i class="fa fa-plus-circle"></i></a>
            </div>*}
            <div class="col-xs-8 no-padding">
                {*                        <input type="text" name="message5" id="message5" class="form-control chat-input" data-chat-input="" hotkeys="enter, btnSendMsg4, click" data-chat-conversation="#messages4" placeholder="Say something">*}
                <input type="text" name="message5" id="message5" class="form-control chat-input"  hotkeys="enter, btnSendMsg5, click"   placeholder="Say something">
            </div>
            {*   <div class="col-xs-1 link text-master m-l-10 m-t-15 p-l-10 b-l b-grey col-top">
            <a href="#" class="link text-master"><i class="pg-camera"></i></a>
            </div>*}
            <div class="col-xs-1 link text-master m-l-10 m-t-15 p-l-10 b-l b-grey col-top hidden">
                {*                        <a href="#" class="link text-master" ><i class="fa fa-paper-plane-o"></i></a>*}
                {$btnSendMsg5}
            </div>
        </div>
    </div>
    <!-- END Chat Input  !-->
</div>