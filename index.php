<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="http://www.iron.io/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/jquery.snippet.min.css">

    <style type="text/css" media="screen">
      @font-face {
        font-family: 'Conv_gillsans';
        src: url('fonts/gillsans.eot');
        src: local('☺'), url('fonts/gillsans.woff') format('woff'), url('fonts/gillsans.ttf') format('truetype'), url('fonts/gillsans.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
    </style>

    <script type="text/javascript"
            src="https://www.google.com/jsapi?key=ABQIAAAAhes0f80sBcwL-h5xCNkkgxQBmiBpQeSpIciQPfZ5Ss-a60KXIRQOVvqzsNpqzhmG9tjky_5rOuaeow"></script>
    <script type="text/javascript">google.load('jquery', '1');
    google.load('jqueryui', '1'); </script>
    <script src="javascripts/jquery.snippet.min.js" type="text/javascript" charset="utf-8"></script>


    <style type="text/css" media="screen">
      #step-1 {
        margin-right: -34%;
        margin-left: 33%;
        z-index: 10;
      }

      #step-2 {
        /*opacity: 0;*/
      }

      #step-3 {
        opacity: 0;
        /*margin-left: -30%;*/
      }
    </style>

    <script type="text/javascript" charset="utf-8">
      $(document).ready(function () {

        // $('#step-1').animate({'margin-left': 0}, 1500); 
        // $('#step-1').animate({'margin-right': 0}, 1000); 
        // $('#step-2').animate({opacity: 1}, 300);
        
      });
    </script>
</head>
<body>

<div class="gears-bg"></div>

  <header>
    <a id="githublink" href="https://github.com/rkononov/php_example" target="_blank" title="Check App Sources on Github">App Sources on Github</a>
    <span>
      This page shows how you can easly processing images with IronMQ and IronWorker in background!
    </span>
  </header>

  <div id="flashes" class="hidden">
    After you images uploaded IronWorker grab it from the queue...
  </div>

  <section id="steps">
    <div id="step-1" class="transform-step">
      <h2 style="line-height: 1.2em;">Add picture via posting url to <b>IronMQ</b></h2>
      
      <code id='code-example'>
        <pre>
$ironmq = new IronMQ('config.ini');
$ironmq->postMessage("input_queue", 
            array("body" => $url_to_picture));</pre>
      </code>

      <div id="posted-image">
        <img src="http://stuntsoftware.com/img/onthejob/icon_onthejob_128.png" alt="">
      </div>

      <?php $input_queue_id = "input_queue_" . rand(); ?>
      <?php $output_queue_id = "output_queue_" . rand(); ?>
      <div id="upload-form">
        <img src="images/ajax-loader.gif" class="spinner">
        <img src="images/step-1-bg.png" alt="" style="margin: 0 auto 10px;clear: both;display: block;height: 99px;">
        <h3>Or add url to pic in form below</h3>
        <form action="/mq/postMessage.php" id="sendMessageForm">
            <input id = "pic_url" type="url" name="url" placeholder="Search..."/>
            <input id="sent_img_btn" type="submit" value="Push to Queue" disabled="disabled" />
        </form>
        <small id="sample-toggler">Or even simply choose one from our robots set</small>
        <div id="samples">
          <img src="images/samples/irondog.png" alt="">
          <img src="images/samples/transformer.png" alt="">
          <img src="images/samples/android.png" alt="">
          <img src="images/samples/walle.png" alt="">
          <img src="images/samples/r2d2.png" alt="">
          <img src="images/samples/calculon.png" alt="">
        </div><!-- / -->
        <div id="result">Message posted</div>
      </div>
      
      <div id="input_queue"></div>

    </div>

    <div id="step-2" class="transform-step">
        <div id="send-images">
            <div id="process-image"></div>
            <img src="images/arrow-right.png" alt="">
        </div>
        <div id="receive-images">
            <div id="processed-image"></div>
            <img src="images/arrow-left.png" alt="">
        </div>

        <img id="send-spinner" src="images/ajax-loader.png" class="spinner">

        <!-- <div id="gears">
          <div class="gear-small shadow">
            <object data="images/gear-small-shadow.svg" type="image/svg+xml" ></object>
          </div>
          <div class="gear-small">
            <object data="images/gear-small.svg" type="image/svg+xml" ></object>
          </div>
          <div class="gear-big shadow">
            <object data="images/gear-big-shadow.svg" type="image/svg+xml" ></object>
          </div>
          <div class="gear-big">
            <object data="images/gear-big.svg" type="image/svg+xml" ></object>
          </div>
        </div> -->
    </div>

    <div id="step-3" class="transform-step">

      <div id="gears">
        <div class="gear-small shadow">
          <object data="images/gear-small-shadow.svg" type="image/svg+xml" ></object>
        </div>
        <div class="gear-small">
          <object data="images/gear-small.svg" type="image/svg+xml" ></object>
        </div>
        <div class="gear-big shadow">
          <object data="images/gear-big-shadow.svg" type="image/svg+xml" ></object>
        </div>
        <div class="gear-big">
          <object data="images/gear-big.svg" type="image/svg+xml" ></object>
        </div>
      </div>

      <!-- <img src="images/ajax-loader.gif" class="spinner"> -->

      <h2>And See <b>IronWorker</b> Magick</h2>
      <div id="output_queue">
       
      </div>
    </div>    
  </section>

  <div class="clearfloat"></div>

  <section id="result-flow" class="hidden">
    <h2>Processed images</h2>
    <table id="output">
      <thead>
        <tr>
          <th>Image from queue</th>
          <th>Thumbnail</th>
          <th>Rotated</th>
          <th>Grayscale</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </section>
  
  <footer>
    <a href="http://iron.io" title="Messaging and Background Processing for Cloud Apps"><img src="http://www.iron.io/assets/resources/ironio-badge-red.png" alt="Iron.io Badge" /></a>      
  </footer>

