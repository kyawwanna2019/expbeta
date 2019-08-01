<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Car field list location
 *
 * Created by ShineTheme
 *
 */
$default=array(
    'title'=>'',
    'is_required'=>'off',
);
if(isset($data)){
    extract(wp_parse_args($data,$default));
}else{
    extract($default);
}
if(!isset($field_size)) $field_size='lg';
$old_location=STInput::get('location_id');
$list_location = TravelHelper::treeLocationHtml('st_cars');
if($is_required == 'on'){
    $is_required = 'required';
}
$location_id=STInput::get('location_id', '');
$location_name = STInput::request('location_name', '');
if (!$location_id){
    $location_id = STInput::get('location_id_pick_up');
    $location_name = STInput::get('pick-up');
}
?>
<?php if(!empty($list_location) and is_array($list_location)): ?>
<div class="form-group form-group-<?php echo esc_attr($field_size)?> form-group-icon-left">    
    <label for="field-hotel-location"><?php echo esc_html( $title)?></label>
    <i class="fa fa-map-marker input-icon"></i>
   <select  name="location_id" class="form-control" <?php echo esc_attr($is_required) ?>>
       <option value=""><?php _e('-- Select --',ST_TEXTDOMAIN) ?></option>
       <?php

           foreach($list_location as $key => $value):
              $name = $value['fullname'];
              $name = explode('||', $name);
              $name = $name[0];
              $prefix = '';
              for( $i = 2; $i <= $value['level'] / 20; $i++){
                $prefix .= '--';
              }
               ?>
              <option <?php selected($value['ID'], $location_id); ?> value="<?php echo $value['ID']; ?>"><?php echo $prefix.' '.$name; ?></option>
           <?php endforeach; ?>
   </select>
</div>
<?php endif ?>