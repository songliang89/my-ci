/**
 * Created by smzdm on 15/3/11.
 */


$(function(){

    $(".launch").on("click",function(){
        if ($(this).attr("handle") == "launch") {
            var html = getDistrictChildList($(this).attr("id"));
            $(this).parent().parent().after(html);
            $(this).attr("handle","un_launch").removeClass("am-icon-folder-o").addClass("am-icon-folder-open");
        } else {
            $(".tr_"+$(this).attr("id")).remove();
            $(this).attr("handle","launch").removeClass("am-icon-folder-open").addClass("am-icon-folder-o");
        }
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