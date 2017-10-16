<!DOCTYPE html>
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
		<div id="input-wrap">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="在此输入消息" id="message-input">
				<span class="input-group-addon" id="btn-send">发送</span>
			</div>
		</div>

		<div align="center" style="bottom: 76px;position: absolute;padding: 0 65px;">
			<audio controls autoplay style="display: none;"></audio>
			<br>
			<input onclick='startRecording()' type='button' value='录音' />
			<input onclick='stopRecording()' type='button' value='停止' />
			<input onclick='playRecording()' type='button' value='播放' />
			<input onclick='uploadAudio()' type='button' value='上传' />
			<input onclick='translateAudio()' type='button' value='识别' />
		</div>

	</div>
	<script src='/js/jquery.js'></script>
	<script src='/js/fn.js'></script>
	<script src='/js/chat.js?{{ str_random(10) }}'></script>
	<script src="/vendor/layer/layer.js"></script>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
	<script>
        wx.config(<?php echo $wxJs->config(array('startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'translateVoice'), false) ?>);
        var localId = '';
        function startRecording() {
            wx.startRecord();
            layer.msg('开始录音....');
        }

        function stopRecording() {
            wx.stopRecord({
                success: function (res) {
                    localId = res.localId;
                    layer.msg('结束录音');
                }
            });
        }

        wx.onVoiceRecordEnd({
            // 录音时间超过一分钟没有停止的时候会执行 complete 回调
            complete: function (res) {
                localId = res.localId;
            }
        });

        function playRecording() {
            if(!localId){
                layer.msg('请先开始录音');
                return;
			}
            wx.playVoice({
                localId: localId
            });
            layer.msg('开始播放....');
        }
        
        function uploadAudio() {
            layer.msg("录音上传中...");
            wx.uploadVoice({
                localId: localId, // 需要上传的音频的本地ID，由stopRecord接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    var serverId = res.serverId; // 返回音频的服务器端ID
                    layer.msg("录音上传成功");
                }
            });
        }

        function translateAudio() {
            layer.msg("录音识别中...");
            wx.translateVoice({
                localId: localId, // 需要识别的音频的本地Id，由录音相关接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    $("#message-input").val(res.translateResult);
                }
            });
		}
	</script>
</body>

</html>