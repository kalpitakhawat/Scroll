<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @include('master/head')
  </head>
  <body>
    @include('master/navbar')
    <main>
      <div class="container mt-3">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-text-tab" data-toggle="tab" href="#nav-text" role="tab" aria-controls="nav-text" aria-selected="true"><i data-feather="edit-3"></i></a>
                    <a class="nav-item nav-link" id="nav-photo-tab" data-toggle="tab" href="#nav-photo" role="tab" aria-controls="nav-photo" aria-selected="false">  <i data-feather="image"></i></a>
                    <a class="nav-item nav-link" id="nav-video-tab" data-toggle="tab" href="#nav-video" role="tab" aria-controls="nav-video" aria-selected="false"><i data-feather="film"></i></a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-text" role="tabpanel" aria-labelledby="nav-text-tab">
                    <form action="#" method="post" v-on:submit.prevent="onSubmit">
                      <div class="row mt-2">
                        <div class="col-12">
                          <textarea name="conetent" id="content" v-model="content"></textarea>
                        </div>
                        <div class="col-12 mt-2 text-right">
                          <button type="submit" name="submit" class="btn btn-outline-primary"> Post </button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="nav-photo" role="tabpanel" aria-labelledby="nav-photo-tab">
                    <div class="row text-center mt-5">
                      <div class="col-12" id="photo">
                        <div class="row">
                          <div class="col-12">
                            <p class="lead">
                              Image Upload
                            </p>
                          </div>
                        </div>
                        <form action="#" method="post" v-on:submit.prevent="onSubmit">
                          <div class="row">
                            <div class="col-8 col-md-6 offset-2 offset-md-4">
                              <div class="form-group">
                                <input type="file" class="form-control-file" id="imageUpload" @change="processFile">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <button type="submit" name="submit" class="btn btn-outline-primary"> Post </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab">
                    <div class="row text-center mt-5">
                      <div class="col-12" id="video">
                        <div class="row">
                          <div class="col-12">
                            <p class="lead">
                              Video Upload
                            </p>
                          </div>
                        </div>
                        <form action="#" method="post" v-on:submit.prevent="onSubmit">
                          <div class="row">
                            <div class="col-8 col-md-6 offset-2 offset-md-4">
                              <div class="form-group">
                                <input type="file" class="form-control-file" id="videoUpload" @change="processFile">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <button type="submit" name="submit" class="btn btn-outline-primary"> Post </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8">
              <hr>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="container">
                  <div class="row">
                    <div class="col-2">
                      <img src="/image/default-user-image.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-10 align-self-center">
                      <p class="lead"><strong>Jhon Doe</strong> </p>
                    </div>
                  </div>
                  <div class="">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    @include('master/scripts')
    <script src="/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
			tinymce.init({
    		selector: '#content',
    		height: 150,
    		theme: 'modern',
    		plugins: '',
        menubar:false,
        statusbar: false,
    		toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    		image_advtab: true,
    		templates: [
      		{ title: 'Test template 1', content: 'Test 1' },
      		{ title: 'Test template 2', content: 'Test 2' }
    		],
    		content_css: [
      		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      		'//www.tinymce.com/css/codepen.min.css'
    		]
  		});
		</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script type="text/javascript">
      document.getElementById('imageUpload').onchange = function (event) {
        nav_photo.processFile(event);
      }
    </script>
    <script type="text/javascript">
      var nav_text = new Vue({
        el:'#nav-text',
        data:{
          content:'',
        },
        mouted(){

        },
        methods:{
          onSubmit:function () {
            var self = this;
            self.content = tinyMCE.get('content').getContent();
            self.sendPostRequest();
          },
          sendPostRequest:function () {
            var self = this;
            axios.post('/api/post', {
                'content':self.content,
                'type':'text',
              }).then(function (response) {
                console.log(response);
              }).catch(function (error) {
                console.log(error);
            });
          }
        },
      });
    </script>
    <script type="text/javascript">
      var nav_photo = new Vue({
        el:'#photo',
        data:{
          content:'',
        },
        methods:{
          processFile:function (event) {
              var self =this;
              //var imagefile = document.querySelector('#imageUpload');
              console.log(event.target.files[0]);
              var formData = new FormData();
              formData.append("file",event.target.files[0]);
              axios.post('/api/upload',formData , {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
              }).then(function (response) {
                console.log(response.data.file_path);
                self.content = response.data.file_path;
              }).catch(function (error) {
                console.log(error);
            });
          },
          onSubmit:function () {
            var self = this;
            console.log(self.content);
            self.sendPostRequest();
          },
          sendPostRequest:function () {
            var self = this;
            axios.post('/api/post', {
                'content':self.content,
                'type':'image',
              }).then(function (response) {
                console.log(response);
              }).catch(function (error) {
                console.log(error);
            });
          }
        },
        watch:{
          image:function () {
            console.log(image);
          }
        },
      })
    </script>
    <script type="text/javascript">
      var nav_photo = new Vue({
        el:'#video',
        data:{
          content:'',
        },
        methods:{
          processFile:function (event) {
              var self =this;
              //var imagefile = document.querySelector('#imageUpload');
              console.log(event.target.files[0]);
              var formData = new FormData();
              formData.append("file",event.target.files[0]);
              axios.post('/api/upload',formData , {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
              }).then(function (response) {
                console.log(response.data.file_path);
                self.content = response.data.file_path;
              }).catch(function (error) {
                console.log(error);
            });
          },
          onSubmit:function () {
            var self = this;
            console.log(self.content);
            self.sendPostRequest();
          },
          sendPostRequest:function () {
            var self = this;
            axios.post('/api/post', {
                'content':self.content,
                'type':'image',
              }).then(function (response) {
                console.log(response);
              }).catch(function (error) {
                console.log(error);
            });
          }
        },
        watch:{
          image:function () {
            console.log(image);
          }
        },
      })
    </script>
  </body>
</html>