<script>
    function queue_worker(data,queue_name) {
        var task_id = ''
        $.ajaxSetup({async:false});
        $.post('/iw/queueWorker.php', { url:data, queue_name:queue_name },function(data) {
            task_id = data;
        });
        return task_id;
    }

    function urlExists(testUrl) {
     var http = jQuery.ajax({
        type:"HEAD",
        url: testUrl,
        async: false
      })
      return http.status!=404&&http.status!=0;
    }

    $(document).ready(function () {

        $("#code-example pre").snippet("php",{style:"vim-dark",transparent:true,showNum:false});

        $('#sample-toggler').click(function(){
          $('#samples').slideToggle(300);
        });

        $('#samples img').click(function(){
          $('#sent_img_btn').removeAttr('disabled');
          $(this).parent().children('img').removeClass('selected');
          $(this).addClass('selected');
          $('#pic_url').val('http://'+window.location.hostname+'/'+$(this).attr('src'));
        });

        $('#pic_url').keyup(function(e) {
          if($(e.target).val()=="") {
            $('#sent_img_btn').attr('disabled', 'disabled');
          } else {
            $('#sent_img_btn').removeAttr('disabled');
          }
        }).click(function(e) {
          if($(e.target).val()=="") {
            $('#sent_img_btn').attr('disabled', 'disabled');
          } else {
            $('#sent_img_btn').removeAttr('disabled');
          }
        }).bind('paste', function(e) {
          setTimeout(function() {
            if($(e.target).val()!="") {
              $('#sent_img_btn').removeAttr('disabled');
            }
          }, 100);
        });;

        $('a.smooth-scroll').live('click', function(e){
          e.preventDefault();
          $('html, body').animate({scrollTop: $( $(e.target).attr('href') ).offset().top}, 'slow');
        });

        setInterval(function () {
            $.get('/mq/getMessage.php?queue_name=<?php echo $input_queue_id;?>', null, function (data) {
              if (data) {
                var task_id = queue_worker(data,'<?php echo $output_queue_id;?>');
                var image = '<img src="' + data + '"/><br/>';
                
                var html = '<tr><td>' + image + '</td><td><span id="' +
                    task_id + '_thumb"><img src="images/ajax-loader-circle.gif" class="spinner" /></span></td><td><span id="' +
                    task_id + '_rotated"><img src="images/ajax-loader-circle.gif" class="spinner" /></span></td><td><span id="' +
                    task_id + '_grayscale"><img src="images/ajax-loader-circle.gif" class="spinner" /></span></td></tr>';
                $('#output tbody').prepend(html);
                
                if( $('#result-flow').hasClass('hidden') ){
                  $('#result-flow').slideDown(500, function(){
                    $(this).removeClass('hidden');
                  });
                }
              }
            });

            $.get('/mq/getMessage.php?queue_name=<?php echo $output_queue_id;?>', null, function (data) {
              if (data) {
                
                $('#step-3').css('background-image', 'url(images/step-3-bg.png)');
                $('#gears').fadeOut(100).removeClass('moving');

                $('#send-spinner').attr('src', "images/ajax-loader.gif");
                // $('#step-3 .spinner').fadeOut(400);
                $('#step-3').animate({'background-position-y': '40%'}, 500);
                $('#processed-image').animate({left: '40%', opacity: '1'}, 1500, function(){
                  $(this).animate({left: '-10%', opacity: '0'}, 1500, function(){
                    $(this).css('left', '100%');
                    $('#gears').delay(800).removeClass('moving');
                    $('#send-spinner').attr('src', "images/ajax-loader.png");
                    $('#flashes').html("Check processed images below. Here is the code we are executing on the image on <a href='https://github.com/rkononov/php_example' target='_blank' title='Check App Sources on Github'>Github</a>");
                  });
                });
                $('#receive-images img').animate({'opacity': '.75'}, 1500, function(){
                    $('#receive-images img').animate({'opacity': '.1'}, 1500);
                });

                var parsed = jQuery.parseJSON(data);

                $('#output_queue').html('');
                
                // $('#output_queue').append('<img src="'+parsed["thumbnail"]+'" >'+
                //   '<img src="'+parsed["rotated"]+'" >'+
                //   '<img src="'+parsed["grayscale"]+'" >');
                
                $('#output_queue').html('Completed! <a href="#result-flow" class="smooth-scroll" title="">Check the results &darr;</a>');
                
                $('#output_queue').fadeIn(1000);

                $("#" + parsed["task_id"] + "_thumb").html('<img src="' + parsed["thumbnail"] + '"/>');
                $("#" + parsed["task_id"] + "_rotated").html('<img src="' + parsed["rotated"] + '"/>');
                $("#" + parsed["task_id"] + "_grayscale").html('<img src="' + parsed["grayscale"] + '"/>');

                if( $('#result-flow').hasClass('hidden') ){
                  $('#result-flow').slideDown(500, function(){
                    $(this).removeClass('hidden');
                  });
                }
              }
            })

        }, 5000); // every 5 seconds

        $("#sendMessageForm").submit(function (event) {
          event.preventDefault();

          if( !urlExists($('#pic_url').val()) ) {
            $('#result').addClass('error').html('URL looks wrong. Please check it again').fadeIn(600, function(){
              $(this).delay(1000).fadeOut(2000);
            });;
            return false;

          } else {
            $('#samples').slideUp(300);
            /* get some values from elements on the page: */
            var $form = $(this),
                term = $form.find('input[name="url"]').val(),
                url = $form.attr('action');
            $("#pic_url").empty();

            /* Send the data using post and put the results in a div */
            $('#upload-form .spinner').fadeIn(400);
            $.post(url, { url:term,queue_name:'<?php echo $input_queue_id;?>'},
              function (data) {
                  
                $('#upload-form .spinner').fadeOut(400);
                $("#result").hide().empty().removeClass('error').append(data).fadeIn(600, function(){
                  $(this).delay(1000).fadeOut(2000);
                });

                if($('#flashes').hasClass('hidden')){
                  $('#flashes').removeClass('hidden').animate({'margin-top': 0}, 300);
                }

                $('#code-example').slideUp(200);
                $('#posted-image').html('<img src="'+$('#pic_url').val()+'">');
                $('#posted-image').slideDown(200, function(){
                });


                $('#step-1').animate({'margin-left': '0%'}, 750, 'linear'); 
                $('#step-1').animate({'margin-right': '0%'}, 1000, 'linear', function(){
                  $('#step-3').animate({opacity: 1}, 500);
                  
                  // $('#gears').delay(800).addClass('moving');
                  $('#send-spinner').attr('src', "images/ajax-loader.gif");
                  $('#process-image').delay(1200).animate({left: '40%', opacity: '1'}, 1500, function(){
                      $(this).animate({left: '95%', opacity: '0'}, 1500, function(){
                          $(this).css('left', '-10%');
                          //$('#gears').delay(400).removeClass('moving');
                          $('#step-3').css('background-image', 'none');
                          $('#gears').fadeIn(300).addClass('moving');
                          $('#output_queue').html('');

                          $('#send-spinner').attr('src', "images/ajax-loader.png");
                          $('#flashes').html('and worker has been started process images...');
                      });
                  });
                  $('#send-images img').delay(1500).animate({'opacity': '.75'}, 1000, function(){
                      $('#send-images img').animate({'opacity': '.1'}, 1500);
                  });

                  $('#step-3 .spinner').delay(4200).fadeIn(500);
                  $('#output_queue').delay(1500).fadeOut(500);
                });



              }
            );
            
          } // else end

        });
    });
</script>

<style type="text/css">
    table.sample {
        border-width: 1px;
        border-spacing: 0px;
        border-style: none;
        border-color: gray;
        border-collapse: collapse;
        background-color: white;
    }

    table.sample th {
        border-width: 1px;
        padding: 1px;
        border-style: inset;
        border-color: gray;
        background-color: white;
        -moz-border-radius:;
    }

    table.sample td {
        width: 300;
        align: center;
        border-width: 1px;
        padding: 1px;
        border-style: inset;
        border-color: gray;
        background-color: white;
        -moz-border-radius:;
    }
</style>


</body>
</html>
