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
      var storeForm 				= $('#wppb-create-form');
			var updateForm 				= $('#wppb-update-form');
			var progressBarsTable = $('#wppb-admin-table tbody');

      storeForm.on('submit', function(e){
        e.preventDefault();
        var data = {
					"action"    : 'wppb_store',
          "name"      : $('#name').val(),
          "category"  : $('#category').val(),
          "goal"      : $('#goal').val(),
          "color"     : $('#color').val()
        };

				storeProgressBar(data, e.target);
      });

			updateForm.on('submit', function(e){
        e.preventDefault();
        var data = {
					"action"    : 'wppb_update',
					"id"        : $('#edit_id').val(),
          "name"      : $('#edit_name').val(),
          "category"  : $('#edit_category').val(),
          "goal"      : $('#edit_goal').val(),
          "color"     : $('#edit_color').val(),
        };

				updateProgressBar(data, e.target);
      });

			function storeProgressBar(data, form){
				showSpinner(form, true);
        $.post(ajax_object.ajax_url, data, function(response){
					showSpinner(form, false);
					if( response ){
						appendProgressBarRow( response );
					}
        });
			}

			function updateProgressBar(data, form){
				showSpinner(form, true);
        $.post(ajax_object.ajax_url, data, function(response){
					if( response.success ){
						progressBarsTable.find('tr').remove();
						$('.edit-progress-bar-form').hide();
						data.id = response.id;
						data.shortcode = `[wppb id="${response.id}"]`;
						loadProgressBars(response);
						showSpinner(form, false);
					}
        });
			}

			function appendProgressBarRow( pb ){
				let tr = $('<tr></tr>');

				let deleteButton = $('<button class="btn btn-primary" data-id="' + pb.id + '" >Eliminar</button>');
				deleteButton.on('click', function(e){
					let id = $( this ).attr('data-id');
					let domRow = $( e.target ).parent().parent();
					deleteProgressBar(id, domRow);
				});

				let updateButton = $('<button class="btn btn-primary" data-id="' + pb.id + '" >Editar</button>');
				updateButton.on('click', function(e){
					let id = $( pb.id ).attr('data-id');
					let domRow = $( e.target ).parent().parent();
					editProgressBar(pb.id, domRow);
				});

				let td = $('<td></td>');
				td.append( deleteButton );
				td.append( updateButton );

				tr.append('<td>' + pb.name + '</td>');
				tr.append('<td>' + pb.category + '</td>');
				tr.append('<td>' + pb.goal + '</td>');
				tr.append('<td>' + pb.color + '</td>');
				tr.append('<td>' + pb.shortcode + '</td>');
				tr.append(td);
				progressBarsTable.append(tr);
			}

			function loadProgressBars(){
				$.get(ajax_object.ajax_url, {'action' : 'wppb_list'}, function(response){
	        response.forEach(function(pb){
	          appendProgressBarRow( pb );
	        });
	      });
			}
			function clearForm(){
				$('#name').val('');
				$('#category').val('');
				$('#goal').val('');
				$('#color').val('#000000');

				$('#edit_name').val('');
				$('#edit_category').val('');
				$('#edit_goal').val('');
				$('#edit_color').val('#000000');
			}

			function deleteProgressBar(id, domRow){
				$.post(ajax_object.ajax_url, {'action' : 'wppb_delete', 'id': id}, function(response){
	        if(response){
						domRow.remove();
					}
	      });
			}

			function editProgressBar(id, domRow){
				$('#edit-progress-bar-id').text( id );
				$('#edit-progress-bar-id').show();
				$('.edit-progress-bar-form').show();

				let name = domRow.children().eq(0).text();
				let category = domRow.children().eq(1).text();
				let color = domRow.children().eq(3).text();
				let goal = domRow.children().eq(2).text();

				$('#edit_id').val( id );
				$('#edit_name').val( name );
				$('#edit_category').val( category );
				$('#edit_color').val( color );
				$('#edit_goal').val( goal );

				updateForm.show();
			}

			function showSpinner(form, show){
				if( form ){
					if( show ){
						form.querySelector('.locked-overlay').style.display = 'block';
						form.querySelector('.spinner').style.display = 'block';
						clearForm();
					}else{
						form.querySelector('.locked-overlay').style.display = 'none';
						form.querySelector('.spinner').style.display = 'none';
					}
				}
			}
	 });

})( jQuery );
