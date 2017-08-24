
<div class="row">
    <div class="  col-xs-12  col-sm-8  ">
        <ul class="event-list">
            {foreach from=$itinerary key=key item=place }
                <li class="{$place.type}">
                    <time datetime="{$place.startdate}">
                        <span class="day">{$place.day}</span>
                        <span class="month">{$place.month}</span>
                        <span class="year">2017</span>
                        <span class="time">ALL DAY</span>
                    </time>
                    {if $place.pic!=''}
                        <img alt="Arrival" src="{$place.pic}" />
                    {/if}
                    <div class="info">
                        {if $place.type == 'activity'}
                            <div  class="action-buttons pull-right" >

                                <i class="fa fa-2x fa-pencil" url="trip" name="btnaddactivity" params="id={$place.id}" event="click"></i>
                                <i class="fa fa-2x fa-trash-o m-l-20" msg="Do you really wanna delete this?" url="trip" name="btndelactivity" params="id={$place.id}" event="click"></i>
                            </div>
                        {/if}
                        <h2 class="title">{$place.title}</h2>
                        <p class="desc">{$place.desc} </p>
                        {if $place.type != 'activity'}
                            <p class="btn-add-activities"><a name="btnAddActivity" id="btnAddActivity" params="id_place={$place.id_place}" 
                                                             href="#none"  link="#none" event="click" label="Activity" class=""><i class="fa fa-plus"></i> <span>add activities in {$place.title}</span></a></p>
                            {/if}
                    </div>
                    {*<div class="social">
                    <ul>
                    <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
                    <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
                    <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
                    </ul>
                    </div>*}
                    {*<div class="activities">
                    {foreach from=$event.activities item=activity}
                    {$activity.name}
                    {/foreach}
                    </div>*}
                </li>

            {/foreach}

        </ul>
    </div>
    <div class="  col-xs-12 col-sm-4">
        <div class="view chat-view bg-white clearfix b-l b-grey chat-height-500">
            <!-- BEGIN Header  !-->
            <div class="h4 p-l-20 ">
                Let's talk
            </div>
            <!-- END Header  !-->
            <!-- BEGIN Conversation  !-->
            {*            <div class="" id="conversation4"  name="conversation4" params="id_trip={$trip->getID()}" event="load"></div>*}
            <div class="chat-inner " id="messages4"  name="messages4" >
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
                        {*                        <input type="text" name="message4" id="message4" class="form-control chat-input" data-chat-input="" hotkeys="enter, btnSendMsg4, click" data-chat-conversation="#messages4" placeholder="Say something">*}
                        <input type="text" name="message4" id="message4" class="form-control chat-input"  hotkeys="enter, btnSendMsg4, click"   placeholder="Say something">
                    </div>
                    {*   <div class="col-xs-1 link text-master m-l-10 m-t-15 p-l-10 b-l b-grey col-top">
                    <a href="#" class="link text-master"><i class="pg-camera"></i></a>
                    </div>*}
                    <div class="col-xs-1 link text-master m-l-10 m-t-15 p-l-10 b-l b-grey col-top hidden">
                        {*                        <a href="#" class="link text-master" ><i class="fa fa-paper-plane-o"></i></a>*}
                        {$btnSendMsg4}
                    </div>
                </div>
            </div>
            <!-- END Chat Input  !-->
        </div>
    </div>
</div>


{*<link class="main-stylesheet" href="{$baseUrl}Public/pages/css/themes/simple.css" rel="stylesheet" type="text/css" />*}
{*<script src="{$baseUrl}Public/assets/js/timeline.js" type="text/javascript"></script>
<script src="{$baseUrl}Public/assets/js/scripts.js" type="text/javascript"></script>*}

