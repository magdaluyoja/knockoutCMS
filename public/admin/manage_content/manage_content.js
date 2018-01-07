(function(){
	var WidgetCorp = function(){
		var self = this;

		self.loading = ko.observable("");
		self.subjectVisible = ko.observable(false);
		self.pageVisible = ko.observable(false);
		self.selected = ko.observable("");

		self.menu_name = ko.observable("");
		self.position = ko.observable("");
		self.visible = ko.observable("");

		self.subjects = ko.observableArray();
		self.pageList = ko.observableArray();
		self.pageData = ko.observableArray();

		self.showloading = ko.observable(false);
		self.isSelected = ko.pureComputed(function() {
			return self.selected();
		});
		self.isVisible = function(visible){
			if(visible == 1){
				return "Yes";
			}else{
				return "No";
			}
		};
		self.newcontent = function(content){
			return content.replace(/\\r|\\n/g, "<br/>").replace(/\\|\"/g, "");
		};
		self.getSubjectContent = function(subject){
			$.ajax({
				data: "action=getSubjectContent&subjectId="+subject.menu_id,
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.showloading(true);
					self.loading("Fetching data..."); 
				},
				success:function(response){
					response = response.split("|");
					var subjectArr = response[0].split(",");
					var pageArr = response[1].split(",");
					self.pageList(pageArr);
					self.menu_name(subjectArr[1]);
					self.position(subjectArr[2]);
					self.visible(subjectArr[3] == 1 ? "Yes" : "No");
					self.subjectVisible(true);
					self.pageVisible(false);
					self.selected("selected");
					self.loading(""); 
					self.showloading(false);
				}
			});
		};
		self.getPageContent = function(page){
			$.ajax({
				data: "action=getPageContent&pageId="+page.sub_menu_id,
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.showloading(true);
					self.loading("Fetching data..."); 
				},
				success:function(response){
					self.pageData(JSON.parse(response));
					self.pageVisible(true);
					self.subjectVisible(false);
					self.selected("selected");
					self.loading(""); 
					self.showloading(false);
				}
			});
		};

		(function(){
			$.ajax({
				data: "action=getSubjects",
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.showloading(true);
					self.loading("Fetching data..."); 
				},
				success:function(response){
					var arrMenu = response.split("|");
					for(var a = 0; a < arrMenu.length; a++){
						self.subjects.push(JSON.parse(arrMenu[a]));
					}
					self.loading(""); 
					self.showloading(false);
				}
			});
		}());
	}

	
	ko.applyBindings(new WidgetCorp());
}());