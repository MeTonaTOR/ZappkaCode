<!doctype html>
<html data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ZAPPKA KODY</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .zappkacode {
                width: 100%;
                height: 80px;
                image-rendering: pixelated;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/js/qrcode.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function() {

                var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
                    
                    function onScanSuccess(decodedText, decodedResult) {
                        var text = decodedText;

                        if(decodedResult.result.format.formatName == "QR_CODE") {
                            const urlObject = new URL(text);
                            const params = new URLSearchParams(urlObject.search);
                            text = params.get('ploy');
                        }

                        jQuery("#passwordHelpBlock").html("<input type='hidden' name='kod' value='"+text+"' />");
                        jQuery("#kodinput").val(text);
                        jQuery("#kodinput").prop('disabled', true);
                        html5QrcodeScanner.clear();
                    }
        
                    html5QrcodeScanner.render(onScanSuccess);

                jQuery(".zappkablock").each(function(index) {
                    jQuery(this).dblclick(function(event) {
                        var id = jQuery(this).data("kodid");
                        var usesleft = jQuery(this).data("usesleft");
                        var left = usesleft-1;

                        jQuery(this).data("usesleft", left);

                        $.get("?action=zaktualizuj&kod=" + id, function(data) { console.log(data) });

                        if(left == 0) {
                            const fade = { opacity: 0, transition: 'opacity 400ms' };
                            jQuery(this).css(fade).slideUp();
                        }
                    }); 
                })
            })
        </script>
    </head>
    <body>
        <br />
        <div class="container">

            {$informacja}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: 100%">Dodaj kod</button>
            <br />
            <br />
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                {$kody}
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Dodaj kod:</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="index.php">
                            <input type="hidden" name="action" value="dodajkod" />
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="informacjainput" class="form-label">Informacja:</label>
                                    <input type="text" class="form-control" id="informacjainput" name="informacja" placeholder="Unknown">
                                </div>

                                <div class="mb-3">
                                    <label for="kodinput" class="form-label">Kod:</label>
                                    <input type="text" class="form-control" id="kodinput" name="kod" placeholder="990000000000" pattern="[0-9]{12}" required>
                                    <div id="passwordHelpBlock" class="form-text">
                                        Możesz również zeskanować kod QR albo BARCODE:
                                        <div id="reader"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="zgodapapierosy" id="zgodapapierosy" checked>
                                        <label class="form-check-label" for="zgodapapierosy">
                                            Posiada zgody do sekcji palacza
                                        </label>
                                      </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                                <input type="submit" class="btn btn-primary" value="Wyślij" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <br />

        <script src="assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
