/*
 * This javascript animate the webpage elements. For example, menus fly up.
 * By Brian Morgan
 * @Package HopefulTheme
 */

jQuery(document).ready( function() {
/* animate the menu */
jQuery(".menu-container ul.menu > li").mouseenter(function() {
	jQuery(this).animate( {marginTop:"-0.5em"} );
});
jQuery(".menu-container ul.menu > li").mouseleave( function() {
	jQuery(this).animate( {marginTop:"0"} );
});
/* animate the buttons */
jQuery(".button").mouseenter( function() {
	jQuery(this).animate( {opacity: 1, paddingTop:"0.5em", paddingBottom:"0.5em"}, 170 );
});
jQuery(".button").mouseleave( function() {
	jQuery(this).animate( {opacity: 0.8, paddingTop:"0.1em", paddingBottom:"0.1em"}, 170 );
});
});