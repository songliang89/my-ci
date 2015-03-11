/**
 * Created by smzdm on 15/3/11.
 */


$(function(){
    // 点击大类 展开收起功能
    $(".launch").on("click",function(){
        if ($(this).attr("handle") == "launch") {
            //alert();
            var html = getDistrictChildList($(this).attr("id"),$("#parent_"+$(this).attr("id")).is(":checked"));
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

    // 点击父类 选中子类
    $(".parent").on("click",function(){
        var j = 0;
        $("input[name='district_id[]']").each(function(key,obj){
            if ($(obj).is(":checked")) {
                j++;
            }
        })
        if (j == $("input[name='district_id[]']").length) {
            $("#check_all").prop("checked",true);
        } else {
            $("#check_all").prop("checked",false);
        }
        if ($(this).is(":checked")) {
            $(".child_"+$(this).val()).each(function(key,obj){
                $(obj).prop("checked",true);
            })
        } else {
            $(".child_"+$(this).val()).each(function(key,obj){
                $(obj).prop("checked",false);
            })
        }
    })

    // 点击子类
    $(document).on("click",".child",function(){
         if ($(this).is(":checked")) {
             var j = 0;
            $(".child_"+$(this).attr("pid")).each(function(key,obj){
                if ($(obj).is(":checked")) {
                    j++;
                }
            })
             if (j == $(".child_"+$(this).attr("pid")).length) {
                 $("#parent_"+$(this).attr("pid")).prop("checked",true);
             }
         } else {
             $("#parent_"+$(this).attr("pid")).prop("checked",false);
         }
    })
})

/**
 * 获取 子类列表.
 *
 * @param pid
 * @returns {string}
 */
function getDistrictChildList(pid,ischecked)
{
    var html = "";
    if ("" == pid) {
        return html;
    }
    $.ajax({
        type:"post",
        url:"/district_child_list",
        data:{pid:pid,r:Math.random(),checked:ischecked},
        dataType:'html',
        async:false,
        success:function(data){
            html = data;
        }
    })
    return html;
}