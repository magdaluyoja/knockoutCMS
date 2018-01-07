(function(){
	var Subject = function(){
		var self = this;
		self.positionList = ko.observableArray();
		self.subjectList = ko.observableArray();
		self.menuName = ko.observable("");
		self.position = ko.observable();
		self.visible = ko.observable();

		self.saveMode = ko.observable("Save");
		self.currentId = null;

		self.focused = ko.observable(true);

		self.showloading = ko.observable(false);
		self.showmsg = ko.observable(false);
		self.msgClass = ko.observable("");
		self.loading = ko.observable("");
		self.msgs = ko.observable("");
		self.errMsg = null;

		self.isVisible = function(visible){
			if(visible == 1){
				return "Yes";
			}else{
				return "No";
			}
		};
		self.editSubject = function(subject){
			self.saveMode("Update");
			$.ajax({
				data: 	"action=editSubject&id="+subject.id,
				type: 	"POST",
				url: 	"manage_subjects.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Fetching menu data..."); 
				},
				success: function(response){
					self.showloading(false); 
					self.loading(""); 
					response = response.split(",");
					self.currentId = response[0];
					self.menuName(response[1]);
					self.position(response[2]);
					self.visible(response[3]);
					self.focused(true);
				}
			});
		};
		self.deleteSubject = function(subject){
			$.ajax({
				data: 	"action=deleteSubject&id="+subject.id,
				type: 	"POST",
				url: 	"manage_subjects.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Deleting menu data..."); 
				},
				success: function(response){
					response = response.replace(/\s/g, '');
					if(response == "successful"){
						self.subjectList.remove( function (item) { return item.id === subject.id; } );
						self.msgs('Menu deletion was successful.');
						self.msgClass("message");
						self.showmsg(true);
					}
					else{
						self.showmsg(true);
						self.msgClass("error");
						self.msgs(response);
					}
					self.showloading(false); 
					self.loading(""); 
				}
			});
		};
		self.saveSubject = function(form){
			self.errMsg = "";
			
			if(!self.menuName().replace(/\s/g, '').length){
				self.errMsg += "Menu name must not be empty. <br>";
			}
			if(!self.position().replace(/\s/g, '').length){
				self.errMsg += "Please select menu position. <br>";
			}
			if(!self.visible()){
				self.errMsg += "Please select visibility option. <br>";
			}
			if(!self.errMsg){
				$.ajax({
					data: 	$(form).serialize() + "&action=saveSubject&id="+self.currentId+"&mode="+self.saveMode(),
					type: 	"POST",
					url: 	"manage_subjects.php",
					beforeSend: function(){
						self.showloading(true); 
						self.loading("Saving menu..."); 
					},
					success: function(response){
						var arrResponse = response.split("|"); 

						var msg = arrResponse[0].replace(/\s/g, '');
						if(msg == "successful"){
							self.loading(""); 
							if(self.saveMode() === "Save"){
								self.msgs('Menu "'+ self.menuName() +'" was successfully saved.');
							}else{
								self.subjectList.remove( function (item) { return item.id === self.currentId.replace(/\s/g, ''); } );
								self.msgs('Menu "'+ self.menuName() +'" was successfully updated.');
							}
							var newMenu = JSON.parse(arrResponse[1]);
							self.subjectList.push(newMenu);	
							self.clearFields();
							self.msgClass("message");
						}
						else{
							self.msgs(self.errMsg);
							self.msgClass("error");
						}
						self.showmsg(true);
						self.showloading(false); 
						self.loading(""); 
					}
				});
			}else{
				self.msgs(self.errMsg);
				self.msgClass("error");
				self.showmsg(true);
			}
		};
		(function(){
			$.ajax({
				data: 	"action=getPositionSubjectList",
				type: 	"POST",
				url: 	"manage_subjects.php",
				beforeSend: function(){
					self.showloading(true); 
					self.loading("Fetching data..."); 
				},
				success: function(response){
					var arrResponse = response.split("|");
					self.showloading(false);
					self.loading("");

					self.positionList(arrResponse[0].split(","));
					var arrSubject = arrResponse[1].split("-"); 
					for(var a = 0; a < arrSubject.length; a++){
						self.subjectList.push(JSON.parse(arrSubject[a]));
					}
				}
			});
		}());
		self.clearFields = function(){
			self.menuName("");
			self.position(1);
			self.visible(false);
			self.saveMode("Save")
		}

	}

	ko.applyBindings(Subject);

}());
	

$(document).ready(function() {
    document.title = 'Knockout CMS | Manage Subjects';
});