jQuery( document ).ready( function( $ ) {

	/**
	 * Tooltips and Popovers
	 *
	 * Examples:
	 * <button data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button>
	 * <button data-toggle="popover" data-placement="top" data-content="The sample popover text to display." title="Popover at Top">Popover at Top</button>
	 */
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="tooltip"]').tooltip();

} );