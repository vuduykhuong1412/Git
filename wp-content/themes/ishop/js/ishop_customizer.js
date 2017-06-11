jQuery(document).ready(function() {

	jQuery( "#sortable" ).sortable();
	
	jQuery( "#sortable" ).disableSelection();
	


	
	jQuery('.wp-full-overlay-sidebar-content').prepend('<a style="width: 80%; margin: 20px auto 20px auto; display: block; text-align: center;" href="http://www.insertcart.com/product/ishop-wordpress-theme/" class="button" target="_blank">{pro}</a>'.replace('{pro}',scatmanjhon.pro));
	
	jQuery( '.ui-state-default' ).on( 'mousedown', function() {

		jQuery( '#customize-header-actions #save' ).trigger( 'click' );

	});
	
});
