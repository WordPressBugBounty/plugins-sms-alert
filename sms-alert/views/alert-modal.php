<?php
/**
 * Alert modal template.
 * PHP version 5
 *
 * @category Template
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 */
 
if (! defined('ABSPATH') ) {
    exit;
}
?>
<div class="sa-modal sa-fade" id="<?php echo esc_attr($modal_id); ?>">
    <div id="confirm" class="sa-modal-dialog">
        <div class="sa-modal-header">
            <h5 class="sa-modal-title"><?php echo esc_attr($modal_title); ?></h5>
            <button type="button" class="sa-close" data-dismiss="sa-modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="sa-modal-body">
            <?php echo wp_kses_post($modal_body); ?>
        </div>
        <div class="sa-modal-footer">
            <?php echo wp_kses_post($modal_footer); ?>
        </div>
    </div>
</div>
