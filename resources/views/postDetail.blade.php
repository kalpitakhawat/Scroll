<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    @include('master/head')
  </head>
  <body>
    @include('master/navbar')
    <main>
      <div class="container mt-3">
          <div class="row justify-content-center" id="post">
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
                    <div class="col-8 offset-2" v-if="post.type == 'text'">
                        <p class="card-text"  v-html="post.content"></p>
                    </div>
                    <div class="col-8 offset-2 col-md-6 offset-md-3" v-else-if="post.type == 'image'">
                        <img :src="post.content" class="img-fluid" alt="">
                    </div>
                    <div class="col-8 offset-2 col-md-6 offset-md-3"  v-else-if="post.type == 'video'">
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
                      <button class="card-link btn btn-outline-primary btn-sm" v-on:click= "like(post.id)" v-if="!post.isLiked"><i data-feather="thumbs-up"></i></button>
                      <button class="card-link btn btn-primary btn-sm" v-on:click= "unlike(post.id)" v-else><i data-feather="thumbs-up" ></i></button>
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
          <div class="row justify-content-center" id="comments">
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-10">
                   <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="write your comment here" v-model="comment"></textarea>
                </div>
                <div class="col-md-2 align-self-end mt-2">
                  <button type="button" class="btn btn-outline-primary" @click="addComment">Done</button>
                </div>
              </div>
              <div class="row p-3" v-for="comment in comments">
                <div class="col-md-10">
                  <small>
                    <div class="card" style="border:none;">
                        <div class="card-body">
                          <h6 class="card-title">@{{comment.user_name}}</h6>
                          <p class="card-subtitle mb-2 text-muted">@{{moment(comment.created_at ).fromNow()}}</p>
                          <p class="card-text">@{{comment.comment}}</p>
                        </div>
                        <hr>
                      </div>
                  </small>
                </div>
              </div>
            </div>
          </div>
      </div>
    </main>
    @include('master/scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyCNaomawz0cCNZKoA09aQJWQE7v9b5ygZs",
        authDomain: "scroll-ca149.firebaseapp.com",
        databaseURL: "https://scroll-ca149.firebaseio.com",
        projectId: "scroll-ca149",
        storageBucket: "scroll-ca149.appspot.com",
        messagingSenderId: "18950059931"
      };
      firebase.initializeApp(config);

    </script>
    <script type="text/javascript">
      var post = new Vue({
        el:'#post',
        data:{
          postId : '',
          post:new Object(),
          comment:'',
        },
        mounted(){
          var self = this;
          self.initalCall();
        },
        methods:{
          initalCall:function () {
            var self = this;
            var link = window.location.href.split('/')
            self.postId = link[link.length - 1];
            axios.post('/api/getDetails',{
              'pid':self.postId,
            }).then(function (response) {
              console.log(response.data);
              self.post = response.data.post;
            }).catch(function (error) {
              console.log(error);
            });
          },
          like:function(id , index) {
            var self = this;
            axios.post('/api/like', {
                'pid':id,
              }).then(function (response) {
                self.post.isLiked = true;
                self.post.likes += 1
              }).catch(function (error) {
                console.log(error);
            });
          },
          unlike:function(id , index) {
            var self = this;
            axios.post('/api/unlike', {
                'pid':id,
              }).then(function (response) {
                self.post.isLiked = false;
                self.post.likes -= 1;

              }).catch(function (error) {
                console.log(error);
            });
          },
        }
      });
    </script>
    <script type="text/javascript">
      var cmts = new Vue({
        el:'#comments',
        data:{
          postId:'',
          comment:'',
          comments:new Array(),
        },
        mounted(){
          var self =this;
          var link = window.location.href.split('/')
          self.postId = link[link.length - 1];
          self.firebaseCall();
        },
        methods:{
          firebaseCall:function () {
            var self = this;
            var db = firebase.database();
            var commentRef = db.ref('comments');
            commentRef.orderByChild('pid').equalTo(self.postId).on('value', function(snapshot) {
              self.comments = [];
              snapshot.forEach(function(childSnapshot) {
                    var item = childSnapshot.val();
                    item.key = childSnapshot.key;

                    self.comments.push(item);
                });

              self.commentSort();

            });
          },
          commentSort:function () {
            var self = this;
            self.comments.reverse();
            console.log(self.comments);

          },
          addComment:function () {
            var self = this;
            axios.post('/api/addComment', {
                'pid':self.postId,
                'comment':self.comment,
              }).then(function (response) {
                console.log(response);
                post.post.comments += 1;
              }).catch(function (error) {
                console.log(error);
              });
          },
        },
        watch:{
          comments:function () {
              var self = this;
              // console.log(self.comments);
          }
        }
      });
    </script>
  </body>
</html>