{literal}
    <style>
        body {
            padding: 60px 0px;
            background-color: rgb(220, 220, 220);
        }

        .event-list {
            list-style: none;
            font-family: 'Lato', sans-serif;
            margin: 0px;
            padding: 0px;
        }
        .event-list > li {
            background-color: rgb(255, 255, 255);
            box-shadow: 0px 0px 5px rgb(51, 51, 51);
            box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
            padding: 0px;
            margin: 0px 0px 20px;
        }
        .event-list > .activity {
            margin-left: 25px;
            margin-top: -19px;
        }
        .event-list > .activity > .btn-add-activities{
            display: none !important;
        }
        .event-list > li > time {
            display: inline-block;
            width: 100%;
            color: rgb(255, 255, 255);
            background-color: rgb(197, 44, 102);
            padding: 5px;
            text-align: center;
            text-transform: uppercase;
        }
        .event-list > li:nth-child(even) > time {
            background-color: rgb(165, 82, 167);
        }
        .event-list > li > time > span {
            display: none;
        }
        .event-list > li > time > .day {
            display: block;
            font-size: 56pt;
            font-weight: 100;
            line-height: 1;
        }
        .event-list > li time > .month {
            display: block;
            font-size: 24pt;
            font-weight: 900;
            line-height: 1;
        }
        .event-list > li > img {
            width: 100%;
        }
        .event-list > li > .info {
            padding-top: 5px;
            text-align: center;
        }
        .event-list > li > .info > .title {
            font-size: 17pt;
            font-weight: 700;
            margin: 0px;
        }
        .event-list > li > .info > .desc {
            font-size: 13pt;
            font-weight: 300;
            margin: 0px;
        }
        .event-list > li > .info > .btn-add-activities {
            font-size: 12pt;
            font-weight: 300;
            font-style: italic;
            position: absolute;
            bottom: 0px;
            padding-left: 20px;
        }
        .event-list > li > .info > ul,
        .event-list > li > .social > ul {
            display: table;
            list-style: none;
            margin: 10px 0px 0px;
            padding: 0px;
            width: 100%;
            text-align: center;
        }
        .event-list > li > .social > ul {
            margin: 0px;
        }
        .event-list > li > .info > ul > li,
        .event-list > li > .social > ul > li {
            display: table-cell;
            cursor: pointer;
            color: rgb(30, 30, 30);
            font-size: 11pt;
            font-weight: 300;
            padding: 3px 0px;
        }
        .event-list > li > .info > ul > li > a {
            display: block;
            width: 100%;
            color: rgb(30, 30, 30);
            text-decoration: none;
        }
        .event-list > li > .social > ul > li {
            padding: 0px;
        }
        .event-list > li > .social > ul > li > a {
            padding: 3px 0px;
        }
        .event-list > li > .info > ul > li:hover,
        .event-list > li > .social > ul > li:hover {
            color: rgb(30, 30, 30);
            background-color: rgb(200, 200, 200);
        }
        .facebook a,
        .twitter a,
        .google-plus a {
            display: block;
            width: 100%;
            color: rgb(75, 110, 168) !important;
        }
        .twitter a {
            color: rgb(79, 213, 248) !important;
        }
        .google-plus a {
            color: rgb(221, 75, 57) !important;
        }
        .facebook:hover a {
            color: rgb(255, 255, 255) !important;
            background-color: rgb(75, 110, 168) !important;
        }
        .twitter:hover a {
            color: rgb(255, 255, 255) !important;
            background-color: rgb(79, 213, 248) !important;
        }
        .google-plus:hover a {
            color: rgb(255, 255, 255) !important;
            background-color: rgb(221, 75, 57) !important;
        }

        @media (min-width: 768px) {
            .event-list > li {
                position: relative;
                display: block;
                width: 100%;
                height: 120px;
                padding: 0px;
            }
            .event-list > li > time,
            .event-list > li > img  {
                display: inline-block;
            }
            .event-list > li > time,
            .event-list > li > img {
                width: 120px;
                float: left;
            }
            .event-list > li > .info {
                background-color: rgb(245, 245, 245);
                overflow: hidden;
            }
            .event-list > li > time,
            .event-list > li > img {
                width: 120px;
                height: 120px;
                padding: 0px;
                margin: 0px;
            }
            .event-list > li > .info {
                position: relative;
                height: 120px;
                text-align: left;
                padding-right: 40px;
            }
            .event-list > li > .info > .title,
            .event-list > li > .info > .desc {
                padding: 0px 10px;
            }
            .event-list > li > .info > ul {
                position: absolute;
                left: 0px;
                bottom: 0px;
            }
            .event-list > li > .social {
                position: absolute;
                top: 0px;
                right: 0px;
                display: block;
                width: 40px;
            }
            .event-list > li > .social > ul {
                border-left: 1px solid rgb(230, 230, 230);
            }
            .event-list > li > .social > ul > li {
                display: block;
                padding: 0px;
            }
            .event-list > li > .social > ul > li > a {
                display: block;
                width: 40px;
                padding: 10px 0px 9px;
            }


            .action-buttons {
                cursor: pointer;
                opacity: 0;
                -moz-transition: cubic-bezier(0.55, 0.09, 0.68, 0.53) 0.4s;
                -webkit-transition: cubic-bezier(0.55, 0.09, 0.68, 0.53) 0.4s;
                transition: cubic-bezier(0.55, 0.09, 0.68, 0.53) 0.4s;
            }
            li:hover > .info > .action-buttons {
                opacity: 1;
            }
        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            var $timeline_block = $('.timeline-block');

            //hide timeline blocks which are outside the viewport
            $timeline_block.each(function () {
                if ($(this).offset().top > $(window).scrollTop() + $(window).height() * 0.75) {
                    $(this).find('.timeline-point, .timeline-content').addClass('is-hidden');
                }
            });

            //on scolling, show/animate timeline blocks when enter the viewport
            $(window).on('scroll', function () {
                $timeline_block.each(function () {
                    if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.75 && $(this).find('.timeline-point').hasClass('is-hidden')) {
                        $(this).find('.timeline-point, .timeline-content').removeClass('is-hidden').addClass('bounce-in');
                    }
                });
            });
        });
    </script>

{/literal}