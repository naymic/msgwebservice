<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Web Service Documentation</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: left;
                padding: 20px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Web Service Documentation
                </div>

                <h1> Web Service</h1>


                <h4>Basic Json request: {{'<domain name>/{"appid":<appid>,"apptoken":"<token>","modulid":<modul id>,"applang":"<app language shortform>","requitems":<array of message ids>,"requitemsreplace":<array for replacement or empty>}'}}</h4>

                <h1>Message CRUD</h1>

                <h4>{{'Create your signup and login on <domain name>/message'}}</h4>

                <h4>New apps and modules are created direct in the database, future managing with an interface is planned. </h4>


                <h4>Example for replacement inside a message: This is a test [[0]] replace [[1]] message'}}</h4>

                <h1>Example usage</h1>

                <h2>Get one message</h2>
                <h4>{{'{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1],"requitemsreplace":[]}'}}</h4>

                <h2> Get multiples messges
                    <h4>{{'{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]}'}}</h4>

                <h2> Replace inside messages
                <h4>{{'{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1,2,43],"requitemsreplace":[[],[],["test1", "test2"]]}'}}</h4>

                <h2>Incomplete request
                <h4>{{'{"appid":1,"appoken":"msgwsiscool!","modulid":1,"applng":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]}'}}</h4>

            </div>
        </div>
    </body>
</html>
