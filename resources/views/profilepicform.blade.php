<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    @include('master/head')
    <link rel="stylesheet" href="/css/cropper.css">
    <style media="screen">
      .cropercss{
        width:1000px !important;
      }
    </style>
  </head>
  <body>
    @include('master/navbar')
    <main>
      <div class="container mt-3" id="app">
        <div class="row justify-content-center text-center">
          <div class="col-8">
            <div class="card">
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <p class="lead">
                      Upload Your Profile Pic
                    </p>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <img :src="preview" alt="" class="img-fluid" id="preview" @click ="edit" data-toggle="tooltip" title="Click To Edit">
                  </div>
                </div>
                <div class="row justify-content-center mt-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="file" class="form-control-file" @change = "processFile" id="avatarSelector">
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center mt-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <button type="button" name="button" class="btn btn-outline-primary" v-if="preview != ''" @click="upload">Upload</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row justify-content-center">
                  <div id="prt">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click = "getImageData">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    @include('master/scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="/js/cropper.js"></script>
    <script>
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
          $('#cropImageModal').on('hidden.bs.modal', function (e) {
            console.log('closed');
            if (app.preview == '') {

              document.getElementById('avatarSelector').value = '';
            }
          });
      });

    </script>
    <script type="text/javascript">
      var cropBoxData;
      var canvasData;
      var cropper;
      var image;
      function setImage(src) {
        var myNode = document.getElementById("prt");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
        image = new Image();
        image.src = src;
        //image.className += 'cropercss';
        image.id = 'croperImage';
        document.getElementById('prt').appendChild(image);
        cropper = new Cropper(image, {
          autoCropArea: 0.5,
          aspectRatio: 1,
          restore: false,
          minContainerWidth:500,
          minContainerHeight:500,
          viewMode:2,
          ready: function () {

            // Strict mode: set crop box data first
            cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
          }
        });
      }
      function getCroppedImage() {
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();
        var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
        cropper.destroy();

        return croppedImage;
      }
      function dataURItoBlob(dataURI) {
          // convert base64/URLEncoded data component to raw binary data held in a string
          var byteString;
          if (dataURI.split(',')[0].indexOf('base64') >= 0)
              byteString = atob(dataURI.split(',')[1]);
          else
              byteString = unescape(dataURI.split(',')[1]);

          // separate out the mime component
          var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

          // write the bytes of the string to a typed array
          var ia = new Uint8Array(byteString.length);
          for (var i = 0; i < byteString.length; i++) {
              ia[i] = byteString.charCodeAt(i);
          }

          return new Blob([ia], {type:mimeString});
      }
    </script>
    <script type="text/javascript">
      var app = new Vue({
        el:'#app',
        data:{
          preview:'',
          orignalImageFile: null,
        },
        mounted(){

        },
        methods:{
          processFile:function (e) {
            var self = this;
            self.orignalImageFile = e.target.files[0];
            setImage(URL.createObjectURL(e.target.files[0]));
            $('#cropImageModal').modal('show');
          },
          getImageData:function () {
            var self = this;
            self.preview = getCroppedImage();
            $('#cropImageModal').modal('hide');
          },
          edit:function () {
            var self = this;
            setImage(window.URL.createObjectURL(self.orignalImageFile));
            $('#cropImageModal').modal('show');
          },
          upload:function () {
            var self = this;
            var formData = new FormData();
            formData.append("file",dataURItoBlob(self.preview));
            axios.post('/api/avatarupload',formData , {
                headers: {
                  'Content-Type': 'multipart/form-data'
                },
            }).then(function (response) {
              console.log(response.data);
            }).catch(function (error) {
              console.log(error);
          });
          }

        }
      });
    </script>
  </body>
</html>
