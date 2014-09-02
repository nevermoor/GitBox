/** Author InkThemes ***/
jQuery('document').ready(function($){
var commentform=$('#commentform'); // find the comment form
    commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
    var statusdiv=$('#comment-status'); // define the info panel
	var list ;
	     $('a.comment-reply-link').click(function(){
	      list = $(this).parent().parent().parent().attr('id');
		   	 });
	 
    commentform.submit(function(){
        //serialize and store form data in a variable
        var formdata=commentform.serialize();
        var parent=$('#commentform #comment_parent').val();
        //Add a status message
        statusdiv.html('<p>Processing...</p>');
        //Extract action URL from commentform
        var formurl=commentform.attr('action');
        //Post Form with data
        
        $.ajax({
            type: 'post',
            url: formurl,
            data: formdata,
            error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                },
            success: function(data, textStatus){
                if(data == "success" || textStatus == "success"){
                    statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
                    //alert(data);
                    if($("#comments").has("ol.commentlist").length > 0){
						if(list != null){
							alert('prepend');
							$('div.rounded').prepend(data);
						}
						else{
		                   	var location = $('#comment-'+parent);
		                   	alert('4: '+location.toSource());
		                   	if (location.id.length != 0)
		                   		location.append(data);
		                   	else
		                   		$('ol.commentlist').append(data);
		                   	$('textarea#comment-form')[0].val('');
	               			alert ($('textarea#comment-form')[0].val());
	                	}
	            	} 
	            	else{
						alert('no success');
		              	$("#commentsbox").find('div.post-info').prepend('<ol class="commentlist"> </ol>');
		              	$('ol.commentlist').html(data);             
	                }

                }
                
                else{
                    statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                    commentform.find('textarea[name=comment]').val('');
                }
            }
        });
        return false;
    });
});

