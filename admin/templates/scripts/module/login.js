/* 登陆页面 */
seajs.use(["jquery", "scValidator"], function ($, validator) {
	$(function(){
		var login  = new validator.login({
			form : ".scr-wrapper",
			id : "#username",
			password : "#password",
			remember : "#remember",
			submit : "#login",
			submitIng : "#login-ing"
		});

		login.initialize();
	});
});