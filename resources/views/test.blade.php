<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cropper.js</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/css/tether.min.css" />
  <link rel="stylesheet" href="/css/cropper.css">
  <style>
    .img-container img {
      max-width: 100%;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Cropper in a Bootstrap modal</h1>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-target="#modal" data-toggle="modal">
      Launch the demo
    </button>
    <canvas id="cns" width="500" height="500"></canvas>
    <!-- Modal -->
    <div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Cropper</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src="/image/default-user-image.png" alt="Picture">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="getData()">Get</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="/js/cropper.js"></script>
  <script>
    var cropBoxData;
    var canvasData;
    var cropper;
    window.addEventListener('DOMContentLoaded', function () {
      var image = document.getElementById('image');


      $('#modal').on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          autoCropArea: 0.5,
          aspectRatio: 1,
          restore: false,
          ready: function () {

            // Strict mode: set crop box data first
            cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
          }
        });
      }).on('hidden.bs.modal', function () {
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        cropper.destroy();
      });
    });
  </script>
  <script type="text/javascript">
    function getData() {
      var cnvs = cropper.getCroppedCanvas({maxWidth:500,maxHeight:500});
      console.log(cnvs.toDataURL("image/png"));


    }
  </script>
</body>
</html>
