<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 21/08/2015
 * Time: 9:45 SA
 */

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/* Redirect Logout to main page */
add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}

// Disable Admin Bar for everyone but administrators
if (!function_exists('disable_admin_bar')) {

  function disable_admin_bar() {

      if (!current_user_can('manage_options')) {

          // for the admin page
          remove_action('admin_footer', 'wp_admin_bar_render', 1000);
          // for the front-end
          remove_action('wp_footer', 'wp_admin_bar_render', 1000);

          // css override for the admin page
          function remove_admin_bar_style_backend() { 
              echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
          }     
          add_filter('admin_head','remove_admin_bar_style_backend');

          // css override for the frontend
          function remove_admin_bar_style_frontend() {
              echo '<style type="text/css" media="screen">
              html { margin-top: 0px !important; }
              * html body { margin-top: 0px !important; }
              </style>';
          }
          add_filter('wp_head','remove_admin_bar_style_frontend', 99);

      }
  }
}
add_action('init','disable_admin_bar');

/* Remove Admin bar */
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

/* Remove Admin logo */
function wpsnipp_admin_bar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action( 'wp_before_admin_bar_render', 'wpsnipp_admin_bar_remove_logo', 0 );


/* Tariff files operation */
//------- Multiple File Upload --------
add_action('wp_ajax_cvf_upload_files', 'cvf_upload_files');
add_action('wp_ajax_nopriv_cvf_upload_files', 'cvf_upload_files'); // Allow front-end submission 

