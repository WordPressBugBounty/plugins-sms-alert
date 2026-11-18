<?php
/**
 * Otp popup 2 template.
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
use Elementor\Frontend;
   
$smsalert_uniqueNo                  = wp_rand();        
$smsalert_alt_form_id             = 'saFormNo_'.$smsalert_uniqueNo;
$smsalert_otp_template_style = smsalert_get_option('otp_template_style', 'smsalert_general', 'popup-4');
$smsalert_otp_in_popup = smsalert_get_option('otp_in_popup', 'smsalert_general', 'on');
$smsalert_popup_class = 'popup';
if ('on' !== $smsalert_otp_in_popup) {
    $smsalert_popup_class = '';
}
$smsalert_modal_style = smsalert_get_option('modal_style', 'smsalert_general', '');
$smsalert_otp_template_style = ('otp-popup-1.php'===$smsalert_otp_template_style)?'popup-1':(('otp-popup-2.php'===$smsalert_otp_template_style)?'popup-2':$smsalert_otp_template_style);
$smsalert_values              = !empty(SmsAlertUtility::get_elementor_data("form_list"))?SmsAlertUtility::get_elementor_data("form_list"):$smsalert_otp_template_style;
$smsalert_form_id                = (isset($smsalert_form_id) ? $smsalert_form_id : $smsalert_alt_form_id);
$post = get_page_by_path('modal_style', OBJECT, 'sms-alert');
if (is_plugin_active('elementor/elementor.php') && !empty($post)) {  
    $post_id= $post->ID;    
    $smsalert_frontent = new Frontend();
    $smsalert_content =  $smsalert_frontent->get_builder_content($post_id);
} else {
    if ($smsalert_values == 'popup-2') {
        $smsalert_content = SAPopup::getModelStyle(array('otp_template_style'=>'popup-2'));
    } else if ($smsalert_values == 'popup-3') {
        $smsalert_content = SAPopup::getModelStyle(array('otp_template_style'=>'popup-3'));
    } else if ($smsalert_values == 'popup-1') {
        $smsalert_content = SAPopup::getModelStyle(array('otp_template_style'=>'popup-1'));
    } else {
        $smsalert_content = SAPopup::getModelStyle(array('otp_template_style'=>'popup-4'));
    }
}
echo ' <div class="modal smsalertModal ' . esc_attr($smsalert_modal_style) . ' ' . esc_attr($smsalert_popup_class) . ' ' . esc_attr($smsalert_form_id) . ' ' . esc_attr($smsalert_values) . '" data-modal-close="' . esc_attr(substr($smsalert_modal_style, 0, -2)) . '" data-form-id="' . esc_attr($smsalert_form_id) . '">
    ' .
/* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated HTML with internally escaped dynamic values. */
$smsalert_content . '
    <div class="ring sa-hide"><span></span></div>
</div>';