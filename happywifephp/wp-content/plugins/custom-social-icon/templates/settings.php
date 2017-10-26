<div class="wrap">
    <h2>Custom Social Icon</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('CSI_template-group'); ?>
        <?php @do_settings_fields('CSI_template-group'); ?>		
        <table class="form-table">  
            <tr valign="top">
                <th scope="row"><label for="_csi_link">Icons</label></th>
                <td>
					<?php  $get_CSI_links =get_option('_csi_link');	?>				
					
					<div id="CSI_content">
												
								<?php
								$counter = 0;
								$CSI_length = count($get_CSI_links);
								if(!empty($get_CSI_links)){
									 foreach($get_CSI_links as $single_CSI_link){									 
										$get_path_id =  "$single_CSI_link[path]";									
										$path =  wp_get_attachment_url($get_path_id );
										?>
										<div class="space" id="input_<?php  echo (int)$counter; ?>">			
										<span><b>Link<?php  echo (int)$counter+1; ?> :</b></span><input id="_csi_link" name="_csi_link[<?php echo (int)$counter; ?>][link]" class="left txt" type="text"  value="<?php  echo "$single_CSI_link[link]"; ?>" >
										<a href="javascript:;" class="ls_test_media">Click To change Image</a>
										<input type="hidden" class="set_filepath_hidden" name="_csi_link[<?php echo (int)$counter; ?>][path]"  value="<?php  echo "$single_CSI_link[path]"; ?>" />
										
											<span class="txt_show_des" >Selected File :</span><img class="CSI_img_path" src="<?php echo $path  ?>"  atl="<?php echo $get_path_id ?>">
										
											<img data-id="<?php  echo (int)$counter+1; ?>" src="<?php echo plugins_url( 'images/remove.png', dirname(__FILE__) ) ?>" class="remove"/>
											<br />									 
										<?php 									
										if($CSI_length==((int)$counter+1)){ ?>										
											<img data-id=<?php  echo (int)$counter+1; ?>  class="add right" src=" <?php echo plugins_url( 'images/add.png', dirname(__FILE__) ) ?> ">
										<?php } ?>
										
										</div>
										<?php
										(int)$counter++;
									} 
								
								}else { ?>
									<div class="space" id="input_<?php  echo (int)$counter; ?>">			
										<span><b>Link1 :</b></span><input id="_csi_link" name="_csi_link[<?php echo (int)$counter; ?>][link]" class="left txt" type="text"  value="" >
										<a href="javascript:;" class="ls_test_media">Click To change Image</a>
										<input type="hidden" class="set_filepath_hidden" name="_csi_link[<?php echo (int)$counter; ?>][path]"  value="" />
										
											<span class="txt_show_des" >Selected File :</span><img class="CSI_img_path" src="<?php echo plugins_url( 'images/no_image.png', dirname(__FILE__) ) ?>"  atl="no image">
										
											<img data-id="<?php  echo (int)$counter+1; ?>" src="<?php echo plugins_url( 'images/remove.png', dirname(__FILE__) ) ?>" class="remove"/>
											<br />
											<img data-id=<?php  echo (int)$counter+1; ?>  class="add right" src=" <?php echo plugins_url( 'images/add.png', dirname(__FILE__) ) ?> ">	
										
										</div>
									
								<?php } ?>
								
								
					   </div>
					</td>
            </tr>            	
        </table>
        <?php @submit_button(); ?>
    </form>
</div>
