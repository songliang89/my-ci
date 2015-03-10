/**
 * Created by smzdm on 15/3/4.
 */


/**
 * 验证email
 * @param val  邮箱
 * @returns {boolean}
 */
function checkEmail(val)
{
    var reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    if (reg.test(val)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 验证规则：字母、数字、下划线组成，字母开头，4-16位。
 * @param userName
 * @returns {boolean}
 */
function checkUserName(userName)
{
    var reg = /^[a-zA-Z0-9]\w{3,15}$/;
    if (reg.test(userName)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 校验手机号
 *
 * @param str
 * @returns {boolean}
 */
function checkMobile(str)
{
    var reg = /^1\d{1,10}/;
    if (reg.test(str)) {
        return true;
    } else {
        return false;
    }
}

function userLogin()
{
    var userid = $.cookie("userid");
    var username = $.cookie("username");
    if (typeof userid != "undefined" && typeof username != "undefined") {
        $("#login").hide();
        $("#register").hide();
        $("#user_msg").show();
        $("#logout").show();
        $("#userinfo").show();
        $("#username").html(username);
    }
}

userLogin();

