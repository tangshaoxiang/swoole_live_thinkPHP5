var wsUrl = "ws://106.14.14.231:8811";

var websocket = new WebSocket(wsUrl);

//实例对象的onopen属性
websocket.onopen = function(evt) {
    console.log("conected-swoole-success");
}

// 实例化 onmessage
websocket.onmessage = function(evt) {
    push(evt.data);
    console.log("ws-server-return-data:" + evt.data);
}

//onclose
websocket.onclose = function(evt) {
    console.log("close");
}
//onerror

websocket.onerror = function(evt, e) {
    console.log("error:" + evt.data);
}

function push(data) {
    data = JSON.parse(data);
    console.log(data);
    html = '<div class="frame">';
    html += '<h3 class="frame-header">';
    html += '<i class="icon iconfont icon-shijian"></i>第'+data.type+'节';
    html += '</h3>';
    html += '<div class="frame-item">';
    html += '<span class="frame-dot"></span>';
    html += '<div class="frame-item-author">';
    if(data.logo){
        html += '<img src="'+data.logo+'" width="20px" height="20px" />';
    }
    html += data.title;
    html += '<p>比赛如火如荼~~~勇士必胜</p>';
    html += '<p>';
    html += '<img src="'+data.image+'" width="40%" />';
    html += '</p>';
    html += '</div>';
    html += '<p>'+data.content+'</p>';
    html += '</div>';
    html += '</div>';
    $('#match-result').prepend(html);
}