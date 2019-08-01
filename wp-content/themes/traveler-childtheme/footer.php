<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Footer
 *
 * Created by ShineTheme
 *
 */

if(New_Layout_Helper::isNewLayout()){
    echo st()->load_template('layouts/modern/common/footer');
    return;
}
?>
</div>
<!-- end row -->
</div>
<!--    End #Wrap-->
<?php

    $footer_template = TravelHelper::st_get_template_footer(get_the_ID());
    if($footer_template){
        $vc_content = STTemplate::get_vc_pagecontent($footer_template);
        if ($vc_content){
            echo '<footer id="main-footer" class="container-fluid">';
            echo $vc_content;
            echo ' </footer>';
        }
    }else
    {
?>
<!--        Default Footer -->
    <footer id="main-footer" class="container-fluid">
        <div class="container text-center">
            <p><?php _e('Copy &copy; 2014 Shinetheme. All Rights Reserved',ST_TEXTDOMAIN)?></p>
        </div>

    </footer>
<?php }?>

<!-- Gotop -->
<?php
    switch (st()->get_option('scroll_style' ,'')) {
        case "tour_box":
            ?>
            <div id="gotop" class="go_top_tour_box" title="<?php _e('Go to top',ST_TEXTDOMAIN)?>">
                <i class="fa fa-angle-double-up"></i><p><?php echo __("TOP", ST_TEXTDOMAIN )  ; ?></p>
            </div>
            <?php
            break;
        default :
            ?>
            <div id="gotop" title="<?php _e('Go to top',ST_TEXTDOMAIN)?>">
                <i class="fa fa-chevron-up"></i>
            </div>
            <?php
            break;
    }
?>

<!-- End Gotop -->
<?php do_action('st_before_footer');?>
<?php wp_footer(); ?>
<?php do_action('st_after_footer');?>

<!-- Tariff delete box Modal -->
<div id="modDeleteConfirm" class="modal fade" tabindex="2" style="position:fixed; z-index:100000;margin-top:200px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal">×</button>
					<span class="modal-title"><b>Delete Confirmation</b></span>
			</div>
			<div class="modal-body">
            <span id="spanTariffName"></span>
            <input type="hidden" name="txtTariffId" id="txtTariffId" value="" />
            </div>
			<div class="modal-footer">
                <button class="btn btn-default clsYesDelete" type="button">Yes</button>
                <button class="btn btn-primary clsNoDelete" type="button" data-dismiss="modal">No</button>
			</div>
			</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

</script>
</body>
</html>