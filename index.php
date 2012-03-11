<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
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
      
      <code>
        <pre>
$ironmq = new IronMQ('config.ini');
$ironmq->postMessage("input_queue", 
          array("body" => $url_to_picture));</pre>
      </code>
      
      <div id="upload-form">
        <h3>Or add url to pic in form below</h3>
        <form action="/mq/postMessage.php" id="sendMessageForm">
            <input id = "pic_url" type="text" name="url" placeholder="Search..."/>
            <input type="submit" value="Add picture"/>
        </form>
        <small>Or even simply choose one from our set</small>
      </div>
      
      <div id="result">Message posted</div>
    </div>
    <div class="box-connector"></div>
    <div id="step-2" class="transform-step">
      <h2>List of pictures pushed to workers</h2>
      <div id="input_queue"></div>
    </div>
    <div class="box-connector"></div>
    <div id="step-3" class="transform-step">
      <h2>List of processed pictures</h2>
      <div id="output_queue"></div>
    </div>    
  </section>
  
  <footer>
    <a href="http://iron.io" title="Messaging and Background Processing for Cloud Apps"><img src="http://www.iron.io/assets/resources/ironio-badge-red.png" alt="Iron.io Badge" /></a>      
  </footer>    

<script>
    function queue_worker(data)
    {
        $.post('/iw/queueWorker.php', { url:data });
    }
    $(document).ready(function () {
        setInterval(function () {
            $.get('/mq/getMessage.php?queue_name=input_queue', null, function (data) {
                if (data) {
                    $("#input_queue").append(data + '<br/>');
                    queue_worker(data);
                }
            })
            $.get('/mq/getMessage.php?queue_name=output_queue', null, function (data) {
                if (data) {
                    $("#output_queue").append(data + '<br/>');
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
            $.post(url, { url:term },
                    function (data) {
                        $("#result").hide().empty().append(data).fadeIn(200, function(){
                          $(this).delay(1000).fadeOut(2000);
                        });
                    }
            );
        });
    });
</script>


</body>
</html>
