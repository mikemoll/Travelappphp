(function() {
    var input = document.getElementById("images"),
            formdata = false;

    function showUploadedItem(source) {
        var list = document.getElementById("listaArquivos"),
                li = document.createElement("li"),
                img = document.createElement("img");
        img.src = source;
        li.appendChild(img);
        list.appendChild(li);
    }

    if (window.FormData) {
        formdata = new FormData();
        document.getElementById("btn").style.display = "none";
    }


    input.addEventListener("change", function(evt) {
        var i = 0, len = this.files.length, img, reader, file;

        for (; i < len; i++) {
            file = this.files[i];

            if (!!file.type.match(/image.*/)) {
                if (window.FileReader) {
                    reader = new FileReader();
                    reader.onloadend = function(e) {
                        showUploadedItem(e.target.result, file.fileName);
                    };
                    reader.readAsDataURL(file);
                }
                if (formdata) {
                    formdata.append("Filedata[]", file);
                }
            }
        }

        if (formdata) {
            $.ajax({
                url: 'http://localhost/novolayout/site/arquivo/upload/album/10',
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                dataType:'json',
                success: function(res) {
                    returnRequest(res);
                    document.getElementById("filaEnvio").innerHTML = "Feito! "
                    formdata = new FormData();
//                    document.getElementById("filaEnvio").innerHTML = res;
                }
            });
        }
    }, false);
}());
