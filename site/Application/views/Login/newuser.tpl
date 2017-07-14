
<h1 class="light">Create your Tumbleweed account</h1>

<p id="msg">{$msg}</p>
<!-- START Login Form -->
<!-- START Form Control-->

<div class="form-group form-group-default col-md-6">

    <div class=" no-padding">
        <label>First name</label>
        <div class="controls">
            {$nomeCompleto}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-6">
    <div class="  no-padding">
        <label>Last name</label>
        <div class="controls">
            {$lastname}
        </div>
    </div>
</div>
<div class="form-group form-group-default col-md-12">

    <label>User name</label>
    <div class="controls">
        {$loginUser}
    </div>
</div>
<div class="form-group form-group-default col-md-12">
    <label>Password</label>
    <div class="controls">
        {$senha}
    </div>
</div>
<div class="form-group form-group-default col-md-12">
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