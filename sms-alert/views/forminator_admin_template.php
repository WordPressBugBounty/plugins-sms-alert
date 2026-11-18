<?php
/**
 * Template.
 * PHP version 5
 *
 * @category View
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 */
 
if (! defined('ABSPATH') ) {
    exit;
} 
$smsalert_forminator_forms = SA_Forminator::getForminatorForms();
if (! empty($smsalert_forminator_forms) ) {
	$smsalert_disablePlayground     = SmsAlertUtility::isPlayground()?"disablePlayground":"";
    ?>
<div class="cvt-accordion <?php echo esc_attr($smsalert_disablePlayground); ?>">
    <div class="accordion-section">
    <?php foreach ( $smsalert_forminator_forms as $smsalert_ks => $smsalert_vs ) { ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_<?php echo esc_attr($smsalert_ks); ?>">
            <input type="checkbox" name="smsalert_forminator_general[forminator_admin_notification_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_forminator_general[forminator_admin_notification_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('forminator_admin_notification_' . $smsalert_ks, 'smsalert_forminator_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label><?php echo esc_html(ucwords(str_replace('-', ' ', $smsalert_vs))); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_<?php echo esc_attr($smsalert_ks); ?>" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top" style="position:relative">
                <td>
                <a href="<?php echo esc_url(admin_url('admin.php?page=forminator-cform-wizard&id=' . absint($smsalert_ks))); ?>" title="<?php esc_attr_e('Edit Form', 'sms-alert'); ?>" target="_blank" class="alignright">
					<small><?php esc_html_e('Edit Form', 'sms-alert'); ?></small>
				</a>
                <div class="smsalert_tokens">
        <?php
        $smsalert_fields = SA_Forminator::getForminatorVariables($smsalert_ks);
        foreach ( $smsalert_fields as $smsalert_key=>$smsalert_value ) {
            echo  "<a href='#' data-val='[" . esc_attr($smsalert_key) . "]'>".esc_attr($smsalert_value)."</a> | ";
        }
        ?>
                </div>                
                <textarea data-parent_id="smsalert_forminator_general[forminator_admin_notification_<?php echo esc_attr($smsalert_ks); ?>]" name="smsalert_forminator_message[forminator_admin_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_forminator_message[forminator_admin_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" <?php echo( ( smsalert_get_option('forminator_admin_notification_' . esc_attr($smsalert_ks), 'smsalert_forminator_general', 'on') === 'on' ) ? '' : "readonly='readonly'" ); ?> class="token-area"><?php 
				// translators: 1: Store name.
				echo esc_textarea(smsalert_get_option('forminator_admin_sms_body_' . $smsalert_ks, 'smsalert_forminator_message', sprintf(__('Dear admin, you have a new enquiry from %1$s.%2$sPowered by%3$swww.smsalert.co.in', 'sms-alert'), '[store_name]', PHP_EOL, PHP_EOL))); ?></textarea>
                <div id="menu_forminator_admin_<?php echo esc_attr($smsalert_ks); ?>" class="sa-menu-token" role="listbox"></div>
                </td>
                </tr>
            </table>
        </div>
    <?php } ?>
    </div>
</div>
    <?php
} else {
    echo '<h3>No Form(s) published</h3>';
}
?>
