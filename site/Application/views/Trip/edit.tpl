
<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<div class="row">
    <div class="col-lg-12">
        {$tripname}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        {$startdate}
    </div>
    <div class="col-lg-6">
        {$enddate}
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        {$Description}
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        {$travelmethod}
    </div>
    <div class="col-lg-4">
        {$inventory}
    </div>
    <div class="col-lg-4">
        {$notes}
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <h3>Activities in this Trip</h3>
        {$gridActivity}
    </div>
    <div class="col-lg-6">
        <h3>Users in this Trip</h3>
        {$gridUser}
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        {$btnSalvar} {$btnCancel}
    </div>
</div>
