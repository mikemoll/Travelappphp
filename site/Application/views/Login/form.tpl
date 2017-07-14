
<h1 class="light">Welcome to<br>Tumbleweed</h1>
<h3 class="light">Discover, plan and enjoy your gratest travel adventures.</h3>

<p id="msg">{$msg}</p>
<p class="p-t-35">Sign into your Tumbleweed account</p>
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
        <a href="#" class="text-info small">Forgot my password</a>
    </div>
</div>
<!-- END Form Control-->
{*<button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>*}
{$btnLogin}
<br/>
<button class="btn btn-success btn-cons m-t-10" type="submit">Request invite</button>

{* $btnLoginFacebook *}
{* $btnEsqueci *}

<p class="p-t-35">Not registered yet?</p>
{$btnCreate}

<!--END Login Form-->