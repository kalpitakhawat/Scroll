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
    <link rel="stylesheet" href="/css/toast.css">
  </head>
  <body>
    @include('master/navbar')

    <main>
      <div class="container mt-3">

        <div class="row justify-content-center">
          <div class="col-md-8">
            @if(Auth::check())
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
                        <div class="col-12 mt-2 text-right" v-if = "!loading">
                          <button type="submit" name="submit" class="btn btn-outline-primary"> Post </button>
                        </div>
                        <div class="col-12 mt-3 text-right" v-else>
                          <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                          </div>
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
                                <input type="file" class="form-control-file" id="imageUpload" @change="processFile" :disabled = "loading">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12" v-if = "uploaded && !loading">
                              <button type="submit" name="submit" class="btn btn-outline-primary" > Post </button>
                            </div>
                            <div class="col-12 mt-3 text-right" v-if="loading">
                              <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                              </div>
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
                                <input type="file" class="form-control-file" id="videoUpload" @change="processFile" :disabled = "loading">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12" v-if = "uploaded && !loading">
                              <button type="submit" name="submit" class="btn btn-outline-primary" v-if="uploaded"> Post </button>
                            </div>
                            <div class="col-12 mt-3 text-right" v-if="loading">
                              <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @else
            <div class="card text-center">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  Sign In To Upload Your Post.
                </div>
              </div>
              <div class="row mt-3">
                <div class="col">
                  <a href="/login/" class="btn btn-primary">Sign In</a>
                </div>
              </div>
            </div>
          </div>
          @endif
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
                      <div class="col-2 p-4">
                        <img :src="post.avatar" class="img-fluid rounded-circle" alt="" v-if="post.avatar != '' || post.avatar != null">
                        <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="" v-else>
                      </div>
                      <div class="col-10 align-self-center">
                        <h5 class="card-title">@{{post.user_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">@{{moment(post.created_at ).fromNow()}}</h6>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8 offset-2" v-if="post.type == 'text'">
                          <p class="card-text" v-html="post.content" ></p>
                      </div>
                      <div class="col-8 offset-2 col-md-6 offset-md-3" v-else-if="post.type == 'image'">
                          <img :src="post.content" class="img-fluid" alt="">
                      </div>
                      <div class="col-8 offset-2 col-md-6 offset-md-3" v-else-if="post.type == 'video'">
                          <video :src="post.content"  class="img-fluid" controls>

                          </video>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col text-left">
                        <small>
                          <a class="card-link text-muted" @click = 'getLikes(post.id)' style="cursor: pointer;">@{{post.likes}} Likes</a>
                          <a :href="'/post/'+post.id" class="card-link text-muted">@{{post.comments}} Comments</a>
                        </small>
                      </div>
                      <div class="col text-right">
                        @if(Auth::check())
                          <button class="card-link btn btn-outline-primary btn-sm" v-on:click= "like(post.id , index)" v-if="!post.isLiked"><i data-feather="thumbs-up"></i></button>
                          <button class="card-link btn btn-primary btn-sm" v-on:click= "unlike(post.id , index)" v-else><i data-feather="thumbs-up" ></i></button>
                        @else
                          <button class="card-link btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Sign In To Like Post...!" @click = "warn"><i data-feather="thumbs-up"></i></button>
                        @endif
                        <a class="card-link btn btn-outline-primary btn-sm text-primary" :href="'/post/'+ post.id"><i data-feather="message-circle"></i></a>
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
          <!-- Modal -->
          <div class="modal fade" id="likeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Likes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <ul class="list-group list-group-flush" v-if="likes.length > 0">
                    <li class="list-group-item" v-for="like in likes">
                      <div class="row">
                        <div class="col-2">
                          <img :src="like.avatar" class="img-fluid rounded-circle" alt="" v-if="like.avatar != '' || like.avatar != null">
                          <img src="/image/default-user-image.png" class="img-fluid rounded-circle" alt="" v-else>
                        </div>
                        <div class="col-10 align-self-center">
                          <h5 class="card-title">@{{like.user_name}}</h5>
                          <h6 class="card-subtitle mb-2 text-muted">@{{moment(like.created_at ).fromNow()}}</h6>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <p v-else>No Likes For This Post</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
    <footer></footer>
    @include('master/scripts')
    <script src="/js/toast.js" charset="utf-8"></script>
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
    <script type="text/javascript">
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script type="text/javascript">
      var nav_text = new Vue({
        el:'#nav-text',
        data:{
          content:'',
          loading : false,
        },
        mouted(){

        },
        methods:{
          onSubmit:function () {
            var self = this;
            self.loading = true;
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
                tinyMCE.activeEditor.setContent('');
                toastr.success('Your Post Successfully Uploaded');
                self.loading = false;
                timeline.addPost(response.data.post)
              }).catch(function (error) {
                toastr.error(error);
                self.loading = false;
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
          loading:false,
        },
        methods:{
          processFile:function (event) {
              var self =this;
              self.laoding = true;
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
                self.laoding = false;
                self.content = response.data.file_path;
              }).catch(function (error) {
                self.laoding = false;
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
            self.laoding = true;
            axios.post('/api/post', {
                'content':self.content,
                'type':'image',
              }).then(function (response) {
                console.log(response);
                timeline.addPost(response.data.post);
                toastr.success('Your Post Successfully Uploaded');
                document.getElementById('imageUpload').value = '';
                self.uploaded = false;
                self.laoding = false;
              }).catch(function (error) {
                toastr.error(error);
                console.log(error);
                document.getElementById('imageUpload').value = '';
                self.uploaded = false;
                self.laoding = false;
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
      var nav_video = new Vue({
        el:'#video',
        data:{
          content:'',
          uploaded:false,
          loading:false,
        },
        methods:{
          processFile:function (event) {
              var self =this;
              self.laoding = true;
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
                self.laoding = false;

              }).catch(function (error) {
                console.log(error);
                self.laoding = false;
            });
          },
          onSubmit:function () {
            var self = this;
            self.laoding = true;
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
                timeline.addPost(response.data.post);
                toastr.success('Your Post Successfully Uploaded');
                document.getElementById('videoUpload').value = '';
                self.uploaded = false;
                self.laoding = false;
              }).catch(function (error) {
                toastr.error(error);
                console.log(error);
                document.getElementById('videoUpload').value = '';
                self.uploaded = false;
                self.laoding = false;
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
          limit: 5,
          islast: false,
          loading: false,
          isLogin : false,
          likes :[],
        },
        mounted(){
          var self = this;
          $('[data-toggle="tooltip"]').tooltip();
          self.getPost();
          setTimeout(function () {
            $('[data-toggle="tooltip"]').tooltip()
          },1000);
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
          warn:function () {
            toastr.warning('You Have To Sign In To Like Post');
          },
          getLikes:function (id) {
            $('#likeModal').modal('hide');
            var self =this;
            self.likes = [];
            axios.post('/api/getLikes', {
                'pid':id,
              }).then(function (response) {
                self.likes = response.data.likes;
                $('#likeModal').modal('show');
              }).catch(function (error) {
                console.log(error);
            });
          }
        },
      });
    </script>
    <script type="text/javascript">
      $(function(){
       $(window).scroll(function(){
           if($(document).height() > $(window).scrollTop()+$(window).height()-50 && !timeline.islast && !timeline.loading){
              timeline.getPost();
           }
       });
      });
    </script>
  </body>
</html>
