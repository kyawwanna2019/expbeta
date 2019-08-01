<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User tariffs upload
 *
 * Created by Kyaw
 *
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);
?>

<div class="st-create">
  <h2 class="pull-left"> Tariffs Upload </h2>
</div>
<div class="msg">
  <?php
    if (!empty(STUser_f::$msg_uptp)) {
        STUser_f::get_mess_utp();
    }
    ?>
</div>
<?php 
    $admin_packages = STAdminPackages::get_inst();
    $order = $admin_packages->get_order_by_partner(get_current_user_id());
    $enable = $admin_packages->enabled_membership();
    if($enable && $admin_packages->get_user_role() == 'partner'):
        if( $order ):
?>
<div class="row mb20">
  <div class="col-xs-12">
    <?php 
            $item_can_public = $admin_packages->count_item_can_public(get_current_user_id());
            if($item_can_public < 0 ):
        ?>
    <div class="alert alert-warning mt20">
      <?php 
                echo __('<strong>PACKAGE INFORMATIONS:</strong> Some of your items are not published because it exceeds the amount of the package.', ST_TEXTDOMAIN)
            ?>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php else: ?>
<div class="row mb20">
  <div class="col-xs-12">
    <div class="partner-package-info">
      <div class="packages-heading"> <img src="<?php echo get_template_directory_uri(); ?>/img/membership.png" alt="<?php echo TravelHelper::get_alt_image(); ?>" class="heading-image img-responsive"> </div>
      <p class="text-warning"> <?php echo __('Your account need to register a membership package to continue using.', ST_TEXTDOMAIN); ?> </p>
      <a class="btn btn-primary mt10" href="<?php echo esc_url( $admin_packages->register_member_page() ); ?>"> <?php echo __('Register', ST_TEXTDOMAIN) ?></a> </div>
  </div>
</div>
<?php endif; ?>
<?php 
    endif;
