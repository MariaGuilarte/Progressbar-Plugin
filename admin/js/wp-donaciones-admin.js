(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

   $(function() {
      console.log('Progress bar script mounted');
      var storeForm = $('#wppb-create-form');

      storeForm.on('submit', function(e){
        e.preventDefault();
        var data = {
          "name"      : $('#name').val(),
          "category"  : $('#category').val(),
          "goal"      : $('#goal').val(),
          "color"     : $('#color').val(),
          "shortcode" : $('#shortcode').val(),

          "action"    : 'wppb_store'
        };

        $.post(ajax_object.ajax_url, data, function(response){
          console.log('Progress bars admin: ' + response);
        });
      });

      $.get(ajax_object.ajax_url, {'action' : 'wppb_list'}, function(response){
        let table = $('#wppb-admin-table tbody');

        response.forEach(function(pb){
          console.log('Working');
          let tr = $('<tr></tr>');
          tr.append('<td>' + pb.name + '</td>');
          tr.append('<td>' + pb.category + '</td>');
          tr.append('<td>' + pb.goal + '</td>');
          tr.append('<td>' + pb.color + '</td>');
          tr.append('<td>' + pb.shortcode + '</td>');
          table.append(tr);
        });
      });
	 });

})( jQuery );
