
<h1 class="light">Create your Tumbleweed account</h1>

<p id="msg">{$msg}</p>
<!-- START Login Form -->
<!-- START Form Control-->
{if $isfacebook}
<div class="col-md-12 p-b-15" style='overflow: hidden;'>
    <div class="col-xs-height" style='width: 200px; margin: 0px auto; display: block;'>
        <span class="thumbnail-wrapper circular bg-success" style="">
            <img width="34" height="34" alt="" data-src-retina="{$facebookphoto}" data-src="{$facebookphoto}" src="{$facebookphoto}" class="col-top">
        </span>
    </div>
</div>
{else}
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
{/if}
<div class="form-group form-group-default col-md-12">

    <label>Email</label>
    <div class="controls">
        {$email}
    </div>
</div>
<div class="form-group form-group-default col-md-12">

    <label>User name</label>
    <div class="controls">
        {$loginUser}
    </div>
</div>
{if !$isfacebook}
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
{/if}

<div class="row">
    <div class="col-md-12">
        {$termsofuse}
    </div>
</div>
{$btnRegister}
{$btnCancel}



<!--END Login Form-->