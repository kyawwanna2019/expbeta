<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User tariffs detail
 *
 * Created by Kyaw
 *
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);



$arrPostNames = array("tr","ho","pk","dl"); 

function postNameLong_partner($postName){ 
$strPostNameLong = "";
switch($postName){
 case "ho" : {$strPostNameLong = "hotel"; break;}	
 case "pk" : {$strPostNameLong = "package"; break;}	
 case "tr" : {$strPostNameLong = "transfer"; break;}	
 case "dl" : {$strPostNameLong = "delux"; break;}	
}
return $strPostNameLong;
}  

 
function decryptData_partner(){ 
$data = $_GET["data"];
$decryptData = base64_decode(strtr($data, '._-', '+/='));
return $decryptData;
}  

//echo decryptData(); 

list($countryCode, $countryName, $currentYear, $increaseOneYear,$marketCode) = explode('~', decryptData_partner());
 
//---- Show By User Role ----
	 
$marketDesc = "";
  switch ($marketCode){ case "wwa" : case "wwb" : { $marketDesc = "World Wide"; break; } 
		  case "eua" : case "eub" :{ $marketDesc = "European Union"; break; } 
		  case "uka" : case "ukb" :{ $marketDesc = "UK and Ireland"; break; }
		  case "usa" : case "usb" :{ $marketDesc = "US and Canada"; break; }
		  case "fra" : case "frb" :{ $marketDesc = "France"; break; }
		  case "rua" : case "rub" :{ $marketDesc = "Russia"; break; }
	  }	
	
function getTariffFilesHeader_partner($countryName, $postName)
{
	$postType = strtolower($countryName) . '-' . $postName;  
	$args = array(
	  'numberposts' => 1000,
	  'post_type' => array($postType, $postType . '-draft'), //$postType,
	  'orderby' => 'date',
	  'order' => 'DESC'
	);
	 
	$tariffItems = get_posts($args); 
	return $tariffItems;
}
  
//--- Get Tariff Files ---

function getTariffFilesDetail_partner($postID)
{
$args = array(
    'posts_per_page' => 10,
    'order'          => 'DESC',
    //'post_mime_type' => 'image',
    'post_parent'    => $postID// , $post->ID,
    //'post_type'      => 'attachment'
    );

$arrTariffFiles = get_children( $args);  //returns Array ( [$image_ID]. 
$strTariffFile = "";
foreach ($arrTariffFiles as $tariffFile) {
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
	
	$strTariffFile .= "<i class='fa fa-download'>&nbsp; </i> </button></a>&nbsp;";
	
}

return $strTariffFile; 
}

?>

<div class="st-create">
  <h3 class="pull-left"><?php echo $marketDesc; ?> Tariffs - <?php echo $countryName?> (01 NOV <?php echo $currentYear; ?> - 31 OCT <?php echo $increaseOneYear; ?> )</h3>
