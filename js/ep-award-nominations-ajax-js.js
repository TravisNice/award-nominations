 ( function( $ ) {
  $('#upload_form').on('submit', function(e){
		       e.preventDefault();
		       var $this = $(this),
		       nonce = $this.find('#image_upload_nonce').val(),
		       images_wrap = $('#images_wrap'),
		       status = $('#status'),
		       formdata = false;
		       
		       if ( $this.find('#images').val() == '' ) {
		       alert('Please select an image to upload');
		       return;
		       }
		       
		       status.fadeIn().text('Loading...')
		       
		       if (window.FormData) {
		       formdata = new FormData();
		       }
		       var files_data = $('#images');
		       
		       $.each($(files_data), function(i, obj) {
			      $.each(obj.files, function(j, file) {
				     formdata.append('files['+j+']', file);
				     })
			      });
		       // our AJAX identifier
		       
		       formdata.append('action', 'upload_images');
		       formdata.append('nonce', nonce);
		       
		       $.ajax({
			      url: localizedScript.ajaxurl,
			      type: 'POST',
			      data: formdata,
			      dataType: 'json',
			      processData: false,
			      contentType: false,
			      success: function(data) {
			      
			      if (data.status) {
			      images_wrap.append(data.message);
			      status.fadeIn().text('Image uploaded').fadeOut(2000);
			      } else {
			      status.fadeIn().text(data.message);
			      }
			      },
			      
			      xhr: function( event ) {
			      var xhr = new window.XMLHttpRequest();
			      xhr.upload.addEventListener("progress", function(event) {
							  var percent = event.loaded / event.total * 100;
							  status.fadeIn().text(Math.round(percent) + "% complete");
							  }, false);
			      xhr.addEventListener("progress", function(event){
						   var percent = ((event.loaded / event.total) * 100);
						   status.fadeIn().text( Math.round(percent) + "% complete");
						   },false);
			      return xhr;
			      }
			      
			      });
		       
		       });
  } )( jQuery );
