jQuery(document).ready(function($){
	

	var selected;
	var shortcode_store = [];
	function check_sidebar_name_field(e) {
		
		var $this = jQuery(this),
			$addButton = $this.siblings('.kopa_shortcode_generate_button');

		if ( $this.val() ) {
			$addButton.removeClass('kopa_button_inactive')
			return;
		}

		$addButton.addClass('kopa_button_inactive');

		return;
	}

	function generate_shortcode(e){
		e.preventDefault();
		var $this = $(this);
		var shortcode;
		var shortcode_name;
		shortcode = '[luxento_megamenu ids="';
		if(selected){
		for (var i = 0; i < selected.length; i++) {
			shortcode = shortcode + selected[i]
			if(i<selected.length - 1){
				shortcode = shortcode + ',';
			}
		};
		shortcode = shortcode + '"]';
		shortcode_name = jQuery('#kopa_megamenu_generator_add_field').val();
		jQuery('.megamenu-shortcode-generated').append('<li class="row">'+
			'<div class="col-md-4">'+ shortcode_name +'</div>' +
			'<div class="col-md-6">'+ shortcode +'</div> '+ 
			'<div class="col-md-2"><span class="remove-shortcode">Remove Shortcode</span></div>' +
		'</li>');
		console.log(shortcode);
		
		shortcode_store.push(shortcode_name + '___' + shortcode);
		var current_shortcode = jQuery('.shortcode_current').val();
		if(!current_shortcode){
			current_shortcode = current_shortcode + ',' + shortcode_store;
		}else{
			current_shortcode = shortcode_store;
		}
		
		jQuery('.shortcode_current').val(current_shortcode);
		jQuery('#kopa_megamenu_generator_add_field').val('');
		jQuery('.kopa_shortcode_generate_button').addClass('kopa_button_inactive');
		}

		
	}
	

	function remove_shortcode(e){
		var $this = jQuery(this);
		var shortcode_block = $this.parents().eq(1);
		shortcode_block.hide();
		var shortcode = $this.data('shortcode');
		var hiddenValue = jQuery('.shortcode_current').val();
		var newValue = hiddenValue.replace(','+shortcode, '');

	}

	jQuery('.kopa_megamenu_add_field').on('keyup', check_sidebar_name_field);
	jQuery('.kopa_shortcode_generate_button').on('click', generate_shortcode);

	jQuery('.remove-shortcode').on('click', remove_shortcode);
	
	jQuery('#megamenu_generator').on('change',function(){
		selected = (jQuery('#megamenu_generator').val());
		
	});
		
});