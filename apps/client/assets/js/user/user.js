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
            $(this).parent().parent().removeClass().addClass("control-group");
            $(this).siblings(".help-inline").hide().html("");
        } else {
            if ($(this).val().length < 4 || $(this).val().length > 14) {
                $(this).parent().parent().removeClass().addClass("control-group error");
                $(this).siblings(".help-inline").show().html("4-14字符,无特殊字符");
            } else {

                //todo 判断用户名是否被占用

                $(this).parent().parent().removeClass().addClass("control-group success");
                $(this).siblings(".help-inline").hide().html("");
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
        $(this).siblings(".help-inline").show().html("输入密码,至少六位");
    })

    $("#password").blur(function(){
        if ("" == $(this).val()) {
            $(this).parent().parent().removeClass().addClass("control-group info");
            $(this).siblings(".help-inline").hide().html("");
        } else {
            if ($(this).val().length < 6) {
                $(this).parent().parent().removeClass().addClass("control-group error");
                $(this).siblings(".help-inline").show().html("输入密码,至少六位");
            } else {
                $(this).parent().parent().removeClass().addClass("control-group success");
                $(this).siblings(".help-inline").hide().html("");
            }
        }
    })

    // 确认密码
    $("#again_password").focus(function(){
        $(this).parent().parent().addClass("info");
        $(this).siblings(".help-inline").show().html("确认密码");
    })

    $("#again_password").blur(function(){
        if ($(this).val() == "") {
            $(this).parent().parent().removeClass().addClass("control-group info");
            $(this).siblings(".help-inline").hide().html("");
        } else {
            if ($(this).val() != $("#password").val()) {
                $(this).parent().parent().removeClass().addClass("control-group error");
                $(this).siblings(".help-inline").show().html("两次输入的密码不一致");
            } else {
                $(this).parent().parent().removeClass().addClass("control-group success");
                $(this).siblings(".help-inline").hide().html("");
            }
        }
    })

    // 提交
    $("#register_submit").click(function(){
        // 用户名判断
        if ($("#user_name").val() == "") {
            $("#user_name").parent().parent().removeClass().addClass("control-group error");
            $("#user_name").siblings(".help-inline").show().html("用户名不能为空");
            return false;
        }



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