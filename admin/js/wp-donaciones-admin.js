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
		 	loadProgressBars();
      var storeForm = $('#wppb-create-form');

      storeForm.on('submit', function(e){
        e.preventDefault();
        var data = {
					"action"    : 'wppb_store',
          "name"      : $('#name').val(),
          "category"  : $('#category').val(),
          "goal"      : $('#goal').val(),
          "color"     : $('#color').val(),
          "shortcode" : $('#shortcode').val()
        };

				storeProgressBar(data);
      });

			function storeProgressBar(data){
				$('.wppb-create-form-wrap .spinner').show();
				$('.wppb-create-form-wrap .locked-overlay').css({'display':'flex'});

				clearForm();

        $.post(ajax_object.ajax_url, data, function(response){
					$('.wppb-create-form-wrap .spinner').hide();
					$('.wppb-create-form-wrap .locked-overlay').css({'display':'none'});

					if( response ){
						getProgressBar(response);
					}

        });
			}

			function loadProgressBars(){
				let table = $('#wppb-admin-table tbody');
				$.get(ajax_object.ajax_url, {'action' : 'wppb_list'}, function(response){
	        response.forEach(function(pb){
	          let tr = $('<tr></tr>');
						let deleteButton = $('<button class="btn btn-primary" data-id="' + pb.id + '" >Eliminar</button>');
						deleteButton.on('click', function(e){
							let id = $( this ).attr('data-id');
							let domRow = $( e.target ).parent().parent();
							deleteProgressBar(id, domRow);
						});
						let td = $('<td></td>');
						td.append( deleteButton );

	          tr.append('<td>' + pb.name + '</td>');
	          tr.append('<td>' + pb.category + '</td>');
	          tr.append('<td>' + pb.goal + '</td>');
	          tr.append('<td>' + pb.color + '</td>');
	          tr.append('<td>' + pb.shortcode + '</td>');
						tr.append(td);
	          table.append(tr);
	        });
	      });
			}

			function getProgressBar(id){
				$.get(ajax_object.ajax_url, {'action' : 'wppb_show', 'id': id}, function(response){
	        let table = $('#wppb-admin-table tbody');

	        if( response.length ){
						console.log('id is: ' + id);
						console.log( response );

						response.forEach(function(pb){
		          let tr = $('<tr></tr>');
							let deleteButton = $('<button class="btn btn-primary" data-id="' + pb.id + '" >Eliminar</button>');
							deleteButton.on('click', function(e){
								let id = $( this ).attr('data-id');
								let domRow = $( e.target ).parent().parent();
								deleteProgressBar(id, domRow);
							});
							let td = $('<td></td>');
							td.append( deleteButton );

		          tr.append('<td>' + pb.name + '</td>');
		          tr.append('<td>' + pb.category + '</td>');
		          tr.append('<td>' + pb.goal + '</td>');
		          tr.append('<td>' + pb.color + '</td>');
		          tr.append('<td>' + pb.shortcode + '</td>');
							tr.append(td);
		          table.append(tr);
		        });
					}
	      });
			}

			function clearForm(){
				$('#name').val('');
				$('#category').val('');
				$('#goal').val('');
				$('#color').val('#000000');
				$('#shortcode').val('');
			}

			function deleteProgressBar(id, domRow){
				$.post(ajax_object.ajax_url, {'action' : 'wppb_delete', 'id': id}, function(response){
	        if(response){
						domRow.remove();
					}
	      });
			}
	 });

})( jQuery );
