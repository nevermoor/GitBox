function AjaxedCommentsShowEffect(element) {
	if(acArgs.showEffect === 'fade') {
		jQuery(element).fadeIn(300);
	} else if(acArgs.showEffect === 'slide') {
		jQuery(element).slideDown(300);
	}
}


function AjaxedCommentsHideEffect(element) {
	if(acArgs.hideEffect === 'fade') {
		jQuery(element).fadeOut(300);
	} else if(acArgs.hideEffect === 'slide') {
		jQuery(element).slideUp(300);
	}
}


jQuery(document).ready(function($) {

	var textareaCommentOld = '';
	var actionApprove = 0;
	var actionUnapprove = 0;
	var actionTrash = 0;
	var actionUntrash = 0;
	var actionSpam = 0;
	var actionUnspam = 0;


	//enable timer
	if(acArgs.timer === 'yes') {
		//starts timer for specific comments
		$.each($('span.ac-timer'), function() {

			$(this).countdown({
				until: parseInt($(this).attr('rel').split('|')[1]),
				format: 'MS',
				timeSeparator: ':',
				compact: true,
				compactLabels: ['', '', '', '', '', '', ''],
				compactLabels1: ['', '', '', '', '', '', ''],
				layout: '{mn}{sep}{snn}</b>',
				onExpiry: removeEditAction
			});
		});
	}


	//show inline actions on hover
	if(acArgs.hideInlineActions === 'yes') {
		$(document).on('mouseenter', '.ac-top-comment', function() {

			$(this).find('.ac-comment-edit').removeClass('ac-hide-row-actions');
		});

		$(document).on('mouseleave', '.ac-top-comment', function() {

			$(this).find('.ac-comment-edit').addClass('ac-hide-row-actions');
		});
	}


	//remove edit|save|close actions when the countdown reaches zero
	function removeEditAction() {

		var divAction = $(this).closest('div');
		var commId = $(this).attr('rel').split('|')[0];
		var commTextarea = $('#ac-textarea-'+commId);
		var commSection = $('#ac-section-'+commId);

		if(commSection.css('display') === 'none') {
			if(acArgs.editCommEffect === 'fade') {
				commTextarea.fadeOut(300, function() {
					commSection.fadeIn(300);
					commTextarea.remove();
				});
			} else if(acArgs.editCommEffect === 'slide') {
				commTextarea.slideUp(300, function() {
					commSection.slideDown(300);
					commTextarea.remove();
				});
			}
		}

		if(acArgs.editCommEffect === 'fade') {
			divAction.fadeOut(300, function() {
				divAction.remove();
			});
		} else if(acArgs.editCommEffect === 'slide') {
			divAction.slideUp(300, function() {
				divAction.remove();
			});
		}
	}


	//makes effects with edit|cancel|save actions
	function AjaxedCommentsEditCommentEffect(id, type, content) {

		if(type === 'remove') {
			if(acArgs.editCommEffect === 'fade') {
				id.fadeOut(300, function() {
					id.remove();
				});
			} else if(acArgs.editCommEffect === 'slide') {
				id.slideUp(300, function() {
					id.remove();
				});
			}
		} else {
			var divTextarea = $('#ac-textarea-'+id);
			var section = $('#ac-section-'+id);
			var textareaPadding = parseInt($('textarea').css('padding-left'), 10) + parseInt($('textarea').css('padding-right'), 10);

			divTextarea.width($(section).width() - textareaPadding);

			if(type === 'show') {
				if(acArgs.editCommEffect === 'fade') {
					section.fadeOut(300, function() {
						divTextarea.fadeIn(300);
					});
				} else if(acArgs.editCommEffect === 'slide') {
					section.slideUp(300, function() {
						divTextarea.slideDown(300);
					});
				}
			} else if(type === 'hide') {
				if(acArgs.editCommEffect === 'fade') {
					divTextarea.fadeOut(300, function() {
						section.fadeIn(300);

						if(content !== '') {
							section.html(content);
						}
					});
				} else if(acArgs.editCommEffect === 'slide') {
					divTextarea.slideUp(300, function() {
						section.slideDown(300);

						if(content !== '') {
							section.html(content);
						}
					});
				}
			}
		}
	}


	function deactivateActions(element, type) {

		if(type === 'edit' || type === 'delete') {
			actionApprove = element.find('a.comment-ac-approve-link').length;
			actionUnapprove = element.find('a.comment-ac-unapprove-link').length;
			actionTrash = element.find('a.comment-ac-trash-link').length;
			actionUntrash = element.find('a.comment-ac-untrash-link').length;
			actionSpam = element.find('a.comment-ac-spam-link').length;
			actionUnspam = element.find('a.comment-ac-unspam-link').length;
		}

		$.each(element.find('a'), function() {
			if(type === 'save') {
				if(!($(this).hasClass('comment-ac-edit-link'))) {
					$(this).replaceWith('<span class="'+$(this).attr('class')+'" href="'+$(this).attr('href')+'" rel="'+$(this).attr('rel')+'">'+$(this).html()+'</span>');
				}
			} else if(type === 'edit') {
				if(!($(this).hasClass('comment-ac-cancel-link') || $(this).hasClass('comment-ac-save-link'))) {
					$(this).replaceWith('<span class="'+$(this).attr('class')+' disabled" href="'+$(this).attr('href')+'" rel="'+$(this).attr('rel')+'">'+$(this).html()+'</span>');
				}
			} else {
				$(this).replaceWith('<span class="'+$(this).attr('class')+'" href="'+$(this).attr('href')+'" rel="'+$(this).attr('rel')+'">'+$(this).html()+'</span>');
			}
		});
	}


	function activateActions(action, element, type, class1, class2, text) {

		$.each(element.find('.comment-ac-edit-link, .comment-ac-cancel-link, .comment-ac-save-link, .comment-ac-delete-link'), function() {
			$(this).replaceWith('<a class="'+$(this).attr('class')+'" href="'+$(this).attr('href')+'" rel="'+$(this).attr('rel')+'">'+$(this).html()+'</a>');
		});

		var foEl = element.find('.'+action);

		if(type === 'success') {
			if(action === 'comment-ac-trash-link') {
				foEl.replaceWith('<a class="comment-ac-untrash-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				element.find('.comment-ac-spam-link').addClass('disabled');
				element.find('.comment-ac-unapprove-link').addClass('disabled');
				element.find('.comment-ac-approve-link').addClass('disabled');

			} else if(action === 'comment-ac-spam-link') {
				foEl.replaceWith('<a class="comment-ac-unspam-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				element.find('.comment-ac-trash-link').addClass('disabled');
				element.find('.comment-ac-unapprove-link').addClass('disabled');
				element.find('.comment-ac-approve-link').addClass('disabled');

			} else if(action === 'comment-ac-approve-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-trash-link');

				foEl.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');

			} else if(action === 'comment-ac-cancel-link' || action === 'comment-ac-save-link') {
				element.find('.comment-ac-edit-link').removeClass('disabled');
				element.find('.comment-ac-delete-link').removeClass('disabled');

				if(actionApprove === 1) {
					var foEl1 = element.find('span.comment-ac-approve-link');

					foEl1.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUnapprove === 1) {
					var foEl1 = element.find('span.comment-ac-unapprove-link');

					foEl1.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}

				if(actionTrash === 1) {
					var foEl1 = element.find('span.comment-ac-trash-link');

					foEl1.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUntrash === 1) {
					var foEl1 = element.find('span.comment-ac-untrash-link');

					foEl1.replaceWith('<a class="comment-ac-untrash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}

				if(actionSpam === 1) {
					var foEl1 = element.find('span.comment-ac-spam-link');

					foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUnspam === 1) {
					var foEl1 = element.find('span.comment-ac-unspam-link');

					foEl1.replaceWith('<a class="comment-ac-unspam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}

			} else if(action === 'comment-ac-untrash-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-approve-link');
				var foEl3 = element.find('.comment-ac-unapprove-link');

				foEl.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
				foEl3.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl3.attr('href')+'" rel="'+foEl3.attr('rel')+'">'+foEl3.html()+'</a>');

			} else if(action === 'comment-ac-unspam-link') {
				var foEl1 = element.find('.comment-ac-trash-link');
				var foEl2 = element.find('.comment-ac-approve-link');
				var foEl3 = element.find('.comment-ac-unapprove-link');

				foEl.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				foEl1.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
				foEl3.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl3.attr('href')+'" rel="'+foEl3.attr('rel')+'">'+foEl3.html()+'</a>');

			} else if(action === 'comment-ac-unapprove-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-trash-link');

				foEl.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+text+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
			}
		} else if(type === 'fail') {
			if(action === 'comment-ac-trash-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-approve-link');
				var foEl3 = element.find('.comment-ac-unapprove-link');

				foEl.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
				foEl3.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl3.attr('href')+'" rel="'+foEl3.attr('rel')+'">'+foEl3.html()+'</a>');

			} else if(action === 'comment-ac-spam-link') {
				var foEl1 = element.find('.comment-ac-trash-link');
				var foEl2 = element.find('.comment-ac-approve-link');
				var foEl3 = element.find('.comment-ac-unapprove-link');

				foEl.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');
				foEl1.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
				foEl3.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl3.attr('href')+'" rel="'+foEl3.attr('rel')+'">'+foEl3.html()+'</a>');

			} else if(action === 'comment-ac-approve-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-trash-link');

				foEl.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');

			} else if(action === 'comment-ac-untrash-link') {
				foEl.replaceWith('<a class="comment-ac-untrash-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');

			} else if(action === 'comment-ac-unspam-link') {
				foEl.replaceWith('<a class="comment-ac-unspam-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');

			} else if(action === 'comment-ac-unapprove-link') {
				var foEl1 = element.find('.comment-ac-spam-link');
				var foEl2 = element.find('.comment-ac-trash-link');

				foEl.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl.attr('href')+'" rel="'+foEl.attr('rel')+'">'+foEl.html()+'</a>');
				foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				foEl2.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl2.attr('href')+'" rel="'+foEl2.attr('rel')+'">'+foEl2.html()+'</a>');
			} else if(action === 'comment-ac-delete-link') {
				if(actionApprove === 1) {
					var foEl1 = element.find('span.comment-ac-approve-link');

					foEl1.replaceWith('<a class="comment-ac-approve-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUnapprove === 1) {
					var foEl1 = element.find('span.comment-ac-unapprove-link');

					foEl1.replaceWith('<a class="comment-ac-unapprove-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}

				if(actionTrash === 1) {
					var foEl1 = element.find('span.comment-ac-trash-link');

					foEl1.replaceWith('<a class="comment-ac-trash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUntrash === 1) {
					var foEl1 = element.find('span.comment-ac-untrash-link');

					foEl1.replaceWith('<a class="comment-ac-untrash-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}

				if(actionSpam === 1) {
					var foEl1 = element.find('span.comment-ac-spam-link');

					foEl1.replaceWith('<a class="comment-ac-spam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				} else if(actionUnspam === 1) {
					var foEl1 = element.find('span.comment-ac-unspam-link');

					foEl1.replaceWith('<a class="comment-ac-unspam-link'+class1+class2+'" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</a>');
				}
			} else if(action === 'comment-ac-save-link') {
				var foEl1 = element.find('a.comment-ac-delete-link');

				element.find('a.comment-ac-edit-link').hide();
				foEl1.replaceWith('<span class="comment-ac-delete-link'+class1+class2+' disabled" href="'+foEl1.attr('href')+'" rel="'+foEl1.attr('rel')+'">'+foEl1.html()+'</span>');
			}
		}
	}


	//edit comment
	$(document).on('click', 'a.comment-ac-edit-link', function(event) {

		var id = $(this).attr('rel');
		var thisEl = $(this).closest('div');

		deactivateActions(thisEl, 'edit');
		textareaCommentOld = $('#ac-textarea-'+id+' textarea').val();
		AjaxedCommentsEditCommentEffect(id, 'show', '');

		thisEl.find('span.comment-ac-edit-link').hide();
		thisEl.find('span.edit-comment-actions').show();

		return false;
	});


	//cancel comment
	$(document).on('click', 'a.comment-ac-cancel-link', function(event) {

		var id = $(this).attr('rel').split('|');
		var thisEl = $(this).closest('div');
		var clickedLinkClass = $(this).context.className.split(' ');
		var class1 = (clickedLinkClass.length > 1 ? ' '+clickedLinkClass[1] : '');
		var class2 = (clickedLinkClass.length > 2 ? ' '+(clickedLinkClass[2] !== 'disabled' ? clickedLinkClass[2] : '') : '');

		activateActions('comment-ac-cancel-link', thisEl, 'success', class1, class2, '');
		AjaxedCommentsEditCommentEffect(id[0], 'hide', '');

		thisEl.find('.comment-ac-edit-link').show();
		thisEl.find('.edit-comment-actions').hide();

		return false;
	});


	//save comment
	$(document).on('click', 'a.comment-ac-save-link', function(event) {

		var commInfo = $(this).attr('rel').split('|');
		var commBox = $('#ac-cid-'+commInfo[0]);
		var commBoxInside = $('#ac-cid-'+commInfo[0]+' div');
		var textareaCommentNew = $.trim($('#ac-textarea-'+commInfo[0]+' textarea').val());
		var commElementEditLink = $(this).closest('div').find('a.comment-ac-edit-link');
		var commElementEditActions = $(this).closest('div').find('span.edit-comment-actions');
		var commElementSpinner = $(this).closest('div').find('.ac-comm-spinner');
		var commElementActions = $(this).closest('div');
		var clickedLinkClass = $(this).context.className.split(' ');
		var class1 = (clickedLinkClass.length > 1 ? ' '+clickedLinkClass[1] : '');
		var class2 = (clickedLinkClass.length > 2 ? ' '+(clickedLinkClass[2] !== 'disabled' ? clickedLinkClass[2] : '') : '');

		deactivateActions(commElementActions, 'save');

		if(textareaCommentNew === '') {
			commBoxInside.html(acArgs.errEmptyComment);
			AjaxedCommentsShowEffect(commBox);

			if(acArgs.timeToHide > 0) {
				setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
			}
		}
		else if($.trim(textareaCommentOld) === textareaCommentNew) {
			AjaxedCommentsEditCommentEffect(commInfo[0], 'hide', '');
			commElementEditLink.show();
			commElementEditActions.hide();
			activateActions('comment-ac-save-link', commElementActions, 'success', class1, class2, '');
		} else {
			commElementSpinner.css('display', 'inline-block');

			$.ajax({
				type: 'POST',
				url: acArgs.ajaxurl,
				data: {
					action: 'ac-save-comment',
					comm_id: commInfo[0],
					nonce: commInfo[1],
					form: $('#ac-textarea-'+commInfo[0]+' textarea').val()
				},
				dataType: 'html'
			})
			.done(function(data) {
				commElementSpinner.hide();

				if(data !== '') {
					AjaxedCommentsEditCommentEffect(commInfo[0], 'hide', data);
					commElementEditLink.show();
					commElementEditActions.hide();
					activateActions('comment-ac-save-link', commElementActions, 'success', class1, class2, '');
				} else {
					activateActions('comment-ac-save-link', commElementActions, 'fail', class1, class2, '');
					commBoxInside.html(acArgs.errUnknown);
					AjaxedCommentsShowEffect(commBox);

					if(acArgs.timeToHide > 0) {
						setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
					}
				}
			}).fail(function(data) {
				commElementSpinner.hide();
				activateActions('comment-ac-save-link', commElementActions, 'fail', class1, class2, '');
				commBoxInside.html(acArgs.errUnknown);
				AjaxedCommentsShowEffect(commBox);

				if(acArgs.timeToHide > 0) {
					setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
				}
			});
		}

		return false;
	});


	//delete comment
	$(document).on('click', 'a.comment-ac-delete-link', function(event) {

		if(confirm(acArgs.deleteComment)) {
			var clickedLink = $(this).closest('.ac-top-comment');
			var commElementActions = $(this).closest('div');
			var commInfo = $(this).attr('rel').split('|');
			var commElementSpinner = $(this).closest('div').find('.ac-comm-spinner');
			var commBox = $('#ac-cid-'+commInfo[0]);
			var commBoxInside = $('#ac-cid-'+commInfo[0]+' div');
			var clickedLinkClass = $(this).context.className.split(' ');
			var class1 = (clickedLinkClass.length > 1 ? ' '+clickedLinkClass[1] : '');
			var class2 = (clickedLinkClass.length > 2 ? ' '+(clickedLinkClass[2] !== 'disabled' ? clickedLinkClass[2] : '') : '');

			deactivateActions(commElementActions, 'delete');
			commElementSpinner.css('display', 'inline-block');

			$.ajax({
				type: 'POST',
				url: acArgs.ajaxurl,
				data: {
					action: 'ac-delete-comment',
					comm_id: commInfo[0],
					nonce: commInfo[1]
				},
				dataType: 'html'
			})
			.done(function(data) {
				commElementSpinner.hide();

				if(data === 'AC_OK') {
					AjaxedCommentsEditCommentEffect(clickedLink, 'remove', '');
				} else {
					activateActions('comment-ac-delete-link', commElementActions, 'fail', class1, class2, '');
					commBoxInside.html(acArgs.errUnknown);
					AjaxedCommentsShowEffect(commBox);

					if(acArgs.timeToHide > 0) {
						setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
					}
				}
			}).fail(function(data) {
				commElementSpinner.hide();
				activateActions('comment-ac-delete-link', commElementActions, 'fail', class1, class2, '');
				commBoxInside.html(acArgs.errUnknown);
				AjaxedCommentsShowEffect(commBox);

				if(acArgs.timeToHide > 0) {
					setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
				}
			});
		}

		return false;
	});


	//trash|untrash|spam|unspam|approve|unapprove comment
	$(document).on('click', 'a.comment-ac-trash-link, a.comment-ac-untrash-link, a.comment-ac-spam-link, a.comment-ac-unspam-link, a.comment-ac-approve-link, a.comment-ac-unapprove-link', function(event) {

		var clickedLinkClass = $(this).context.className.split(' ');
		var commInfo = $(this).attr('rel').split('|');
		var commElementColor = $(this).closest('.ac-top-comment');
		var commElement = $(this).closest('.ac-top-comment').children('');
		var commElementActions = $(this).closest('div');
		var commElementSpinner = $(this).closest('div').find('.ac-comm-spinner');
		var commApproved = $(this).closest('div').find('.comment-ac-approve-link');
		var commUnapproved = $(this).closest('div').find('.comment-ac-unapprove-link');
		var clickedClass = clickedLinkClass[0];
		var clickedLink = $(this);
		var commBox = $('#ac-cid-'+commInfo[0]);
		var commBoxInside = $('#ac-cid-'+commInfo[0]+' div');
		var addedClass = '';
		var ajaxAction = '';
		var ajaxText = '';
		var bgColor = '';
		var class1 = (clickedLinkClass.length > 1 ? ' '+clickedLinkClass[1] : '');
		var class2 = (clickedLinkClass.length > 2 ? ' '+(clickedLinkClass[2] !== 'disabled' ? clickedLinkClass[2] : '') : '');
		var changeType = '';

		deactivateActions(commElementActions, '');
		commElementSpinner.css('display', 'inline-block');

		if(clickedClass === 'comment-ac-trash-link') {
			addedClass = 'comment-ac-untrash-link';
			ajaxAction = 'ac-trash-comment';
			ajaxText = acArgs.untrash;
			bgColor = acArgs.trashColor;
			changeType = 'off';
		} else if(clickedClass === 'comment-ac-untrash-link') {
			addedClass = 'comment-ac-trash-link';
			ajaxAction = 'ac-untrash-comment';
			ajaxText = acArgs.trash;
			bgColor = (commApproved.length === 1 ? acArgs.holdColor : 'transparent');
			changeType = 'on';
		} else if(clickedClass === 'comment-ac-spam-link') {
			addedClass = 'comment-ac-unspam-link';
			ajaxAction = 'ac-spam-comment';
			ajaxText = acArgs.unspam;
			bgColor = acArgs.spamColor;
			changeType = 'off';
		} else if(clickedClass === 'comment-ac-unspam-link') {
			addedClass = 'comment-ac-spam-link';
			ajaxAction = 'ac-unspam-comment';
			ajaxText = acArgs.spam;
			bgColor = (commApproved.length === 1 ? acArgs.holdColor : 'transparent');
			changeType = 'on';
		} else if(clickedClass === 'comment-ac-approve-link') {
			addedClass = 'comment-ac-unapprove-link';
			ajaxAction = 'ac-approve-comment';
			ajaxText = acArgs.unapprove;
			bgColor = 'transparent';
		} else if(clickedClass === 'comment-ac-unapprove-link') {
			addedClass = 'comment-ac-approve-link';
			ajaxAction = 'ac-unapprove-comment';
			ajaxText = acArgs.approve;
			bgColor = acArgs.holdColor;
		}

		$.ajax({
			type: 'POST',
			url: acArgs.ajaxurl,
			data: {
				action: ajaxAction,
				comm_id: commInfo[0],
				nonce: commInfo[1]
			},
			dataType: 'html'
		})
		.done(function(data) {
			commElementSpinner.hide();

			if(data === 'AC_OK') {
				activateActions(clickedClass, commElementActions, 'success', class1, class2, ajaxText);

				if(acArgs.highlightComments === 'yes') {
					

					$.each(commElement, function() {
						if($(this).find('#ac-section-'+commInfo[0]).length === 1) {
							if(commElementColor.hasClass('ac-full-spam') || commElementColor.hasClass('ac-full-hold') || commElementColor.hasClass('ac-full-trash')) {
								$(this).css('backgroundColor', $(this).css('backgroundColor'));
								commElementColor.removeClass('ac-full-spam ac-full-hold ac-full-trash');
							}

							$(this).animate({backgroundColor: bgColor}, 300);
						}
					});
				}
			} else {
				activateActions(clickedClass, commElementActions, 'fail', class1, class2, '');
				commBoxInside.html(acArgs.errUnknown);
				AjaxedCommentsShowEffect(commBox);

				if(acArgs.timeToHide > 0) {
					setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
				}
			}
		}).fail(function(data) {
			commElementSpinner.hide();
			activateActions(clickedClass, commElementActions, 'fail', class1, class2, '');
			commBoxInside.html(acArgs.errUnknown);
			AjaxedCommentsShowEffect(commBox);

			if(acArgs.timeToHide > 0) {
				setTimeout('AjaxedCommentsHideEffect("#ac-cid-'+commInfo[0]+'")', acArgs.timeToHide * 1000);
			}
		});

		return false;
	});


	//new comment
	$(document).on('submit', '#commentform', function(event) {

		$('#ac-spinner').css('display', 'inline-block');

		$.ajax({
			type: 'POST',
			url: acArgs.ajaxurl,
			data: {
				action: 'ac-add-new-comment',
				form: $(this).serialize(),
				nonce: $('#ajaxed-comments-box').attr('rel')
			},
			dataType: 'html'
		})
		.done(function(data) {
			if(data === '-1') {
				$('#ajaxed-comments .ac-inside-box').html(acArgs.errUnknownReloadPage);
				AjaxedCommentsShowEffect('#ajaxed-comments');

				if(acArgs.timeToHide > 0) {
					setTimeout('AjaxedCommentsHideEffect("#ajaxed-comments")', acArgs.timeToHide * 1000);
				}
			} else {
				try {
					var acJson = $.parseJSON(data);

					if(acJson.info === 'AC_COMMENT_ADDED') {
						document.location.href = acJson.loc;
						document.location.reload(true);
					}
				} catch (e) {
					document.location.href = '#ajaxed-comments';
					$('#ajaxed-comments .ac-inside-box').html(data);
					AjaxedCommentsShowEffect('#ajaxed-comments');

					if(acArgs.timeToHide > 0) {
						setTimeout('AjaxedCommentsHideEffect("#ajaxed-comments")', acArgs.timeToHide * 1000);
					}
				}
			}

			$('span#ac-spinner').hide();
		}).fail(function(data) {
			$('#ajaxed-comments .ac-inside-box').html(acArgs.errUnknown);
			AjaxedCommentsShowEffect('#ajaxed-comments');
			$('span#ac-spinner').hide();

			if(acArgs.timeToHide > 0) {
				setTimeout('AjaxedCommentsHideEffect("#ajaxed-comments")', acArgs.timeToHide * 1000);
			}
		});

		return false;
	});
});