<?php
/**
 * COD to prepaid template.
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
<div class="cvt-accordion">
    <div class="accordion-section">        
        <div class="cvt-accordion-body-title" data-href="#accordion_Code_to_prepaid_cust_0">
            <input type="checkbox" name="smsalert_cod_to_prepaid[customer_notify]" id="smsalert_cod_to_prepaid[customer_notify]" class="notify_box" <?php echo ( 'on' === $templates[0]['enabled'] ) ? "checked='checked'" : ''; ?> /><label><?php echo esc_html($templates[0]['title']); ?></label>
            <span class="expand_btn"></span>
        </div>
        <div id="accordion_Code_to_prepaid_cust_0" class="cvt-accordion-body-content">
            <?php
            $smsalert_count = 0;
            $smsalert_total_frequency = array();
            foreach ( $templates as $smsalert_template ) {
                if ($smsalert_template['text-body'] == '' ) {
                    continue;
                }
                ?>
            <table class="form-table cod_sche bottom-border" id="codscheduler_<?php echo esc_attr($smsalert_count); ?>">
                <tr valign="top">
                    <th>
                        <label><?php esc_html_e('Send sms to  payment url', 'sms-alert'); ?></label>
                    </th>
                    <td>
                <?php
                $smsalert_hours = $smsalert_template['frequency'];
                    
                array_push($smsalert_total_frequency, $smsalert_hours);
                    
                if ('' === $smsalert_hours ) {
                    $smsalert_hours = 60;
                }
                ?>
                        <select id="<?php echo esc_attr($smsalert_template['selectNameId']); ?>" name="<?php echo esc_attr($smsalert_template['selectNameId']); ?>" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" class="smsalert_cod_to_prepaid_scheduler">
                            <option value='10' <?php selected($smsalert_hours, 10); ?>><?php esc_html_e('After 10 minutes', 'sms-alert'); ?></option>
                            <option value='20' <?php selected($smsalert_hours, 20); ?>><?php esc_html_e('After 20 minutes', 'sms-alert'); ?></option>
                            <option value='30' <?php selected($smsalert_hours, 30); ?>><?php esc_html_e('After 30 minutes', 'sms-alert'); ?></option>
                            <option value='60' <?php selected($smsalert_hours, 60); ?>><?php esc_html_e('After 1 hour', 'sms-alert'); ?></option>
                            <option value='120' <?php selected($smsalert_hours, 120); ?>><?php esc_html_e('After 2 hours', 'sms-alert'); ?></option>
                            <option value='180' <?php selected($smsalert_hours, 180); ?>><?php esc_html_e('After 3 hours', 'sms-alert'); ?></option>
                            <option value='240' <?php selected($smsalert_hours, 240); ?>><?php esc_html_e('After 4 hours', 'sms-alert'); ?></option>
                            <option value='300' <?php selected($smsalert_hours, 300); ?>><?php esc_html_e('After 5 hours', 'sms-alert'); ?></option>
                            <option value='360' <?php selected($smsalert_hours, 360); ?>><?php esc_html_e('After 6 hours', 'sms-alert'); ?></option>
                            <option value='720' <?php selected($smsalert_hours, 720); ?>><?php esc_html_e('After 12 hours', 'sms-alert'); ?></option>
                            <option value='1440' <?php selected($smsalert_hours, 1440); ?>><?php esc_html_e('After 24 hours', 'sms-alert'); ?></option>
                            <option value='2880' <?php selected($smsalert_hours, 2880); ?>><?php esc_html_e('After 48 hours', 'sms-alert'); ?></option>
                            <option value='0' <?php selected($smsalert_hours, 0); ?>><?php esc_html_e('Disable notifications', 'sms-alert'); ?></option>
                        </select> 
                        
                        <a href="#" onclick="return false;" class="sa-delete-btn alignright"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e('Remove', 'sms-alert'); ?></a>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2">
                        <div class="smsalert_tokens">
                <?php
                foreach ( $smsalert_template['token'] as $smsalert_vk => $smsalert_vv ) {
                    echo wp_kses_post(sprintf("<a href='#' data-val='%s'>%s</a> | ", $smsalert_vk, $smsalert_vv));
                }
                ?>
                <?php if (! empty($smsalert_template['moreoption']) ) { ?>
                                <a href="<?php echo esc_url($url); ?>" class="thickbox search-token-btn">[...More]</a>
                <?php } ?>
                        </div>
                        <textarea name="<?php echo esc_attr($smsalert_template['textareaNameId']); ?>" id="<?php echo esc_attr($smsalert_template['textareaNameId']); ?>" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>" <?php echo( ( 'on' === $smsalert_template['enabled'] ) ? '' : "readonly='readonly'" ); ?> class="token-area"><?php echo esc_textarea($smsalert_template['text-body']); ?></textarea>
                        <div id="menu_code_to_prepaid<?php echo esc_attr($smsalert_count) ?>" class="sa-menu-token" role="listbox"></div>
                    </td>
                </tr>
            </table>
                <?php $smsalert_count++; 
            } ?>
            <div style="padding: 10px 0px 0px 10px;">
                <button class="button action" id="addNewpage" type="button" data-parent_id="<?php echo esc_attr($smsalert_template['checkboxNameId']); ?>">
                <span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e('Add New', 'sms-alert'); ?></button>
            </div>
        </div>
        <div class="" style="padding: 5px 10px 10px 10px;">
            <table class="form-table">
                <tbody>
                <tr>
            <th scope="row"><?php esc_html_e('When order is marked as', 'sms-alert'); ?><span class="tooltip" data-title="Select Order Status"><span class="dashicons dashicons-info"></span></span>
                        </th>
                        <td>
                            <select name="smsalert_cod_to_prepaid[order_status]" id="smsalert_cod_to_prepaid[order_status]" data-parent_id="smsalert_cod_to_prepaid[customer_notify]" style="width:80%">
                                
                                <?php
                                $smsalert_order_statuses = is_plugin_active('woocommerce/woocommerce.php') ? wc_get_order_statuses() : array();
    
    
                                $smsalert_order_status     = smsalert_get_option('order_status', 'smsalert_cod_to_prepaid', "wc-processing");
                                
                                foreach ( $smsalert_order_statuses as $smsalert_o_key => $smsalert_status ) {
                                    
                                    ?>
                                <option 
                                    <?php 
                                    
                                    if (strtolower($smsalert_order_status)==strtolower($smsalert_o_key)) {
                                        
                                        echo "selected";
                                    }
                                    ?>
                                
                                value="<?php echo esc_attr(strtr(strtolower($smsalert_o_key), ' ', '-')); ?>"><?php echo esc_attr($smsalert_status); ?></option>
                                
                                <?php } ?>
                            </select>
                            <span class="tooltip" data-title="Select Order Status"><span class="dashicons dashicons-info"></span></span>
                        </td>
                        
                    
                    
            <th scope="row"><?php esc_html_e(' When payment method is', 'sms-alert'); ?><span class="tooltip" data-title="Please select payment gateway"><span class="dashicons dashicons-info"></span></span>
                        </th>
                        <td>
                            <select name="smsalert_cod_to_prepaid[checkout_payment_plans]" id="checkout_payment_plans" data-parent_id="smsalert_cod_to_prepaid[customer_notify]" style="width:80%">
                            
                                <?php
                                 $smsalert_payment_plans = WC()->payment_gateways->payment_gateways();
                                 
                                 
                                 $smsalert_checkout_payment_plans     = smsalert_get_option('checkout_payment_plans', 'smsalert_cod_to_prepaid', "cod");
                                 
                                 
                                foreach ( $smsalert_payment_plans as $smsalert_payment_plan ) {
                                    echo '<option ';
                                    if ($smsalert_payment_plan->id == $smsalert_checkout_payment_plans) {
                                        echo( 'selected' );
                                    } 
                                    echo( ' value="' . esc_attr($smsalert_payment_plan->id) . '">' . esc_attr($smsalert_payment_plan->title) . '</option>' );

                                } ?>
                            </select>
                            <span class="tooltip" data-title="Please select payment gateway"><span class="dashicons dashicons-info"></span></span>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>                
    </div>
    
</div>
<div class="submit alignright">
    <a href="https://kb.smsalert.co.in/knowledgebase/cod-to-prepaid-sms-integration/" target="_blank" class="btn-outline" style="float:left;"><span class="dashicons dashicons-format-aside"></span> Documentation</a>
</div>
<!-- /-cvt-accordion -->

<script>
    jQuery("#addNewpage").on("click", addSchedulerpage );
  
    function addSchedulerpage(){
        var last_scheduler_no = jQuery('#accordion_Code_to_prepaid_cust_0').find('.form-table:last').attr("id").split('_')[1];        
        jQuery("#accordion_Code_to_prepaid_cust_0 .form-table:last").clone().insertAfter("#accordion_Code_to_prepaid_cust_0 .form-table:last");        
        
        var new_scheduler_no = +last_scheduler_no + 1; 
        
        jQuery('#accordion_Code_to_prepaid_cust_0 .form-table:last').attr('id', 'codscheduler_' + new_scheduler_no);
        var scheduler_last = jQuery("#codscheduler_"+new_scheduler_no).html().replace(  /\[cron\]\[\d+\]/g,  "[cron]["+new_scheduler_no+"]"); 
        
        jQuery('#codscheduler_'+new_scheduler_no).html(scheduler_last);
    }    
    jQuery(document).on('click',".sa-delete-btn",function(){
        var last_item     = (jQuery(".cod_sche").length==1) ? true : false;
        if(last_item)
        {
            showAlertModal(alert_msg.last_item);
            return false;
        }
        else
        {
            jQuery(this).parents(".cod_sche").remove();
        }
    });
    jQuery(document).ready(function(){
        var frequency_arr = <?php echo json_encode($smsalert_total_frequency) ?>;
        
        var frequency_sch = jQuery(".smsalert_cod_to_prepaid_scheduler").length;
        
        jQuery('.smsalert_cod_to_prepaid_scheduler').each(function(index) {
            
            var selected_freq = jQuery("#codscheduler_"+index+" .smsalert_cod_to_prepaid_scheduler").find(":selected").val();
            
            jQuery.each(frequency_arr, function (i, elem) {                
                if( selected_freq != elem ){
                    jQuery("#codscheduler_"+index+" option[value='"+elem+"']").attr("disabled", "disabled");
                }
            });
        });
    })
</script>
