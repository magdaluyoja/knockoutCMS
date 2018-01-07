(function(){
	var Admin = function(){
		var self = this;
		self.adminList = ko.observableArray();
		self.username = ko.observable("");
		self.password = ko.observable("");
		self.confirmpassword = ko.observable("");

		self.saveMode = ko.observable("Save");
		self.currentId = null;

		self.focused = ko.observable(true);

		self.showloading = ko.observable(false);
		self.showmsg = ko.observable(false);
		self.msgClass = ko.observable("");
		self.loading = ko.observable("");
		self.msgs = ko.observable("");
		self.errMsg = null;

		self.editAdmin = function(admin){
			self.saveMode("Update");
			$.ajax({
				data: 	"action=editAdmin&id="+admin.id,
				type: 	"POST",
				url: 	"manage_admins.php",
				beforeSend: function(){
					self.showloading(true);
					self.loading("Fetching admin data..."); 
				},
				success: function(response){
					response = response.split(",");
					self.currentId = response[0];
					self.username(response[1]);
					self.focused(true);
					self.loading(""); 
					self.showloading(false);
				}
			});
		};
		self.deleteAdmin = function(admin){
			$.ajax({
				data: 	"action=deleteAdmin&id="+admin.id,
				type: 	"POST",
				url: 	"manage_admins.php",
				beforeSend: function(){
					self.showloading(true);
					self.loading("Fetching admin data..."); 
				},
				success: function(response){
					response = response.replace(/\s/g, '');
					if(response == "successful"){
						self.loading(""); 
						self.adminList.remove( function (item) { return item.id === admin.id; } );
						self.msgs('Admin deletion was successful.');
						self.msgClass("message");
					}
					else{
						self.msgs(response);
						self.msgClass("error");
					}
					self.loading(""); 	
					self.showloading(false);
					self.showmsg(true);
				}
			});
		};
		self.saveAdmin = function(form){
			self.errMsg = "";
			
			if(!self.username().replace(/\s/g, '').length){
				self.errMsg += "Username must not be empty. <br>";
			}
			if(!self.password().replace(/\s/g, '').length){
				self.errMsg += "Password must not be empty. <br>";
			}
			if(!self.confirmpassword().replace(/\s/g, '').length){
				self.errMsg += "Confirm Password must not be empty. <br>";
			}
			if(!self.errMsg){
				if(self.password() !== self.confirmpassword()){
					self.errMsg += "Passwords did not match.";
				}
			}
			
			if(!self.errMsg){
				$.ajax({
					data: 	$(form).serialize() + "&action=saveAdmin&id="+self.currentId+"&mode="+self.saveMode(),
					type: 	"POST",
					url: 	"manage_admins.php",
					beforeSend: function(){
						self.showloading(true);
						self.loading("Saving user data..."); 
					},
					success: function(response){
						var arrResponse = response.split("|"); 

						var msg = arrResponse[0].replace(/\s/g, '');
						if(msg == "successful"){
							if(self.saveMode() === "Save"){
								self.msgs('Admin "'+ self.username() +'" was successfully saved.');
							}else{
								self.adminList.remove( function (item) { return item.id === self.currentId.replace(/\s/g, ''); } );
								self.msgs('Admin "'+ self.username() +'" was successfully updated.');
							}
							var newAdmin = JSON.parse(arrResponse[1]);
							self.adminList.push(newAdmin);	
							self.clearFields();
							self.msgClass("message");
						}
						else{
							self.msgClass("error");
							self.msgs(msg);
						}
						self.showmsg(true);
						self.showloading(false); 
						self.loading(""); 
					}
				});
			}else{
				
				self.showmsg(true);
				self.msgClass("error");
				self.msgs(self.errMsg);
			}
		};
		(function(){
			$.ajax({
				data: 	"action=getAdminList",
				type: 	"POST",
				url: 	"manage_admins.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Fetching admin list..."); 
				},
				success: function(response){
					var arrAdmin = response.split("|"); 
					for(var a = 0; a < arrAdmin.length; a++){
						self.adminList.push(JSON.parse(arrAdmin[a]));
					}
					self.loading(""); 
					self.showloading(false); 
				}
			});
		}());
		self.clearFields = function(){
			self.username("");
			self.password("");
			self.confirmpassword("");
			self.focused(true);
			self.saveMode("Save");
		}

	}

	ko.applyBindings(Admin);

}());
	

$(document).ready(function() {
    document.title = 'Knockout CMS | Manage Admins';
});