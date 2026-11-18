<?php
/**
 * Login with otp form template.
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
$smsalert_redirect = isset($_GET['redirect_to'])?sanitize_text_field(wp_unslash($_GET['redirect_to'])):$redirect_url;
?>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="username"><?php echo esc_html($label_field); ?><span class="required">*</span></label>
    <input type="tel" placeholder = "<?php echo esc_attr($placeholder_field); ?>" class="woocommerce-Input woocommerce-Input--text input-text sa_mobileno phone-valid" name="username"  value="">
    <input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="redirect" value="<?php echo esc_url($smsalert_redirect); ?>">
</p>
<?php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- reCAPTCHA filter generates HTML.
echo apply_filters('gglcptch_display_recaptcha', '', 'sa_lwo_form');
?>
<p class="form-row">
    <button type="submit" class="button smsalert_login_with_otp_btn" name="smsalert_login_with_otp_btn" value="<?php echo esc_attr($button_field); ?>"><span class="button__text"><?php echo esc_html($button_field); ?></span></button>    
    <a href="#" onclick="return false;" class="sa_default_login_form" data-parentForm="login"><?php esc_html_e('Back', 'sms-alert'); ?></a>
</p>