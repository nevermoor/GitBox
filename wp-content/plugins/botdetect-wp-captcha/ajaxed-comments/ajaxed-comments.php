<?php
/*
Plugin Name: Ajaxed Comments
Description: Ajaxed Comments adds AJAX to WordPress comments. It enables editing comments inline, AJAX moderation, error handling and time limited comment editing.
Version: 1.0.6
Author: dFactory
Author URI: http://www.dfactory.eu/
Plugin URI: http://www.dfactory.eu/plugins/ajaxed-comments/
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: ajaxed-comments
Domain Path: /languages

Ajaxed Comments
Copyright (C) 2013, Digital Factory - info@digitalfactory.pl

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


class AjaxedComments
{
	private $options = array(
		'inline-edit' => array(
			'comments_statuses' => array('approve'),
			'css_style' => 'wp-default',
			'edit_comm_effect' => 'fade',
			'delete_button' => 'no',
			'delete_group' => 'admins',
			'show_actions_on_hover' => 'no',
			'timer' => 'yes',
			'time_to_edit' => 5,
			'highlight_comments' => 'yes',
			'highlight_colors' => array(
				'spam' => '#fff1cc',
				'trash' => '#ffaaaa',
				'unapproved' => '#ffffe0'
			)
		),
		'messages' => array(
			'pos_not_logged' => 'comment_form_before_fields',
			'pos_logged' => 'comment_form_logged_in_after',
			'remove_message' => 3,
			'show_effect' => 'fade',
			'hide_effect' => 'fade',
			'css_style' => 'wp-default'
		)
	);
	private $styles = array();
	private $rem_msgs = array();
	private $positions = array();
	private $comments_statuses = array();
	private $comments = array();
	private $tabs = array();
	private $statuses = array();
	private $choice = array();
	private $amount_of_comments = '';
	private $timer = FALSE;
	private $time_left = 0;


	public function __construct()
	{
		register_activation_hook(__FILE__, array(&$this, 'activation'));
		register_deactivation_hook(__FILE__, array(&$this, 'deactivation'));

		//actions
		add_action('plugins_loaded', array(&$this, 'load_textdomain'));
		add_action('plugins_loaded', array(&$this, 'load_defaults'));
		add_action('admin_init', array(&$this, 'register_settings'));
		add_action('admin_menu', array(&$this, 'admin_menu_options'));
		add_action('wp_ajax_ac-add-new-comment', array(&$this, 'ajax_add_new_comment'), 1000);
		add_action('wp_ajax_nopriv_ac-add-new-comment', array(&$this, 'ajax_add_new_comment'), 1000);
		add_action('wp_ajax_ac-save-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_nopriv_ac-save-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-trash-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-untrash-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-spam-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-unspam-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-approve-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-unapprove-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_ac-delete-comment', array(&$this, 'ajax_comments'));
		add_action('wp_ajax_nopriv_ac-delete-comment', array(&$this, 'ajax_comments'));
		add_action('wp_enqueue_scripts', array(&$this, 'front_comments_scripts_styles'));
		add_action('admin_enqueue_scripts', array(&$this, 'admin_comments_scripts_styles'));
		add_action('comments_array', array(&$this, 'get_specified_comments'), 10, 2);

		//filters
		add_filter('comment_id_fields', array(&$this, 'comment_form_spinner'));
		add_filter('comment_text', array(&$this, 'get_comment_text'), 1);
		add_filter('comment_text', array(&$this, 'add_section_to_comment'), 1000);
		add_filter('comment_class', array(&$this, 'add_comment_class'));
		add_filter('get_comments_number', array(&$this, 'get_comments_amount'), 10, 2);
		add_filter('plugin_action_links', array(&$this, 'plugin_settings_link'), 10, 2);
		add_filter('plugin_row_meta', array(&$this, 'plugin_extend_links'), 10, 2);
		add_filter('edit_comment_link', array(&$this, 'add_inline_actions'), 10, 2);
		add_filter('user_has_cap', array(&$this, 'force_edit_comments'), 10, 3);
	}


	public function add_comment_class($classes)
	{
		global $comment;

		$classes[] = 'ac-top-comment';
		$classes[] = 'ac-full-'.$this->statuses[$comment->comment_approved];

		return $classes;
	}


	private function sort_comments_desc($element_a, $element_b)
	{
		return strnatcasecmp($element_b->comment_date, $element_a->comment_date);
	}


	private function sort_comments_asc($element_a, $element_b)
	{
		return strnatcasecmp($element_a->comment_date, $element_b->comment_date);
	}


	public function get_specified_comments($comments, $post_id)
	{
		if(!current_user_can('moderate_comments'))
		{
			return $comments;
		}
		else
		{
			$option = get_option('ac_inline_edit');

			$array = array_merge(
				(in_array('approve', $option['comments_statuses']) ? (array)get_comments(array('post_id' => $post_id, 'status' => 'approve')) : array()),
				(in_array('hold', $option['comments_statuses']) ? (array)get_comments(array('post_id' => $post_id, 'status' => 'hold')) : array()),
				(in_array('trash', $option['comments_statuses']) ? (array)get_comments(array('post_id' => $post_id, 'status' => 'trash')) : array()),
				(in_array('spam', $option['comments_statuses']) ? (array)get_comments(array('post_id' => $post_id, 'status' => 'spam')) : array())
			);

			usort($array, array(&$this, 'sort_comments_'.get_option('comment_order')));

			return $array;
		}
	}


	/**
	 * Gets proper number of visible comments
	*/
	public function get_comments_amount($amount, $post_id)
	{
		if(!current_user_can('moderate_comments'))
		{
			return $amount;
		}
		else
		{
			if(isset($this->amount_of_comments[$post_id]))
			{
				return $this->amount_of_comments[$post_id];
			}
			else
			{
				global $wp_query;

				$option = get_option('ac_inline_edit');

				if(isset($wp_query->comments) && !empty($wp_query->comments))
				{
					$amount = 0;

					foreach($wp_query->comments as $comment)
					{
						$amount += in_array($this->statuses[$comment->comment_approved], $option['comments_statuses']) ? 1 : 0;
					}

					return ($this->amount_of_comments[$post_id] = $amount);
				}
				else
				{
					global $wpdb;

					$statuses = array();

					foreach($option['comments_statuses'] as $status)
					{
						if($status === 'hold')
						{
							$statuses[] = '\'0\'';
						}
						else
						{
							$statuses[] = '\''.$status.'\'';
						}
					}

					$statuses[] = '\'1\'';

					$comments = (array)$wpdb->get_results('SELECT COUNT(comment_ID) as amount FROM '.$wpdb->comments.' WHERE comment_post_ID = '.$post_id.' AND comment_approved IN ('.implode(',', $statuses).')');

					return ($this->amount_of_comments[$post_id] = $comments[0]->amount);
				}
			}
		}
	}


	/**
	 * Loads defaults
	*/
	public function load_defaults()
	{
		$this->statuses = array(
			'0' => 'hold',
			'1' => 'approve',
			'spam' => 'spam',
			'trash' => 'trash'
		);

		$this->positions = array(
			'pos_not_logged' => array(
				'comment_form_before' => __('before form', 'ajaxed-comments'),
				'comment_form_top' => __('form top', 'ajaxed-comments'),
				'comment_form_before_fields' => __('before form fields', 'ajaxed-comments'),
				'comment_form' => __('form bottom', 'ajaxed-comments'),
				'comment_form_after' => __('after form', 'ajaxed-comments')
			),
			'pos_logged' => array(
				'comment_form_before' => __('before form', 'ajaxed-comments'),
				'comment_form_top' => __('form top', 'ajaxed-comments'),
				'comment_form_logged_in_after' => __('before form fields', 'ajaxed-comments'),
				'comment_form' => __('inside form', 'ajaxed-comments'),
				'comment_form_after' => __('after form', 'ajaxed-comments')
			)
		);

		$this->styles = array(
			'none' => __('none', 'ajaxed-comments'),
			'wp-default' => __('WordPress default', 'ajaxed-comments'),
			'bootstrap' => __('Bootstrap', 'ajaxed-comments')
		);

		$this->rem_msgs = array(
			0 => __('do not hide', 'ajaxed-comments'),
			1 => __('1 second', 'ajaxed-comments'),
			2 => __('2 seconds', 'ajaxed-comments'),
			3 => __('3 seconds', 'ajaxed-comments'),
			5 => __('5 seconds', 'ajaxed-comments'),
			10 => __('10 seconds', 'ajaxed-comments')
		);

		$this->effects = array(
			'fade' => __('fade', 'ajaxed-comments'),
			'slide' => __('slide', 'ajaxed-comments'),
		);

		$this->comments_statuses = array(
			'approve' => __('approved', 'ajaxed-comments'),
			'hold' => __('unapproved', 'ajaxed-comments'),
			'trash' => __('trash', 'ajaxed-comments'),
			'spam' => __('spam', 'ajaxed-comments')
		);

		$this->tabs = array(
			'inline-edit' => array(
				'name' => __('Editing', 'ajaxed-comments'),
				'metakey' => 'ac_inline_edit',
				'submit' => 'save_inline_edit'
			),
			'messages' => array(
				'name' => __('Messages', 'ajaxed-comments'),
				'metakey' => 'ac_messages',
				'submit' => 'save_messages'
			)
		);

		$this->choice = array(
			'yes' => __('yes', 'ajaxed-comments'),
			'no' => __('no', 'ajaxed-comments'),
		);

		$this->delete_groups = array(
			'admins' => __('admins only', 'ajaxed-comments'),
			'users' => __('logged in users', 'ajaxed-comments'),
			'everyone' => __('all commenters', 'ajaxed-comments')
		);
	}


	/**
	 * Activation
	*/
	public function activation()
	{
		add_option('ac_inline_edit', $this->options['inline-edit'], '', 'no');
		add_option('ac_messages', $this->options['messages'], '', 'no');
	}


	/**
	 * Deactivation
	*/
	public function deactivation()
	{
		delete_option('ac_inline_edit');
		delete_option('ac_messages');
	}


	/**
	 * Turns off add-comment redirect
	*/
	function comment_redirect($location)
	{
		echo json_encode(array('loc' => $location, 'info' => 'AC_COMMENT_ADDED'));

		exit;
	}


	/**
	 * Adds comment using AJAX
	*/
	public function ajax_add_new_comment()
	{
		if(isset($_POST['form'], $_POST['action'], $_POST['nonce']) && $_POST['action'] === 'ac-add-new-comment' && check_ajax_referer('new-comm-ajax-sec-check', 'nonce', FALSE))
		{
			global $wpdb;

			//parses serialized form-string
			parse_str($_POST['form'], $post_form);
			$_POST = array_merge($_POST, $post_form);

			//antispam bee plugin fix
			if(is_plugin_active('antispam-bee/antispam_bee.php'))
				$_POST['comment'] = $post_form[substr(md5(get_bloginfo('url')), 0, 5).'-comment'];

			//bws captcha fix
			if(is_plugin_active('captcha/captcha.php'))
				$_REQUEST = array_merge($_REQUEST, $_POST);

			//we have to add user id manually
			$user_ID = get_current_user_id();

			//turns off errors due to wp-load.php notice
			error_reporting(0);

			//turns off redirect
			add_filter('comment_post_redirect', array(&$this, 'comment_redirect'));

			//adds comment
			require_once(dirname(__FILE__).'/../../../wp-comments-post.php');
		}

		exit;
	}


	/**
	 * Manages comment actions with AJAX
	*/
	public function ajax_comments()
	{
		if(isset($_POST['comm_id'], $_POST['action'], $_POST['nonce']))
		{
			$comm_id = (int)$_POST['comm_id'];
			$opt = get_option('ac_inline_edit');
			$err_lvl = error_reporting();
			$approve_delete = FALSE;

			//is delete button active?
			if($opt['delete_button'] === 'yes')
			{
				$delete_group = (isset($opt['delete_group']) ? $opt['delete_group'] : $this->options['inline-edit']['delete_group']);

				if($delete_group === 'admins' && current_user_can('manage_options'))
					$approve_delete = TRUE;
				elseif($delete_group === 'users' && is_user_logged_in())
					$approve_delete = TRUE;
				elseif($delete_group === 'everyone')
					$approve_delete = TRUE;
			}

			//disables errors due to current_user_can() notices
			error_reporting(0);

			if(current_user_can('edit_comment', $comm_id) && $_POST['action'] === 'ac-save-comment' && check_ajax_referer('save-comm-ajax-sec-check', 'nonce', FALSE) && isset($_POST['form']))
			{
				error_reporting($err_lvl);

				if(wp_update_comment(array('comment_ID' => $comm_id, 'comment_content' => $_POST['form'])))
				{
					remove_filter('comment_text', array(&$this, 'get_comment_text'), 1);
					remove_filter('comment_text', array(&$this, 'add_section_to_comment'), 1000);
					comment_text($comm_id);
					add_filter('comment_text', array(&$this, 'add_section_to_comment'), 1000);
					add_filter('comment_text', array(&$this, 'get_comment_text'), 1);
				}
				else echo '';
			}
			elseif(current_user_can('moderate_comments'))
			{
				error_reporting($err_lvl);

				if($_POST['action'] === 'ac-approve-comment' && check_ajax_referer('approve-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_set_comment_status($comm_id, 'approve') ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-unapprove-comment' && check_ajax_referer('approve-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_set_comment_status($comm_id, 'hold') ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-spam-comment' && check_ajax_referer('spam-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_spam_comment($comm_id) ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-unspam-comment' && check_ajax_referer('spam-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_unspam_comment($comm_id) ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-trash-comment' && check_ajax_referer('trash-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_trash_comment($comm_id) ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-untrash-comment' && check_ajax_referer('trash-comm-ajax-sec-check', 'nonce', FALSE))
					echo (wp_untrash_comment($comm_id) ? 'AC_OK' : '');
				elseif($_POST['action'] === 'ac-delete-comment' && check_ajax_referer('delete-comm-ajax-sec-check', 'nonce', FALSE) && $approve_delete === TRUE)
					echo (wp_delete_comment($comm_id, TRUE) ? 'AC_OK' : '');
			}
			elseif($_POST['action'] === 'ac-delete-comment' && check_ajax_referer('delete-comm-ajax-sec-check', 'nonce', FALSE) && $approve_delete === TRUE)
				echo (wp_delete_comment($comm_id, TRUE) ? 'AC_OK' : '');
		}

		exit;
	}


	/**
	 * Adds little spinner next to comment submit button
	*/
	public function comment_form_spinner($result)
	{
		$result .= '<span id="ac-spinner"></span>';

		return $result;
	}


	/**
	 * Force editing comment for comment authors
	*/
	public function force_edit_comments($allcaps, $cap, $args)
	{
		$this->timer = FALSE;
		
		// Break if we're not asking to edit a comment
		if('edit_comment' != $args[0])
			return $allcaps;

		// Brak if user already can moderate comments
		if(!empty($allcaps['moderate_comments']))
			return $allcaps;

		$comment = get_comment($args[2]);

		// Break if the user is the post author (post authors can edit comments in their posts)
		if($args[1] == $comment->comment_author && is_user_logged_in()) // doesn't work for not logged in
			return $allcaps;

		$post_type = get_post_type($comment->comment_post_ID) == 'page' ? $post_type = 'page' : 'post'; // comment post post type

		// Frontend only
		if(!is_admin() || (defined('DOING_AJAX') && DOING_AJAX))
		{
			$opt = get_option('ac_inline_edit');

			if($opt['timer'] === 'yes')
			{
				$time_left = strtotime($comment->comment_date) + $opt['time_to_edit'] * 60 - current_time('timestamp');

				// Editing comments for logged in users
				if(is_user_logged_in())
				{
					if($comment->user_id == get_current_user_id() && $time_left > 0)
					{
						$this->timer = TRUE;
						$this->time_left = $time_left;

						$allcaps['edit_others_'.$post_type.'s'] = TRUE; // enable edit comment
						$allcaps['edit_published_'.$post_type.'s'] = TRUE; // enable edit comment
					}
				}
				// Editing comments for anonymous commenters
				else
				{
					$current_commenter = wp_get_current_commenter();

if($comment->comment_author == $current_commenter['comment_author'] && $comment->comment_author_email == $current_commenter['comment_author_email'] && $time_left > 0 && $comment->comment_author_IP === preg_replace('/[^0-9a-fA-F:., ]/', '', $_SERVER['REMOTE_ADDR']))
					{
						$this->timer = TRUE;
						$this->time_left = $time_left;

						$allcaps['edit_others_'.$post_type.'s'] = TRUE; // enable edit comment
						$allcaps['edit_published_'.$post_type.'s'] = TRUE; // enable edit comment
					}
				}
			}
		}

		return $allcaps;
	}


	/**
	 * Adds new links after 'Edit' comment link
	*/
	public function add_inline_actions($link, $cid)
	{
		$options_m = get_option('ac_messages');
		$options_ie = get_option('ac_inline_edit');
		$del_nonce = wp_create_nonce('delete-comment_'.$cid);
		$app_nonce = wp_create_nonce('approve-comment_'.$cid);

		//need to make sure these values will not be changed after using current_user_can() function
		$timer = $this->timer;
		$time_left = $this->time_left;

		$show_delete = FALSE;

		//is delete button active?
		if($options_ie['delete_button'] === 'yes')
		{
			$delete_group = (isset($options_ie['delete_group']) ? $options_ie['delete_group'] : $this->options['inline-edit']['delete_group']);

			if($delete_group === 'admins' && current_user_can('manage_options'))
				$show_delete = TRUE;
			elseif($delete_group === 'users' && is_user_logged_in())
				$show_delete = TRUE;
			elseif($delete_group === 'everyone')
				$show_delete = TRUE;
		}

		$permalink = 'href="'.get_permalink().'"';
		$adminlink = 'href="'.esc_url(admin_url('comment.php?c='.$cid.'&action=%s&_wpnonce=%s')).'"';
		$actionlink = '<%s class="comment-%s-link'.($options_ie['css_style'] !== 'none' ? ' '.$options_ie['css_style'] : '').' ac-button %s" %s rel="'.$cid.'|%s">%s</%s>';
		$returnlink = '<div class="ac-comment-edit'.($options_ie['show_actions_on_hover'] === 'yes' ? ' ac-hide-row-actions' : '').'">'.(current_user_can('edit_comment', $cid) || $timer === TRUE ? '<a class="comment-ac-edit-link ac-button'.($options_ie['css_style'] !== 'none' ? ' '.$options_ie['css_style'] : '').'" rel="'.$cid.'" href="'.get_edit_comment_link($cid).'">'.__('Edit', 'ajaxed-comments').'</a><span class="edit-comment-actions" style="display: none;">'.sprintf($actionlink, 'a', 'ac-save', '', $permalink, wp_create_nonce('save-comm-ajax-sec-check'), __('Save', 'ajaxed-comments'), 'a').sprintf($actionlink, 'a', 'ac-cancel', '', $permalink, '', __('Cancel', 'ajaxed-comments'), 'a').'</span>' : '').(current_user_can('moderate_comments') ? '%s%s%s' : '').($show_delete === TRUE ? '%s' : '').'<span class="ac-comm-spinner"></span>'.($timer === TRUE && $options_ie['timer'] === 'yes' ? '<span class="edit-time-remaining">'.__('Time remaining', 'ajaxed-comments').': <span class="ac-timer" rel="'.$cid.'|'.$time_left.'"></span></span>' : '').'</div><div class="ac-mini-info-box'.($options_m['css_style'] !== 'none' ? ' '.$options_m['css_style'] : '').'" id="ac-cid-'.$cid.'" style="display: none;"><div></div></div>';
		$deletelink = ($options_ie['delete_button'] === 'yes' && $show_delete === TRUE ? sprintf($actionlink, 'a', 'ac-delete', '', sprintf($adminlink, 'deletecomment', $del_nonce), wp_create_nonce('delete-comm-ajax-sec-check'), __('Delete', 'ajaxed-comments'), 'a') : '');

		//gets old status of comment
		$old_status = get_comment_meta($cid, '_wp_trash_meta_status', TRUE);

		switch(wp_get_comment_status($cid))
		{
			case 'approved':
				if($show_delete === TRUE && !current_user_can('manage_options'))
					return sprintf($returnlink, $deletelink);
				else
					return sprintf($returnlink, sprintf($actionlink, 'a', 'ac-unapprove', '', sprintf($adminlink, 'unapprovecomment', $app_nonce), wp_create_nonce('approve-comm-ajax-sec-check'), __('Unapprove', 'ajaxed-comments'), 'a'), sprintf($actionlink, 'a', 'ac-spam', '', sprintf($adminlink, 'spamcomment', $del_nonce), wp_create_nonce('spam-comm-ajax-sec-check'), __('Spam', 'ajaxed-comments'), 'a'), sprintf($actionlink, 'a', 'ac-trash', '', sprintf($adminlink, 'trashcomment', $del_nonce), wp_create_nonce('trash-comm-ajax-sec-check'), __('Trash', 'ajaxed-comments'), 'a'), $deletelink);
			case 'unapproved':
				if($show_delete === TRUE && !current_user_can('manage_options'))
					return sprintf($returnlink, $deletelink);
				else
					return sprintf($returnlink, sprintf($actionlink, 'a', 'ac-approve', '', sprintf($adminlink, 'approvecomment', $app_nonce), wp_create_nonce('approve-comm-ajax-sec-check'), __('Approve', 'ajaxed-comments'), 'a'), sprintf($actionlink, 'a', 'ac-spam', '', sprintf($adminlink, 'spamcomment', $del_nonce), wp_create_nonce('spam-comm-ajax-sec-check'), __('Spam', 'ajaxed-comments'), 'a'), sprintf($actionlink, 'a', 'ac-trash', '', sprintf($adminlink, 'trashcomment', $del_nonce), wp_create_nonce('trash-comm-ajax-sec-check'), __('Trash', 'ajaxed-comments'), 'a'), $deletelink);
			case 'trash':
				if($show_delete === TRUE && !current_user_can('manage_options'))
					return sprintf($returnlink, $deletelink);
				else
					return sprintf($returnlink, sprintf($actionlink, 'span', 'ac-'.($old_status === '1' ? 'unapprove' : 'approve'), 'disabled', sprintf($adminlink, 'unapprovecomment', $app_nonce), wp_create_nonce('approve-comm-ajax-sec-check'), __(($old_status === '1' ? 'Unapprove' : 'Approve'), 'ajaxed-comments'), 'span'), sprintf($actionlink, 'span', 'ac-spam', 'disabled', sprintf($adminlink, 'spamcomment', $del_nonce), wp_create_nonce('spam-comm-ajax-sec-check'), __('Spam', 'ajaxed-comments'), 'span'), sprintf($actionlink, 'a', 'ac-untrash', '', sprintf($adminlink, 'untrashcomment', $del_nonce), wp_create_nonce('trash-comm-ajax-sec-check'), __('Restore', 'ajaxed-comments'), 'a'), $deletelink);
			case 'spam':
				if($show_delete === TRUE && !current_user_can('manage_options'))
					return sprintf($returnlink, $deletelink);
				else
					return sprintf($returnlink, sprintf($actionlink, 'span', 'ac-'.($old_status === '1' ? 'unapprove' : 'approve'), 'disabled', sprintf($adminlink, 'unapprovecomment', $app_nonce), wp_create_nonce('approve-comm-ajax-sec-check'), __(($old_status === '1' ? 'Unapprove' : 'Approve'), 'ajaxed-comments'), 'span'), sprintf($actionlink, 'a', 'ac-unspam', '', sprintf($adminlink, 'unspamcomment', $del_nonce), wp_create_nonce('spam-comm-ajax-sec-check'), __('Unspam', 'ajaxed-comments'), 'a'), sprintf($actionlink, 'span', 'ac-trash', 'disabled', sprintf($adminlink, 'trashcomment', $del_nonce), wp_create_nonce('trash-comm-ajax-sec-check'), __('Trash', 'ajaxed-comments'), 'span'), $deletelink);
			default:
				return $link;
		}
	}


	/**
	 * Gets comment's text
	*/
	public function get_comment_text($text)
	{
		global $comment;

		$this->comments[$comment->comment_ID] = $text;
		return $text;
	}


	/**
	 * Adds section to comment's text
	*/
	public function add_section_to_comment($text)
	{
		global $comment;

		return '<div id="ac-section-'.$comment->comment_ID.'">'.$text.'</div><div class="ac-textarea" id="ac-textarea-'.$comment->comment_ID.'" style="display: none;"><textarea>'.$this->comments[$comment->comment_ID].'</textarea></div>';
	}


	/**
	 * Displays information box on front
	*/
	public function display_information_box()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ajaxed-comments" style="display: none;"'.($options['css_style'] !== 'none' ? ' class="'.$options['css_style'].'"' : '').'>
			<div id="ajaxed-comments-box" rel="'.wp_create_nonce('new-comm-ajax-sec-check').'">
				<div class="ac-inside-box"></div>
			</div>
		</div>';
	}


	/**
	 * Registers settings
	*/
	public function register_settings()
	{
		//inline edit
		register_setting('ac_inline_edit', 'ac_inline_edit', array(&$this, 'validate_configuration'));
		add_settings_section('ajaxed_comments_settings', __('Editing Settings', 'ajaxed-comments'), '', 'ac_inline_edit');
		add_settings_field('ac_comments_statuses', __('Comments statuses', 'ajaxed-comments'), array(&$this, 'comments_statuses'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_timer', __('Comment Edit Timer', 'ajaxed-comments'), array(&$this, 'comments_box_timer'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_time_to_edit', __('Editing time', 'ajaxed-comments'), array(&$this, 'comments_box_time_to_edit'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_delete', __('Delete permanently button', 'ajaxed-comments'), array(&$this, 'comments_box_delete'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_edit_comm_effect', __('Edit comment effect', 'ajaxed-comments'), array(&$this, 'comments_box_edit_comm_effect'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_css_style_inline', __('CSS style', 'ajaxed-comments'), array(&$this, 'comments_box_css_style_inline'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_show_actions_on_hover', __('Show on hover', 'ajaxed-comments'), array(&$this, 'comments_box_show_actions_on_hover'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_highlight_comments', __('Highlight comments', 'ajaxed-comments'), array(&$this, 'comments_box_highlight_comments'), 'ac_inline_edit', 'ajaxed_comments_settings');
		add_settings_field('ac_highlight_colors', __('Highlight colors', 'ajaxed-comments'), array(&$this, 'comments_box_highlight_colors'), 'ac_inline_edit', 'ajaxed_comments_settings');

		//messages
		register_setting('ac_messages', 'ac_messages', array(&$this, 'validate_configuration'));
		add_settings_section('ajaxed_comments_messages_settings', __('Messages Settings', 'ajaxed-comments'), '', 'ac_messages');
		add_settings_field('ac_info_box_position_logged', __('Message box position for logged in users', 'ajaxed-comments'), array(&$this, 'comments_box_position_logged'), 'ac_messages', 'ajaxed_comments_messages_settings');
		add_settings_field('ac_info_box_position_not_logged', __('Message box position for logged out users', 'ajaxed-comments'), array(&$this, 'comments_box_position_not_logged'), 'ac_messages', 'ajaxed_comments_messages_settings');
		add_settings_field('ac_show_effect', __('Show message effect', 'ajaxed-comments'), array(&$this, 'comments_box_show_effect'), 'ac_messages', 'ajaxed_comments_messages_settings');
		add_settings_field('ac_hide_effect', __('Hide message effect', 'ajaxed-comments'), array(&$this, 'comments_box_hide_effect'), 'ac_messages', 'ajaxed_comments_messages_settings');
		add_settings_field('ac_rem_msg', __('Hide message after', 'ajaxed-comments'), array(&$this, 'comments_box_remove_messages'), 'ac_messages', 'ajaxed_comments_messages_settings');
		add_settings_field('ac_css_style', __('CSS style', 'ajaxed-comments'), array(&$this, 'comments_box_css_style'), 'ac_messages', 'ajaxed_comments_messages_settings');
	}


	/**
	 * Settings field callback - timer
	*/
	public function comments_box_timer()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_timer">';

		foreach($this->choice as $val => $trans)
		{
			echo '
			<input id="ac-timer-'.$val.'" type="radio" name="ac_inline_edit[timer]" value="'.$val.'" '.checked($val, $options['timer'], FALSE).' />
			<label for="ac-timer-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Comment timer allows users to edit their comments for specified time', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - time to edit
	*/
	public function comments_box_time_to_edit()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_time_to_edit">
			<input type="text" value="'.$options['time_to_edit'].'" name="ac_inline_edit[time_to_edit]" />
			<p class="description">'.__('How much time (in minutes) a user has to edit a published comment', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - highlight colors
	*/
	public function comments_box_highlight_colors()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_highlight_colors"'.($options['highlight_colors'] === 'no' ? ' style="display: none;"' : '').'>';

		foreach($options['highlight_colors'] as $status => $color)
		{
			echo '
			<p>
				<span>'.__($status, 'ajaxed-comments').'</span>: <input type="text" value="'.$color.'" class="ac-color-picker" name="ac_inline_edit[highlight_colors]['.$status.']" data-default-color="'.$color.'" />
			</p>';
		}

		echo '
			<p class="description">'.__('Pick highlight colors for specific comment statuses', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - highlight comments
	*/
	public function comments_box_highlight_comments()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_highlight_comments">';

		foreach($this->choice as $val => $trans)
		{
			echo '
			<input id="ac-highlight-comments-'.$val.'" type="radio" name="ac_inline_edit[highlight_comments]" value="'.$val.'" '.checked($val, $options['highlight_comments'], FALSE).' />
			<label for="ac-highlight-comments-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Highlight comments with specific colors', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - actions on hover
	*/
	public function comments_box_show_actions_on_hover()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_show_on_hover">';

		foreach($this->choice as $val => $trans)
		{
			echo '
			<input id="ac-show-on-hover-'.$val.'" type="radio" name="ac_inline_edit[show_actions_on_hover]" value="'.$val.'" '.checked($val, $options['show_actions_on_hover'], FALSE).' />
			<label for="ac-show-on-hover-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Show inline edit actions only on hovering over a comment', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - visible statuses
	*/
	public function comments_statuses()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_comments_statuses">';

		foreach($this->comments_statuses as $val => $trans)
		{
			if($val !== 'approve')
			{
				echo '
			<input id="ac-comment-status-'.$val.'" type="checkbox" name="ac_inline_edit[comments_statuses][]" value="'.$val.'" '.checked(TRUE, in_array($val, $options['comments_statuses']), FALSE).' />
			<label for="ac-comment-status-'.$val.'">'.$trans.'</label>';
			}
		}

		echo '
			<p class="description">'.__('Select comments of which statuses will be available for moderation on the front-end of your site', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Settings field callback - delete button
	*/
	public function comments_box_delete()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_delete">';

		foreach($this->choice as $val => $trans)
		{
			echo '
			<input id="ac-delete-'.$val.'" type="radio" name="ac_inline_edit[delete_button]" value="'.$val.'" '.checked($val, $options['delete_button'], FALSE).' />
			<label for="ac-delete-'.$val.'">'.$trans.'</label>';
		}

		echo '
		</div>
		<div id="ac_delete_group"'.($options['delete_button'] === 'yes' ? '' : ' style="display: none;"').'>';

		foreach($this->delete_groups as $val => $trans)
		{
			echo '
				<input id="ac-delete-group-'.$val.'" type="radio" name="ac_inline_edit[delete_group]" value="'.$val.'" '.checked($val, (isset($options['delete_group']) ? $options['delete_group'] : $this->options['inline-edit']['delete_group']), FALSE).' />
				<label for="ac-delete-group-'.$val.'">'.$trans.'</label>';
		}

		echo '
		</div>
		<div>
			<p class="description">'.__('This will add Delete to edit buttons that allows you to permanently delete comments', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - show info box effect
	*/
	public function comments_box_show_effect()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_show_effect">';

		foreach($this->effects as $val => $trans)
		{
			echo '
			<input id="ac-show-effect-'.$val.'" type="radio" name="ac_messages[show_effect]" value="'.$val.'" '.checked($val, $options['show_effect'], FALSE).' />
			<label for="ac-show-effect-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select animation for showing messages', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - hide info box effect
	*/
	public function comments_box_hide_effect()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_hide_effect">';

		foreach($this->effects as $val => $trans)
		{
			echo '
			<input id="ac-hide-effect-'.$val.'" type="radio" name="ac_messages[hide_effect]" value="'.$val.'" '.checked($val, $options['hide_effect'], FALSE).' />
			<label for="ac-hide-effect-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select animation for hiding messages', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - edit comment effect
	*/
	public function comments_box_edit_comm_effect()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_edit_comm_effect">';

		foreach($this->effects as $val => $trans)
		{
			echo '
			<input id="ac-edit-comm-effect-'.$val.'" type="radio" name="ac_inline_edit[edit_comm_effect]" value="'.$val.'" '.checked($val, $options['edit_comm_effect'], FALSE).' />
			<label for="ac-edit-comm-effect-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select animation effect for edit comment', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - css style for messages
	*/
	public function comments_box_css_style()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_css_style">';

		foreach($this->styles as $val => $trans)
		{
			echo '
			<input id="ac-css-style-'.$val.'" type="radio" name="ac_messages[css_style]" value="'.$val.'" '.checked($val, $options['css_style'], FALSE).' />
			<label for="ac-css-style-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Choose your message box style', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - css style for inline edit
	*/
	public function comments_box_css_style_inline()
	{
		$options = get_option('ac_inline_edit');

		echo '
		<div id="ac_css_style_inline">';

		foreach($this->styles as $val => $trans)
		{
			echo '
			<input id="ac-css-style-'.$val.'" type="radio" name="ac_inline_edit[css_style]" value="'.$val.'" '.checked($val, $options['css_style'], FALSE).' />
			<label for="ac-css-style-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select style for edit buttons', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - hide message after time
	*/
	public function comments_box_remove_messages()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_remove_message">';

		foreach($this->rem_msgs as $val => $trans)
		{
			echo '
			<input id="ac-remove-message-'.$val.'" type="radio" name="ac_messages[remove_message]" value="'.$val.'" '.checked($val, $options['remove_message'], FALSE).' />
			<label for="ac-remove-message-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select for how long message box should be displayed', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - logged users
	*/
	public function comments_box_position_logged()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_logged_box">';

		foreach($this->positions['pos_logged'] as $type => $trans)
		{
			echo '
			<input id="ac-logged-'.$type.'" type="radio" name="ac_messages[pos_logged]" value="'.$type.'" '.checked($type, $options['pos_logged'], FALSE).' />
			<label for="ac-logged-'.$type.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select message box position for logged in users', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Setting field - not logged users
	*/
	public function comments_box_position_not_logged()
	{
		$options = get_option('ac_messages');

		echo '
		<div id="ac_notlogged_box">';

		foreach($this->positions['pos_not_logged'] as $type => $trans)
		{
			echo '
			<input id="ac-notlogged-'.$type.'" type="radio" name="ac_messages[pos_not_logged]" value="'.$type.'" '.checked($type, $options['pos_not_logged'], FALSE).' />
			<label for="ac-notlogged-'.$type.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select message box position for logged out users', 'ajaxed-comments').'</p>
		</div>';
	}


	/**
	 * Validates settings
	*/
	public function validate_configuration($input)
	{
		if(isset($_POST['save_inline_edit']))
		{
			$statuses_arr = array();
			$input['comments_statuses'][] = 'approve';

			foreach($input['comments_statuses'] as $status)
			{
				if(in_array($status, array_keys($this->comments_statuses)))
				$statuses_arr[] = $status;
			}

			$input['comments_statuses'] = $statuses_arr;

			$input['edit_comm_effect'] = (isset($input['edit_comm_effect']) && in_array($input['edit_comm_effect'], array_keys($this->effects)) ? $input['edit_comm_effect'] : $this->options['inline-edit']['edit_comm_effect']);

			$input['css_style'] = (isset($input['css_style']) && in_array($input['css_style'], array_keys($this->styles)) ? $input['css_style'] : $this->options['inline-edit']['css_style']);

			$input['delete_button'] = (isset($input['delete_button']) && in_array($input['delete_button'], array_keys($this->choice)) ? $input['delete_button'] : $this->options['inline-edit']['delete_button']);

			if($input['delete_button'] === 'yes')
				$input['delete_group'] = (isset($input['delete_group']) && in_array($input['delete_group'], array_keys($this->delete_groups)) ? $input['delete_group'] : $this->options['inline-edit']['delete_group']);
			else
			{
				$options_edit = get_option('ac_inline_edit');
				$input['delete_group'] = (isset($options_edit['delete_group']) ? $options_edit['delete_group'] : $this->options['inline-edit']['delete_group']);
			}

			$input['show_actions_on_hover'] = (isset($input['show_actions_on_hover']) && in_array($input['show_actions_on_hover'], array_keys($this->choice)) ? $input['show_actions_on_hover'] : $this->options['inline-edit']['show_actions_on_hover']);

			$input['timer'] = (isset($input['timer']) && in_array($input['timer'], array_keys($this->choice)) ? $input['timer'] : $this->options['inline-edit']['timer']);

			$input['time_to_edit'] = (($a = (int)$input['time_to_edit']) <= 0 ? $this->options['inline-edit']['time_to_edit'] : $a);

			$input['highlight_comments'] = (isset($input['highlight_comments']) && in_array($input['highlight_comments'], array_keys($this->choice)) ? $input['highlight_comments'] : $this->options['inline-edit']['highlight_comments']);

			foreach($this->options['inline-edit']['highlight_colors'] as $status => $color)
			{
				$input['highlight_colors'][$status] = ((isset($input['highlight_colors'][$status]) && preg_match('/^#[0-9a-f]{6}$/i', $input['highlight_colors'][$status]) === 1) ? $input['highlight_colors'][$status] : $this->options['inline-edit']['highlight_colors'][$status]);
			}

			if($input['highlight_comments'] === 'yes' && ini_get('allow_url_fopen') === '1')
			{
				$string = 
'.ac-full-hold > [id] {
	background-color: '.$input['highlight_colors']['unapproved'].' !important;
}
.ac-full-trash > [id] {
	background-color: '.$input['highlight_colors']['trash'].' !important;
}
.ac-full-spam > [id] {
	background-color: '.$input['highlight_colors']['spam'].' !important;
}';

				file_put_contents(WP_PLUGIN_DIR.'/ajaxed-comments/css/ajaxed-comments-colors.css', $string);
			}
		}
		elseif(isset($_POST['save_messages']))
		{
			$input['pos_logged'] = (isset($input['pos_logged']) && in_array($input['pos_logged'], array_keys($this->positions['pos_logged'])) ? $input['pos_logged'] : $this->options['messages']['pos_logged']);

			$input['pos_not_logged'] = (isset($input['pos_not_logged']) && in_array($input['pos_not_logged'], array_keys($this->positions['pos_not_logged'])) ? $input['pos_not_logged'] : $this->options['messages']['pos_not_logged']);

			$input['show_effect'] = (isset($input['show_effect']) && in_array($input['show_effect'], array_keys($this->effects)) ? $input['show_effect'] : $this->options['messages']['show_effect']);

			$input['hide_effect'] = (isset($input['hide_effect']) && in_array($input['hide_effect'], array_keys($this->effects)) ? $input['hide_effect'] : $this->options['messages']['hide_effect']);

			$input['remove_message'] = (int)(isset($input['remove_message']) && in_array($input['remove_message'], array_keys($this->rem_msgs)) ? $input['remove_message'] : $this->options['messages']['remove_message']);

			$input['css_style'] = (isset($input['css_style']) && in_array($input['css_style'], array_keys($this->styles)) ? $input['css_style'] : $this->options['messages']['css_style']);
		}

		return $input;
	}


	/**
	 * Adds admin menu options
	*/
	public function admin_menu_options()
	{
		add_options_page(
			__('Ajaxed Comments', 'ajaxed-comments'),
			__('Ajaxed Comments', 'ajaxed-comments'),
			'manage_options',
			'ajaxed-comments-options',
			array(&$this, 'comments_options_page')
		);
	}


	/**
	 * Shows option page
	*/
	public function comments_options_page()
	{
		if(isset($_GET['tab']))
		{
			$tab_key = $_GET['tab'];
			$tab = $this->tabs[$tab_key]['metakey'];
		}
		else
		{
			$tab_key = 'inline-edit';
			$tab = $this->tabs[$tab_key]['metakey'];
		}

		echo '
		<div class="wrap">'.screen_icon().'
			<h2>'.__('Ajaxed Comments Settings', 'ajaxed-comments').'</h2>
			<h2 class="nav-tab-wrapper">';

		foreach($this->tabs as $key => $name)
		{
			echo '
			<a class="nav-tab '.($tab_key == $key ? 'nav-tab-active' : '').'" href="'.esc_url(admin_url('options-general.php?page=ajaxed-comments-options&tab='.$key)).'">'.$name['name'].'</a>';
		}

		echo '
			</h2>
			<div class="ajaxed-comments-settings">
				<div class="df-credits">
					<h3 class="hndl">'.__('Ajaxed Comments', 'ajaxed-comments').'</h3>
					<div class="inside">
						<h4 class="inner">'.__('Need support?', 'ajaxed-comments').'</h4>
						<p class="inner">'.__('If you are having problems with this plugin, please talk about them in the', 'ajaxed-comments').' <a href="http://dfactory.eu/support/" target="_blank" title="'.__('Support forum','ajaxed-comments').'">'.__('Support forum', 'ajaxed-comments').'</a></p>
						<hr />
						<h4 class="inner">'.__('Do you like this plugin?', 'ajaxed-comments').'</h4>
						<p class="inner"><a href="http://wordpress.org/support/view/plugin-reviews/ajaxed-comments" target="_blank" title="'.__('Rate it 5', 'ajaxed-comments').'">'.__('Rate it 5', 'ajaxed-comments').'</a> '.__('on WordPress.org', 'ajaxed-comments').'<br />'.
						__('Blog about it & link to the', 'ajaxed-comments').' <a href="http://dfactory.eu/plugins/ajaxed-comments/" target="_blank" title="'.__('plugin page', 'ajaxed-comments').'">'.__('plugin page', 'ajaxed-comments').'</a><br />'.
						__('Check out our other', 'ajaxed-comments').' <a href="http://dfactory.eu/plugins/" target="_blank" title="'.__('WordPress plugins', 'ajaxed-comments').'">'.__('WordPress plugins', 'ajaxed-comments').'</a>
						</p>            
						<hr />
						<p class="df-link inner">'.__('Created by', 'ajaxed-comments').' <a href="http://www.dfactory.eu" target="_blank" title="dFactory - Quality plugins for WordPress"><img src="'.plugins_url('/images/logo-dfactory.png' , __FILE__ ).'" title="dFactory - Quality plugins for WordPress" alt="dFactory - Quality plugins for WordPress" /></a></p>
					</div>
				</div>
				<form action="options.php" method="post">';

		wp_nonce_field('update-options');
		settings_fields($tab);
		do_settings_sections($tab);

		echo '
					<p class="submit">';

		submit_button('', 'primary', $this->tabs[$tab_key]['submit'], FALSE);

		echo '
					</p>
				</form>
			</div>
			<div class="clear"></div>
		</div>';
	}


	/**
	 * Enqueues scripts and styles (admin side)
	*/
	public function admin_comments_scripts_styles($page)
	{
		if(is_admin() && $page === 'settings_page_ajaxed-comments-options')
		{
			wp_enqueue_script(
				'ajaxed-comments-admin',
				plugins_url('/js/admin.js', __FILE__),
				array('jquery', 'jquery-ui-core', 'jquery-ui-button', 'wp-color-picker')
			);

			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('ajaxed-comments-admin', plugins_url('/css/admin.css', __FILE__));
			wp_enqueue_style('ajaxed-comments-front', plugins_url('/css/wp-like-ui-theme.css', __FILE__));
		}
	}


	/**
	 * Enqueues scripts and styles (front side)
	*/
	public function front_comments_scripts_styles()
	{
		if(!is_admin())
		{
			$options_msg = get_option('ac_messages');
			$options_edit = get_option('ac_inline_edit');

			if(is_user_logged_in())
			{
				add_action($options_msg['pos_logged'], array(&$this, 'display_information_box'));
			}
			else
			{
				add_action($options_msg['pos_not_logged'], array(&$this, 'display_information_box'));
			}

			wp_enqueue_script(
				'timer',
				plugins_url('/js/jquery.countdown.min.js', __FILE__),
				array('jquery')
			);

			wp_enqueue_script(
				'ajaxed-comments-front',
				plugins_url('/js/front.js', __FILE__),
				array('jquery', 'jquery-color', 'timer')
			);

			wp_localize_script(
				'ajaxed-comments-front',
				'acArgs',
				array(
					'editCommEffect' => $options_edit['edit_comm_effect'],
					'showEffect' => $options_msg['show_effect'],
					'hideEffect' => $options_msg['hide_effect'],
					'timeToHide' => $options_msg['remove_message'],
					'hideInlineActions' => $options_edit['show_actions_on_hover'],
					'ajaxurl' => admin_url('admin-ajax.php'),
					'untrash' => __('Restore', 'ajaxed-comments'),
					'trash' => __('Trash', 'ajaxed-comments'),
					'unspam' => __('Unspam', 'ajaxed-comments'),
					'spam' => __('Spam', 'ajaxed-comments'),
					'unapprove' => __('Unapprove', 'ajaxed-comments'),
					'approve' => __('Approve', 'ajaxed-comments'),
					'holdColor' => $options_edit['highlight_colors']['unapproved'],
					'trashColor' => $options_edit['highlight_colors']['trash'],
					'spamColor' => $options_edit['highlight_colors']['spam'],
					'highlightComments' => $options_edit['highlight_comments'],
					'timer' => $options_edit['timer'],
					'errUnknown' => __('Error has occurred. Please try again later or reload a page.', 'ajaxed-comments'),
					'errEmptyComment' => __('Comment is empty.', 'ajaxed-comments'),
					'deleteComment' => __('Are you sure you want to delete this comment?', 'ajaxed-comments')
				)
			);

			wp_enqueue_style('ajaxed-comments-front', plugins_url('/css/front.css', __FILE__));

			if($options_edit['highlight_comments'] === 'yes')
			{
				wp_enqueue_style('ajaxed-comments-colors', plugins_url('/css/colors.css?'.time(), __FILE__));
			}
		}
	}


	/**
	 * Loads textdomain
	*/
	public function load_textdomain()
	{
		load_plugin_textdomain('ajaxed-comments', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
	}


	/**
	 * Add links to Support Forum
	*/
	public function plugin_extend_links($links, $file) 
	{
		if (!current_user_can('install_plugins'))
			return $links;
	
		$plugin = plugin_basename(__FILE__);
		
		if ($file == $plugin) 
		{
			return array_merge(
				$links,
				array(sprintf('<a href="http://www.dfactory.eu/support/forum/ajaxed-comments/" target="_blank">%s</a>', __('Support', 'ajaxed-comments')))
			);
		}
		
		return $links;
	}


	/**
	 * Add links to Settings page
	*/
	function plugin_settings_link($links, $file) 
	{
		if(!is_admin() || !current_user_can('manage_options'))
			return $links;

		static $plugin;

		$plugin = plugin_basename(__FILE__);

		if($file == $plugin) 
		{
			$settings_link = sprintf('<a href="%s">%s</a>', admin_url('options-general.php').'?page=ajaxed-comments-options', __('Settings', 'ajaxed-comments'));
			array_unshift($links, $settings_link);
		}

		return $links;
	}
}

$ac_in = new AjaxedComments();
?>