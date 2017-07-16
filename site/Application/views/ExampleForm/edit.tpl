<h1>Example Form</h1>
<p>Here you're gonna find how to use the Form Fields!</p>
<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<fieldset>
    <legend>

        <h3>Ui_Element_Text</h3>
    </legend>
    <div class="row">
        <div class="col-lg-6">
            <p>That's the base:</p>
            <pre>
$element = new Ui_Element_Text('text', "Simple Text");
$form->addElement($element);
            </pre>
        </div>
        <div class="col-lg-6">
            {$text}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {$maxlength}
        </div>
        <div class="col-lg-6">
            {$hidingremaningcharacteres}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {$placeholder}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {$textRequired}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {$hotkey}
        </div>
    </div>
</fieldset>
<div class="row">
    <div class="col-lg-12">
        {$pass}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        {$textmask}
    </div>
    <div class="col-lg-6">
        {$date}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        {$select}
    </div>
    <div class="col-lg-6">
        {*        <div class="radio radio-default">*}
        {$radio}
        {*        </div>*}
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        {$checkbox}
        <pre>
            {$checkboxCode}
        </pre>
    </div>
    <div class="col-lg-6">
    </div>
</div>
<div class="row">
    <h2>Grid</h2>
</div>
<div class="row">
    <div class="col-lg-12">
        {$grid}
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        {$btnSalvar} {$btnCancel}
    </div>
</div>
