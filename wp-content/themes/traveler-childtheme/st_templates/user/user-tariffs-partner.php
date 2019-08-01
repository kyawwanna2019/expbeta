<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User tariffs partner
 *
 * Created by Kyaw
 *
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);


//---- SSL Encryption ----
//$key previously generated safely, ie: openssl_random_pseudo_bytes
function encryptData($content){ 
return strtr(base64_encode($content), '+/=', '._-');
}

//echo encryptData('TH~THAILAND~2018~2019~wwa');
 
//---- Show By User Role ----
	 
$marketDesc = "";
  switch ($role){
	  case "wwa" : case "wwb" :{
		   $marketDesc = "World Wide";
		   break;
		  } 
		  case "eua" : case "eub" :{
		   $marketDesc = "European Union";
		   break;
		  } 
		  case "uka" : case "ukb" :{
		   $marketDesc = "UK and Ireland";
		   break;
		  }
		  case "usa" : case "usb" :{
		   $marketDesc = "US and Canada";
		   break;
		  }
		  case "fra" : case "frb" :{
		   $marketDesc = "France";
		   break;
		  }
		  case "rua" : case "rub" :{
		   $marketDesc = "Russia";
		   break;
		  }
	  }	
	

    //---- Create Country Array -----
	
	$arrTariffCountry = array(
    array(
        "country_code" => "TH",
        "country_name" => "THAILAND",
        "country_flag" => "../img/flags/th.png"
    ),
    array(
        "country_code" => "VN",
        "country_name" => "VIETNAM",
        "country_flag" => "../img/flags/vn.png"
    ),
    array(
        "country_code" => "SG",
        "country_name" => "SINGAPORE",
        "country_flag" => "../img/flags/sg.png"
    ),
    array(
        "country_code" => "KH",
        "country_name" => "CAMBODIA",
        "country_flag" => "../img/flags/kh.png"
    ),
    array(
        "country_code" => "LA",
        "country_name" => "LAOS",
        "country_flag" => "../img/flags/la.png"
    ),
    array(
        "country_code" => "MM",
        "country_name" => "MYANMAR",
        "country_flag" => "../img/flags/mm.png"
    ),
    array(
        "country_code" => "CN",
        "country_name" => "CHINA",
        "country_flag" => "../img/flags/cn.png"
    ),
    array(
        "country_code" => "ID",
        "country_name" => "INDONESIA",
        "country_flag" => "../img/flags/id.png"
    ),
    array(
        "country_code" => "MY",
        "country_name" => "MALAYSIA",
        "country_flag" => "../img/flags/my.png"
    ),
    array(
        "country_code" => "PH",
        "country_name" => "PHILIPPINES",
        "country_flag" => "../img/flags/ph.png"
    ),
    array(
        "country_code" => "IK",
        "country_name" => "SRI LANKA",
        "country_flag" => "../img/flags/lk.png"
    ),
    array(
        "country_code" => "NP",
        "country_name" => "NEPAL",
        "country_flag" => "../img/flags/np.png"
    ),
    array(
        "country_code" => "BT",
        "country_name" => "BHUTAN",
        "country_flag" => "../img/flags/bt.png"
    ),
    array(
        "country_code" => "KR",
        "country_name" => "SOUTH KOREA",
        "country_flag" => "../img/flags/kr.png"
    ),
    array(
        "country_code" => "TW",
        "country_name" => "TAIWAN",
        "country_flag" => "../img/flags/tw.png"
    ),
    array(
        "country_code" => "JP",
        "country_name" => "JAPAN",
        "country_flag" => "../img/flags/jp.png"
    )
); 
 

?>

<div class="st-create">
  <h2 class="pull-left"><?php echo $marketDesc; ?> Tariff List</h2>
</div>
<div class="row"> 
  <div class="form-group col-md-6 col-xs-12">
    <label for="tariff_date_range">Date Range</label>
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
  <div class="form-group col-md-6 col-xs-12">
    <label for="tariff_market">
      <?php st_the_language('tariff_market') ?>
    </label>
    <select name="tariff_market" class="form-control">
      <option value="wwa">World Wide A</option>
      <option value="wwb">World Wide B</option>
      <option value="eua">European Union A</option>
      <option value="eub">European Union B</option>
      <option value="uka">United Kingdom A</option>
      <option value="ukb">United Kingdom B</option>
      <option value="usa">United State and Canada A</option>
      <option value="usb">United State and Canada B</option>
      <option value="ana">Australia and New Zealand A</option>
      <option value="anb">Australia and New Zealand B</option>
      <option value="gea">German A</option>
      <option value="geb">German B</option>
      <option value="fra">French A</option>
      <option value="frb">French B</option>
      <option value="rua">Russia A</option>
      <option value="rub">Russia B</option>
    </select>
  </div>
</div>
<div class="row mb20">
  <div class="col-xs-12">
    <?php
 $cur_date = date('Y'); 
 $earliest_year = $cur_date - 1;
 $latest_year = $cur_date + 1; 
 
 $arrTariffYears = array();                        
							   
 
 
	
?>
    <div class="row">
      <div class="bg-white">
        <div class="box-body">
          <?php  
		
		 for ($iTariffCountryCount = 0; $iTariffCountryCount < count($arrTariffCountry) ; $iTariffCountryCount++){
	 
	?>
          <div class="btn-sm col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <button class="btn btn-block btn-default" onclick='funcTariffDetail("<?php echo $arrTariffCountry[$iTariffCountryCount]["country_code"] . '~' . $arrTariffCountry[$iTariffCountryCount]["country_name"]; ?>")'>
            <div style="width:16px;height:11px;float:left;"> <img src="<?php echo $arrTariffCountry[$iTariffCountryCount]["country_flag"] ?>" alt="<?php echo $arrTariffCountry[$iTariffCountryCount]["country_name"] ?>" title="<?php echo $arrTariffCountry[$iTariffCountryCount]["country_name"] ?>" /> </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 tariff_button_title" style="text-align:left;"><?php echo $arrTariffCountry[$iTariffCountryCount]["country_name"] ?></div>
            </button>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="gap gap-small"></div>
  </div> 
</div>
<script type = "text/javascript"> 
 						
function funcTariffDetail(country){
		var params = country + '~' + jQuery("select[name=tariff_date_range]").val() + '~' + ((parseInt(jQuery("select[name=tariff_date_range]").val()) + 1) + '~' + jQuery("select[name=tariff_market]").val());
		var data = encodeURIComponent(btoa(params));
		window.location.href = "./tariffs-detail-partner/?sc=tariffs-detail-partner&data=" + data;
}; 
 </script> 
