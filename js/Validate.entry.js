$.extend(validatePrompt, {
    username:{
        onFocus:"",
        succeed:"",
        isNull:"请输入用户名",
        error:"不存在此用户名"
    }
});

$.extend(validateFunction, {
    username:function(option) {
        var format = validateRules.isNull(option.value);
        if (!format) {
            validateSettings.succeed.run(option);
        }
        else {
            validateSettings.error.run(option, option.prompts.error);
        }
    },
    pwd:function(option) {
        validateSettings.succeed.run(option);
    },
    FORM_validate:function() {
        $("#loginname").jdValidate(validatePrompt.username, validateFunction.username, true);
        $("#loginpwd").jdValidate(validatePrompt.pwd, validateFunction.pwd, true);
        return validateFunction.FORM_submit(["#loginname","#loginpwd"]);
    },
    FORM_validate_authcode:function() {
        $("#loginname").jdValidate(validatePrompt.username, validateFunction.username, true);
        $("#loginpwd").jdValidate(validatePrompt.pwd, validateFunction.pwd, true);
        $("#authcode").jdValidate(validatePrompt.authcode, validateFunction.authcode, true);
        return validateFunction.FORM_submit(["#loginname","#loginpwd","#authcode"]);
    }
});
//setTimeout(function(){$("#loginname").get(0).focus();},0);
setTimeout(function() {
    if (!$("#loginname").val()) {
        $("#loginname").get(0).focus();
    }
}, 0);
$("#loginname").jdValidate(validatePrompt.username, validateFunction.username);
$("#loginpwd").jdValidate(validatePrompt.empty, validateFunction.pwd);
$("#authcode").jdValidate(validatePrompt.empty, validateFunction.authcode);

function verc() {
    $("#JD_Verification1").click();
}


$("#loginname,#loginpwd, #authcode").bind('keyup', function(event) {
    if (event.keyCode == 13) {
        $("#loginsubmit").click();
    }
});

$("#loginsubmit").click(function() {
    var flag = validateFunction.FORM_validate();
    if (flag) {
        $(this).attr({ "disabled": "disabled" });
        $.ajax({
            type: "POST",
            url: "/vip/Inc/CheckVip.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: $("#formlogin").serialize(),
            error: function() {
                $("#loginpwd").attr({ "class": "text highlight2" });
                $("#loginpwd_error").html("系统忙，请稍候").show().attr({ "class": "error" });
                $("#loginsubmit").removeAttr("disabled");
            },
            success: function(result) {
                if (result) {
                    if (result == -1) {
                        $("#loginname").attr({ "class": "text highlight2" });
                        $("#loginname_error").html("用户名错误").show().attr({ "class": "error" });
                    }
                    if (result == -2) {
                        $("#loginpwd").attr({ "class": "text highlight2" });
                        $("#loginpwd_error").html("密码错误").show().attr({ "class": "error" });
                    }
                    if (result == 1) {
                        var signGotoUrl = getCookie('signGotoUrl');
                        if (signGotoUrl == '' || signGotoUrl == undefined)
                            signGotoUrl = "/vipmanage";
                        xajax_CleanCookie('signGotoUrl');
                        window.location = signGotoUrl;
                    }
                    verc();
                }
            }
        });
    }
});

$("#loginsubmitframe").click(function() {
    var flag = validateFunction.FORM_validate();
    if (flag) {
        $(this).attr({ "disabled": "disabled" });
        $.ajax({
            type: "POST",
            url: "/vip/inc/CheckVip.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: $("#formloginframe").serialize(),
            error: function() {
                $("#loginpwd").attr({ "class": "text highlight2" });
                $("#loginpwd_error").html("系统忙，请稍候").show().attr({ "class": "error" });
                $("#loginsubmitframe").removeAttr("disabled");
            },
            success: function(result) {
                if (result) {
                    if (result == -1) {
                        $("#loginname").attr({ "class": "text highlight2" });
                        $("#loginname_error").html("用户名错误").show().attr({ "class": "error" });
                    }
                    if (result == -2) {
                        $("#loginpwd").attr({ "class": "text highlight2" });
                        $("#loginpwd_error").html("密码错误").show().attr({ "class": "error" });
                    }
                    if (result == 1) {
                        var signGotoUrl = getCookie('signGotoUrl');
                        if (signGotoUrl == '' || signGotoUrl == undefined)
                            signGotoUrl = "/vipmanage";
                        xajax_CleanCookie('signGotoUrl');
                        $("#loginsubmitframe").removeAttr("disabled");
                        window.location = signGotoUrl;
                    }
                    verc();
                }
            }
        });
    }
});
$("#loginname,#loginpwd, #authcode").bind('keyup', function(event) {
    if (event.keyCode == 13) {
        $("#loginsubmitframe").click();
    }
});