(function(){
	var Login = function(){
		var self = this;

		self.username = ko.observable("");
		self.password = ko.observable("");
		self.loading = ko.observable("");
		self.msgs = ko.observable("");
		self.showmsg = ko.observable(false);
		self.errMsg = null;

		self.login = function(form){
			self.errMsg = "";
			if(!self.username().replace(/\s/g, '').length){
				self.errMsg += "Username must not be empty. <br>";
			}
			if(!self.password().replace(/\s/g, '').length){
				self.errMsg += "Password must not be empty.";
			}
			if(!self.errMsg){
				$.ajax({
					data: 	$(form).serialize() + "&action=login",
					type: 	"POST",
					url: 	"login.php",
					beforeSend: function(){
						self.loading("Logging in..."); 
					},
					success: function(response){
						response = response.replace(/\s/g, '');
						if(response === "successful"){
							window.location = "/knockoutCMS/public/admin";	
						}else{
							self.loading(""); 
							self.showmsg(true);
							self.msgs(response);
						}
					}
				});
			}else{
				self.showmsg(true);
				self.msgs(self.errMsg);
			}
		}
	}
	ko.applyBindings(Login);
}());