<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User tariffs edit
 *
 * Created by Kyaw
 *
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);

function decryptData_partner(){ 
$data = $_GET["data"];
$decryptData = base64_decode(strtr($data, '._-', '+/='));
return $decryptData;
}  

function getTariffFilesDetail_partner()
{
$args = array(
    'posts_per_page' => 10,
    'order'          => 'DESC',
    //'post_mime_type' => 'image',
    'post_parent'    => decryptData_partner()// , $post->ID,
    //'post_type'      => 'attachment'
    );

$arrTariffFiles = get_children( $args);   

$strTariffFile = "";

foreach ($arrTariffFiles as $tariffFile) {
	$strTariffFile .= "<div id='divName" . $tariffFile->ID . "' class='alert alert-warning alert-dismissible'><span id='spnName" . $tariffFile->ID . "' data-dismiss='alert'>" . $tariffFile->post_title . "</span>&nbsp;";
	/*
	$strTariffFile .= "<a style='margin-left:10px;float:right;' ";
	$strTariffFile .= "href='./tariffs-download/?file=" . $tariffFile->guid . "'>";
	$strTariffFile .= "<button class='btn btn-default btn-xs' style='float: right; color: #000000;width:70px;'>";
	switch($tariffFile->post_mime_type){
		case "xls" : case "xlsx" :{
			  $strTariffFile .= "EXCEL&nbsp; ";
			  break;
			}
		case "doc" : case "docx" :{
			  $strTariffFile .= "WORD&nbsp; ";
			  break;
			}
		case "ppt" : case "pptx" :{
			  $strTariffFile .= "POWER POINT&nbsp; ";
			  break;
			}
		case "pdf" :{
			  $strTariffFile .= "PDF&nbsp; ";
			  break;
			}
		case "zip" :{
			  $strTariffFile .= "Zip&nbsp; ";
			  break;
			}
		case "rar" :{
			  $strTariffFile .= "Rar&nbsp; ";
			  break;
			}
		case "txt" :{
			  $strTariffFile .= "Text&nbsp; ";
			  break;
			}
			default:{
		 	 $strTariffFile .= $tariffFile->post_mime_type . "File&nbsp; ";
			}
		};
	
	$strTariffFile .=  "<i class='fa fa-download'>&nbsp; </i></button></a>";
	*/
	$strTariffFile .=  "&nbsp;<a href='#modDeleteConfirm' data-toggle='modal'><button class='btn btn-default btn-xs clsdelete' style='color: #000000;width:50px;float:right;' id='delete" . $tariffFile->ID . "' ><i class='fa fa-remove'>&nbsp;</i></button></a>";	
	$strTariffFile .=  "</div>";
	
}

return $strTariffFile; 


}


$tariffItem = get_post(decryptData_partner());
list($activeTariffCountryCode, $activeTariffType, $activeTariffMarketCode, $activeTariffYear) = explode('-', $tariffItem->post_title);
?>

