<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <div class="d-flex justify-content-center">
            <div class="card border mb-3" style="width: 20rem;">
                <div class="card-header bg-transparent border">Header</div>
                <form action="">
                    <div class="card-body text-success">

                        <input type="text" class="form-control mb-2" id="email" placeholder="Email" name="email" require>

                        <input type="password" class="form-control" id="password" style="width:100%" placeholder="Password" name="password" require>
                    </div>
                    <div class="card-footer bg-transparent border d-flex justify-content-around">
                        <button class="btn btn-default border btn-sm mx-2" style="width:100%">Cancel</button>
                        <button class="btn btn-primary btn-sm mx-2 btn-login" style="width:100%">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".btn-login").click(function(e) {
                e.preventDefault();

                var formData = {

                    email: $("input[name=email]").val(),
                    password: $("input[name=password]").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                }

                jQuery.ajax({
                    url: "{{url('api/v1/auth/login')}}",
                    data: formData,
                    cache: false,
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    success: function(data) {
                        $('body').html(data)
                    },
                    error: function(error) {
                        console.log('ini error :' + error)
                    }
                });

            });
        })

        function login() {
            localStorage.setItem('token', 'bla bla bla')
            window.location.replace('/')
        }
    </script>
</body>

</html>
