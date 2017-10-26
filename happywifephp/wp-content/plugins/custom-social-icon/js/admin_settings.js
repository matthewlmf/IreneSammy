jQuery(document).ready(function($){
	var add_image_path= CSI_obj_name.CSI_image_url;
    var id=2,txt_box;
	$('#CSI_content').on('click','.add',function(){		
		  $(this).remove();
		  var counter = parseInt($(this).attr('data-id'));
		  var next_counter =parseInt(counter)+1;		  
		  txt_box='<div class="space" id="input_'+id+'" ><span><b>Link'+next_counter+' :</b></span><input type="text" name="_csi_link['+counter+'][link]" class="left txt"/><a href="javascript:;" class="ls_test_media">Click To change Image</a><input type="hidden" class="set_filepath_hidden" name="_csi_link['+counter+'][path]"  /><span class="txt_show_des" >Selected File :</span><img class="CSI_img_path" src="'+add_image_path+'no_image.png"  atl="<?php echo $get_path_id ?>"><img data-id="'+counter+'" src="'+add_image_path+'remove.png" class="remove"/><br /><img data-id="'+(counter+1)+'" class="add right" src="'+add_image_path+'add.png" /></div>';
		  $("#CSI_content").append(txt_box);
		  
		  id++;
	});

	$('#CSI_content').on('click','.remove',function(){		
	        var parent=$(this).parent().prev().attr("id");
			var parent_im=$(this).parent().attr("id");
			$("#"+parent_im).slideUp('medium',function(){
				$("#"+parent_im).remove();
				if($('.add').length<1){
					$("#"+parent).append('<img src="'+add_image_path+'add.png" class="add right"/> ');
				}
			});
	});

	var custom_file_frame;
	var click_btn_obj ;
   $(document).on('click', '.ls_test_media', function(event) {
      event.preventDefault();
      click_btn_obj=$(this);
      //If the frame already exists, reopen it
      if (typeof(custom_file_frame)!=="undefined") {
         custom_file_frame.close();
      }
 
      //Create WP media frame.
      custom_file_frame = wp.media.frames.customHeader = wp.media({
         //Title of media manager frame
         title: "Sample title of WP Media Uploader Frame",
         library: {
            type: 'image'
         },
         button: {
            //Button text
            text: "insert File"
         },
         //Do not allow multiple files, if you want multiple, set true
         multiple: false
      });
 
      //callback for selected image
      custom_file_frame.on('select', function() {
         
        var attachment = custom_file_frame.state().get('selection').first().toJSON();
         var get_img_path = attachment.id;
         var get_img_src= attachment.url;         
           
        $(click_btn_obj).siblings('.show_fplink').attr('href',get_img_path);
        $(click_btn_obj).siblings('.show_fplink').html(get_img_path);
        $(click_btn_obj).siblings('.set_filepath_hidden').val(get_img_path);
        $(click_btn_obj).siblings('.CSI_img_path').attr('src',get_img_src);
        
      $(click_btn_obj).siblings('.txt_show_des').show();
        
        
         
      });
 
      //Open modal
      custom_file_frame.open();
   });
});

