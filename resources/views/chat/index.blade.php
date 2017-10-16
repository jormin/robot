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
	</div>
	<script src='/js/jquery.js'></script>
	<script src='/js/fn.js'></script>
	<script src='/js/chat.js?{{ str_random(10) }}'></script>
</body>

</html>