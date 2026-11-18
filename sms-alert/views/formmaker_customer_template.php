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
$smsalert_formmarker_forms = SAFormMaker::getFormMaker();
if (! empty($smsalert_formmarker_forms) ) {
	$smsalert_disablePlayground     = SmsAlertUtility::isPlayground()?"disablePlayground":"";
    ?>
<!-- accordion -->
<div class="cvt-accordion">
    <div class="accordion-section">
    <?php foreach ( $smsalert_formmarker_forms as $smsalert_ks => $smsalert_vs ) { ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_cust_<?php echo esc_attr($smsalert_ks); ?>">
            <input type="checkbox" name="smsalert_formmarker_general[formmarker_order_status_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_formmarker_general[formmarker_order_status_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('formmarker_order_status_' . esc_attr($smsalert_ks), 'smsalert_formmarker_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label><?php echo esc_attr(ucwords(str_replace('-', ' ', $smsalert_vs))); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_cust_<?php echo esc_attr($smsalert_ks); ?>" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr>
                    <td><input data-parent_id="smsalert_formmarker_general[formmarker_order_status_<?php echo esc_attr($smsalert_ks); ?>]" type="checkbox" name="smsalert_formmarker_general[formmarker_message_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_formmarker_general[formmarker_message_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('formmarker_message_' . esc_attr($smsalert_ks), 'smsalert_formmarker_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label for="smsalert_formmarker_general[formmarker_message_<?php echo esc_attr($smsalert_ks); ?>]">Enable Message</label>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=manage_fm&task=edit&current_id=' . absint($smsalert_ks))); ?>" title="<?php esc_attr_e('Edit Form', 'sms-alert'); ?>" target="_blank" class="alignright">
						<small><?php esc_html_e('Edit Form', 'sms-alert'); ?></small>
					</a>
                    </td>
                    </tr>
                <tr valign="top"  style="position:relative">
                   <td class="<?php echo esc_attr($smsalert_disablePlayground) ?>">
                        <div class="smsalert_tokens">
        <?php
        $smsalert_fields = SAFormMaker::getFormMakerVariables($smsalert_ks);
        foreach ( $smsalert_fields as $smsalert_key=>$smsalert_value ) {
            echo  "<a href='#' data-val='[" . esc_attr($smsalert_key) . "]'>".esc_attr($smsalert_value)."</a> | ";
        }
        ?>
                        </div>
                        <textarea data-parent_id="smsalert_formmarker_general[formmarker_message_<?php echo esc_attr($smsalert_ks); ?>]" name="smsalert_formmarker_message[formmarker_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_formmarker_message[formmarker_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" <?php echo( ( smsalert_get_option('formmarker_order_status_' . esc_attr($smsalert_ks), 'smsalert_formmarker_general', 'on') === 'on' ) ? '' : "readonly='readonly'" ); ?> class="token-area"><?php echo 
						// translators: 1: Store name.
						esc_textarea(smsalert_get_option('formmarker_sms_body_' . esc_attr($smsalert_ks), 'smsalert_formmarker_message', sprintf(__('Hello user, thank you for contacting with %1$s.', 'sms-alert'), '[store_name]'))); ?></textarea>
                        <div id="menu_formmarker_cust_<?php echo esc_attr($smsalert_ks); ?>" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Select Phone Field : <select name="smsalert_formmarker_general[formmarker_sms_phone_<?php echo esc_attr($smsalert_ks); ?>]">
        <?php
        foreach ( $smsalert_fields as $smsalert_key=>$smsalert_value ) {
            ?>
                            <option value="<?php echo esc_attr($smsalert_key); ?>" <?php echo ( trim(smsalert_get_option('formmarker_sms_phone_' . $smsalert_ks, 'smsalert_formmarker_general', '')) === $smsalert_key ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($smsalert_value); ?></option>
            <?php
        }
        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input data-parent_id="smsalert_formmarker_general[formmarker_order_status_<?php echo esc_attr($smsalert_ks); ?>]" type="checkbox" name="smsalert_formmarker_general[formmarker_otp_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_formmarker_general[formmarker_otp_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('formmarker_otp_' . esc_attr($smsalert_ks), 'smsalert_formmarker_general', 'off') === 'on' ) ? "checked='checked'" : '' ); ?>/><label for="smsalert_formmarker_general[formmarker_otp_<?php echo esc_attr($smsalert_ks); ?>]">Enable Mobile Verification</label>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>
    </div>
</div>
<!--end accordion-->
    <?php
} else {
    echo '<h3>No Form(s) published</h3>';
}
?>
