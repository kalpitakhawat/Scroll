<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @include('master/head')
    <style media="screen">
      .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>

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
                              <button type="submit" name="submit" class="btn btn-outline-primary" v-if = "uploaded"> Post </button>
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
                              <button type="submit" name="submit" class="btn btn-outline-primary" v-if="uploaded"> Post </button>
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
        <div id='timeline'>
          <div v-for="(post , index) in posts">
            <div class="row justify-content-center" v-if="post.type == 'text'">
              <div class="col-md-8">
                <div class="card" style="border:none;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-2">
                        <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="">
                      </div>
                      <div class="col-10 align-self-center">
                        <h5 class="card-title">@{{post.user_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">@{{moment(post.created_at ).fromNow()}}</h6>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8 offset-2">
                          <p class="card-text" v-html="post.content"></p>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col text-left">
                        <small>
                          <a href="#" class="card-link text-muted">@{{post.likes}} Likes</a>
                          <a href="#" class="card-link text-muted">@{{post.comments}} Comments</a>
                        </small>
                      </div>
                      <div class="col text-right">
                        <button class="card-link btn btn-outline-primary btn-sm" v-on:click= "like(post.id , index)" v-if="!post.isLiked"><i data-feather="thumbs-up"></i></button>
                        <button class="card-link btn btn-primary btn-sm" v-on:click= "unlike(post.id , index)" v-else><i data-feather="thumbs-up" ></i></button>
                        <button class="card-link btn btn-outline-primary btn-sm"><i data-feather="message-circle"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center" v-else-if="post.type == 'image'">
              <div class="col-md-8">
                <div class="card" style="border:none;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-2">
                        <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="">
                      </div>
                      <div class="col-10 align-self-center">
                        <h5 class="card-title">@{{post.user_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">@{{moment(post.created_at ).fromNow()}}</h6>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8 offset-2 col-md-6 offset-md-3">
                          <img :src="post.content" class="img-fluid" alt="">
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col text-left">
                        <small>
                          <a href="#" class="card-link text-muted">@{{post.likes}} Likes</a>
                          <a href="#" class="card-link text-muted">@{{post.comments}} Comments</a>
                        </small>
                      </div>
                      <div class="col text-right">
                        <button class="card-link btn btn-outline-primary btn-sm" v-on:click= "like(post.id , index)" v-if="!post.isLiked"><i data-feather="thumbs-up"></i></button>
                        <button class="card-link btn btn-primary btn-sm" v-on:click= "unlike(post.id , index)" v-else><i data-feather="thumbs-up" ></i></button>
                        <button class="card-link btn btn-outline-primary btn-sm"><i data-feather="message-circle"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center" v-else-if="post.type == 'video'">
              <div class="col-md-8">
                <div class="card" style="border:none;">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-2">
                        <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="">
                      </div>
                      <div class="col-10 align-self-center">
                        <h5 class="card-title">@{{post.user_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">@{{moment(post.created_at ).fromNow()}}</h6>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8 offset-2 col-md-6 offset-md-3">
                          <video :src="post.content"  class="img-fluid" controls>

                          </video>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col text-left">
                        <small>
                          <a href="#" class="card-link text-muted">@{{post.likes}} Likes</a>
                          <a href="#" class="card-link text-muted">@{{post.comments}} Comments</a>
                        </small>
                      </div>
                      <div class="col text-right">
                        <button class="card-link btn btn-outline-primary btn-sm" v-on:click= "like(post.id , index)" v-if="!post.isLiked"><i data-feather="thumbs-up"></i></button>
                        <button class="card-link btn btn-primary btn-sm" v-on:click= "unlike(post.id , index)" v-else><i data-feather="thumbs-up" ></i></button>
                        <button class="card-link btn btn-outline-primary btn-sm"><i data-feather="message-circle"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center mt-5">
            <div class="col-2" v-if = "!islast">
              <div class="loader"></div>
            </div>
            <div class="col-4 alert alert-primary" v-else>
              <h5 class="text-center">No More Post.....!!</h5>
            </div>
          </div>
          <div class="mt-5">

          </div>
        </div>
      </div>
    </main>
    @include('master/scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment-with-locales.min.js"></script>
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
                timeline.addPost(response.data.post)
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
          uploaded:false,
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
                self.uploaded = true;
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
                timeline.addPost(response.data.post)
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
          uploaded:false,
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
                self.uploaded = true;

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
                'type':'video',
              }).then(function (response) {
                console.log(response);
                timeline.addPost(response.data.post)
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
      var timeline = new Vue({
        el:'#timeline',
        data:{
          posts: new Array(),
          offset: 0,
          limit: 2,
          islast: false,
          loading: false,
        },
        mounted(){
          var self = this;
          self.getPost();
        },
        methods:{
          getPost:function () {
            var self = this;
            self.loading = true;
            axios.post('/api/getPost', {
                'offset':self.offset,
                'limit':self.limit,
              }).then(function (response) {
                console.log(response.data.post);
                self.offset += response.data.post.length;
                console.log(self.offset);
                self.posts = self.posts.concat(response.data.post);
                console.log(self.posts);
                if (response.data.post.length < self.limit) {
                  self.islast = true;
                }
                self.loading = false;
              }).catch(function (error) {
                console.log(error);
            });
          },
          addPost:function (post) {
            var self = this;
            console.log(post);
            self.offset += 1;
            console.log(self.offset);
            self.posts.unshift(post);
          },
          like:function(id , index) {
            var self = this;
            axios.post('/api/like', {
                'pid':id,
              }).then(function (response) {
                self.posts[index].isLiked = true;
                self.posts[index].likes += 1
              }).catch(function (error) {
                console.log(error);
            });
          },
          unlike:function(id , index) {
            var self = this;
            axios.post('/api/unlike', {
                'pid':id,
              }).then(function (response) {
                self.posts[index].isLiked = false;
                self.posts[index].likes -= 1;

              }).catch(function (error) {
                console.log(error);
            });
          },
        },
      });
    </script>
    <script type="text/javascript">
      $(function(){
       $(window).scroll(function(){
           if($(document).height() > $(window).scrollTop()+$(window).height()-50 && !timeline.islast){
              timeline.getPost();
           }
       });
      });
    </script>
  </body>
</html>
