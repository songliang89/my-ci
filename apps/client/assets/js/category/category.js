/**
 * Created by smzdm on 15/3/11.
 */


$(function(){
    // 点击大类 展开收起功能
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

    // 全选反选功能
    $("#check_all").on("click",function(){
        if ($(this).is(":checked")){
            $("input[name='district_id[]']").each(function(key,obj){
                    $(obj).prop("checked",true);
            })
        } else {
            $("input[name='district_id[]']").each(function(key,obj){
                $(obj).prop("checked",false);
            })
        }
    })
})
/**
 * 获取 子类列表.
 *
 * @param pid
 * @returns {string}
 */
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