<!-- START Login Form -->
<!-- START Form Control-->

<div class="form-group form-group-default">

    <label>Login</label>
    <div class="controls">
        {*            <input type="text" name="username" placeholder="User Name" class="form-control" required>*}
        {$user}
    </div>
</div>

<!-- END Form Control-->
<!-- START Form Control-->
<div class="form-group form-group-default">
    <label>Password</label>
    <div class="controls">
        {*            <input type="password" class="form-control" name="password" placeholder="Credentials" required>*}
        {$senha}
    </div>
</div>


<!-- START Form Control-->
<div class="row">
    <div class="col-md-6 no-padding">
        <div class="checkbox ">
            <input type="checkbox" value="1" id="checkbox1">
            <label for="checkbox1">Keep Me Signed in</label>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a href="#" class="text-info small">Help? Contact Support</a>
    </div>
</div>
<!-- END Form Control-->
{*<button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>*}
{$btnLogin}
{$btnEsqueci}
<!--END Login Form-->