<p class="p-t-35">Create your travel track account</p>
<p id="msg">{$msg}</p>
<!-- START Login Form -->
<!-- START Form Control-->

<div class="form-group form-group-default">

    <div class="col-md-6 no-padding">
        <label>First name</label>
        <div class="controls">
            {$nomeCompleto}
        </div>
    </div>
    <div class="col-md-6 no-padding">
        <label>Last name</label>
        <div class="controls">
            {$lastname}
        </div>
    </div>

    <label>Email</label>
    <div class="controls">
        {$email}
    </div>

    <div class="col-md-4 no-padding">
        <label>Birthdate</label>
        <div class="controls">
            {$birthdate}
        </div>
    </div>

    <div class="col-md-8 no-padding">
        <label>Gender</label>
        <div class="controls">
            {$gender}
        </div>
    </div>
</div>
<div class="form-group form-group-default">

    <label>Education</label>
    <div class="controls">
        {$education}
    </div>

    <div class="col-md-6 no-padding">
        <label>Hometown (city)</label>
        <div class="controls">
            {$hometowncity}
        </div>
    </div>

    <div class="col-md-6 no-padding">
        <label>Hometown (country)</label>
        <div class="controls">
            {$hometowncountry}
        </div>
    </div>
</div>
<div class="form-group form-group-default">

    <label>User name</label>
    <div class="controls">
        {$loginUser}
    </div>
    <label>Password</label>
    <div class="controls">
        {$senha}
    </div>
    <label>Confirm Password</label>
    <div class="controls">
        {$confirmpassword}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
            {$termsofuse}
    </div>
</div>
{$btnRegister}
{$btnCancel}

<!--END Login Form-->