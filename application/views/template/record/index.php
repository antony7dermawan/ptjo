<!DOCTYPE html>
<html>
  <head>
    <title>Screen Recording</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/record/favicon.ico" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/record/styles.css" />
  </head>

  <body id="myvideo">

    <div class='streaming_area' >
      <video id="camera_stream" autoplay=""></video>
    </div>


    <div class = 'record_result' id='record_result'>
      <video id="record_result_vid" />
    </div>


    <div class="cam_button">
      <button id="start" class='start_button' onclick='openFullscreen()'>
        Start
      </button>
      <button id="stop" class='stop_button' disabled onclick='closeFullscreen()'>
        Stop
      </button>
    </div>

    <div class="notification" id='notification'>
      <a>Right Click and press "Save Video As"</a>
    </div>

    


    <div class="clock_ticking" id="clock_ticking">
      
    </div>

    <div class='judul1'>
      <a>Adhi - Jaya Konstruksi, KSO</a>
      <img src="<?= base_url(); ?>assets/png/jaya.png" class="logo1">
      <img src="<?= base_url(); ?>assets/png/adhi.png" class="logo2">
      <img src="<?= base_url(); ?>assets/png/smec.png" class="logo3">
      <img src="<?= base_url(); ?>assets/png/radiar.png" class="logo4">
    </div>

    <div class='judul2'>
      <a>CCTV Inspection RCP Jacking</a>
    </div>

    

    <script src="<?= base_url(); ?>assets/record/index.js"></script>
  </body>
</html>















<script type="text/javascript" src="<?= base_url(); ?>assets/record/jquery.js" ></script>
<script type="text/javascript" >
$(document).ready(function(){
setInterval(function(){
$('#clock_ticking').load('C_clock_ticking')
},<?php echo "1000";?>);
});

</script>








<script type="text/javascript">












navigator.mediaDevices.getUserMedia({
  video : {
    width: {
      min: 1280,
      max: 1280
    },
    height: {
      min: 720,
      max: 720
    },
    frameRate: 1  
  }
})
.then(stream => {
  document.getElementById("camera_stream").srcObject = stream;
})

$(document).ready(function(){
   $('#videoElementID').bind('contextmenu',function() { return false; });
});


  function call_download(url) {

    document.getElementById('my_iframe').src = url;
      document.getElementById('record_result').style.display = 'none';
      document.getElementById('record_result_vid').autoplay = true;


  }


  function closeFullscreen() {   
  document.getElementById('notification').style.display = 'block';
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
  }
}
</script>



<style type="text/css">


.cam_button
{
  position: absolute;
}
.record_result
{
  display: none;
}

.streaming_area
{

  position: absolute;
}

</style>