function cvf_upload_files(){
	                $strConfirmMessage = "";
 
					$tariffId = $_POST['tariffId']; 
					$content   = $_POST['tariff_name'];  //ucwords($tariff_type) . " Tariffs";
					$tariff_date_range = $_POST['tariff_date_range'];
					$tariff_type = $_POST['tariff_type'];					
					$tariff_zone = $_POST['tariff_zone'];					
					$tariff_market = $_POST['tariff_market'];					
					$post_type = $tariff_zone . '-' . $tariff_type;       
					$tariff_publish_status = $_POST['tariff_publish_status']; 
					$publish_post_type = '';
		            if (trim($tariff_publish_status) == 'draft'){
						$publish_post_type = $post_type . '-draft';
					}else{
						$publish_post_type = $post_type;
					}
					
					// $post_status = 'publish'; 
				    //------
					if ($tariffId == 0){
						$new_post = array(
						'post_title'    => $post_type . '-'. $tariff_market . '-' . $tariff_date_range,  
						'post_name'      => $post_type . '-'. $tariff_market . '-' . $tariff_date_range, 
						'post_content'  => $content, // $tariff_type . ' tariffs ' . date("Y-m-d h:i:sa"),
						'post_status'   => 'publish',          
						'post_type'     => $publish_post_type
						);
						
						//insert the the post into database by passing $new_post to wp_insert_post
						//store our post ID in a variable $pid
						$pid = 0;
						$errTariff = '';
						try
						{
						   $pid = wp_insert_post($new_post);
						   $strConfirmMessage = 'Your tariff information is successfully added';
						} 
						catch (Exception $e)
						{ 
						   $errTariff =  ' Message  : ' .$e->getMessage(); 
						}
					} else {
						
						$update_post = array(
						'ID'           => $tariffId,
						'post_title'    => $post_type . '-'. $tariff_market . '-' . $tariff_date_range,   
						'post_name'      => $post_type . '-'. $tariff_market . '-' . $tariff_date_range, 
						'post_content'  => $content, // $tariff_type . ' tariffs ' . date("Y-m-d h:i:sa"),
						'post_status'   => 'publish',          
						'post_type'     => $publish_post_type
						);
						
						//insert the the post into database by passing $new_post to wp_insert_post
						//store our post ID in a variable $pid
						$pid = 0;
						$errTariff = '';
						try
						{
						   $pid = wp_update_post($update_post);
						   $strConfirmMessage = 'Your tariff is successfully updated';
						} 
						catch (Exception $e)
						{ 
						   $errTariff =  ' Message  : ' .$e->getMessage(); 
						}
					} 
					
					
					
					//we now use $pid (post id) to help add out post meta data
					add_post_meta($pid, 'tariff_type', $tariff_type, true);
					add_post_meta($pid, 'tariff_zone', $tariff_zone, true);
					add_post_meta($pid, 'tariff_market', $tariff_market, true);
					add_post_meta($pid, 'tariff_date_range', $tariff_date_range, true);
					add_post_meta($pid, 'tariff_publish_status', $tariff_publish_status, true);
					$parent_post_id = $pid ;
					
					//------------------//
	
    
    //$parent_post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
	

    $valid_formats = array("zip", "rar","doc","docx","xls","xlsx","pdf","jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
    $max_file_size = 1024 * 5000; // in kb
    $max_image_upload = 1000; // Define how many images can be uploaded to the current post
    
	//--- Start Test ---  
        $user_dirname = get_home_path() .'/wp-content/uploads/tariff/' . $tariff_zone . '/' . $tariff_type;
        if ( ! file_exists( $user_dirname ) ) {
        	wp_mkdir_p( $user_dirname ); 
		}
		define( 'UPLOADS', trailingslashit(WP_CONTENT_DIR) . $user_dirname); 
	//--- End Test --- 
    
	//$wp_upload_dir = wp_upload_dir(); 
	//$path = $wp_upload_dir['path'] . '/'; 
	$path = $user_dirname . '/';
    $count = 0;
 
    $attachments = get_posts( array(
        'post_type'         => $publish_post_type,
        'posts_per_page'    => -1,
        'post_parent'       => $parent_post_id,
        'exclude'           => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ) );
	
	

    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){
        
        // Check if user is trying to upload more than the allowed number of images for the current post
        if( ( count( $attachments ) + count( $_FILES['files']['name'] ) ) > $max_image_upload ) {
            $upload_message[] = "Sorry you can only upload " . $max_image_upload . ".";
        } else {
            
            foreach ( $_FILES['files']['name'] as $f => $name ) {
                $extension = pathinfo( $name, PATHINFO_EXTENSION );
                // Generate a randon code for each file name
                //$new_filename = cvf_td_generate_random_code( 20 )  . '.' . $extension;
				$new_filename = $name; 
				$specialchars = array ("\"", "'", ";", ":" ,"\\", " ", "&", "__"); //any others
				$new_filename = str_replace($specialchars, "_", $name); //. '.' . $_FILES['files']['extension'];
				//$new_filename = str_replace($specialchars, "_", $new_filename);
				//$new_filename = str_replace("_.", ".", $new_filename);
				
                if ( $_FILES['files']['error'][$f] == 4 ) {
                    continue; 
                }
                
                if ( $_FILES['files']['error'][$f] == 0 ) {
                    // Check if image size is larger than the allowed file size
                    if ( $_FILES['files']['size'][$f] > $max_file_size ) {
                        $upload_message[] = "$name is too large!.";
                        continue;
                    
                    // Check if the file being uploaded is in the allowed file types
                    } elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
                        $upload_message[] = "$name is not a valid format";
                        continue; 
                    
                    } else{  
					
                        // If no errors, upload the file...
                        if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$new_filename ) ) {
                            
                            $count++; 

                            $filename = $path.$new_filename;
                            $filetype = wp_check_filetype( basename( $filename ), null );
                            //$wp_upload_dir = wp_upload_dir();
							$wp_upload_dir = './wp-content/uploads/tariff/' . $tariff_zone . '/' . $tariff_type;
							$guid = site_url(). '/wp-content/uploads/tariff/' . $tariff_zone . '/' . $tariff_type . '/' . basename($filename);
							$attach_post_title = preg_replace( '/\.[^.]+$/', '', basename($filename));
							
                            $attachment = array(
                                //'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
								'guid' => $guid,
                                'post_mime_type' =>  $extension, // $filetype['type'],
                                'post_title'     =>  substr($attach_post_title, 0, strlen($attach_post_title)-1),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                            
                            // Generate meta data
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            
                        }
                    }
                }
            }
        }
    }
    // Loop through each error then output it to the screen
    if ( isset( $upload_message ) ) :
        foreach ( $upload_message as $msg ){        
            printf( __('<p class="bg-danger" style="padding:10px;">%s</p>', 'wp-trade'), $msg );
        }
    endif; 
	
	if ($strConfirmMessage != ''){ 
		if( $count != 0 ){
			//printf( __('<p class="bg-success" style="padding:10px;">%d file(s) uploaded successfully! </p>', 'wp-trade'), $count );   
			$strConfirmMessage .= ' with ' . $count .' file attachment(s)';		
		}  
		$strConfirmMessage .= '.';
		printf( __('<p class="bg-success" style="padding:10px;">' . $strConfirmMessage . '</p>', 'wp-trade'), $count ); 
	}
    
    exit();
}

