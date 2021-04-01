<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/notification.min.css')}}">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <div class="image" style="width:150px">
                <a class="navbar-brand" href="/">
                    <img src="{{asset('images/ethis_logo.png')}}" alt="" width="100%" height="100%">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="d-flex justify-content-between" style="width:100%">
                    <ul class="navbar-nav navbar mx-5 post">
                        <li><a class="mx-3 nav-link active" href="#">Post <span class="sr-only">(current)</span></a></li>

                        <!-- Notif -->
                        <li class="dropdown dropdown-notifications">
                            <a href="" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-count="0" class="fas fa-bell notification-icon"></i>
                            </a>

                            <div class="dropdown-container dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-toolbar">
                                    <div class="dropdown-toolbar-actions">
                                        <a href="#">Mark all as read</a>
                                    </div>
                                    <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>
                                </div>
                                <ul class="dropdown-item">

                                </ul>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <!-- End Notif -->
                    </ul>
                    <ul class="mx-3 logout navbar-nav navbar mx-5" style="cursor:pointer">
                        <li><a class="nav-link" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <h1 class="text-center mt-4">Posts</h1>

    <div class="d-flex flex-column justify-content-between mx-auto">
        <div class="addPost text-center">
            <a href="{{url('create')}}" class="btn btn-sm btn-success">Add Post</a>
        </div>
        <div id="data">

        </div>
    </div>


    <script type="text/javascript">
        function logout() {
            localStorage.removeItem('token')
            window.location.replace('/login')
        }
        $(document).ready(function() {

            //* notifications
            var notificationsWrapper = $('.dropdown-notifications');
            var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
            var notificationsCountElem = notificationsToggle.find('i[data-count]');
            var notificationsCount = parseInt(notificationsCountElem.data('count'));
            var notifications = notificationsWrapper.find('ul.dropdown-item');

            var nothingNotification = `
                <li class="notification active" style="align:center">
              <div class="mediaNone text-muted">
                    Nothing Notification
              </div>
          </li>
            `;




            Pusher.logToConsole = true;

            var pusher = new Pusher('3f63fc1e302b28ef2e17', {
                cluster: 'ap1',
                encrypted: true
            });
            var channel = pusher.subscribe('post-created');
            // Bind a function to a Event (the full Laravel class)
            channel.bind('App\\Events\\PostNotification', function(data) {

                console.log('data : ' + data)
                var existingNotifications = notifications.html();
                var newNotificationHtml = `
          <li class="notification active mb-2">
              <div class="media">
                <div class="media-left">
                  <div class="media-object" style="width:50px;height:50px;margin-right:20px">
                    <img width="100%" height="100%" style="border-radius:5px" src="` + data.image + `">
                  </div>
                </div>
                <div class="media-body">
                  <strong class="notification-title">` + data.message + `</strong>
                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">about a minute ago</small>
                  </div>
                </div>
              </div>
          </li>
        `;

                notifications.html(newNotificationHtml + existingNotifications);

                notificationsCount += 1;
                notificationsCountElem.attr('data-count', notificationsCount);
                notificationsWrapper.find('.notif-count').text(notificationsCount);
                notificationsWrapper.show();

            });


            // if (!localStorage.getItem('token')) {
            //     window.location.replace('/login')
            // }

            $.ajax({
                url: "{{url('/api/v1/posts')}}",
                type: 'GET',
                dataType: 'json',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ')
                },
                success: function(data) {
                    $.each(data.data, function(key, value) {
                        $('#data').append(`
                            <div class="card mb-3 mx-auto" style="width: 34rem;">
                                <img width="100%" height="100%" src="{{url('${value.image}')}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                <h4>${value.title}</h4>
                                    <p class="card-text">${value.description}</p>
                                </div>
                            </div>
                        `);
                        process = false
                    })

                },
                error: function() {
                    console.log(data)
                }
            })
        })
    </script>
</body>

</html>
