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
$smsalert_ninja_forms = NinjaForm::getNinjaForms();
if (! empty($smsalert_ninja_forms) ) {
    ?>
<!-- accordion -->
<div class="cvt-accordion">
    <div class="accordion-section">
    <?php foreach ( $smsalert_ninja_forms as $smsalert_ks => $smsalert_vs ) { ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_cust_<?php echo esc_attr($smsalert_ks); ?>">
            <input type="checkbox" name="smsalert_ninja_general[ninja_order_status_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_ninja_general[ninja_order_status_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('ninja_order_status_' . esc_attr($smsalert_ks), 'smsalert_ninja_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label><?php echo esc_attr(ucwords(str_replace('-', ' ', $smsalert_vs))); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_cust_<?php echo esc_attr($smsalert_ks); ?>" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr>
                    <td><input data-parent_id="smsalert_ninja_general[ninja_order_status_<?php echo esc_attr($smsalert_ks); ?>]" type="checkbox" name="smsalert_ninja_general[ninja_message_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_ninja_general[ninja_message_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('ninja_message_' . esc_attr($smsalert_ks), 'smsalert_ninja_general', 'on') === 'on' ) ? "checked='checked'" : '' ); ?>/><label>Enable Message</label>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=ninja-forms&form_id=' . absint($smsalert_ks))); ?>" title="<?php esc_attr_e('Edit Form', 'sms-alert'); ?>" target="_blank" class="alignright">
						<small><?php esc_html_e('Edit Form', 'sms-alert'); ?></small>
					</a>
                    </td>
                </tr>
                <tr valign="top" style="position:relative">
                    <td>
                        <div class="smsalert_tokens">
        <?php
        $smsalert_fields = NinjaForm::getNinjavariables($smsalert_ks);
        foreach ( $smsalert_fields as $smsalert_field ) {
            if (! is_array($smsalert_field) ) {
                echo  "<a href='#' data-val='[" . esc_attr($smsalert_field) . "]'>".esc_attr($smsalert_field)."</a> | ";
            } else {
                $smsalert_field = isset($smsalert_field['cells'][0]['fields'][0])?$smsalert_field['cells'][0]['fields'][0]:'';
                if ($smsalert_field!='') {
                    echo  "<a href='#' data-val='[" . esc_attr($smsalert_field) . "]'>".esc_attr($smsalert_field)."</a> | ";
                }
            }
        }
        ?>
                        </div>
                        <textarea data-parent_id="smsalert_ninja_general[ninja_message_<?php echo esc_attr($smsalert_ks); ?>]" name="smsalert_ninja_message[ninja_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_ninja_message[ninja_sms_body_<?php echo esc_attr($smsalert_ks); ?>]" <?php echo( ( smsalert_get_option('ninja_order_status_' . esc_attr($smsalert_ks), 'smsalert_ninja_general', 'on') === 'on' ) ? '' : "readonly='readonly'" ); ?> class="token-area"><?php 
						// translators: 1: Store name.
						echo esc_textarea(smsalert_get_option('ninja_sms_body_' . esc_attr($smsalert_ks), 'smsalert_ninja_message', sprintf(__('Hello user, thank you for contacting with %1$s.', 'sms-alert'), '[store_name]'))); ?></textarea>
                        <div id="menu_ninja_cust_<?php echo esc_attr($smsalert_ks); ?>" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Select Phone Field : 
                        <select name="smsalert_ninja_general[ninja_sms_phone_<?php echo esc_attr($smsalert_ks); ?>]">
        <?php
        $smsalert_phone_field = trim(smsalert_get_option('ninja_sms_phone_' . $smsalert_ks, 'smsalert_ninja_general', ''));
        foreach ( $smsalert_fields as $smsalert_field ) {
            if (! is_array($smsalert_field) ) {
                $smsalert_selected = ($smsalert_phone_field === $smsalert_field )?'selected="selected"':((('' === $smsalert_phone_field) && 0 === strpos($smsalert_field, 'phone') )?'selected="selected"':'');    
                ?>
                    <option value="<?php echo esc_attr($smsalert_field); ?>" <?php selected($smsalert_selected, 'selected'); ?>><?php echo esc_html($smsalert_field); ?></option>
                <?php
            } else {
                $smsalert_field = isset($smsalert_field['cells'][0]['fields'][0])?$smsalert_field['cells'][0]['fields'][0]:'';
                if ($smsalert_field!='') {
                    ?>
                                <option value="<?php echo esc_attr($smsalert_field); ?>" <?php echo ( trim(smsalert_get_option('ninja_sms_phone_' . $smsalert_ks, 'smsalert_ninja_general', '')) === $smsalert_field ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($smsalert_field); ?></option>
                     <?php
                }
            }
        }
        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input data-parent_id="smsalert_ninja_general[ninja_order_status_<?php echo esc_attr($smsalert_ks); ?>]" type="checkbox" name="smsalert_ninja_general[ninja_otp_<?php echo esc_attr($smsalert_ks); ?>]" id="smsalert_ninja_general[ninja_otp_<?php echo esc_attr($smsalert_ks); ?>]" class="notify_box" <?php echo ( ( smsalert_get_option('ninja_otp_' . esc_attr($smsalert_ks), 'smsalert_ninja_general', 'off') === 'on' ) ? "checked='checked'" : '' ); ?>/><label>Enable Mobile Verification</label>
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