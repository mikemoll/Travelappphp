{literal}
    <style>
        #newtrip5_bg{
            background-image: url({/literal}{$placephotopath}{literal}) !important;
            overflow: hidden;
            background-repeat: no-repeat;
        }
        #newtrip5_title{
            padding-top: 20px;
        }
        #newtrip5_subtitle{
            padding-top: 100px;
            padding-bottom: 20px;
        }
        #newtrip5_title,
        #newtrip5_subtitle {
            color: white;
            padding-left: 20px;
        }
        #newtrip5_btn {
            padding-bottom: 20px;
        }
    </style>
{/literal}
<div id='newtrip5_bg'>

    <h1 id="newtrip5_title">Adding {$tripname}</h1>

    <h3 id="newtrip5_subtitle">Dates for {$placename}</h3>

    <div class="col-md-8">
        {$startdate}
    </div>

    <div class="col-md-8">
        {$enddate}
    </div>

    <div class="col-md-8" id="newtrip5_btn">
        {$btnNext5}
    </div>
</div>


<!-- <p> </p>
<img style="height: 100%;width: 100%;" src="{$placephotopath}"/> -->


