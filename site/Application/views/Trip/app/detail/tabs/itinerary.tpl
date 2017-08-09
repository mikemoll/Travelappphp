
<div class="row">
    <div class=" col-sm-1">
        {$btnAddActivity}
    </div>
    <div class="  col-xs-12   col-sm-10  ">
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
                    <div class="social">
                        <ul>
                            <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
                            <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
                            <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
                        </ul>
                    </div>
                    {*<div class="activities">
                    {foreach from=$event.activities item=activity}
                    {$activity.name}
                    {/foreach}
                    </div>*}
                </li>

            {/foreach}
            {*<li>
            <time datetime="2014-07-20">
            <span class="day">4</span>
            <span class="month">Jul</span>
            <span class="year">2017</span>
            <span class="time">ALL DAY</span>
            </time>
            <img alt="Arrival" src="https://media.licdn.com/mpr/mpr/shrinknp_800_800/p/5/005/0b8/3f7/047eea7.jpg" />
            <div class="info">
            <h2 class="title">Arrival to .....</h2>
            <p class="desc">Go to the hotel </p>
            </div>
            <div class="social">
            <ul>
            <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
            <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
            <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
            </ul>
            </div>
            </li>

            <li>
            <time datetime="2014-07-20 0000">
            <span class="day">8</span>
            <span class="month">Jul</span>
            <span class="year">2017</span>
            <span class="time">12:00 AM</span>
            </time>
            <div class="info">
            <h2 class="title">One Piece Unlimited World Red</h2>
            <p class="desc">PS Vita</p>
            <ul>
            <li style="width:50%;"><a href="#website"><span class="fa fa-globe"></span> Website</a></li>
            <li style="width:50%;"><span class="fa fa-money"></span> $39.99</li>
            </ul>
            </div>
            <div class="social">
            <ul>
            <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
            <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
            <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
            </ul>
            </div>
            </li>

            <li>
            <time datetime="2014-07-20 2000">
            <span class="day">10</span>
            <span class="month">Jul</span>
            <span class="year">2017</span>
            <span class="time">8:00 PM</span>
            </time>
            <img alt="My 24th Birthday!" src="https://farm5.staticflickr.com/4150/5045502202_1d867c8a41_q.jpg" />
            <div class="info">
            <h2 class="title">Mouse0270's 24th Birthday!</h2>
            <p class="desc">Bar Hopping in Erie, Pa.</p>
            <ul>
            <li style="width:33%;">1 <span class="glyphicon glyphicon-ok"></span></li>
            <li style="width:34%;">3 <span class="fa fa-question"></span></li>
            <li style="width:33%;">103 <span class="fa fa-envelope"></span></li>
            </ul>
            </div>
            <div class="social">
            <ul>
            <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
            <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
            <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
            </ul>
            </div>
            </li>

            <li>
            <time datetime="2014-07-20">
            <span class="day">15</span>
            <span class="month">Jul</span>
            <span class="year">2017</span>
            <span class="time">ALL DAY</span>
            </time>
            <img alt="Departure" src="https://www.kcet.org/sites/kl/files/styles/kl_image_large/public/thumbnails/image/flight-departure.jpg?itok=RbmwaVZ0" />
            <div class="info">
            <h2 class="title">Departure </h2>
            <p class="desc">Time to say good bye!</p>
            </div>
            <div class="social">
            <ul>
            <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
            <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
            <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
            </ul>
            </div>
            </li>*}
        </ul>
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