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
                    <img :src="preview" alt="" class="img-fluid" id="preview">
                  </div>
                </div>
                <div class="row justify-content-center mt-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="file" class="form-control-file" @change = "processFile">
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
                <button type="button" class="btn btn-primary" @click="modalHidden">Save changes</button>
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
    <script type="text/javascript">
      var app = new Vue({
        el:'#app',
        data:{
          profilepic:'',
          preview:"",
          cropBoxData:null,
          canvasData:null,
          cropper: null,

        },
        mounted(){
          var self = this;
          self.cropBoxData=null;
          self.canvasData=null;
        },
        methods:{
          processFile:function (e) {
            var self = this;
            console.log(e.target.files[0]);
                self.preview = window.URL.createObjectURL(e.target.files[0]);
                var image = new Image();
                image.src = window.URL.createObjectURL(e.target.files[0]);
                image.className +='cropercss';
                image.id = 'croperImage';
                document.getElementById('prt').appendChild(image);
                // self.modalShown(image);
                $('#cropImageModal').modal('show');
                $('#cropImageModal').on('shown.bs.modal', self.modalShown(image));
                $('#cropImageModal').on('hidden.bs.modal', self.modalHidden());
          },
          modalShown:function (image) {
            var self = this;

            var cropper
            cropper = new Cropper(image, {
              autoCropArea: 0.5,
              aspectRatio: 1,
              minContainerWidth: 500,
              minContainerHeight:500,
              viewMode: 2,
              ready: function () {
                // Strict mode: set crop box data first
                var cropBoxData;
                var canvasData;
                cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                
              }
            });

            //console.log(self.cropper.setCropBoxData());
          },
          modalHidden:function () {
            var self = this;
            self.cropBoxData = self.cropper.getCropBoxData();
            self.canvasData = self.cropper.getCanvasData();
            //console.log(self.canvasData);
            self.cropper.destroy();
            self.cropper = new Object();
          }
        },
        watch:{
          profilepic:function () {
            console.log('hello');
          }
        },
      });
    </script>
    <script type="text/javascript">

    </script>
  </body>
</html>
