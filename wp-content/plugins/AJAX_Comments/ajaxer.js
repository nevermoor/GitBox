var $j = jQuery.noConflict(); 



function getCheckedValue(radioObj) {

	if(!radioObj)

		return "";

	var radioLength = radioObj.length;

	if(radioLength === undefined)

		if(radioObj.checked)

			return radioObj.value;

		else

			return "";

	for(var i = 0; i < radioLength; i++) {

		if(radioObj[i].checked) {

			return radioObj[i].value;

		}

	}

	return "";

}





function refreshList(forced)

{

	var rate = getCheckedValue(document.getElementsByName("rate"));



	if (rate > 0)

	{

        	$j("#AJAX_List")

            		.slideUp()

            		.load("./?page_id=2254", function() {

                		$j(this).slideDown();

            		});



		$j("#AJAX_List").stopTime("refresher");

		$j("#AJAX_List").oneTime(rate+"s", "refresher", function() {

        		refreshList(false);

    		});

	}

	else if (forced)

	{

        	$j("#AJAX_List")

            		.slideUp()

            		.load("./?page_id=2254", function() {

                		$j(this).slideDown();

            		});		

	}

	else

	{ 

	//If refresh is off, check back in 60 seconds

		//alert ("Refresh Off");

		$j("#AJAX_List").stopTime("refresher");

		//$j("#AJAX_List").oneTime(rate+"s", "refresher", function() {

        	//	refreshList(false);

		//});

	}

}



$j(function(){

		

    refreshList(true);



});