(function(){
	var Page = function(){
		var self = this;
		self.subjectList = ko.observableArray();
		self.positionList = ko.observableArray();
		self.pageList = ko.observableArray();
		self.subjectId = ko.observable("");
		self.submenu_name = ko.observable("");
		self.position = ko.observable();
		self.visible = ko.observable();
		self.content = ko.observable("");

		self.saveMode = ko.observable("Save");
		self.currentId = null;

		self.showloading = ko.observable(false);
		self.showmsg = ko.observable(false);
		self.msgClass = ko.observable("");
		self.loading = ko.observable("");
		self.msgs = ko.observable("");
		self.errMsg = null;

		self.newcontent = function(content){
			return content.replace(/\\r|\\n/g, "<br/>").replace(/\\|\"/g, "");
		};

		self.isVisible = function(visible){
			if(visible == 1){
				return "Yes";
			}else{
				return "No";
			}
		};
		self.editPage = function(page){
			self.saveMode("Update");
			$.ajax({
				data: 	"action=editPage&id="+page.id,
				type: 	"POST",
				url: 	"manage_pages.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Fetching submenu data..."); 
				},
				success: function(response){
					response = response.split(",");
					self.currentId = response[0];
					self.subjectId(response[1]);
					self.submenu_name(response[2]);
					self.position(response[3]);
					self.visible(response[4]);
					self.content(response[5].replace(/<br\s*\/?>/g,'\n'));

					self.loading(""); 
					self.showloading(false); 
				}
			});
		};
		self.deletePage = function(page){
			$.ajax({
				data: 	"action=deletePage&id="+page.id,
				type: 	"POST",
				url: 	"manage_pages.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Deleting submenu data..."); 
				},
				success: function(response){
					response = response.replace(/\s/g, '');
					if(response == "successful"){
						self.pageList.remove( function (item) { return item.id === page.id; } );
						self.msgs('Submenu deletion was successful.');
						self.msgClass("message");
					}
					else{
						self.msgs(response);
						self.msgClass("error");
					}
					self.showmsg(true);
					self.loading(""); 
					self.showloading(false); 
				}
			});
		};
		self.savePage = function(form){
			self.errMsg = "";
			
			if(!self.subjectId()){
				self.errMsg += "Please select menu name. <br>";
			}
			if(!self.submenu_name().replace(/\s/g, '').length){
				self.errMsg += "Sub menu name must not be empty. <br>";
			}
			if(!self.position().replace(/\s/g, '').length){
				self.errMsg += "Please select menu position. <br>";
			}
			if(!self.visible()){
				self.errMsg += "Please select visibility option. <br>";
			}
			if(!self.content().replace(/\s/g, '').length){
				self.errMsg += "Content must not be empty. <br>";
			}
			if(!self.errMsg){
				var data = $(form).serialize() + "&action=savePage&id="+self.currentId+"&mode="+self.saveMode();
				$.ajax({
					data: 	data,
					type: 	"POST",
					url: 	"manage_pages.php",
					beforeSend: function(){
						self.showloading(true);
						self.loading("Saving menu..."); 
					},
					success: function(response){
						var arrResponse = response.split("|"); 

						var msg = arrResponse[0].replace(/\s/g, '');
						if(msg == "successful"){
							self.loading(""); 
							self.showloading(false);
							if(self.saveMode() === "Save"){
								self.msgs('Submenu "'+ self.submenu_name() +'" was successfully saved.');
							}else{
								self.pageList.remove( function (item) { return item.id === self.currentId.replace(/\s/g, ''); } );
								self.msgs('Submenu "'+ self.submenu_name() +'" was successfully updated.');
							}
							var newMenu = JSON.parse(arrResponse[1]);
							self.pageList.push(newMenu);	
							self.clearFields();
							self.msgClass("message");
						}
						else{
							self.loading(""); 
							self.msgClass("error");
							self.msgs(msg);
						}
						self.showmsg(true);
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
				data: 	"action=getPositionPageList",
				type: 	"POST",
				url: 	"manage_pages.php",
				beforeSend: function(){
					self.showloading(true);
					self.loading("Fetching data..."); 
				},
				success: function(response){
					var arrResponse = response.split("|");
					self.loading("");
					self.showloading(false);
					self.positionList((arrResponse[0].split(",")));
					var arrSubject = arrResponse[1].split("-"); 
					for(var a = 0; a < arrSubject.length; a++){
						self.subjectList.push(JSON.parse(arrSubject[a]));
					}
					var arrPage = arrResponse[2].split("-"); 
					for(var a = 0; a < arrPage.length; a++){
						self.pageList.push(JSON.parse(arrPage[a]));
					}
				}
			});
		}());
		self.clearFields = function(){
			self.subjectId("");
			self.submenu_name("");
			self.content("");
			self.position("1");
			self.visible(false);
			self.saveMode("Save")
		}

	}

	ko.applyBindings(Page);

}());
	

$(document).ready(function() {
    document.title = 'Knockout CMS | Manage Pages';
});