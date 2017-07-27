{literal} 

    <style>
        #btnLogin,
        #btnCreate,
        #btnRequestInvite,
        #btnLoginFacebook {
           /* width: 258px;*/
            width: 100%;
        }
        #btnLoginFacebook {
            background-color: #4267B2;
            color: white;
        }
    </style>
{/literal} 
<h1 class="light">Welcome to<br>Tumbleweed</h1>
<h3 class="light">Discover, plan and enjoy your gratest travel adventures.</h3>

<p id="msg">{$msg}</p>
<p class="p-t-0">Sign into your Tumbleweed account</p>

<div class="form-group form-group-default">

    <label>Login</label>
    <div class="controls">
        {*            <input type="text" name="username" placeholder="User Name" class="form-control" required>*}
        {$user}
    </div>
</div>

<div class="form-group form-group-default">
    <label>Password</label>
    <div class="controls">
        {*            <input type="password" class="form-control" name="password" placeholder="Credentials" required>*}
        {$senha}
    </div>
</div>


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


<div class="row"> 
    <div class="col-md-4  text-center">
        {$btnLogin}
    </div>
    <div class="col-md-8  text-center">
        {$btnLoginFacebook}
{*        <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>*}
    </div> 
    {* <div class="col-md-12 no-padding text-center">
    <p class="p-t-10">or</p>
    </div> 
    <div class="col-md-12 no-padding text-center"> 
    </div> *}
    <div class="col-md-12 no-padding text-center"> 
        <p class="p-t-20">Not registered yet?</p>
    </div> 
    <div class="col-md-12 no-padding text-center"> 
        {$btnCreate} 
    </div> 
    <div class="col-md-12 no-padding text-center"> 
        <button id="btnRequestInvite" class="btn btn-success btn-cons m-t-10" type="submit">Request invite</button> 
    </div> 
</div> 