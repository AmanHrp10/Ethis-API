<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/notification.min.css')}}">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <h3 class="text-center mt-5">Add Post</h3>
        <div class="d-flex justify-content-center mt-5">
            <div class="card" style="width:24rem">
                <form action="">
                    <div class="card-body text-success">

                        <input type="text" class="form-control mb-2" id="title" placeholder="Title" name="title" require>

                        <textarea type="text" class="form-control mb-2" id="description" style="width:100%" placeholder="Description" name="description" require></textarea>
                        <input type="file" class="form-control" id="image" style="width:100%" placeholder="Password" name="image" require>
                    </div>
                    <div class="card-footer bg-transparent border d-flex justify-content-around">
                        <button class="btn btn-default border btn-sm mx-2" style="width:100%">Cancel</button>
                        <button class="btn btn-primary btn-sm mx-2 btn-store" style="width:100%">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".btn-store").click(function(e) {
                e.preventDefault();

                var file = $('input[name=image]').val()

                console.log(file)
                var formData = {

                    title: $("input[name=title]").val(),
                    description: $("input[name=description]").val(),

                    _token: $('meta[name="csrf-token"]').attr('content')
                }

                jQuery.ajax({
                    url: "{{url('api/v1/post')}}",
                    data: formData,
                    cache: false,
                    method: 'POST',
                    headers: {
                        'Content-Type': 'multipart/form-data',
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
    </script>
</body>

</html>
