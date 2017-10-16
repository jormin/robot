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
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
	<link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
</head>

<body>

	<div>
		<ul class="chat-thread" id="chat-wrap">
			<li class="robot">您好，我是果冻，我们聊聊天吧～</li>
		</ul>
		<div id="input-wrap">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="在此输入消息" id="message-input">
				<span class="input-group-addon" id="btn-record">
					<i class="fa fa-microphone"></i>
				</span>
				<span class="input-group-addon" id="btn-send">发送</span>
			</div>
		</div>
	</div>
	<div id="voice-record-popup" class="weui-popup__container">
		<div class="weui-popup__modal">
			<div class="weui_msg">
				<div class="microphone-area" style="cursor:pointer">
					<i class="fa fa-microphone"></i>
				</div>
				<div class="microphone-remark-area"><span>录音中，点击图标结束</span></div>
			</div>
		</div>
	</div>
	<script src='/js/jquery.js'></script>
	<script src='/js/fn.js'></script>
	<script src="/vendor/layer/layer.js"></script>
	<script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
	<script>
        wx.config(<?php echo $wxJs->config(array('startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'translateVoice'), false) ?>);
	</script>
	<script src='/js/chat.js?{{ str_random(10) }}'></script>
</body>

</html>