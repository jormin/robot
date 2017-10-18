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
	<title>{{config('app.name')}}</title>
	<link rel="stylesheet" href="/css/app.css?{{ str_random(10) }}" media="screen" type="text/css" />
    <link rel="stylesheet" href="/css/chat.css?{{ str_random(10) }}" media="screen" type="text/css" />
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
	<link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
</head>

<body>
	<div>
		<ul class="chat-thread" id="chat-wrap">
			<li class="robot">{{config('app.welcome') }}</li>
		</ul>
		<div id="input-wrap">
			<div class="input-group">
				<span class="input-group-addon" id="btn-record">
					&nbsp;<i class="fa fa-microphone"></i>&nbsp;
				</span>
				<textarea class="weui-textarea" placeholder="在此输入消息" rows="3" id="message-input"></textarea>
				<span class="input-group-addon" id="btn-setting">
					&nbsp;<i class="fa fa-cog"></i>&nbsp;
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
	<div id="setting-wrap" class="weui-popup__container popup-bottom">
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal" id="setting-modal">
			<div class="toolbar">
				<div class="toolbar-inner">
					<a href="javascript:;" class="picker-button close-popup">关闭</a>
					<h1 class="title">设置</h1>
				</div>
			</div>
			<div class="modal-content">
				<form id="setting-form">
					<div class="weui-cells weui-cells_form">
						<div class="weui-cell weui-cell_switch">
							<div class="weui-cell__bd">语音播放</div>
							<div class="weui-cell__ft">
								<input class="weui-switch" name="audioPlay" id="audioPlay" type="checkbox" checked>
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label for="person" class="weui-label">声音</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input setting-select" name="person" id="person" type="text" value="女声" readonly="" data-values="0">
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label for="speed" class="weui-label">语速</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input setting-select" name="speed" id="speed" type="text" value="5" readonly="" data-values="5">
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label for="pitch" class="weui-label">语调</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input setting-select" name="pitch" id="pitch" type="text" value="5" readonly="" data-values="5">
							</div>
						</div>
						<div class="weui-cell">
							<div class="weui-cell__hd"><label for="volume" class="weui-label">音量</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input setting-select" name="volume" id="volume" type="text" value="5" readonly="" data-values="5">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<audio src="" id="audio-player" style="display: none"></audio>
	<script src='/js/jquery.js'></script>
	<script src='/js/fn.js'></script>
	<script src="/vendor/layer/layer.js"></script>
	<script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js"></script>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
	<script>
        wx.config(<?php echo $wxJs->config(array('onMenuShareTimeline', 'onMenuShareAppMessage', 'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'translateVoice'), false) ?>);
        wx.ready(function(){
        	$("#audio-player")[0].play();
        });
        var wxShareData = {{ json_encode($shareData) }};
        wx.onMenuShareTimeline(wxShareData);
        wx.onMenuShareAppMessage(wxShareData);
	</script>
	<script src='/js/chat.js?{{ str_random(10) }}'></script>
</body>

</html>