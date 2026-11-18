<?php
/**
 * Cf7 template.
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
$smsalert_wpcf7 = WPCF7_ContactForm::get_current();
if (empty($smsalert_wpcf7->id()) ) {
    echo '<h3>';
    esc_html_e('Please save your contact form 7 once.', 'sms-alert');
    echo '</h3>';
} else {
    $smsalert_contact_form = WPCF7_ContactForm::get_instance($smsalert_wpcf7->id());
    $smsalert_form_fields  = $smsalert_contact_form->scan_form_tags();
    $smsalert_visitor_msg_enable = ( isset($data['visitor_notification']) ) ? $data['visitor_notification'] : "off";
    $smsalert_admin_msg_enable = ( isset($data['admin_notification']) ) ? $data['admin_notification'] : "off";
	// translators: 1: Store name.
    $smsalert_admin_message = ( ! empty($data['text']) ) ? trim($data['text']) : sprintf(__('Dear admin, you have a new enquiry from %1$s.%2$sPowered by%3$swww.smsalert.co.in', 'sms-alert'), '[store_name]', PHP_EOL, PHP_EOL);
    $smsalert_visitor_no = ( ! empty($data['visitorNumber']) ) ? $data['visitorNumber'] : "[billing_phone]";
	// translators: 1: Store name.
    $smsalert_visitor_msg = ( ! empty($data['visitorMessage']) ) ? $data['visitorMessage'] :sprintf(__('Hello user, thank you for contacting with %1$s.', 'sms-alert'), '[store_name]');
    ?>    
<div id="cf7si-sms-sortables" class="meta-box-sortables ui-sortable">
 <div class="tab-panels woocommerce">
<section id="smsalert_settings">
<div class="cvt-accordion">
    <div class="accordion-section">
        <div class="cvt-accordion-body-title" data-href="#accordion_wc_visitor_notification">
            <input type="checkbox" name="wpcf7smsalert-settings[visitor_notification]" id="wpcf7smsalert-settings[visitor_notification]" class="notify_box" <?php echo ( ( 'on' === $smsalert_visitor_msg_enable ) ? "checked='checked'" : '' ); ?> ><label>Visitor SMS Notification</label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_wc_visitor_notification" class="cvt-accordion-body-content" style="display: none;">
            <table class="form-table">
                <tbody><tr valign="top">
                    <td>
                       <div class="smsalert_tokens">
                        <?php
                        foreach ( $smsalert_form_fields as $smsalert_form_field ) {
                                           $smsalert_field = json_decode(wp_json_encode($smsalert_form_field), true);
                            if ('' !== $smsalert_field['name'] ) {
                                echo  "<a href='#' data-val='[" . esc_attr($smsalert_field['name']) . "]'>".esc_attr(ucwords(str_replace('-', ' ', $smsalert_field['name'])))."</a> | ";
                            }
                        }
                        ?>
                        </div>
                        <textarea id="visitor_wpcf7-mail-body" name="wpcf7smsalert-settings[visitorMessage]" data-parent_id="wpcf7smsalert-settings[visitor_notification]" pre_modified_txt="<?php echo esc_textarea($smsalert_visitor_msg); ?>" style="width: 100%;" class="token-area"><?php echo esc_textarea($smsalert_visitor_msg); ?></textarea>
                        <div id="menu_cf7_cust" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <div class="cvt-accordion-body-title" data-href="#accordion_wc_admin_notification">
            <input type="checkbox" name="wpcf7smsalert-settings[admin_notification]" id="wpcf7smsalert-settings[admin_notification]" class="notify_box" <?php echo ( ( 'on' === $smsalert_admin_msg_enable ) ? "checked='checked'" : '' ); ?> ><label>Admin SMS Notification</label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_wc_admin_notification" class="cvt-accordion-body-content" style="display: none;">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row" style="width:155px;">
                        <label for="wpcf7smsalert-settings[phoneno]"><?php esc_html_e('Admin Mobile Number:', 'sms-alert'); ?></label>
                    </th>
                    <td data-parent_id="wpcf7smsalert-settings[admin_notification]">
                        <input type="text" id="wpcf7smsalert-settings[phoneno]" name="wpcf7smsalert-settings[phoneno]" class="wide" size="70" value="<?php echo esc_attr($data['phoneno']); ?>"><span class="tooltip" data-title="<?php esc_html_e('Admin sms notifications will be sent to this number.', 'sms-alert'); ?>"><span class="dashicons dashicons-info"></span></span>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2">
                       <div class="smsalert_tokens">
                        <?php
                        foreach ( $smsalert_form_fields as $smsalert_form_field ) {
                                           $smsalert_field = json_decode(wp_json_encode($smsalert_form_field), true);
                            if ('' !== $smsalert_field['name'] ) {
                                echo  "<a href='#' data-val='[" . esc_attr($smsalert_field['name']) . "]'>".esc_attr(ucwords(str_replace('-', ' ', $smsalert_field['name'])))."</a> | ";
                            }
                        }
                        ?>
                        </div>
                        <textarea id="admin_wpcf7-mail-body" name="wpcf7smsalert-settings[text]" data-parent_id="wpcf7smsalert-settings[admin_notification]" pre_modified_txt="<?php echo esc_textarea($smsalert_admin_message); ?>" style="width: 100%;" class="token-area"><?php echo esc_textarea($smsalert_admin_message); ?></textarea>
                        <div id="menu_cf7_admin" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
            </tbody></table>
        </div> 
        <div style="padding: 5px 10px 10px 10px;">    
            <table class="form-table">
                <tr>
                    <td scope="row" class="td-heading">
                        <label for="wpcf7-mail-body"><?php esc_html_e('Visitor Mobile:', 'sms-alert'); ?></label>
                    </td>
                    <td>
                        <select name="wpcf7smsalert-settings[visitorNumber]" id="visitorNumber">
                        <option value=""><?php esc_attr_e("--select phone field--", "sms-alert");?></option>
                        <?php
                        if (! empty($smsalert_form_fields) ) {
                            foreach ( $smsalert_form_fields as $smsalert_form_field ) {
                                $smsalert_field = json_decode(wp_json_encode($smsalert_form_field), true);
                                if ('' !== $smsalert_field['name'] ) {
                                    ?>
                            
                            
                            <option value="<?php echo '[' . esc_attr($smsalert_field['name']) . ']'; ?>" <?php echo ( '[' . $smsalert_field['name'] . ']' === $smsalert_visitor_no ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($smsalert_field['name']); ?></option>
                                                   <?php
                                }
                            }
                        }
                        ?>
                        </select>
                        <span class="tooltip" data-title="<?php esc_html_e('Select phone field.', 'sms-alert'); ?>"><span class="dashicons dashicons-info"></span></span>
                    </td>
                </tr>
                 <tr class="top-border">
                <?php
                $smsalert_auto_sync = ( isset($data['auto_sync']) ) ? $data['auto_sync'] : "off";
                ?>
                    <td scope="row" class="SMSAlert_box td-heading">
                      <input type="checkbox" name="wpcf7smsalert-settings[auto_sync]" id="wpcf7smsalert-settings[auto_sync]" class="SMSAlert_box sync_group" <?php echo ( ( 'on' === $smsalert_auto_sync ) ? "checked='checked'" : '' ); ?> />
                        <label for="wpcf7-mail-body"><?php esc_html_e('Sync Data To Group:', 'sms-alert'); ?></label>
                    </td>
                    <td>
                        <select name="wpcf7smsalert-settings[smsalert_group]" id="smsalert_group" data-parent_id="wpcf7smsalert-settings[auto_sync]">
                        <?php
                        $smsalert_groups = json_decode(SmsAlertcURLOTP::groupList(), true);
                        if (! is_array($smsalert_groups['description']) || array_key_exists('desc', $smsalert_groups['description']) ) {
                            ?>
                            <option value=""><?php esc_html_e('SELECT', 'sms-alert'); ?></option>
                            <?php
                        } else {
                            foreach ( $smsalert_groups['description'] as $smsalert_group ) {
                                $smsalert_grp = ( ! empty($data['smsalert_group']) ) ? $data['smsalert_group'] : "";
                                
                                ?>
                            <option value="<?php echo esc_attr($smsalert_group['Group']['name']); ?>" <?php echo ( $smsalert_grp === $smsalert_group['Group']['name'] ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($smsalert_group['Group']['name']); ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                        <span class="tooltip" data-title="<?php esc_html_e('Select group in which data will be synced.', 'sms-alert'); ?>"><span class="dashicons dashicons-info"></span></span>
                        <?php
                        if (! empty($smsalert_groups) && ( ! is_array($smsalert_groups['description']) || array_key_exists('desc', $smsalert_groups['description']) ) ) {
                            ?>
                            <a href="#" onclick="create_group(this);" id="create_group" style="text-decoration: none;"><?php esc_html_e('Create Group', 'sms-alert'); ?></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td scope="row" class="td-heading">
                        <label for="wpcf7-mail-body"><?php esc_html_e('Name Field:', 'sms-alert'); ?></label>
                    </td>
                    <td>
                        <select name="wpcf7smsalert-settings[smsalert_name]" id="smsalert_name" data-parent_id="wpcf7smsalert-settings[auto_sync]">
                        <?php
                        $smsalert_username = smsalert_get_option('smsalert_name', 'smsalert_gateway');
                        $smsalert_password = smsalert_get_option('smsalert_password', 'smsalert_gateway');

                        $smsalert_wpcf7        = WPCF7_ContactForm::get_current();
                        $smsalert_contact_form = WPCF7_ContactForm::get_instance($smsalert_wpcf7->id());
                        $smsalert_form_fields  = $smsalert_contact_form->scan_form_tags();
                        if (! empty($smsalert_form_fields) ) {
                            foreach ( $smsalert_form_fields as $smsalert_form_field ) {
                                $smsalert_field = json_decode(wp_json_encode($smsalert_form_field), true);
                                if ('' !== $smsalert_field['name'] ) {
                                
                                    $smsalert_name = ( ! empty($data['smsalert_name']) ) ? $data['smsalert_name'] : "";
                                    ?>
                            <option value="<?php echo '[' . esc_attr($smsalert_field['name']) . ']'; ?>" <?php echo ( '[' . $smsalert_field['name'] . ']' === $smsalert_name ) ? 'selected="selected"' : ''; ?>><?php echo esc_attr($smsalert_field['name']); ?></option>
                                                   <?php
                                }
                            }
                        }
                        ?>
                        <input type="hidden" name="smsalert_gateway[smsalert_name]" id="smsalert_gateway[smsalert_name]" value="<?php echo esc_attr($smsalert_username); ?>" data-id="smsalert_name" class="hidden">
                        <input type="hidden" name="smsalert_gateway[smsalert_password]" id="smsalert_gateway[smsalert_password]" value="<?php echo esc_attr($smsalert_password); ?>" data-id="smsalert_password" class="hidden">
                        </select>
                        <span class="tooltip" data-title="<?php esc_html_e('Select name field.', 'sms-alert'); ?>"><span class="dashicons dashicons-info"></span></span>
                    </td>
                </tr>
                
                 <tr class="top-border">
                    <td scope="row" class="td-heading">
                        <label for="wpcf7-mail-body"></label>
                    </td>
                    <td>
                        <a href="https://www.youtube.com/watch?v=FFslKn_Stmc" target="_blank" class="btn-outline"><span class="dashicons dashicons-video-alt3" style="font-size: 21px"></span>  Youtube</a>

                        <a href="https://kb.smsalert.co.in/knowledgebase/integrate-otp-verification-with-contactform7/" target="_blank" class="btn-outline"><span class="dashicons dashicons-format-aside"></span> Documentation</a>
                    </td>
                </td>
                
                </tr>
                <tr>
            </table>
        </div>        
    </div>
    </div>
    </section>                                
    </div>
    </div>
<?php 
$smsalert_inline_script = 'var adminnumber = "'.esc_attr($data['phoneno']).'";
var tagInput1     = new TagsInput({
    selector: "wpcf7smsalert-settings[phoneno]",
    duplicate : false,
    max : 10,
});
var number = (adminnumber!="") ? adminnumber.split(",") : [];
if(number.length > 0){
    tagInput1.addData(number);
}';
if (! wp_script_is('sainlinescript-handle-footer', 'enqueued') ) {
	wp_register_script('sainlinescript-handle-footer', '', [], '', true);
	wp_enqueue_script('sainlinescript-handle-footer');
}        
wp_add_inline_script("sainlinescript-handle-footer", $smsalert_inline_script); 
} ?>
