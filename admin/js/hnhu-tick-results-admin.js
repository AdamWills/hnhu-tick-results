(function( $ ) {
	'use strict';

	$(function() {

		var $tick_type_field  = $('#acf-field-tick_type'),
				$status_field = $('#acf-field-status'),
				tick_type = '',
				initial_display = true;

		// when the tick type changes, we need to populate the status options
		$tick_type_field.on('change', function () {

			// Get selected value
      $tick_type_field.find('option:selected' ).each(function() {
          tick_type = $( this ).val();
      });

			// set the Status field to "loading" so the user can see that something is happening...
			$status_field.html( $('<option></option>').val('0').html('Loading...').attr({ selected: 'selected', disabled: 'disabled'}) );

			// prepare data to send via ajax
			var data = {
				action: 'add_tick_types',
				tick_nonce: tick_vars.tick_nonce,
				tick_type: tick_type
			};

			// send data to wp ajax
			$.post( ajaxurl, data, function(response) {

					if( response ){

						// disable the field while it's being updated
						$status_field.attr('disabled','disabled').html('');

						// if there's multiple options, give the user an initial selection
						if (response.length > 1) {
							$status_field.html( $('<option></option>').val('0').html('-- Select Status --').attr({ selected: 'selected', disabled: 'disabled'}) );
						}
						// add the other options!
            $.each(response, function(val, text) {
							// if this is the first time this function is running, we need to check to see if we need to load an initial value
							if (initial_display && text === tick_vars.selected_status) {
								$status_field.append( $('<option></option>').val(text).html(text).attr('selected','selected') );
							} else {
                $status_field.append( $('<option></option>').val(text).html(text) );
							}
            });

            // // Enable 'Select Area' field
            $status_field.removeAttr( 'disabled' );
						initial_display = false;
          } else {
						alert('There seems to have been an error getting the status options from this tick type.');
					}
        });

    }).change();

	 });

})( jQuery );
