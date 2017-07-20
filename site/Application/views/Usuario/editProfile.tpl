
<h1>{$TituloPagina}</h1>
<p id="msg">{$msg}</p>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<div class="form-group form-group-default col-md-3 text-center">

    <div class="fileinput fileinput-new" data-provides="fileinput" style="height: 174px;">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 125px;">
        <img data-src="{$PhotoPath}" alt="Click to change the photo">
      </div>
      <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 195px; max-height: 125px;"></div>
      <div>
        <span class="btn btn-default btn-file"><span class="fileinput-new">Change photo</span><span class="fileinput-exists">Change photo</span><input type="file" name="Photo"></span>
      </div>
    </div>

</div>

<div class="form-group form-group-default col-md-3">

    <div class=" no-padding">
        <label>First name</label>
        <div class="controls">
            {$nomeCompleto}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-3">
    <div class="  no-padding">
        <label>Last name</label>
        <div class="controls">
            {$lastname}
        </div>
    </div>
</div>
<div class="no-padding col-md-3">
    {$birthdate}
</div>
<div class="form-group form-group-default col-md-6">
    <label>Email</label>
    <div class="controls">
        {$email}
    </div>

</div>

<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Phone number</label>
        <div class="controls">
            {$telephone}
        </div>
    </div>
</div>


<div class="form-group form-group-default col-md-4">
    <div class=" no-padding">
        <label>Gender</label>
        <div class="controls">
            {$gender}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-5">
    <div class=" no-padding">
        <label>Relationship</label>
        <div class="controls">
            {$relationship}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-6">
    <div class=" no-padding">
        <label>Bio</label>
        <div class="controls">
            {$bio}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-6">
    <div class=" no-padding">
        <label>Traveled to</label>
        <div class="controls">
            {$traveledto}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-3">
    <div class="col-md-6 no-padding">
        <label>Home Town</label>
        <div class="controls">
            {$hometowncity}
        </div>
    </div>

</div>
<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Home Country</label>
        <div class="controls">
            {$hometowncountry}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Live in city</label>
        <div class="controls">
            {$liveincity}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Live in country</label>
        <div class="controls">
            {$liveincountry}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-6">

    <label>Education</label>
    <div class="controls">
        {$education}
    </div>

</div>
<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Occupation</label>
        <div class="controls">
            {$occupation}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-3">
    <div class=" no-padding">
        <label>Dream job</label>
        <div class="controls">
            {$dreamjob}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-4">
    <div class=" no-padding">
        <label>Instagram</label>
        <div class="controls">
            {$instagram}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-4">
    <div class=" no-padding">
        <label>Twitter</label>
        <div class="controls">
            {$twitter}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-4">
    <div class=" no-padding">
        <label>Facebook</label>
        <div class="controls">
            {$facebook}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-3">
    <label>Password</label>
    <div class="controls">
        {$senha}
    </div>
</div>
<div class="form-group form-group-default col-md-3">
    <label>Confirm Password</label>
    <div class="controls">
        {$confirmpassword}
    </div>
</div>
<div class="form-group form-group-default col-md-6" style="visibility: hidden;">
    <div class=" no-padding">
        <label>Calendar type</label>
        <div class="controls">
            {$calendartype}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-6">
    <div class=" no-padding">
        <label>Interests</label>
        <div class="controls">
            {$interests}
        </div>
    </div>
</div>

<div class="form-group form-group-default col-md-6">
    <div class=" no-padding">
        <label>Traveler type</label>
        <div class="controls">
            {$travelertypes}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        {$btnSaveProfile} {$btnCancel}
    </div>
</div>