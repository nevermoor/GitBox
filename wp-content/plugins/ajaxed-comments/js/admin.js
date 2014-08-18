jQuery(document).ready(function($) {

	$('#ac_css_style, #ac_css_style_inline, #ac_delete_group, #ac_show_on_hover, #ac_edit_comm_effect, #ac_delete, #ac_comments_statuses, #ac_remove_message, #ac_logged_box, #ac_timer, #ac_notlogged_box, #ac_highlight_comments, #ac_hide_effect, #ac_show_effect').buttonset();

	if($('input#ac-highlight-comments-no').attr('checked')) {
		$('#ac_highlight_colors').closest('tr').hide();
	}

	if($('input#ac-timer-no').attr('checked')) {
		$('#ac_time_to_edit').closest('tr').hide();
	}

	//show colors
	$(document).on('click', 'input#ac-highlight-comments-yes', function(event) {
		$('#ac_highlight_colors').closest('tr').fadeIn(300);
	});

	//hide colors
	$(document).on('click', 'input#ac-highlight-comments-no', function(event) {
		$('#ac_highlight_colors').closest('tr').fadeOut(300);
	});

	//show timer
	$(document).on('click', 'input#ac-timer-yes', function(event) {
		$('#ac_time_to_edit').closest('tr').fadeIn(300);
	});

	//hide timer
	$(document).on('click', 'input#ac-timer-no', function(event) {
		$('#ac_time_to_edit').closest('tr').fadeOut(300);
	});

	$(document).on('click', 'input#ac-delete-yes', function(event) {
		$('#ac_delete_group').fadeIn(300);
	});

	$(document).on('click', 'input#ac-delete-no', function(event) {
		$('#ac_delete_group').fadeOut(300);
	});

	$('.ac-color-picker').wpColorPicker();
});