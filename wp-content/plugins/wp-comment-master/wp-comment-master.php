<?php
/*
Plugin Name: wp-comment-master
Plugin URI: http://yjlblog.com
Description: an elegant and must-have comment plugin to better satisfy your visitors, it has two main features: AJAX comment posting and comment paginitaion.
Version: 1.7
Author: Yijie Li
Author URI: http://yjlblog.com

    Copyright 2010  Yijie Li  (email: bingjie2680@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License    
    along with this program; if not, write to the Free Software    
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('wp_enqueue_scripts', 'wpcm');
function wpcm(){
   if(!is_admin()){
      if(get_option('autogrow')!='disable'){
          wp_enqueue_script('autosize_js', WP_PLUGIN_URL.'/wp-comment-master/autoresize.jquery.min.js',array('jquery'),'',true);
      }
      if(is_single())wp_enqueue_script('paginating_js', WP_PLUGIN_URL.'/wp-comment-master/cm.js',array('jquery'),'',true);
      wp_enqueue_style('paginating_css', WP_PLUGIN_URL.'/wp-comment-master/cm.css');
      wp_localize_script('paginating_js','yjlSettings',array(
           'pagination'=>get_option('com_paging'),
            'comPerpage'=>get_option('com_per_page'),
            'numPerpage'=>get_option('num_per_page'),   
            'pagerPos'=>get_option('pager_pos'),
            'repForm'=>get_option('rep_form'),
            'gifUrl'=>WP_PLUGIN_URL.'/wp-comment-master/ajax-loader.gif',
            'prev'=>get_option('yjlprev'),
            'next'=>get_option('yjlnext'),
            'timeOut'=>get_option('yjltimeout'),
            'fast'=>get_option('yjlfast'),
            'thank'=>get_option('yjlthank'),
            'order'=>get_option('comment_order'),
            'autoGrow'=>get_option('autogrow')
      ));
   }
}

add_action('admin_init', 'wpcm_admin_init');
function wpcm_admin_init(){
   wp_enqueue_script('admin_js', WP_PLUGIN_URL.'/wp-comment-master/admin.js',array('jquery'),'',true);
}

add_action('admin_menu', 'mt_add_pages');
// action function for above hook
function mt_add_pages() {
    add_options_page('WP-comment-master','WP-comment-master', 'level_4', 'WP-comment-master', 'YJL_options');
    add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
         register_setting( 'YJL-settings-group', 'com_paging' );
 	 register_setting( 'YJL-settings-group', 'com_per_page' );
  	 register_setting( 'YJL-settings-group', 'num_per_page' );
	 register_setting( 'YJL-settings-group', 'pager_pos' );
         register_setting( 'YJL-settings-group', 'rep_form' );
         register_setting( 'YJL-settings-group', 'yjlprev' );
         register_setting( 'YJL-settings-group', 'yjlnext' );
         register_setting( 'YJL-settings-group', 'yjltimeout' );
         register_setting( 'YJL-settings-group', 'yjlfast' );
         register_setting( 'YJL-settings-group', 'yjlthank' );
         register_setting( 'YJL-settings-group', 'autogrow' );
}

function YJL_options() { ?>
   <div class="wrap">
      <h2>WP-Comment-Master Settings:</h2>
      <form method="post" action="options.php">
       <?php settings_fields( 'YJL-settings-group' ); ?>
        <table class="form-table">       
        <tr valign="top" >
          <th scope="row">Reposition the comment form before all comments</th>
          <td>
            <?php $rep_form=get_option('rep_form');?>
          <input type="radio" name="rep_form" value="enable" <?php if( $rep_form!='disable')echo 'checked';?> >Enable 
          <input type="radio" name="rep_form" value="disable" <?php if( $rep_form=='disable')echo 'checked';?>  >Disable
          </td></tr>       

<tr valign="top">
          <th scope="row">Textarea autogrow</th>
          <td>  
               <?php $autogrow=get_option('autogrow');?>
                <input type="radio" name="autogrow" value="enable" <?php if( $autogrow!='disable')echo 'checked';?> >Enable
                <input type="radio" name="autogrow" value="disable" <?php if( $autogrow=='disable')echo 'checked';?>  >Disable
                <br>
          </td>
          </tr>    

         <tr valign="top">
          <th scope="row"><strong>Pagination settings:</strong></th>
           <td></td>
          </tr>

        <tr valign="top">
          <th scope="row">Comment Pagination</th>
          <td>  
              <?php $com_paging=get_option('com_paging');?>
                <input type="radio" name="com_paging" value="enable" <?php if( $com_paging!='disable')echo 'checked';?> >Enable
                <input type="radio" name="com_paging" value="disable" <?php if( $com_paging=='disable')echo 'checked';?>  >Disable
          </td>
          </tr>

          <tr valign="top">
            <th scope="row">Comments per page</th>
            <td><input name="com_per_page" id="com-per-page" value="<?php echo get_option('com_per_page'); ?>" /><br>(If you enable threaded comments,threaded comments does not count towards this number.)</td>
          </tr>
          <tr valign="top">
          <th scope="row">Number of page-number to show</th>
          <td>  <select id="num_per_page" name="num_per_page">
              <?php $num_per_page=get_option('num_per_page');?>
                <option value="5" <?php if($num_per_page==5)echo 'selected';?>  >5</option>
                <option value="3" <?php if($num_per_page==3)echo 'selected';?> >3</option>  
                <option value="7" <?php if($num_per_page==7)echo 'selected';?>  >7</option>
                <option value="9" <?php if($num_per_page==9)echo 'selected';?>  >9</option>
                <option value="11" <?php if($num_per_page==11)echo 'selected';?>  >11</option>
                <option value="13" <?php if($num_per_page==13)echo 'selected';?>  >13</option>
             </select>(default 5)             
          </td>
          </tr>
          <tr valign="top">
          <th scope="row">Page-number position</th>
          <td>  
               <?php $pager_pos=get_option('pager_pos');?>
                <input type="radio" name="pager_pos" value="before" <?php if( $pager_pos!='after'&& $pager_pos!='both')echo 'checked';?> >Before comments<br>
                <input type="radio" name="pager_pos" value="after" <?php if( $pager_pos=='after')echo 'checked';?>  >After comments<br>
                <input type="radio" name="pager_pos" value="both" <?php if( $pager_pos=='both')echo 'checked';?>  >Both before and after comments
          </td>
          </tr>       

         <tr valign="top">
          <th scope="row"><strong>Custom output Text:</stong></th>
           <td></td>
          </tr>
         <tr valign="top">
          <th scope="row">Default Text:</th>
           <td>Custom Text:</td>
          </tr>

          <tr valign="top">
            <th scope="row">'Prev'</th>
            <td><input name="yjlprev" id="yjlprev" value="<?php echo get_option('yjlprev'); ?>" /></td>
          </tr>
           <tr valign="top">
           <th scope="row">'Next'</th>
            <td><input name="yjlnext" id="yjlnext" value="<?php echo get_option('yjlnext'); ?>" /></td>
          </tr>
           <tr valign="top">
            <th scope="row">'Error:Server time out,try again!'</th>
            <td><input name="yjltimeout" id="yjltimeout" value="<?php echo get_option('yjltimeout'); ?>" /></td>
          </tr>
           <tr valign="top">
            <th scope="row">'Please slow down,you are posting to fast!'</th>
            <td><input name="yjlfast" id="yjlfast" value="<?php echo get_option('yjlfast'); ?>" /></td>
          </tr>

           <tr valign="top">
            <th scope="row">'Thank you for your comment!'</th>
            <td><input name="yjlthank" id="yjlthank" value="<?php echo get_option('yjlthank'); ?>" /></td>
          </tr>

          </table>
        <p class="submit">
         <input type="submit" class="button-primary" value="Save Changes" />
       </p>
     </form>
  <p>Thank you for using wp-comment-master, if you have any suggestion,you are very welcom to <a href="http://yjlblog.com/wp-comment-master">visit me</a></p>
   </div>
<?php } ?>