/**
 * Created by smzdm on 15/3/11.
 */
$(function(){
    $(".launch").on("click",function(){
        var html = getDistrictChildList($(this).attr("id"));
        $(this).parent().parent().after(html);
        $(this).removeClass("launch");
    })
})

function getDistrictChildList(pid)
{
    var html = "";
    if ("" == pid) {
        return html;
    }
    $.ajax({
        type:"post",
        url:"/district_child_list",
        data:{pid:pid,r:Math.random()},
        dataType:'html',
        async:false,
        success:function(data){
            html = data;
        }
    })
    return html;
}