?>
<div class="row">
  <div class="col-md-10">
    <?php
        if(!empty($_REQUEST['status'])){
            if($_REQUEST['status'] == 'success'){
                echo '<div class="alert alert-'.$_REQUEST['status'].'">
                        <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                        </button>
                        <p class="text-small">'.st_get_language('user_update_successfully').'</p>
                      </div>';
            }
            if($_REQUEST['status'] == 'danger'){
                echo '<div class="alert alert-'.$_REQUEST['status'].'">
                        <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                        </button>
                        <p class="text-small">'.__("Update not successfully",ST_TEXTDOMAIN).'</p>
                      </div>';
            }
        }
        ?>
    <input type="hidden" name="id_user" value="<?php echo esc_attr($data->ID) ?>">
    
    <!--- Start Test --->
    
    <div class= "col-md-12 upload-form">
      <div class="form-group input-group col-md-12">
        <label for="tariff_name"> Tariff Name </label>
        <div class="col-md-12">
          <input name="tariff_name" class="form-control" value="" type="text" />
        </div>
      </div>
      <div class="form-group input-group">
        <label for="tariff_type">Date Range</label>
        <div class="col-md-12">
          <?php
                              // Sets the top option to be the current year. (IE. the option that is chosen by default).
                              $currently_selected = date('Y'); 
                              // Year to start available options at
                              $earliest_year = $currently_selected - 10;
                              // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                              $latest_year = $currently_selected + 10; 
                               
                              print '<select class="form-control" name="tariff_date_range">';
                              // Loops over each int[year] from current year, back to the $earliest_year [1950]
                              foreach ( range( $latest_year, $earliest_year ) as $i ) {
                                // Prints the option with the next year in range.
								$date_range = "1 November " . $i . ' - ' . "31 October " . ($i + 1);
								 print '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'. $date_range .'</option>';
                              }
							   
                              print '</select>'; 
                              ?>
        </div>
      </div>
      <div class="form-group input-group">
        <label for="tariff_type">
          <?php st_the_language('tariff_file_type') ?>
        </label>
        <div class="col-md-12">
          <select name="tariff_type" class="form-control">
            <option value="ho">Hotel Rate</option>
            <option value="pk">Package Tour</option>
            <option value="tr">Transfer</option>
            <option value="dl">Delux Product</option>
          </select>
        </div>
      </div>
      <div class="form-group input-group">
        <label for="tariff_zone">
          <?php st_the_language('tariff_zone') ?>
        </label>
        <div class="col-md-12">
          <select name="tariff_zone" class="form-control">
            <option value="th">Thailand</option>
            <option value="vn">Vietnam</option>
            <option value="mm">Myanmar</option>
            <option value="ph">Philippines</option>
            <option value="id">Indonesia</option>
          </select>
        </div>
      </div>
      <div class="form-group input-group col-md-12">
        <label for="tariff_market">
          <?php st_the_language('tariff_market') ?>
        </label>
        <div class="col-md-6">
          <input type="checkbox" name="tariff_market" value="wwa" checked="checked">
          &nbsp;World Wide A <br/>
          <input type="checkbox" name="tariff_market" value="wwb">
          &nbsp;World Wide B <br/>
          <input type="checkbox" name="tariff_market" value="eua">
          &nbsp;European Union A <br/>
          <input type="checkbox" name="tariff_market" value="eub">
          &nbsp;European Union B <br/>
          <input type="checkbox" name="tariff_market" value="uka">
          &nbsp;United Kingdom A <br/>
          <input type="checkbox" name="tariff_market" value="ukb">
          &nbsp;United Kingdom B <br/>
          <input type="checkbox" name="tariff_market" value="usa">
          &nbsp;United State and Canada A <br/>
          <input type="checkbox" name="tariff_market" value="usb">
          &nbsp;United State and Canada B <br/>
        </div>
        <div class="col-md-6">
          <input type="checkbox" name="tariff_market" value="ana">
          &nbsp;Australia and New Zealand A <br/>
          <input type="checkbox" name="tariff_market" value="anb">
          &nbsp;Australia and New Zealand B <br/>
          <input type="checkbox" name="tariff_market" value="gea">
          &nbsp;German A <br/>
          <input type="checkbox" name="tariff_market" value="geb">
          &nbsp;German B <br/>
          <input type="checkbox" name="tariff_market" value="fra">
          &nbsp;French A <br/>
          <input type="checkbox" name="tariff_market" value="frb">
          &nbsp;French B <br/>
          <input type="checkbox" name="tariff_market" value="rua">
          &nbsp;Russia A <br/>
          <input type="checkbox" name="tariff_market" value="rub">
          &nbsp;Russia B </div>
      </div>
      <div class="form-group input-group form-group-icon-left">
        <label for="tariff_publish_status">Publish Status</label>
        <div class="col-md-12">
          <input type="checkbox" name="tariff_publish_status" value="publish">
          &nbsp;Publish </div>
      </div>
      <div class="form-group">
        <label>File Upload</label>
        <div class="col-md-12 input-group"> <span class="input-group-btn"> <span class="btn btn-primary btn-file">
          <?php _e("Browse…",ST_TEXTDOMAIN) ?>
          <input name="st_avatar" type="file">
          <input type= "file" name = "files[]" class= "files-data form-control" multiple />
          </span> </span> </div>
      </div> 
      <div class="gap gap-small"></div>
      <div class="form-group upload-response" style="padding:10px;"> </div> 
      <hr>
      <div class= "form-group btn btn-primary" style="padding:0px;">
        <input type="submit" id="uploadfile" value= "Add" class="btn btn-primary btn-upload" />
        &nbsp; <span id="loadingDiv" style="margin-top:5px;"></span> </div>
    </div>
    <script type = "text/javascript">
							
							var fd = new FormData(); 
							var tmpFileList = [];
							var tmpDeleteFileList = [];
							
							function funcDiffArray(a1, a2) {
								var a = [], diff = [];							
								for (var i = 0; i < a1.length; i++) {
									a[a1[i]] = true;
								}
							
								for (var i = 0; i < a2.length; i++) {
									if (a[a2[i]]) {
										delete a[a2[i]];
									} else {
										a[a2[i]] = true;
									}
								}
							
								for (var k in a) {
									diff.push(k);
								}
							
								return diff;
							}
							
							
							function funcDelete(obj){
							  var strFileId = parseInt(jQuery(obj).attr('id').replace("fid_", ""));  
							   var files_data = jQuery('.upload-form .files-data');  
										jQuery.each( files_data , function(i, obj) {
											jQuery.each(obj.files,function(j,file){  
											   if (j == strFileId) {
												 tmpDeleteFileList.push(file.name)
											   }
											})
										}); 
							}; 	
							
                            jQuery(document).ready(function() {  
								
								jQuery('input[type="file"]').change(function(e){ 
								    jQuery('.upload-response').html('');
								    if (jQuery('.upload-response').css('visibility') === 'hidden') {  
										jQuery('.upload-response').show();   
								    } 
								    
									for (var iFileCount = 0; iFileCount < e.target.files.length; iFileCount++){
											var fileName = e.target.files[iFileCount].name;
											
											jQuery('.upload-response').append('<div class="alert alert-warning alert-dismissible"><span onclick="funcDelete(  this)" id="fid_' + iFileCount + '" class="close" data-dismiss="alert" aria-label="close">&times;</span>' + fileName + '</div>'); 
											} 
											jQuery('.upload-response').fadeIn(400);
											
									 		
									 	var files_data = jQuery('.upload-form .files-data');  
										jQuery.each(jQuery(files_data), function(i, obj) {
											jQuery.each(obj.files,function(j,file){ 
												tmpFileList.push(file.name); 
											})
										});	
									  
								}); 
								
                                // When the Upload button is clicked... 
                                jQuery('body').on('click', '.upload-form .btn-upload', function(e){
                                    	e.preventDefault;									 
									  
										var files_data = jQuery('.upload-form .files-data');  
										var curFileCount = 0;
										var addFileCount = 0; 
										
										var tmpCurrentFileList = funcDiffArray(tmpDeleteFileList,tmpFileList);
										
										jQuery.each(jQuery(files_data), function(i, obj) {
											 for (var curFileCount = 0; curFileCount < tmpCurrentFileList.length; curFileCount++)
											   { 
											        jQuery.each(obj.files,function(j,file){  
													   if (tmpCurrentFileList[curFileCount] == file.name){ 
														 fd.append('files[' + addFileCount + ']', file);
														 addFileCount += 1;
													   } 
												 	});
											   }
											
										}); 
										 
										tmpFileList = [];
										tmpDeleteFileList = []; 
									
										if (jQuery('.upload-response').css('visibility') === 'hidden') {  
											jQuery('.upload-response').show();  
										} 
										
                                    
									var arr_tariff_market = 
									jQuery('input:checkbox[name="tariff_market"]:checked')
										.map(function() {
											return jQuery(this).val();
										}).get(); 
										
										var tariff_publish_status = "draft"; 
										if(jQuery('input:checkbox[name="tariff_publish_status"]').is(":checked")) {
												 tariff_publish_status = "publish";
											} else {
												 tariff_publish_status = "draft";
											}  
											
											 
									
									fd.append('tariffId', 0);
									if (jQuery("select[name=tariff_date_range]").val() != "") { fd.append('tariff_date_range', jQuery("select[name=tariff_date_range]").val());}
									if (jQuery("select[name=tariff_type]").val() != "") { fd.append('tariff_type', jQuery("select[name=tariff_type]").val());}
									if (jQuery("select[name=tariff_zone]").val() != "") { fd.append('tariff_zone', jQuery("select[name=tariff_zone]").val());} 
									if (jQuery("input[name=tariff_name]").val() != "") { fd.append('tariff_name', jQuery("input[name=tariff_name]").val());} 
  
									fd.append('tariff_market', arr_tariff_market); 	
									fd.append('tariff_publish_status', tariff_publish_status);					
									fd.append('actionstatus', "insert");
                                    // our AJAX identifier
                                    fd.append('action', 'cvf_upload_files'); 
									
									
									jQuery('#loadingDiv').hide()  // Hide it initially
												.ajaxStart(function() {   
														jQuery(this).html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px;line-height:30px;"></i>&nbsp;');
														jQuery(this).show(); 
												})
												.ajaxStop(function() {
													jQuery(this).html("");
													jQuery(this).hide();
												}); 
												
												 
									
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                                        data: fd,
                                        contentType: false,
                                        processData: false,
                                        success: function(response){  
											//------  
											
											jQuery('.upload-response').fadeIn(700, function() { 
													jQuery(this).html(response); // Append Server Response
											});
											
											 setTimeout(function() {
  													jQuery('.upload-response').fadeOut(700, function() { 								
														jQuery(this).html("");
													    location.reload();
													});	
  											 }, 2000);

											
											//------
                                        }
                                    });  
                                });
                            });                     
                            </script> 
  </div>
</div>
