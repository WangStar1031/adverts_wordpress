jQuery(document).ready(function(){
	jQuery('#city_meta_box_country').change(function(e) {
		var data = {
			'action': 'get_states_of_country',
			'CID': jQuery(this).val()
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery("#city_meta_box_state").length>0)
			{
				jQuery("#city_meta_box_state").html(response);
			}
		});
    });
	
	jQuery('#post').validate();
	
});