</div>
<div class="row mb20">
  <div class="col-xs-12"> 
    <!-- Hotel Tariffs -->
    <div class="box-body">
      <?php foreach ($arrPostNames as $arrPostName) { ?>
      <div class="panel panel-default col-lg-12 col-md-12 col-sm-12 col-xs-12" style="float:left;padding:0px;">
        <div class="panel-heading panel box box-primary" style="border-top:0px;border-left:0px;border-right:0px;padding:10px;"> <b><?php echo ucfirst(postNameLong_partner($arrPostName)); ?> Tariffs</b> <a class="accordion-toggle col-lg-1 col-md-1 col-sm-1 col-xs-1" data-toggle="collapse" data-parent="#accordion" href="#<?php echo ucfirst(postNameLong($arrPostName)); ?>" style="float:right;text-align:right;outline:none;"> </a> </div>
        <div id="<?php echo ucfirst(postNameLong_partner($arrPostName)); ?>" class="panel-collapse collapse in col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box-body">
            <ul class="list-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?php foreach ((getTariffFilesHeader_partner($countryCode, $arrPostName)) as $tariffItem) { 
                         list($activeTariffCountryCode, $activeTariffType, $activeTariffMarketCode, $activeTariffYear) = explode('-', $tariffItem->post_title);       
				if ( $currentYear == $activeTariffYear ) {
									?>
              <li id='li<?php echo $tariffItem->ID; ?>' class='list-group-item float-left col-lg-12 col-md-12 col-sm-12 col-xs-12'> <i class='fa fa-caret-right'></i> &nbsp;
                <?php  
					echo '<span id="tariffName' . $tariffItem->ID . '">' . $tariffItem->post_content . '</span>';
					if (strpos($tariffItem->post_type, '-draft') !== false) {
						echo '<span style="background-color:#cccccc;padding:7px;font-size:12px;margin-left:10px;">[draft]</span>';
					}
					
					echo getTariffFilesDetail_partner($tariffItem->ID); 
					echo "&nbsp;<button id='edit" . $tariffItem->ID . "' class='btn btn-default btn-xs clsedit' style='color: #000000;width:50px;'><i class='fa fa-edit'>&nbsp;</i></button>&nbsp;<a href='#modDeleteConfirm' data-toggle='modal'><button class='btn btn-default btn-xs clsdelete' style='color: #000000;width:50px;'  id='delete_". $tariffItem->post_type . "_". $tariffItem->ID . "' ><i class='fa fa-remove'>&nbsp;</i></button></a>&nbsp;";
				
				?>
              </li>
              <?php 
			  	}
			  } ?>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<script type = "text/javascript">
	
							
	jQuery(document).ready(function() {   
	
	    function funcGetURLParameter(paramName){ 
			var paramValue = "";
			var url = jQuery(location).attr('href');   
			var results = new RegExp('[\?&]' + paramName + '=([^&#]*)').exec(url);
			if (results != null) {
				 paramValue = decodeURI(results[1]) || 0; 
			}  
			return paramValue;
        }
	
		jQuery('.clsdelete').click(function(){ 
			jQuery('.modal-footer').show();	
		    var strDelete = jQuery(this).attr("id").replace("_draft", "");	
		    var arrTariffZoneTypeAndId = strDelete.replace("delete_", "").split("_");
			var tariffId = 0;
			var tariffZone = "";
			var tariffType = "";
			if (arrTariffZoneTypeAndId.length > 0){
				var arrTariffZoneAndType = arrTariffZoneTypeAndId[0].split("-");
				if (arrTariffZoneAndType.length > 0){
					tariffZone = arrTariffZoneAndType[0];
					tariffType = arrTariffZoneAndType[1];
				}
			 	tariffId = arrTariffZoneTypeAndId[1];
			}
			
		   	//alert(tariffId + " , " + tariffZone + " , " + tariffType);
			
			jQuery('#txtTariffId').attr("value",tariffId + "-" + tariffZone + "-" + tariffType);
			jQuery("#spanTariffName").html("Are you sure to delete the tariff " + jQuery("#tariffName" + tariffId).html() + "?"); 
			
    	});
		
		jQuery('.clsYesDelete').click(function(){ 
		    jQuery('.modal-footer').hide();
			var arrTariffZoneTypeAndId = jQuery('#txtTariffId').val().split("-");
			
			var tariffId = 0;
			var tariffZone = "";
			var tariffType = "";
			
			if (arrTariffZoneTypeAndId.length > 0){
				tariffId = arrTariffZoneTypeAndId[0];
				tariffZone = arrTariffZoneTypeAndId[1];
				tariffType = arrTariffZoneTypeAndId[2];
			}
			
			jQuery('#spanTariffName').html('Deleting ' + jQuery('#tariffName' + tariffId).html() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o-notch fa-spin" style="font-size:20px;line-height:30px;"></i>');
			
			var fd = new FormData();
			fd.append('tariffId',tariffId);			
			fd.append('tariffZone',tariffZone);			
			fd.append('tariffType',tariffType);
			fd.append('tariffName',jQuery('#tariffName' + tariffId).html());
			
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
								jQuery('#spanTariffName').html(jQuery('#tariffName' + tariffId).html() + " is successfully deleted.");
							 setTimeout(function() {
  								 jQuery('#modDeleteConfirm').fadeOut(1200);	
jQuery('#modDeleteConfirm').fadeOut(1200, function() {
								 jQuery('#modDeleteConfirm').modal('hide');
								 jQuery('#li' + tariffId).remove();
								}); 	
							   }, 2000);
															
							} else {
								jQuery('#spanTariffName').html(jQuery('#tariffName' + tariffId).html() + " can not be deleted. Please try again."); 
								 setTimeout(function() {
  								 jQuery('#modDeleteConfirm').fadeOut(1200);	
jQuery('#modDeleteConfirm').fadeOut(1200, function() {
								 jQuery('#modDeleteConfirm').modal('hide');
								});	
								 
							   }, 2000); 
							}
						 });
					}
			}); 
    	});
		
		jQuery('.clsedit').click(function(){
			var tariffId = jQuery(this).attr("id").replace("edit", ""); 
			var data = encodeURIComponent(btoa(tariffId)); 
			var url = jQuery(location).attr('href'); 
			var str = "page-user-setting/";
			var targetUrl = "";			
			if(url.indexOf(str) != -1){
			   	targetUrl = "../?sc=tariffs-edit" + "&data=" + data;
			} else
			{
				targetUrl = "../edit-tariff/?sc=" + funcGetURLParameter("sc") + "&data=" + data;
			} 
		 	window.location.href = targetUrl;
    	}); 
		 
	});      
							
</script>