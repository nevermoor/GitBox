jQuery(document).ready(function($){
    $('input[name="com_paging"]').eq(0).click(function(){
           $('input[name="com_per_page"]').attr('disabled', false);
           $('select[name="num_per_page"]').attr('disabled', false);
           $('input[name="pager_pos"]').attr('disabled', false);
    });
   $('input[name="com_paging"]').eq(1).click(function(){
           $('input[name="com_per_page"]').attr('disabled', true);
           $('select[name="num_per_page"]').attr('disabled', true);
           $('input[name="pager_pos"]').attr('disabled', true);
    });
});