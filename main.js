jQuery( document ).ready(function($){

	$( 'a.toggle-href' ).click(function(){
		$( $( this ).attr( 'href' ) ).toggle();

		return false;
	});

	$( '.hide' ).hide();

	$( 'form.replace' ).submit(function(){
		return confirm( 'Are you ABSOLUTELY sure?' );
	});

	$( '.form-table thead tr th input' ).change(function(){
		var checked = $(this).attr( 'checked' );
		
		if ( checked ) 
			$( 'input', $( this ).parent().parent().parent().next() ).attr( 'checked', 'checked' );
		else
			$( 'input', $( this ).parent().parent().parent().next() ).removeAttr( 'checked' );
		return false;
	});
	
	$( 'a.preview,a.preview-clean' ).click(function(){
		
		$( '#previewer #preview-file' ).val( $( this ).attr( 'title' ) );
		
		if ( $( this ).hasClass( 'preview-clean' ) )
			$( '#previewer #preview-clean' ).val( 1 );
		else
			$( '#previewer #preview-clean' ).val( '0' );
			
		$( '#previewer' ).submit();
		
		return false;
	});

});