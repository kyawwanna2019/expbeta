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

//echo decryptData();
 
//list($countryCode, $countryName, $currentYear, $increaseOneYear) = explode('~', decryptData());
list($countryCode, $countryName, $currentYear, $increaseOneYear) = explode('~', decryptData()); 
 
//---- Show By User Role ----
	 
$marketDesc = "";
  switch ($role){ case "wwa" : case "wwb" : { $marketDesc = "World Wide"; break; } 
		  case "eua" : case "eub" :{ $marketDesc = "European Union"; break; } 
		  case "uka" : case "ukb" :{ $marketDesc = "UK and Ireland"; break; }
		  case "usa" : case "usb" :{ $marketDesc = "US and Canada"; break; }
		  case "fra" : case "frb" :{ $marketDesc = "France"; break; }
		  case "rua" : case "rub" :{ $marketDesc = "Russia"; break; }
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
        <div class="panel-heading panel box box-primary" style="border-top:0px;border-left:0px;border-right:0px;padding:10px;"> <b><?php echo ucfirst(postNameLong($arrPostName)); ?> Tariffs</b> <a class="accordion-toggle col-lg-1 col-md-1 col-sm-1 col-xs-1" data-toggle="collapse" data-parent="#accordion" href="#<?php echo ucfirst(postNameLong($arrPostName)); ?>" style="float:right;text-align:right;outline:none;"> </a> </div>
        <div id="<?php echo ucfirst(postNameLong($arrPostName)); ?>" class="panel-collapse collapse in col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="box-body">
            <ul class="list-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?php foreach ((getTariffFilesHeader($countryCode, $arrPostName)) as $hotelTariff) { 
			  list($activeTariffCountryCode, $activeTariffType, $activeTariffMarketCode, $activeTariffYear) = explode('-', $hotelTariff->post_title);       		 if ( $currentYear == $activeTariffYear ) {
                                $checkMarket = (in_array($role,explode(",",str_replace(strtolower($countryCode . '-' . $arrPostName) . '-','', $hotelTariff->post_title))))? "true" : "false";
								if ($checkMarket == "true") { 
								?>
                              <li class='list-group-item float-left col-lg-12 col-md-12 col-sm-12 col-xs-12'> <i class='fa fa-caret-right'></i> &nbsp;<?php echo $hotelTariff->post_content ?>
                              
							  <?php echo getTariffFilesDetail($hotelTariff->ID);?> 
                              </li>
                              <?php } 
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
