
<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<div class="row">
    <div class="col-lg-3">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

        <div class="form-group form-group-default col-md-12 text-center">

            <div class="fileinput fileinput-new" data-provides="fileinput" style="height: 174px;">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 125px;">
                    <img data-src="{$PhotoPath}" alt="Click to change the photo">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 195px; max-height: 125px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Change image</span><span class="fileinput-exists">Change image</span><input type="file" name="Photo"></span>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                {$btnSave} {$btnCancel}
            </div>
        </div>
    </div>
    <div class="col-lg-5">

        <div class="row">
            <div class="col-lg-12">
                {$name}
            </div>
            <div class="col-lg-12">
                {$country}
            </div>
            <div class="col-lg-12">
                {$formatted_address}
            </div>
            <div class="col-lg-12">
                {$google_place_id}
            </div>
            <div class="col-lg-12">
                {$rating}
            </div>
            <div class="col-lg-12">
                {$googletypes}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                {$description}
            </div>
        </div>
    </div>
</div>

