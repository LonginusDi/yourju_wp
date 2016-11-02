"use strict";
$ = jQuery.noConflict();
if ($("#ct-metabox-page-sidebar [name='_ct_sidebar_position']:checked").val() == 'no') {
	$("#_ct_sidebar_widget_area").closest(".rwmb-field").hide();
}
$("#ct-metabox-page-sidebar [name='_ct_sidebar_position']").click(function() {
	if ($(this).val() == 'no') {
		$("#_ct_sidebar_widget_area").closest(".rwmb-field").hide();
	} else {
		$("#_ct_sidebar_widget_area").closest(".rwmb-field").show();
	}
});