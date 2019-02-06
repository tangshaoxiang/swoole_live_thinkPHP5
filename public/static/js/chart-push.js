$(function () {
    $('#discuss-box').keydown(function (event) {
        if(event.keyCode == 13){
            var text = $(this).val();
            var url  = "http://www.darian.shop:8811/?s=index/chart/index"
            var data = {'content':text,'game_id':1};
            $.post(url,data,function (data) {
                //todo
                console.log(data);
                $(this).html("")
            },'json')
        }
    })
});