<?php

/*

Template Name: Tariffs Detail Agent

*/

 /*
 
if(st()->get_option('enable_popup_login','off') == 'on'){

    wp_redirect( home_url( '/' ) );

    exit();

} */
 
$current_user = wp_get_current_user();

$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);

get_header(); 
?>
 
<div class="container-fluid">

    <div class="container">
        <div class="breadcrumb" id="test">
                <ul class="breadcrumb  mt15">
                    <li><a href="./">Home</a></li>
                    <li><a href="../tariffs-agent">Tariffs</a></li>
                    <li class="active">Detail</li>
                </ul>
        </div>
    </div> 
    <div class="row"> 
        <div class="container"> 
        <?php echo st()->load_template('user/user-tariffs-detail-agent');?> 
        </div> 
    </div>

<div class="gap gap-small"></div>

</div>



<?php  get_footer(); ?>

