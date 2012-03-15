<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="http://www.iron.io/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700' rel='stylesheet' type='text/css'>

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
</head>
<body>

<div class="gears-bg"></div>

  <header>
    This page shows how you can easly processing images with IronMQ and IronWorker in background!
  </header>

  <section id="steps">
    <div id="step-1" class="transform-step">
      <h2 style="font-size: 14px;line-height: 1.2em;">Add picture via posting url to IronMQ</h2>
      
      <code id='code-example'>
        <pre>
$ironmq = new IronMQ('config.ini');
$ironmq->postMessage("input_queue", 
          array("body" => $url_to_picture));</pre>
      </code>

      <div id="posted-image">
        <img src="http://stuntsoftware.com/img/onthejob/icon_onthejob_128.png" alt="">
      </div>

      
      <div id="upload-form">
        <img src="images/ajax-loader.gif" class="spinner">
        <img src="images/step-1-bg.png" alt="" style="margin: 0 auto 10px;clear: both;display: block;height: 99px;">
        <h3>Or add url to pic in form below</h3>
        <form action="/mq/postMessage.php" id="sendMessageForm">
            <input id = "pic_url" type="text" name="url" placeholder="Search..."/>
            <input type="submit" value="Add picture"/>
        </form>
        <small>Or even simply choose one from our set</small>
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
    </div>

    <div id="step-3" class="transform-step">
      <img src="images/ajax-loader.gif" class="spinner">

      <h2>IronWorker</h2>
      <div id="output_queue">
        <div class="processed-image">
          <img src="http://i.imgur.com/F1uM5.jpg" alt="">
          <a href="http://i.imgur.com/F1uM5.jpg" title="">http://i.imgur.com/F1uM5.jpg</a>
        </div>
        <div class="processed-image">
          <img src="http://i.imgur.com/71uxd.jpg">
          <a href="http://i.imgur.com/71uxd.jpg" title="">http://i.imgur.com/71uxd.jpg</a>
        </div>
        <div class="processed-image">
          <img src="http://i.imgur.com/1Ihnp.jpg" alt="">
          <a href="http://i.imgur.com/1Ihnp.jpg" title="">http://i.imgur.com/1Ihnp.jpg</a>
        </div>
      </div>
    </div>    
  </section>

  <div class="clearfloat"></div>

  <section id="result-flow">
    <h2>And see result images:</h2>
    <table id="output">
      <thead>
        <tr>
          <td>Image from queue</td>
          <td>Thumbnail</td>
          <td>Rotated</td>
          <td>Grayscale</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </section>
  
  <footer>
    <a href="http://iron.io" title="Messaging and Background Processing for Cloud Apps"><img src="http://www.iron.io/assets/resources/ironio-badge-red.png" alt="Iron.io Badge" /></a>      
  </footer>

<!-- <table class="sample">
    <tr>
        <td VALIGN="top">
            <h3>Add picture via posting url to IronMQ</h3>
            <br/>
            $ironmq = new IronMQ('config.ini');<br/>
            $ironmq->postMessage("input_queue", array("body" => $url_to_picture));<br/>

            <h3>Or add url to pic in form below</h3>

            <form action="/mq/postMessage.php" id="sendMessageForm">
                <input id="pic_url" type="text" name="url" placeholder="Search..."/>
                <input type="submit" value="Add picture"/>
            </form>
            <div id="result"></div>

        </td>
        <td VALIGN="top">
            <table id="output">
                <tbody>
                <tr>
                    <td>
                        Image from queue
                    </td>
                    <td>
                        Thumbnail
                    </td>
                    <td>
                        Rotated
                    </td>
                    <td>
                        Grayscale
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
</table>
 -->

<script>
    function queue_worker(data) {
        var task_id = ''
        $.ajaxSetup({async:false});
        $.post('/iw/queueWorker.php', { url:data },function(data) {
            task_id = data;
        });
        return task_id;
    }
    $(document).ready(function () {
        setInterval(function () {
            $.get('/mq/getMessage.php?queue_name=input_queue', null, function (data) {
                if (data) {
                    var task_id = queue_worker(data);
                    var image = '<img width="200" src="' + data + '"/><br/>';
                    
                    $('#step-3 .spinner').show();
                    var html = '<tr><td>' + image + '</td><td><span id="' +
                        task_id + '_thumb"><img width="200" src="images/ajax-loader-circle.gif"/><br/></span></td><td><span id="' +
                        task_id + '_rotated"><img width="200" src="images/ajax-loader-circle.gif"/><br/></span></td><td><span id="' +
                        task_id + '_grayscale"><img width="200" src="images/ajax-loader-circle.gif"/><br/></span></td></tr>';
                    $('#output tbody tr:first').before(html);
                }
            });
            $.get('/mq/getMessage.php?queue_name=output_queue', null, function (data) {
                if (data) {
                    $('#step-3 .spinner').fadeOut(400);
                    $('#step-3').animate({'background-position-y': '40%'}, 500);
                    $('#output_queue').fadeIn(1000);
                    $('#processed-image').animate({left: '40%', opacity: '1'}, 1000, function(){
                      $(this).animate({left: '-10%', opacity: '0'}, 1000, function(){
                        $(this).css('left', '100%');
                      });
                    });
                    $('#receive-images img').animate({'opacity': '.75'}, 1000, function(){
                        $('#receive-images img').animate({'opacity': '.1'}, 1000);
                    });

                    var parsed = jQuery.parseJSON(data);
                    $("#" + parsed["task_id"] + "_thumb").html('<img src="' + parsed["thumbnail"] + '"/>');
                    $("#" + parsed["task_id"] + "_rotated").html('<img src="' + parsed["rotated"] + '"/>');
                    $("#" + parsed["task_id"] + "_grayscale").html('<img src="' + parsed["grayscale"] + '"/>');
                }
            })

        }, 5000); // every 5 seconds

        $("#sendMessageForm").submit(function (event) {
          event.preventDefault();


          /* get some values from elements on the page: */
          var $form = $(this),
              term = $form.find('input[name="url"]').val(),
              url = $form.attr('action');
          $("#pic_url").empty();

          /* Send the data using post and put the results in a div */
          $('#upload-form .spinner').fadeIn(400);
          $.post(url, { url:term },
            function (data) {
                
              $('#upload-form .spinner').fadeOut(400);
              $("#result").hide().empty().append(data).fadeIn(600, function(){
                $(this).delay(1000).fadeOut(2000);
              });

              $('#code-example').slideUp(200);
              $('#posted-image').html('<img src="'+$('#pic_url').val()+'">');
              $('#posted-image').slideDown(200, function(){
              });

              $('#process-image').delay(1000).animate({left: '40%', opacity: '1'}, 1000, function(){
                  $(this).animate({left: '95%', opacity: '0'}, 1000, function(){
                      $(this).css('left', '-10%');
                  });
              });
              $('#send-images img').delay(1000).animate({'opacity': '.75'}, 1000, function(){
                  $('#send-images img').animate({'opacity': '.1'}, 1000);
              });
            }
          );
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
