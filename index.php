<?php

    if($_POST["photo"]){


        echo  $_POST["fileToUpload"];
       
        /*$img = str_replace('data:image/png;base64,', '', $_POST["fileToUpload"]);
        $img = str_replace('', '+', $img);
        $fileData = base64_decode($img);
*/
        $data = $_POST["fileToUpload"];
        list($type, $data) = explode(';', $data);
	    list(, $data)      = explode(',', $data);
	    $data = base64_decode($data);
        
        file_put_contents(date("Y-m-d H:i:s").'-photo.png',  $data);
    }


 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    
    <title>Display Webcam Stream</title>


    <style>
        video#vid,
        canvas#canvas {
            width: 300px;
            height: 225px;
            border: 3px solid #d3d3d3;
        }

        video#vid {
            border: 3px solid #d3d3d3;
        }

        canvas#canvas {
            border: 3px solid #d3d3d3;
        }

        .camera_snap>input[type="button"] {
            border: none;
            padding: 1%;
            width: 37px;
            color: #fff;
            transition: 0.1s all;
        }

        .camera_snap>input[type="button"]:active {
            opacity: 0.4;
            width: 30px;
            background-size: cover;
            -moz-background-size: cover;
        }
    </style>
</head>

<body>
    <div class="camera_snap">
        <video autoplay id="vid"></video>
        <canvas id="canvas" width="640" height="480"></canvas>
        <br />
        <input type="button" class="snapbutton" onclick="snapshot()" />
    </div>

    <div class="">
        <form method="POST" action="/" enctype="multipart/form-data">
    
            <input type="hidden" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="photo">
        </form>
    </div> 
    <script>
        var video = document.querySelector("#vid");
        var canvas = document.querySelector('#canvas');
        var ctx = canvas.getContext('2d');
        var localMediaStream = null;

        var onCameraFail = function (e) {
            console.log('Não funcionou ://// .', e);
        };

        function snapshot() {
            if (localMediaStream) {
                ctx.drawImage(video , 0, 0);
                console.log(canvas.toDataURL('image/jpeg'));
                document.getElementById("fileToUpload").value =canvas.toDataURL('image/jpeg');
            }
        }
        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia;
        window.URL = window.URL || window.webkitURL;
        navigator.getUserMedia({
            video: true
        }, function (stream) {
            video.src = window.URL.createObjectURL(stream);
            localMediaStream = stream;
        }, onCameraFail);
    </script>
</body>

</html>