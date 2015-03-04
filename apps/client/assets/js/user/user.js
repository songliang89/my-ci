/**
 * Created by smzdm on 15/3/4.
 */

/**
 *  用户注册 start
 **/
$(function(){
    // 昵称
    $("#user_name").focus(function(){
        $(this).parent().parent().addClass("info");
        $(this).siblings(".help-inline").show().html("4-14字符,无特殊字符");
    })

    $("#user_name").blur(function(){
        if ($(this).val() == "") {
            $(this).parent().parent().removeClass("info");
            $(this).siblings(".help-inline").hide().html("");
        } else {
            if ($(this).val().length < 4 || $(this).val().length > 14) {
                $(this).parent().parent().removeClass("info").addClass("error");
                $(this).siblings(".help-inline").show().html("4-14字符,无特殊字符");
            }
        }
    })

    // email
    $("#email").focus(function(){
        $(this).parent().parent().addClass("info");
        $(this).siblings(".help-inline").show().html("请输入邮箱");
    })

    $("#email").blur(function(){
        if ($(this).val() == "") {
            $(this).parent().parent().removeClass("info");
            $(this).siblings(".help-inline").hide().html("");
        } else {
            if (!checkEmail($(this).val())) {
                $(this).parent().parent().removeClass("info").addClass("error");
                $(this).siblings(".help-inline").show().html("请输入正确的邮箱地址");
            } else {
                $(this).parent().parent().removeClass("info").addClass("success");
                $(this).siblings(".help-inline").show().html("");
            }
        }
    })

    // 密码
    $("#password").focus(function(){
        $(this).parent().parent().addClass("info");
        $(this).siblings(".help-inline").show().html("输入密码");
    })

    $("#password").blur(function(){
        $(this).parent().parent().removeClass("info");
        $(this).siblings(".help-inline").hide().html("");
    })

    // 确认密码
    $("#again_password").focus(function(){
        $(this).parent().parent().addClass("info");
        $(this).siblings(".help-inline").show().html("确认密码");
    })

    $("#again_password").blur(function(){
        $(this).parent().parent().removeClass("info");
        $(this).siblings(".help-inline").hide().html("");
    })

    // 提交
    $("#register_submit").click(function(){
        var post_data = {
            user_name:$("#user_name").val(),
            email:$("#email").val(),
            password: $.md5($("#password").val()),
            r:Math.random()
        };
        $.ajax({
            type:"post",
            url :'/register_ajax_submit',
            dataType:'json',
            data:post_data,
            success:function(data) {

            }
        })
    })
})



/**
 *  用户注册 end
 **/