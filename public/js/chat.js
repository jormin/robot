if($("#wechatAuth").is(':checked')){
    enableUserAvatar();
}
function enableUserAvatar() {
    $('head').append("<style id='user-style'>.chat-thread li.user:before{background-image:url(http://wx.qlogo.cn/mmopen/vi_32/sGcQQ61NTDjmTiahCgEQldhdHoCpFCbiaU7O8RG0d805oIicrkNaXkM1e5LDgXhkH1mjc990u1yGsWXNxZqDnJ7yA/0) }</style>");
}
$("#chat-wrap").css('height', $(window).height()-40);
$('#message-input').on('click', function(e){
    var target = this;
    setTimeout(function(){
            target.scrollIntoView(true);
    },100);
});
$("#btn-send").click(function () {
    robotReply();
});
function robotReply() {
    var messageInputDom = $('#message-input');
    var chatWrapDom = $('#chat-wrap');
    var message = messageInputDom.val();
    if(!message){
        return;
    }
    var params = {'message': message};
    var userMessage = '<li class="user">'+message+'</li>';
    chatWrapDom.append(userMessage);
    messageInputDom.val('');
    dealScorll();
    var callback = function (data) {
        var reply = '';
        switch (data.code){
            case 100000:
                // 文本
                reply = '<li class="robot">'+data.text+'</li>';
                chatWrapDom.append(reply);
                break;
            case 200000:
                // 链接
                reply = '<li class="robot">'+data.text+'，<a href="'+data.url+'" target="_blank">查看详情</a></li>';
                chatWrapDom.append(reply);
                break;
            case 302000:
                // 新闻
                reply = '<li class="robot">'+data.text+'</li>';
                chatWrapDom.append(reply);
                reply = '<li class="robot">';
                $(data.list).each(function (index, item) {
                    if(!item.article || !item.detailurl){
                        return;
                    }
                    if(index != 0){
                        reply += '<br>';
                    }
                    reply += (index+1)+'. <a href="'+item.detailurl+'" target="_blank">'+item.article+'</a>';
                });
                chatWrapDom.append(reply);
                break;
            case 308000:
                // 菜谱
                break;
        }
        if(data.audio){
            $("#audio-player").attr("src", data.audio);
            var player = $("#audio-player")[0];
            player.play();
        }
        dealScorll();
    };
    requestAjax(params, 'post', '/chat/robot', callback, false);
}
function dealScorll() {
    var chatWrapDom = $('#chat-wrap');
    chatWrapDom.scrollTop(chatWrapDom.prop("scrollHeight"))
}
$("#btn-record").click(function () {
    $("#voice-record-popup").show();
    wx.startRecord();
})
$(document).on("click",".microphone-area",function(){
    $("#voice-record-popup").hide();
    wx.stopRecord({
        success: function (res) {
            var localId = res.localId;
            deal_voice_record(localId);
        }
    });
})
wx.onVoiceRecordEnd({
    // 录音时间超过一分钟没有停止的时候会执行 complete 回调
    complete: function (res) {
        var localId = res.localId;
        deal_voice_record(localId);
    }
});
function deal_voice_record(localId){
    wx.translateVoice({
        localId: localId, // 需要识别的音频的本地Id，由录音相关接口获得
        isShowProgressTips: 1, // 默认为1，显示进度提示
        success: function (res) {
            // 语音识别的结果
            $('#message-input').val(res.translateResult);
            robotReply();
        }
    });
}
$("#btn-setting").click(function () {
    $("#setting-wrap").popup();
})
$("#person").select({
    title: "选择声音",
    items: [{title: "女声",value: "0"},{title: "男声",value: "1"},{title: "度逍遥",value: "3"},{title: "度丫丫",value: "4"}],
    onClose: function () {
        $("#setting-wrap").popup();
    }
});
$("#speed").select({
    title: "选择语速",
    items: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
    onClose: function () {
        $("#setting-wrap").popup();
    }
});
$("#pitch").select({
    title: "选择语调",
    items: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
    onClose: function () {
        $("#setting-wrap").popup();
    }
});
$("#volume").select({
    title: "选择声音",
    items: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'],
    beforeClose: function () {
        $("#setting-wrap").popup();
    }
});
$(".setting-select").click(function () {
    $.closePopup();
})
$("#btn-close-popup").click(function () {
    $.closePopup();
    var params = $("#setting-form").serializeJson();
    params.wechatAuth = $("#wechatAuth").is(':checked') ? 1 : 0;
    params.audioPlay = $("#audioPlay").is(':checked') ? 1 : 0;
    params.person = $("#person").data('values');
    var callback = function (data) {
        console.log(params);
        if(data.status === 1){
            $.toast('保存成功', function () {
                if(data.data.auth === 1){
                    window.location.href = domain+'?wechatAuth=1';
                }
                if(params.wechatAuth === 0){
                    $("#user-style").remove();
                }else{
                    enableUserAvatar();
                }
            });
        }else{
            $.toast('保存失败', 'forbidden');
        }
    };
    requestAjax(params, 'post', '/user/config', callback, false);
})