   
  jQuery(function($) {

    /*$( "#Birthday" ).datepicker({
      changeMonth: true,
      changeYear: true ,
      yearRange: "1947:"+ new Date().getFullYear() });*/
  });
 
 
function checkPasswordStrength( $pass1,
                                $pass2,
                                $strengthResult,
                                $submitButton,
                                blacklistArray ) {
    var pass1 = $pass1.val();
    var pass2 = $pass2.val();
 
    // Reset the form & meter
    
        $strengthResult.removeClass( 'short bad good strong' );
 
    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
 
    // Get the password strength
    var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );
 
    // Add the strength meter results
    switch ( strength ) {
 
        case 2:
            $strengthResult.addClass( 'bad' ).html( pwsL10n.bad );
            break;
 
        case 3:
            $strengthResult.addClass( 'good' ).html( pwsL10n.good );
            break;
 
        case 4:
            $strengthResult.addClass( 'strong' ).html( pwsL10n.strong );
            break;
 
        case 5:
            $strengthResult.addClass( 'short' ).html( pwsL10n.mismatch );
            break;
 
        default:
            $strengthResult.addClass( 'short' ).html( pwsL10n.short );
 
    }
 
    // The meter function returns a result even if pass2 is empty,
    // enable only the submit button if the password is strong and
    // both passwords are filled up

    return strength;
}

jQuery( document ).ready( function( $ ) {
     // Binding to trigger checkPasswordStrength
	var ButtonValue = 0;
    $('#change-password').on('click',function(e) {
        if ($("#old-pass").val() == '' || ( $("#old-pass").val().length < 6 )) {
            ButtonValue = $(this).val();
            alert("Current  password should not be empty or less than 6");
        }
        else if ($("input[name=pass1]").val() == '' || ( $("input[name=pass1]").val().length < 6 )) {
            ButtonValue = $(this).val();
            alert("Password1 should not be empty or less than 6");
        }
        else if ($("input[name=pass2]").val() == '' || ( $("input[name=pass2]").val().length < 6 )) {
            ButtonValue = $(this).val();
            alert("Password2 should not be empty or less than 6");
        }
        else if ($("input[name=pass1]").val() !== $("input[name=pass2]").val()) {
            ButtonValue = $(this).val();
            alert("New password does not match with confirm new password");
        }
    });

	$("input" ).on('keyup keypress', function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
/*    $( 'body' ).on( 'keyup', 'input[name=pass1], input[name=pass2]',
        function( event ) {
            checkPasswordStrength(
                $('input[name=pass1]'),         // First password field
                $('input[name=pass2]'), // Second password field
                $('#pass-strength'),           // Strength meter
                $('input[type=submit]'),           // Submit button
                ['black', 'listed', 'word']        // Blacklisted words
            );
        }
    );*/


	$('form').submit(function(e){        //psuedo code
		if(ButtonValue == 1 )
		{ ButtonValue = 0; if(e.preventDefault) e.preventDefault(); else e.returnValue = false;}});


	$ ( '#delete-button' ).on ( 'click', function ( e ) {
		var txt;
		ButtonValue = 1;
		var r = confirm ( "Do you really want to delete image ?" );
		if ( r == true ) {
			$ ( "#delete" ).val ( '1' );
			$ ( '#your-profile' ).submit ();
		} else {

		}

	} );

});



