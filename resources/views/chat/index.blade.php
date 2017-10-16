<!DOCTYPE html>保存文件
<html>
<head>
	<!-- 声明文档使用的字符编码 -->
	<meta charset='utf-8'>
	<!-- 优先使用 IE 最新版本和 Chrome -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<!-- 为移动设备添加 viewport -->
	<meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">

	<meta name="uid" value="{{$userID}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>自动聊天室</title>
	<link rel="stylesheet" href="/css/app.css?{{ str_random(10) }}" media="screen" type="text/css" />
    <link rel="stylesheet" href="/css/chat.css?{{ str_random(10) }}" media="screen" type="text/css" />
</head>

<body>

	<div>
		<ul class="chat-thread" id="chat-wrap">
			<li class="robot">您好，我是果冻，我们聊聊天吧～</li>
		</ul>
		{{--<div id="input-wrap">--}}
			{{--<div class="input-group">--}}
				{{--<input type="text" class="form-control" placeholder="在此输入消息" id="message-input">--}}
				{{--<span class="input-group-addon" id="btn-send">发送</span>--}}
			{{--</div>--}}
		{{--</div>--}}

		<button onclick="startRecording(this);">record</button>
		<button onclick="stopRecording(this);" disabled>stop</button>

	</div>
	<script src='/js/jquery.js'></script>
	<script src='/js/fn.js'></script>
	<script src='/js/chat.js?{{ str_random(10) }}'></script>
	<script src="/js/recorder.js"></script>
	<script>

        var audio_context;
        var recorder;

        function startUserMedia(stream) {
            var input = audio_context.createMediaStreamSource(stream);
            __log('Media stream created.');

            // Uncomment if you want the audio to feedback directly
            //input.connect(audio_context.destination);
            //__log('Input connected to audio context destination.');

            recorder = new Recorder(input);
            __log('Recorder initialised.');
        }

        function startRecording(button) {
            recorder && recorder.record();
            button.disabled = true;
            button.nextElementSibling.disabled = false;
            __log('Recording...');
        }

        function stopRecording(button) {
            recorder && recorder.stop();
            button.disabled = true;
            button.previousElementSibling.disabled = false;
            __log('Stopped recording.');

            // create WAV download link using audio data blob
            createDownloadLink();

            recorder.clear();
        }

        function createDownloadLink() {
            recorder && recorder.exportWAV(function(blob) {
//                var url = URL.createObjectURL(blob);
                var formData = new FormData();
                formData.append("file",blob);
                $.ajax({
                    url : '/chat/upfile',
                    type : 'POST',
                    data : formData,
					// 告诉jQuery不要去处理发送的数据
                    processData : false,
					// 告诉jQuery不要去设置Content-Type请求头
                    contentType : false,
                    beforeSend:function(){
                        console.log("正在进行，请稍候");
                    },
                    success : function(responseStr) {
                        if(responseStr.status===0){
                            console.log("成功"+responseStr);
                        }else{
                            console.log("失败");
                        }
                    },
                    error : function(responseStr) {
                        console.log("error");
                    }
                });
            });
        }

        window.onload = function init() {
            try {
                // webkit shim
                window.AudioContext = window.AudioContext || window.webkitAudioContext;
                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
                window.URL = window.URL || window.webkitURL;
                audio_context = new AudioContext;
                __log('Audio context set up.');
                __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
            } catch (e) {
                alert('No web audio support in this browser!');
            }

            navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
                __log('No live audio input: ' + e);
            });
        };
	</script>
</body>

</html>