<h1 id="addCityTitle">Adding {$tripname}</h1>

<h3>Awesome! Let's add some more details for {$placename}...</h3>
<div class="row">
    <div class="form-group form-group-default col-md-6">

        <!-- <div class=" no-padding"> -->
            <label>Budget</label>
            <div class="controls">
                {$budget}
            </div>
        <!-- </div> -->
    </div>
    <div class="col-md-6">
        <div class="checkbox ">
            {$budgetnotsure}
<!--             <input type="checkbox" value="Y" id="budgetcheckbox">
            <label for="budgetcheckbox">I’m Not sure yet</label> -->
        </div>
    </div>
</div>
<div class="row">

    <div class="form-group form-group-default col-md-6">

        <!-- <div class=" no-padding"> -->
            <label>Accomodation</label>
            <div class="controls">
                {$accomodation}
            </div>
        <!-- </div> -->
    </div>
    <div class="col-md-6">
        <div class="checkbox ">
            {$accomodationnotsure}
<!--             <input type="checkbox" value="Y" id="budgetcheckbox">
            <label for="budgetcheckbox">I’m Not sure yet</label> -->
        </div>
    </div>
</div>
<div class="row">

    <div class="form-group col-md-8">

        <!-- <div class=" no-padding"> -->
            <label>How are you getting there?</label>

                <div class="radio radio-success">
                    <input type="radio" value="f" name="transportationinfo" id="transportation_Fly">
                    <label for="transportation_Fly"><i class="fa fa-plane"></i> Fly</label>

                    <input type="radio" value="b" name="transportationinfo" id="transportation_Boat">
                    <label for="transportation_Boat"><i class="fa  fa-space-shuttle"></i> Boat</label>

                    <input type="radio" value="d" name="transportationinfo" id="transportation_Drive" checked>
                    <label for="transportation_Drive"><i class="fa  fa-car"></i> Drive</label>

                    <input type="radio" value="b" name="transportationinfo" id="transportation_Bike">
                    <label for="transportation_Bike"><i class="fa  fa-bicycle"></i> Bike</label>

                    <input type="radio" value="w" name="transportationinfo" id="transportation_Walk">
                    <label for="transportation_Walk"><i class="fa  fa-tree"></i> Walk</label>

                    <input type="radio" value="t" name="transportationinfo" id="transportation_Train">
                    <label for="transportation_Train"><i class="fa   fa-truck"></i> Train</label>

                </div>
        <!-- </div> -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {$btnAddMorePlaces}
        {$btnFinish}
    </div>
</div>


