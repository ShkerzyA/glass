createNode=function(parent) {
		var current = $("<li/>").attr("id", this.id || "").attr("control", this.control || "").html("<span>123<a href=/glass/Department/"+ this.id + ">" + this.text + "</a></span>").appendTo(parent);
		if (this.classes) {
			current.children("span").addClass(this.classes);
		}
		if (this.expanded) {
			current.addClass("open");
		}
		if (this.hasChildren || this.children && this.children.length) {
			var branch = $("<ul/>").appendTo(current);
			if (this.hasChildren) {
				current.addClass("hasChildren");
				createNode.call({
					classes: "placeholder",
					text: "&nbsp;",
					children:[]
				}, branch);
			}
			if (this.children && this.children.length) {
				$.each(this.children, createNode, [branch])
			}
		}

		if (this.control) {
			settings.url='/glass/'+this.control+'/ajaxFillTree';
		}
	}
