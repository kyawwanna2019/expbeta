<?php
global $post;

$class = 'col-lg-4 col-md-6 col-sm-6 col-xs-6 item-service grid-item has-matchHeight';
if(isset($top_search) and $top_search)
    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 item-service grid-item has-matchHeight';
if(isset($slider) and $slider)
    $class = 'item-service grid-item has-matchHeight';
?>
<div class="<?php echo $class; ?>">
<!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 item-service grid-item has-matchHeight">-->
<div style="border:1px solid #CCC;min-height:470px;">
    <div class="thumb">
        <?php if(is_user_logged_in()){ ?>
            <?php $data = STUser_f::get_icon_wishlist();?>
            <div class="service-add-wishlist login <?php echo $data['status'] ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', ST_TEXTDOMAIN) : __('Add to wishlist', ST_TEXTDOMAIN); ?>">
                <i class="fa fa-heart"></i>
                <div class="lds-dual-ring"></div>
            </div>
        <?php }else{ ?>
            <a href="" class="login" data-toggle="modal" data-target="#st-login-form">
                <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', ST_TEXTDOMAIN); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            </a>
        <?php } ?>
        <div class="service-tag bestseller">
            <?php echo STFeatured::get_featured(); ?>
        </div>
        <a href="<?php echo get_the_permalink() ?>">
            <?php
            if(has_post_thumbnail()){
                the_post_thumbnail(array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
            }else{
                echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
            }
            ?>
        </a>
        <?php
        $view_star_review = st()->get_option('view_star_review', 'review');
        if($view_star_review == 'review') :
            ?>
            <ul class="icon-group text-color booking-item-rating-stars">
                <?php
                $avg = STReview::get_avg_rate();
                echo TravelHelper::rate_to_string($avg);
                ?>
            </ul>
        <?php elseif($view_star_review == 'star'): ?>
            <ul class="icon-list icon-group booking-item-rating-stars">
                <span class="pull-left mr10"><?php echo __('Hotel star', ST_TEXTDOMAIN); ?></span>
                <?php
                $star = STHotel::getStar();
                echo  TravelHelper::rate_to_string($star, $star);
                ?>
            </ul>
        <?php endif; ?>
    </div>
    <h4 class="service-title"  style="padding-left:10px;padding-right:10px;"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
    <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
        <p class="service-location" style="padding-left:10px;padding-right:10px;"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo $address; ?></p>
    <?php endif;?>

    <div class="section-footer">
    
        <div class="service-review" style="padding-left:10px;padding-right:10px;">
            <?php
            $count_review = STReview::count_comment(get_the_ID());
            $avg = STReview::get_avg_rate();
            ?>
            <span class="rating"><?php echo $avg; ?>/5 
            <?php //echo TravelHelper::get_rate_review_text($avg); ?>
            </span>
            <span class="st-dot"></span>
            <span class="review"><?php echo $count_review . ' ' . _n(esc_html__('Review', ST_TEXTDOMAIN),esc_html__('Reviews', ST_TEXTDOMAIN),$count_review); ?></span>
        </div>
        <div class="service-price" style="padding-left:10px;padding-right:10px;">
            <span>
                <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                <?php if(STHotel::is_show_min_price()): ?>
                    <?php _e("From", ST_TEXTDOMAIN) ?>
                <?php else:?>
                    <?php _e("Avg", ST_TEXTDOMAIN) ?>
                <?php endif;?>
            </span>
            <span class="price">
                <?php
                $price = isset($post->st_price)?$post->st_price:0;
                if($price){
                    echo TravelHelper::format_money($price);
                }else{
                    $price = STHotel::get_price();
                    echo TravelHelper::format_money($price);
                }
                ?>
            </span>
            <span><?php echo __('/night', ST_TEXTDOMAIN); ?></span>
        </div>
    </div>
 </div>
</div>