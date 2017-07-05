<script type="text/javascript" src="{$HTTP_REFERER}Public/Js/fadeslideshow.js">
    /***********************************************
     * Ultimate Fade In Slideshow v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
     * This notice MUST stay intact for legal use
     * Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
     ***********************************************/
</script>
<script type="text/javascript">
    {literal} 


    var mygallery1 = new fadeSlideShow({
        wrapperid: "banner", //ID of blank DIV on page to house Slideshow
        dimensions: [600, 250], //width/height of gallery in pixels. Should reflect dimensions of largest image
        imagearray: [
    {/literal}    {$imagensBanner1}{literal}
        ],
        displaymode: {type: 'auto', pause: 2500, cycles: 0, wraparound: false},
        persist: false, //remember last viewed slide and recall within same session?
        fadeduration: 500, //transition duration (milliseconds)
        descreveal: "ondemand",
        togglerid: ""
    });

    {/literal}
</script>

<br>
<div id="banner" style="height: 200px;width: 600px;border: 1px #D7C172 solid">600px x 200px;</div>

<table border="0" style="width:100%">
    <tbody>
        <tr >
            <td  style="width:100%">
                <p class="titulo">PACOTES EM DESTAQUE</p>
                <p class="texto">
                    {$pacotes_destaque}
                </p>
            </td>
           {* <td style="vertical-align: top ;padding-left: 40px;">
                <p class="titulo">NOTíCIAS</p>
                <p class="texto">
                    {$produtos_destaque}
                </p>
            </td>*}
        </tr>

    </tbody>
</table>
