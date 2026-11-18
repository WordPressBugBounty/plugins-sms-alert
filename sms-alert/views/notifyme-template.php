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
?>
<!-- Admin-accordion -->
<div class="cvt-accordion"><!-- cvt-accordion -->
    <div class="accordion-section">
        <?php
        if (!empty($templates)) {
            foreach ( $templates as $smsalert_template ) { 
                ?>
        <div class="cvt-accordion-body-title" data-href="#accordion_<?php echo esc_attr($checkTemplateFor); ?>_<?php echo esc_attr($smsalert_template['status']); ?>">
            <input type="checkbox" name="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" class="notify_box" <?php echo ( 'on' === $smsalert_template['enabled'] ) ? "checked='checked'" : ''; ?> <?php echo ( ! empty($smsalert_template['chkbox_val']) ) ? "value='" . esc_attr($smsalert_template['chkbox_val']) . "'" : ''; ?>  /><label><?php echo esc_html($smsalert_template['title']); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_<?php echo esc_attr($checkTemplateFor); ?>_<?php echo esc_attr($smsalert_template['status']); ?>" class="cvt-accordion-body-content">
            <table class="form-table">
                <tr valign="top" style="position:relative">
                    <td>
                        <div class="smsalert_tokens">
                <?php
                foreach ( $smsalert_template['token'] as $smsalert_vk => $smsalert_vv ) {
                    echo  "<a href='#' data-val='".esc_attr($smsalert_vk)."'>".esc_attr($smsalert_vv)."</a> | ";
                }
                ?>
                        </div>
                        <textarea name="<?php echo esc_attr($smsalert_template['textareaNameId']); ?>" id="<?php echo esc_attr($smsalert_template['textareaNameId']); ?>" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" <?php echo( ( 'on' === $smsalert_template['enabled'] ) ? '' : "readonly='readonly'" );?>  class="token-area" ><?php echo esc_textarea($smsalert_template['text-body']); ?></textarea>
                        <div id="menu_<?php echo esc_attr($checkTemplateFor); ?>_<?php echo esc_attr($smsalert_template['status']); ?>" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
            </table>
        </div>
                <?php
            } 
        }
        ?>
        <div>
        <table class="form-table">
        <tr valign="top" style="position:relative">
            <td class="td-heading">
                        Notify Me Style:                </td>
            <td><?php
                $smsalert_disabled = (! is_plugin_active('elementor/elementor.php')) ? "anchordisabled" : "";
                $post = get_page_by_path('notifyme_style', OBJECT, 'sms-alert'); 
            ?>              
                <a href="<?php echo esc_url(admin_url('edit.php?post_name=notifyme_style')); ?>" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" class="button <?php echo esc_attr($smsalert_disabled); ?> notifyme action" target="_blank" style="float:left;">
					<?php esc_html_e('Edit With Elementor', 'sms-alert'); ?>
				</a>
                <?php if (!empty($post->post_type)) {?>
                <a href="#" onclick="return false;" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" id="btn_reset_style" temp-style="notifyme_style" class="btn_reset_style btn-outline" style="float:left;"><?php esc_html_e('Reset', 'sms-alert'); ?></a>
                    <?php
                }
                ?>
                <span class="reset_style"></span>    
            <?php
            if ($smsalert_disabled!='') {
                ?>        
            <span><?php esc_html_e('To edit, please install elementor plugin', 'sms-alert'); ?>    </span>
                <?php
            }
            ?>
            </td>
        </tr>
    </table>
        </div>
    </div>    
</div>

<!--help links-->
<?php
if (!empty($templates)) {
    foreach ( $templates as $smsalert_template ) {
        if (!empty($smsalert_template['help_links']) ) {
                
            foreach ($smsalert_template['help_links'] as $link) {
                echo wp_kses_post('<a href="'.$link['href'].'" alt="'.$link['alt'].'" target="'.$link['target'].'" class="'.$link['class'].'">'.$link['icon']." ".$link['label'].'</a>');
            }
        } 
    } 
}
?>

<div class="submit" style="clear:both">
    <a href="admin.php?page=all-subscriber" class="button action alignright"><?php esc_html_e('View Subscriber', 'sms-alert'); ?></a>
</div>

