<h1>{$TituloPagina}</h1>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<div class="form-group form-group-default col-md-3 text-center">

    <div class="fileinput fileinput-new" data-provides="fileinput" style="height: 174px;">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 125px;">
        <img data-src="{$imgPath}" alt="Click to change the image">
      </div>
      <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 195px; max-height: 125px;"></div>
      <div>
        <span class="btn btn-default btn-file"><span class="fileinput-new">Change image</span><span class="fileinput-exists">Change image</span><input type="file" name="image"></span>
      </div>
    </div>

</div>

<input type="hidden" autofocus="true" />
<!-- LINHA 1  -->
<div class="row">
    <div class="col-lg-12">
        {$description}
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        {$btnSave} {$btnCancel}
    </div>
</div>