<div class="st-create">
  <h2 class="pull-left"> Tariffs Edit </h2>
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
          <input name="tariff_name" class="form-control" value="<?php echo $tariffItem->post_content; ?>" type="text" />
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
								 print '<option value="'.$i.'"'.($i == $activeTariffYear ? ' selected="selected"' : '').'>'. $date_range .'</option>';
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
        <?php 
		print '<select name="tariff_type" class="form-control">';
		if ($activeTariffType == 'ho'){ print '<option value="ho" selected="selected">Hotel Rate</option>'; } else {print '<option value="ho">Hotel Rate</option>';}
		if ($activeTariffType == 'pk'){ print '<option value="pk" selected="selected">Package Tour</option>'; } else {print '<option value="pk">Package Tour</option>';}
		if ($activeTariffType == 'tr'){ print '<option value="tr" selected="selected">Transfer</option>'; } else {print '<option value="tr">Transfer</option>';}
		if ($activeTariffType == 'dl'){ print '<option value="dl" selected="selected">Delux Product</option>'; } else {print '<option value="dl">Delux Product</option>';}
        print '</select>';
		?>
        </div>
      </div>
      <div class="form-group input-group">
        <label for="tariff_zone">
          <?php st_the_language('tariff_zone') ?>
        </label>
        <div class="col-md-12">
        <?php  
		print '<select name="tariff_zone" class="form-control">';
		if ($activeTariffCountryCode == 'th'){ print '<option value="th" selected="selected">Thailand</option>'; } else {print '<option value="th">Thailand</option>';}
		if ($activeTariffCountryCode == 'vn'){ print '<option value="vn" selected="selected">Vietnam</option>'; } else {print '<option value="vn">Vietnam</option>';}
		if ($activeTariffCountryCode == 'mm'){ print '<option value="mm" selected="selected">Myanmar</option>'; } else {print '<option value="mm">Myanmar</option>';}
		if ($activeTariffCountryCode == 'ph'){ print '<option value="ph" selected="selected">Philippines</option>'; } else {print '<option value="ph">Philippines</option>';}
		if ($activeTariffCountryCode == 'id'){ print '<option value="id" selected="selected">Indonesia</option>'; } else {print '<option value="id">Indonesia</option>';}
        print '</select>'; 
		?>
        </div>
      </div>
      <div class="form-group input-group col-md-12">
        <label for="tariff_market">
          <?php st_the_language('tariff_market') ?>
        </label>
        <div class="col-md-6">
          <?php 
		  	$arrTariffMarketCode = explode(',', $activeTariffMarketCode); 
			 
			$chkWWA = "";
			$chkWWB = "";
			$chkEUA = "";
			$chkEUB = "";
			$chkUKA = "";
			$chkUKB = "";
			$chkUSA = "";
			$chkUSB = "";
			$chkANA = "";
			$chkANB = "";
			$chkGEA = "";
			$chkGEB = "";
			$chkFRA = "";
			$chkFRB = "";
			$chkRUA = "";
			$chkRUB = "";
		    for ($iMarketCode = 0; $iMarketCode < sizeof($arrTariffMarketCode); $iMarketCode++){
				switch ($arrTariffMarketCode[$iMarketCode]){
					 case "wwa" : { $chkWWA = "checked=checked"; break; }
					 case "wwb" : { $chkWWB = "checked=checked"; break; }
					 case "eua" : { $chkEUA = "checked=checked"; break; }
					 case "eub" : { $chkEUB = "checked=checked"; break; }
					 case "uka" : { $chkUKA = "checked=checked"; break; }
					 case "ukb" : { $chkUKB = "checked=checked"; break; }
					 case "usa" : { $chkUSA = "checked=checked"; break; }
					 case "usb" : { $chkUSB = "checked=checked"; break; }
					 case "ana" : { $chkANA = "checked=checked"; break; }
					 case "anb" : { $chkANB = "checked=checked"; break; }
					 case "gea" : { $chkGEA = "checked=checked"; break; }
					 case "geb" : { $chkGEB = "checked=checked"; break; }
					 case "fra" : { $chkFRA = "checked=checked"; break; }
					 case "frb" : { $chkFRB = "checked=checked"; break; }
					 case "rua" : { $chkRUA = "checked=checked"; break; }
					 case "rub" : { $chkRUB = "checked=checked"; break; }
				} 
			}   
		  ?>
        
        
          <input type="checkbox" name="tariff_market" value="wwa" <?php print $chkWWA; ?>>
          &nbsp;World Wide A <br/>
          <input type="checkbox" name="tariff_market" value="wwb" <?php print $chkWWB; ?>>
          &nbsp;World Wide B <br/>
          <input type="checkbox" name="tariff_market" value="eua" <?php print $chkEUA; ?>>
          &nbsp;European Union A <br/>
          <input type="checkbox" name="tariff_market" value="eub" <?php print $chkEUB; ?>>
          &nbsp;European Union B <br/>
          <input type="checkbox" name="tariff_market" value="uka" <?php print $chkUKA; ?>>
          &nbsp;United Kingdom A <br/>
          <input type="checkbox" name="tariff_market" value="ukb" <?php print $chkUKB; ?>>
          &nbsp;United Kingdom B <br/>
          <input type="checkbox" name="tariff_market" value="usa" <?php print $chkUSA; ?>>
          &nbsp;United State and Canada A <br/>
          <input type="checkbox" name="tariff_market" value="usb" <?php print $chkUSB; ?>>
          &nbsp;United State and Canada B <br/>
        </div>
        <div class="col-md-6">
          <input type="checkbox" name="tariff_market" value="ana" <?php print $chkANA; ?>>
          &nbsp;Australia and New Zealand A <br/>
          <input type="checkbox" name="tariff_market" value="anb" <?php print $chkANB; ?>>
          &nbsp;Australia and New Zealand B <br/>
          <input type="checkbox" name="tariff_market" value="gea" <?php print $chkGEA; ?>>
          &nbsp;German A <br/>
          <input type="checkbox" name="tariff_market" value="geb" <?php print $chkGEB; ?>>
          &nbsp;German B <br/>
          <input type="checkbox" name="tariff_market" value="fra" <?php print $chkFRA; ?>>
          &nbsp;French A <br/>
          <input type="checkbox" name="tariff_market" value="frb" <?php print $chkFRB; ?>>
          &nbsp;French B <br/>
          <input type="checkbox" name="tariff_market" value="rua" <?php print $chkRUA; ?>>
          &nbsp;Russia A <br/>
          <input type="checkbox" name="tariff_market" value="rub" <?php print $chkRUB; ?>>
          &nbsp;Russia B </div>
      </div>
      <div class="form-group input-group form-group-icon-left">
        <label for="tariff_publish_status">Publish Status</label>
        <div class="col-md-12">
			<?php 
                if (strpos($tariffItem->post_type, '-draft') !== false) {
                    print '<input type="checkbox" name="tariff_publish_status" value="publish">';			
                } else {
                    print '<input type="checkbox" name="tariff_publish_status" value="publish" checked=checked>';	
                }
            ?> 
          &nbsp;Publish
          </div> 
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
      <div class="form-group" > <?php echo getTariffFilesDetail_partner(); ?> </div>
      <div class="form-group upload-response" style="padding:10px;"> </div> 
      <hr>
      <div class= "form-group btn btn-primary" style="padding:0px;">
        <input type="submit" id="uploadfile" value= "Update" class="btn btn-primary btn-upload" />
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
											
											
									fd.append('tariffId','<?php echo decryptData_partner(); ?>');
									
									if (jQuery("select[name=tariff_date_range]").val() != "") { fd.append('tariff_date_range', jQuery("select[name=tariff_date_range]").val());}
									if (jQuery("select[name=tariff_type]").val() != "") { fd.append('tariff_type', jQuery("select[name=tariff_type]").val());}
									if (jQuery("select[name=tariff_zone]").val() != "") { fd.append('tariff_zone', jQuery("select[name=tariff_zone]").val());} 
									if (jQuery("input[name=tariff_name]").val() != "") { fd.append('tariff_name', jQuery("input[name=tariff_name]").val());} 
									
									
  
									fd.append('tariff_market', arr_tariff_market); 
									fd.append('tariff_publish_status', tariff_publish_status);
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
  											 }, 1000);

											
											//------
                                        }
                                    });  
                                });
								
								jQuery('.clsdelete').click(function(){ 	 
									var tariffId = jQuery(this).attr("id").replace("delete", "");
									jQuery('.modal-footer').show();
									jQuery('#txtTariffId').attr("value",tariffId);
									jQuery("#spanTariffName").html("Are you sure to delete the tariff '" + jQuery("#spnName" + tariffId).html() + "'?"); 
								});
								
								jQuery('.clsYesDelete').click(function(){ 
									jQuery('.modal-footer').hide();
									jQuery('#spanTariffName').html('Deleting ' + jQuery('#spnName' + jQuery('#txtTariffId').val()).html() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px;line-height:30px;"></i>');
									var fd = new FormData();
									fd.append('tariffId',jQuery('#txtTariffId').val());
									if (jQuery("select[name=tariff_type]").val() != "") { fd.append('tariffType', jQuery("select[name=tariff_type]").val());}
									if (jQuery("select[name=tariff_zone]").val() != "") { fd.append('tariffZone', jQuery("select[name=tariff_zone]").val());}									
									fd.append('tariffName',jQuery('#spnName' + jQuery('#txtTariffId').val()).html());
									fd.append('action', 'funcDeleteTariff'); 
									jQuery.ajax({
											type: 'POST',
											url: '<?php echo admin_url('admin-ajax.php'); ?>',
											data: fd,
											contentType: false,
											processData: false,
											success: function(response){  
												 jQuery('#spanTariffName').fadeIn(700, function() { 
													if (parseInt(response) == 1){						
														jQuery('#spanTariffName').html(jQuery('#spnName' + jQuery('#txtTariffId').val()).html() + " is successfully deleted.");
													 setTimeout(function() { 	
														jQuery('#modDeleteConfirm').fadeOut(1200, function() {
															 jQuery('#modDeleteConfirm').modal('hide');
															 jQuery('#divName' + jQuery('#txtTariffId').val()).remove();
														}); 	
													   }, 2000);
																					
													} else {
														jQuery('#spanTariffName').html(jQuery('#spnName' + jQuery('#txtTariffId').val()).html() + " can not be deleted. Please try again."); 
														 setTimeout(function() { 	
														jQuery('#modDeleteConfirm').fadeOut(1200, function() {
														 jQuery('#modDeleteConfirm').modal('hide');
														});	
														 
													   }, 2000); 
													}
												 });
											}
									}); 
								});
								
                            });                     
                            </script> 
  </div>
</div>
