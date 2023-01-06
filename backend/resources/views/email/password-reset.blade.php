<!doctype html>
<html lang="en">
  <head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12 m-auto">

                <!-- Head -->
                <h3> {{ $subject }} </h3>
                <p> Hi {{ $user->name }}, </p>
                <br>
                
                <!-- Text & Link -->
                <p> With the link below, you are able to reset your password. </p>
                <p> {{ $url }}</p>
                <p>After reseting your password successfully, you are able to login to your account, with your new password.</p>
                <br>
                
                <!-- Signature -->
                <p> Best Regards</p>
                <p> {{ env('APP_NAME') }} </p>
            </div>
        </div>
    </div>
  </body>
</html>