// Random code generator used for file names.
function cvf_td_generate_random_code($length=10) {
 
   $string = '';
   $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
 
   for ($p = 0; $p < $length; $p++) {
       $string .= $characters[mt_rand(0, strlen($characters)-1)];
   }
 
   return $string; 
}

//------- Multiple File Upload --------
add_action('wp_ajax_funcDeleteTariff', 'funcDeleteTariff');
add_action('wp_ajax_nopriv_funcDeleteTariff', 'funcDeleteTariff'); // Allow front-end submission 

function funcDeleteTariff(){
	$tariffId   = $_POST['tariffId'];
	$tariffName   = $_POST['tariffName']; 
	$tariffZone   = $_POST['tariffZone']; 
	$tariffType   = $_POST['tariffType'];	
	printf(deleteTariffs($tariffId, $tariffName, $tariffZone, $tariffType)); 
    exit();
}

function deleteTariffs($parentid, $tariffName, $tariffZone, $tariffType) {
	$rtn = '';
	try {
    	$args = array( 
		'post_parent' => $parentid,
		'post_type' => 'attachment'
		);
		$posts = get_posts( $args );
		$arrpostMeta = get_post_meta('6664','_wp_attached_file',false);
		 
		 
		if (is_array($posts) && count($posts) > 0) { 
			foreach($posts as $post){  
			     $checkFileDeleteStatus = false; 				
				 foreach((get_post_meta($post->ID,'_wp_attached_file',false)) as $postMeta){  
				   $checkFileDeleteStatus = deleteFile($postMeta);
				 }
				 
				 if ($checkFileDeleteStatus == true){
					 delete_post_meta($post->ID, '_wp_attached_file',false); 
				 } 
				 wp_delete_post($post->ID, true);
				  
			} 
		} 
		// Delete the Parent Page
		wp_delete_post($parentid, true);
		
		$tariffFilePathAndName = get_home_path() .'/wp-content/uploads/tariff/' . $tariffZone . '/' . $tariffType . '/' . $tariffName;
		//echo $tariffFilePathAndName;
        if (file_exists( $tariffFilePathAndName ) ) {
			unlink($tariffFilePathAndName);
		} 
		$rtn = 1; //$tariffName . ' is success fully deleted.'; 
	}
	catch (exception $e) {
		
		$rtn = 0; //$tariffName . ' fail to delete because of ' . $e->getMessage(); 
	}  
	
	return $rtn; 
} 


function deleteFile($pFilename)
{
    if ( file_exists($pFilename) ) { 
        if( @unlink($pFilename) !== true )
            throw new Exception('Could not delete file: ' . $pFilename . ' Please close all applications that are using it.');
    }    
    return true;
}

function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
 
add_action( 'pre_ping', 'no_self_ping' );

function postNameLong($postName){ 
	$strPostNameLong = "";
	switch($postName){
	 case "ho" : {$strPostNameLong = "hotel"; break;}	
	 case "pk" : {$strPostNameLong = "package"; break;}	
	 case "tr" : {$strPostNameLong = "transfer"; break;}	
	 case "dl" : {$strPostNameLong = "delux"; break;}	
	}
	return $strPostNameLong;
} 

//---- SSL Encryption ----
//$key previously generated safely, ie: openssl_random_pseudo_bytes
function encryptUrl($content){ 
	return strtr(base64_encode($content), '+/=', '._-');
	}

function decryptData(){ 
	$data = $_GET["data"];
	$decryptData = base64_decode(strtr($data, '._-', '+/='));
	return $decryptData;
} 

function getTariffFilesHeader($countryName, $postName)
{
	$postType = strtolower($countryName) . '-' . $postName;  
	$args = array(
	  'numberposts' => 1000,
	  'post_type' => $postType,
	  'orderby' => 'date',
	  'order' => 'DESC'
	);
	 
	$hotelTariffs = get_posts($args); 
	return $hotelTariffs;
}
  
//--- Get Tariff Files ---

function getTariffFilesDetail($postID)
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
	//$strTariffFile .= "href='./tariffs-download/?file=" . $tariffFile->guid . "'>";
	$strTariffFile .= "href='./tariffs-download/?data=" . encryptUrl($tariffFile->guid) . "'>";
	$strTariffFile .= "<button class='btn btn-default btn-xs' style='float: right; color: #000000;width:100px;'>";
	
	
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

/* Show current template */
function show_template() {
    if( is_super_admin() ){
        global $template;
        print_r($template);
    } 
}
//add_action('wp_footer', 'show_template');
