<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <script src="https://js.pusher.com/2.2/pusher.min.js"></script>
</head>
<body>
<script>
            (function(){
                var pusher = new Pusher('de5bb6706137083dbec8', {
                    encrypted: true
                });

                var channel = pusher.subscribe('test');

                channel.bind('App\\Events\\UserHasRegistered', function(data) {
                    console.log(data);
                });
            })();

//    new Vue({
//        el:'#users',
//        ready:function() {
//            var pusher = new Pusher('de5bb6706137083dbec8', {
//                encrypted: true
//            });
//            pusher.subscribe('test')
//                    .bind('App\\Events\\UserHasRegistered', this.addUser);
//        },
//        methods: {
//            addUser: function(user) {
//                console.log(data);
//            }
//        }
//
//    });
</script>
<div class="container">
    <h1>Welcome</h1>
    <div class="content">

    </div>
</div>
</body>
</html>
