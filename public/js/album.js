$(document).ready(function() {
	
	$("#flash_msg_alert").addClass('in');

	$('#albums-index').on('click', 'a.delete-album',function(event){
        event.preventDefault();
        if(confirm("Esta seguro de Eliminar?")){
	       	var $album_rec_div = $(this);
	        var remove_id = $(this).attr('id');
	        remove_id = remove_id.replace("remove-","");

	        $.post("/album/delete", {
	            id: remove_id
	        },
	        function(data){
	            if(data.response == true){
	            	$album_rec_div.parent().parent().remove();
	            	
	            	$("#flash_txt").html('Album eliminado exitosamente!');
	            	$("#flash_msg").show();
	            	$("#flash_msg_alert").addClass('in');
	            	
	            }
	            else{
	                // print error message
	                console.log('could not remove ');
	            }
	        }, 'json');
        }
    });

    $('.close').click(function () {
      $(this).parent().removeClass('in'); // hides alert with Bootstrap CSS3 implem
    });

});