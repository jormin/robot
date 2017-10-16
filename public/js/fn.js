var requestAjax = function(params, type, url, callback, async) {
    if(!callback){
        callback = function(msg){
            if(msg.result == 0){
                layer(msg.description,{shift: -1,icon:1},function(){
                    window.location.reload();
                })
            }else{
                layer(msg.description,{icon:2});
            }
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        async: !async,
        type: type,
        data: params,
        dataType: 'json',
        success: function(data){
            callback(data);
        },
        error:function(){
            if(window.console){
                console.error('*******************************************************************');
                console.error('on  '+url+'  error');
            }
        }
    });
};
// 表单JSON序列化
$.fn.serializeJson=function(){
    var serializeObj={};
    var array=this.serializeArray();
    var str=this.serialize();
    $(array).each(function(){
        if(serializeObj[this.name]){
            if($.isArray(serializeObj[this.name])){
                serializeObj[this.name].push(this.value);
            }else{
                serializeObj[this.name]=[serializeObj[this.name],this.value];
            }
        }else{
            serializeObj[this.name]=this.value;
        }
    });
    return serializeObj;
};
function __log(e, data) {
    console.log("\n" + e + " " + (data || ''));
}