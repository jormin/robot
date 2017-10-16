$("#chat-wrap").css('height', $(window).height()-96);
$('#message-input').keydown(function(e){
    if(e.keyCode==13){
        robotReply();
    }
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
    var params = {'message': message ,'userID': $("meta[name=uid]").val()};
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
            layer.msg(res.translateResult);
            $('#message-input').val(res.translateResult);
            robotReply();
        }
    });
}