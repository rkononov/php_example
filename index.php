<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<script type="text/javascript"
        src="https://www.google.com/jsapi?key=ABQIAAAAhes0f80sBcwL-h5xCNkkgxQBmiBpQeSpIciQPfZ5Ss-a60KXIRQOVvqzsNpqzhmG9tjky_5rOuaeow"></script>
<script type="text/javascript">google.load('jquery', '1');
google.load('jqueryui', '1'); </script>
<head></head>
<body>
<table class="sample">
<tr>
<td VALIGN="top">
<h3>Add picture via posting url to IronMQ</h3>
<br/>
$ironmq = new IronMQ('config.ini');<br/>
$ironmq->postMessage("input_queue", array("body" => $url_to_picture));<br/>
<h3>Or add url to pic in form below</h3>
<form action="/mq/postMessage.php" id="sendMessageForm">
    <input id = "pic_url" type="text" name="url" placeholder="Search..."/>
    <input type="submit" value="Add picture"/>
</form>
<div id="result"></div>

</td>
<td VALIGN="top">
<h3>List of pictures pushed to workers</h3>
<div id="input_queue"></div>
</td>
<td VALIGN="top">
<h3>List of processed pictures</h3>
<div id="output_queue"></div>
</td>
</table>

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
                        $("#result").empty().append(data);
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
	-moz-border-radius: ;
}
table.sample td {
        width: 300;
	align: center;
	border-width: 1px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: white;
	-moz-border-radius: ;
}
</style>


</body>
</html>
