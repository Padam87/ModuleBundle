Module = {
	mainClicked: function(chkbox) {
		if ($(chkbox).is(":checked")) {
			$(chkbox).parents("div.well").eq(0).find("input[type=checkbox]").attr('checked','checked');
		}
		else {
			$(chkbox).parents("div.well").eq(0).find("input[type=checkbox]").attr('checked', false);
		}
	}
}
