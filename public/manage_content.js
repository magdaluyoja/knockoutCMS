(function(){
	var WidgetCorp = function(){
		var self = this;

		self.loading = ko.observable("");
		self.subjectVisible = ko.observable(false);
		self.pageVisible = ko.observable(false);
		self.selected = ko.observable("");

		self.menu_name = ko.observable("");

		self.subjects = ko.observableArray();
		self.pageList = ko.observableArray();
		self.pageData = ko.observableArray();

		self.isSelected = ko.pureComputed(function() {
			return self.selected();
		});
		self.newcontent = function(content){
			return content.replace(/\\r|\\n/g, "<br/>").replace(/\\|\"/g, "");
		};
		self.getSubjectContent = function(subject){
			$.ajax({
				data: "action=getSubjectContent&subjectId="+subject.menu_id,
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.loading("Fetching data..."); 
				},
				success:function(response){
					self.pageList(JSON.parse(response));
					self.loading(""); 
					self.subjectVisible(true);
					self.pageVisible(false);
					self.selected("selected");
				}
			});
		};
		self.getPageContent = function(page){
			$.ajax({
				data: "action=getPageContent&pageId="+page.sub_menu_id,
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.loading("Fetching data..."); 
				},
				success:function(response){
					self.pageData(JSON.parse(response));
					self.loading(""); 
					self.pageVisible(true);
					self.subjectVisible(false);
					self.selected("selected");
				}
			});
		};

		(function(){
			$.ajax({
				data: "action=getSubjects",
				type: "POST",
				url:"manage_content.php",
				beforeSend:function(){
					self.loading("Fetching data..."); 
				},
				success:function(response){
					var arrMenu = response.split("|");
					for(var a = 0; a < arrMenu.length; a++){
						self.subjects.push(JSON.parse(arrMenu[a]));
					}
					self.loading(""); 
				}
			});
		}());
	}

	
	ko.applyBindings(new WidgetCorp());
}());