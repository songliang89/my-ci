/**
 * Created by smzdm on 15/3/4.
 */

/**
 *  用户注册 start
 **/
$(function(){
    //用户名
    $("#user_name").focus(function(){
        $("#user_name_tips").show().html("请输入用户,4-14个字符").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#user_name_tips").hide().html("");
            //$("#submit_register").attr("disabled",true);
        } else {
            if($(this).val().length <4 || $(this).val().length >14) {
                $("#user_name_tips").show().html("用户名4-14个字符").css("color","red");
                //$("#submit_register").attr("disabled",true);
            } else {
                if (isExistUser($(this).val())) {
                    $("#user_name_tips").show().html("该用户名已被占用").css("color","red");
                    //$("#submit_register").attr("disabled",true);
                } else {
                    //$("#submit_register").attr("disabled",false);
                    $("#user_name_tips").hide().html("").css("color","");
                }
            }
        }
    })

    // 邮箱
    $("#email").focus(function(){
        $("#email_tips").show().html("请输入注册邮箱").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#email_tips").show().html("请输入注册邮箱").css("color","red");
        } else {
           if (!checkEmail($(this).val())) {
               $("#email_tips").show().html("请输入合法的邮箱地址").css("color","red");
           } else {
               if(isExistEmail($(this).val())) {
                   $("#email_tips").show().html("该邮箱已被占用").css("color","red");
               } else {
                   $("#email_tips").hide().html("").css("color","");
               }
           }
        }
    })

    // 密码
    $("#password").focus(function(){
        $("#password_tips").show().html("请输入密码,密码至少六位").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#password_tips").show().html("请输入密码,密码至少六位").css("color","red");
        } else {
            if ($(this).val().length<6) {
                $("#password_tips").show().html("密码至少六位").css("color","red");
            } else {
                $("#password_tips").hide().html("").css("color","");
            }
        }
    })

    // 确认密码
    $("#password2").focus(function(){
        $("#password2_tips").show().html("再次输入密码").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#password2_tips").show().html("再次输入密码").css("color","red");
        } else {
            if ($(this).val() != $("#password").val()) {
                $("#password2_tips").show().html("两次输入密码不一致").css("color","red");
            } else {
                $("#password2_tips").hide().html("").css("color","");
            }
        }
    })

    // 验证码
    $("#input_authcode").blur(function(){
        check_auth_code($(this).val());
    })

    // 提交表单
    $("#submit_register").click(function(){
        var username = $("#user_name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var password2 = $("#passowrd2").val();
        if (username == "") {
            $("#user_name_tips").show().html("用户名不能为空").css("color","red");
            return false;
        }
        if (isExistUser(username)) {
            $("#user_name_tips").show().html("该用户名也存在，不能重复注册").css("color","red");
            return false;
        }
        if (email == "") {
            $("#email_tips").show().html("邮箱不能为空").css("color","red");
            return false;
        }
        if (!checkEmail(email)) {
            $("#email_tips").show().html("请输入正确的邮箱地址").css("color","red");
            return false;
        }
        if (isExistEmail(email)) {
            $("#email_tips").show().html("该email也存在，不能重复注册").css("color","red");
            return false;
        }
        if (password == "") {
            $("#password_tips").show().html("密码不能为空").css("color","red");
            return false;
        }
        if (password.length < 6) {
            $("#password_tips").show().html("密码至少六位").css("color","red");
            return false;
        }
        if (password != password) {
            $("#password2_tips").show().html("两次输入密码不一致").css("color","red");
            return false;
        }
        var postData = {
            user_name:username,
            email:email,
            password: $.md5(password),
            r:Math.random()
        };
        // ajax
        $.ajax({
            type:"post",
            url:"/register_ajax_submit",
            data:postData,
            dataType:"JSON",
            success:function(data){
                if (data.code == "-1") {
                    alert(data.msg);
                } else if(data.code == "-2") {
                    $("#user_name_tips").show().html("用户名不能为空").css("color","red");
                } else if (data.code == "-3") {
                    $("#email_tips").show().html("邮箱不能为空").css("color","red");
                } else if(data.code == "-4") {
                    $("#password_tips").show().html("密码不能为空").css("color","red");
                } else if(data.code == "0") {
                    alert(data.msg);
                } else {
                    alert(data.msg);
                    location.href = "/";
                }

            }
        })
    })
})

/**
 *  用户注册 end
 **/

/**
 *  登录 start
 */
$(function(){
    $("#login_user_name").focus(function(){
        $("#login_user_name_tips").show().html("请输入用户").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#login_user_name_tips").show().html("请输入用户").css("color","red");
        } else {
            $("#login_user_name_tips").hide().html("").css("color","");
        }
    })
    $("#login_password").focus(function(){
        $("#login_password_tips").show().html("请输入密码").css("color","");
    }).blur(function(){
        if ($(this).val() == "") {
            $("#login_password_tips").show().html("请输入用户").css("color","red");
        } else {
            $("#login_password_tips").hide().html("").css("color","");
        }
    })

    $("#login_submit").on("click",function(){
        var user_name = $("#login_user_name").val();
        var password = $("#login_password").val();
        if (user_name == "") {
            $("#login_user_name_tips").show().html("用户名不能为空").css("color","red");
            return false;
        }
        if (password == "") {
            $("#login_password_tips").show().html("密码不能为空").css("color","red");
            return false;
        }
        var postData = {
            user_name:user_name,
            password: $.md5(password),
            r:Math.random()
        };
        $.ajax({
            type:"POST",
            url:'/login_ajax_submit',
            data:postData,
            dataType:"json",
            success:function(data){
                if (data.code == 1) {
                    alert(data.msg);
                    location.href="/";
                } else {
                    $("#login_tips").show().html("用户名或密码错误").css("color","red");
                }
            }
        })
    })
})
/**
 *  登录 end
 */

/**
 * ajax 判断用户名是否存在.
 *
 * @param userName
 * @returns {boolean}
 */
function isExistUser(userName)
{
    var flag = false;
    if ("" == userName) {
        return false;
    }
    $.ajax({
        type:"post",
        url:"/register_is_exist_username",
        data:{user_name:userName,r:Math.random()},
        dataType:"JSON",
        async:false,
        success:function(data){
            if (data.code == 1) {
                flag = true
            }
        }
    })
    return flag;
}

/**
 * 验证邮箱是否被占用.
 *
 * @param email
 * @returns {boolean}
 */
function isExistEmail(email)
{
    var flag = false;
    if ("" == email) {
        return flag;
    }
    $.ajax({
        type:"post",
        url:"/register_is_exist_email",
        data:{email:email,r:Math.random()},
        dataType:"json",
        async:false,
        success:function(data){
            if (data.code == 1) {
                flag = true;
            }
        }
    })
    return flag;
}

/**
 *  切换验证码.
 */
function change_auth_code()
{
    var auth_img = "/authcode?";
    $("#authcode").attr("src",auth_img+"r="+Math.random())
}

function check_auth_code(auth_code)
{
    var flag = false;
    if ("" == auth_code) {
        return flag;
    }
    $.ajax({
        type:"post",
        url:"/check_authcode",
        data:{auth_code:auth_code,r:Math.random()},
        dataType:"json",
        async:false,
        success:function(data){

        }
    })
}

