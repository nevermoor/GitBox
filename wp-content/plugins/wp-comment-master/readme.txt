=== Plugin Name ===
Contributors: bingjie2680
Donate link: http://example.com/
Tags: wordpress Comments, ajax comment, ajax comment posting,comment pager,comment pagination,ajax  commenting,AjAX comment paging,comment paging,paged comments,paginated comments,AJAX comment page,AJAX comments
Requires at least: 2.8
Tested up to: 3.1.3
Stable tag: 1.7

== Description ==
Are you looking for a real AJAX comment posting plugin?
Are you seeking for a better solution to present the long-list comments to your site visitors?
Then this plugin is for you.

WP-comment-master is developed mainly in jQuery to enhance the experience of commenting for your site visitors. it has two main features:AJAX comment posting and comment pagination. the AJAX comment posting enables the commenters to post and view the comment instantly without refreshing the page, while the comment pagination paginates all comments into pages with a well presented and structured navigation. if you does not need either of these two features, you can simply disable it.

= Something to note: =
* SEO:pagination still enables your comment to be indexed by Search Engine Crawler
* Minimize Dom traversal to optimize the performance(this is crucial when you use many plugins)
* Compatible up to the newest verson
* Tested with many themes and in all major browsers
* Custom settings eanbled

Please note that this plugin should work with most wordpress themes, but may not work with some themes due to your different theme css construct, in this case, you can leave a comment to me and I will help you get it to work.

See it in action [here](http://yjlblog.com/?p=11#comments)

== Installation ==
1. Go to your site admin->plugins->add new, and search for wp-comment-master.
1. Install it directly and activate it

= or =

1. Download the 'wp-comment-master' plugin from [plugin site](http://yjlblog.com/?p=11)
1. Upload `wp-comment-master` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

In order for the comment pagination to work in a best outcome, it is suggested to do the following settings:
go to site admin panel->settings->discussion, and check that the option below is not ticked:

* Break comments into pages with  top level comments per page and the last first page displayed by default 
Comments should be displayed with the oldernewer comments at the top of each page

and now you are ready to go...

== Screenshots ==

Screenshot and Demo see [here](http://yjlblog.com/?p=11#comments)

== Changelog ==
= 1.7 =
* correct depreciated api

= 1.6 =
* removed settings for dysfuncational AJAX comment
* javascript code remain beautified, so you can make any changes

= 1.5 =
*Small adjustment of css pager number, should be a bit better user-friendly now

= 1.4 =
* comment form textarea auto grow function added(this feature is based on [James Padolsey's](http://james.padolsey.com) plugin
* fiexed the bug that it didn't work with Atahualpa theme
* corrected some spelling errors

= 1.3 =
* code optimized(less code) and absolutly even better performance
* enabled the comment form position back to the top or bottom of comment list after a reply
* enabled custom output text 
* attempt to recover dysfunction AJAX posting added for some themes that have a diffrent css construct
* the option to enable or disable AJAX posting is removed
* After AJAX posting, pagination will always locate where the new comment is

= 1.2 =
* Solved the problem that 'unlogged' in user can not view post instantly in IE, now very visitor can experience the AJAX commenting.
* Fixed the bug that comment from disappeared after posting when page-number is positioned after commentlist
* load the script in footer instead of head to decrease your site loading time.
* 'Thank you' message displyed after successful submission of comment.


= 1.1 =
* Fixed the bug that comment form disappeared after posting a reply when pagination is disabled
* Fixed some logic to be compatible with more themes.
* fnables page-number to be positioned both before and after commentlist
* Animation effect is enabled during AJAX loading
* Fixed the bug that after a reply, the page-number jump back to the first page.


== Upgrade Notice ==
= 1.4 =
textarea auto grow featured added

= 1.3 =
less code, custom text output enabled, please notice some changes to Css construce and setting panel.

= 1.2 =
Sloved the problem of compatiable issue with IE, decrease your site loading time, AJAx commenting more friendly.

= 1.1 =
Compatiable with more themes, correct some confusions


== Frequently Asked Questions == 
none
