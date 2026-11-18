<?php
/**
 * Sms Campain template.
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
    $smsalert_username = smsalert_get_option('smsalert_name', 'smsalert_gateway');
    $smsalert_password = smsalert_get_option('smsalert_password', 'smsalert_gateway');
    $smsalert_result    = SmsAlertcURLOTP::getTemplates($smsalert_username, $smsalert_password);
    $smsalert_templates = (array)json_decode($smsalert_result, true);
    $smsalert_result = SmsAlertcURLOTP::getSenderids($smsalert_username, $smsalert_password);
    $smsalert_senderids = json_decode($smsalert_result, true);
    $smsalert_result = json_decode(SmsAlertcURLOTP::getCredits(), true);
    $smsalert_routes = ($smsalert_result['description']['routes']);
    $smsalert_phone = array();
    $smsalert_tokens = array();
    $smsalert_count = 0;
    $smsalert_phone_data = '';
    $smsalert_search_hide = 'display:none;';
    $smsalert_send_hide = 'display:block;';
if ($type == 'order_status_data') {
    $smsalert_tokens = WooCommerceCheckOutForm::getOrderVariables();
    $smsalert_search_hide = 'display:block;';
    $smsalert_send_hide = 'display:none;';
}
    global $wpdb;
if (! empty($post_ids) ) {
    foreach ( $post_ids as $smsalert_key => $post_id ) {
		$post_id = absint($post_id);
		if (! $post_id || ! current_user_can('edit_user', $post_id)) {
			continue;
		}
        if ($type == 'orders_data') {
            $smsalert_tokens = WooCommerceCheckOutForm::getOrderVariables();
            if (version_compare(WC_VERSION, '7.1', '<') ) {
                  $smsalert_user_phone = get_post_meta($post_id, '_billing_phone', true);
            } else {
                $order    = wc_get_order($post_id);
                $smsalert_user_phone  = !empty($order->get_billing_phone())?$order->get_billing_phone():$order->get_shipping_phone(); 
            }
            $smsalert_phone[] =$smsalert_user_phone;
        } elseif ($type == 'users_data') {
            $smsalert_tokens = array(
            '[username]'      => 'Username',
            '[store_name]'    => 'Store Name',
            '[email]'         => 'Email',
            '[billing_phone]' => 'Billing Phone',
            '[shop_url]'      => 'Shop Url',
            );
            $smsalert_user_phone = get_user_meta($post_id, 'billing_phone', true); 
            $smsalert_phone[] =$smsalert_user_phone;
        } elseif ($type == 'abandoned_data') {
            $smsalert_tokens = SA_Abandoned_Cart::getAbandonCartvariables();
            $smsalert_table_name = $wpdb->prefix . SA_CART_TABLE_NAME;
            $smsalert_results = $wpdb->get_row($wpdb->prepare(
				"SELECT * FROM `" . esc_sql($smsalert_table_name) . "` WHERE id = %d",
				$post_id
			), ARRAY_A);
            $smsalert_phone[] =$smsalert_results['phone'];
        } elseif ($type == 'subscribe_data') {  
            $smsalert_tokens = array(
            '[item_name]'       => 'Product Name',
            '[name]'            => 'Name',
            '[subscribed_date]' => 'Date',
            '[product_url]'     => 'Product Url',
            '[store_name]'      => 'Store Name',
            '[shop_url]'        => 'Shop Url',
            );
            global $wpdb;
            $smsalert_results = $wpdb->get_row($wpdb->prepare(
				"SELECT P.post_title, P.post_status, P.post_content, PM.meta_value
				 FROM {$wpdb->prefix}posts AS P
				 INNER JOIN {$wpdb->prefix}postmeta AS PM 
					ON P.ID = PM.post_id
				 WHERE P.ID = %d",
				$post_id
			), ARRAY_A);
            $smsalert_phone[] = $smsalert_results['post_title'];
        } 
    }
    $smsalert_phone_data = implode(',', $smsalert_phone);
    $smsalert_count = count($smsalert_phone);
  
}
wp_register_script(
    'custom-jquery',
    SA_MOV_URL . 'js/chosen.jquery.min.js',
    array(),
    SmsAlertConstants::SA_VERSION,
    true
);
wp_enqueue_script('custom-jquery'); 
?>
<style>
#sendbox_section select,#sendbox_section input,#sendbox_section textarea{padding:8px;width:50%;margin-top:5px;}
.sarow button{
    padding: 6px 10px;
    color: #ffff;
    font: inherit;
    background-color: #2271B1;
    border: 1px solid #F0F0F1;
    border-radius: 5px;
    cursor: pointer;
    }
</style>
    <div class="container">
        <h1 >SMS CAMPAIGN</h1>
        <div id="search_section" style="<?php echo esc_attr($smsalert_search_hide); ?>">
       <p class="sarow">
        <label>Select Order Status<br>
            <select  name="order_statuses[]" size="10" data-placeholder="Choose Order Status"  id="order_statuses" multiple class="chosen-select">
            <?php 
               $smsalert_order_statuses = is_plugin_active('woocommerce/woocommerce.php') ? wc_get_order_statuses() : array();
            foreach ( $smsalert_order_statuses as $smsalert_vs  => $smsalert_order_status ) {
                ?>
            <option value="<?php echo esc_attr(strtolower($smsalert_vs));?>"><?php echo  esc_html($smsalert_order_status);?></option>
                <?php
            }
            ?>
         </select>
         </label>
        </p>
        <p class="sarow">
              <button type="button" onclick="search_data()" id="btn">SearchData</button>
        </p>
        </div>
		<?php
		echo wp_kses(
			wp_nonce_field('sacampaign_wp_nonce', 'sacampaign_nonce', true, false),
			array(
				'input' => array(
					'type'  => true,
					'id'    => true,
					'name'  => true,
					'value' => true,
				),
			)
		);
		?>
        <!-- SEARCH DATA -->
        <div id="send_section" style="<?php echo esc_attr($smsalert_send_hide); ?>">
            <div style="display:flex">
            <h3>Total record : <span class="trecord">0</span></h3>
            <a href="#" style="margin-top:20px; margin-left:10px; display:none;" onclick="resetSearch()" id="resetsearch"> modify search </a>                
             </div>
            <div  id="sendbox_section">
                <p class="sarow">
                    <label>
                    Senderid:<br>
                    <select id="senderid">
                   <?php
                    if (!empty($smsalert_senderids['status']) && $smsalert_senderids['status'] == 'success') {
                        foreach ($smsalert_senderids['description'] as $smsalert_key => $smsalert_senderid) {
                            ?>
                            <option value="<?php  echo esc_attr($smsalert_senderid['Senderid']['sender']);?>"><?php  echo esc_html($smsalert_senderid['Senderid']['sender']);?></option>
                           
                            <?php 
                        }
                    } else {
                        ?>
                <option value="ESTORE">ESTORE</option>  
                        <?php
                    }
                    ?>
                        </select>
                    </label>
                    </p>
                    <?php 
                    if (count($smsalert_routes)>1) {?>
                    <p class="sarow">
                        <label>
                        Route:<br>
                        <select id="route">
                        
                        <?php
                        foreach ($smsalert_routes as $smsalert_key => $smsalert_route) {
                            ?>
                        <option value="<?php echo esc_attr($smsalert_route['route']);?>"><?php echo esc_html($smsalert_route['route']);?></option>
                            <?php  
                        }
                        ?> 
                        </select>
                    </label>
                    </p>
                        <?php
                    }
                    if (!empty($smsalert_templates['status']) && $smsalert_templates['status'] == 'success') {
                        ?>
                    <p class="sarow">
                        <label>
                        Template:<br>
                    <select name="templates" id="sms_template">
                    <option value="" disabled selected>Select Template...</option>
                        <?php foreach ( $smsalert_templates['description'] as $smsalert_template ) {
                            ?>
                <option value="<?php echo esc_attr($smsalert_template['Smstemplate']['template']); ?>"><?php echo esc_html($smsalert_template['Smstemplate']['title']); ?></option>
                            <?php
                        }
                        ?>            
                </select>   
                </label>
                </p>
                        <?php
                    }
                    ?>
                    <p class="sarow">
                        <div class="smsalert_tokens">
                        <?php
                        foreach ( $smsalert_tokens as $smsalert_vk => $smsalert_vv ) {
                            echo  "<a href='#' onclick='return false;' data-val='".esc_attr($smsalert_vk)."'>".esc_html($smsalert_vv)."</a> | ";
                        }
                        ?>
                        </div>
                        <textarea name="message" id="sa_message" rows="5" cols="40" placeholder="Message"></textarea>
                    </p>
                    <p class="sarow">
                      <button type="button" id="send_sms"  onclick="sendsms()">Send SMS</button>
                      <a href="<?php echo esc_url(!empty($_SERVER['HTTP_REFERER'])?sanitize_text_field(wp_unslash($_SERVER['HTTP_REFERER'])):''); ?>" style="margin-top:20px; margin-left:10px;"> Go Back</a>
                    </p>
                <div id="success_message">
                </div>
                <div id="error_message">
                 </div>              
                </div>
        </div>
        </div>
                <script>
                var phone = '<?php echo esc_js($smsalert_phone_data); ?>';      
                var type = '<?php echo esc_js($type); ?>';      
                var post_ids = '<?php echo esc_js(implode(',', $post_ids)); ?>';      
                jQuery('.trecord').text('(<?php echo esc_js($smsalert_count); ?>)');
				jQuery(document).on("change","#sms_template",function(){
					jQuery('#sa_message').val(jQuery(this).val());
				});
				jQuery(document).ready(function(){
                  jQuery(".chosen-select").chosen();
				});
                
                function search_data(){
                    var order_statuses = jQuery('#order_statuses').val();
                    var sacampaign_nonce = jQuery('#sacampaign_nonce').val();
                    jQuery('#btn').html('Please Wait..');
                    jQuery.ajax({
                        url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
                        type:'POST',
                        data:'action=process_campaign&order_statuses='+order_statuses+'&sacampaign_nonce='+sacampaign_nonce+'&searchdata=',
                          
                         success : function(response) {
                            jQuery('#btn').html('SearchData');
                            if(response>0) 
                            {
                            jQuery('.trecord').text(response);
                            jQuery('#search_section').hide();
                            jQuery('#resetsearch').show();
                            jQuery('#send_section').show();
                            }
                        }
                    });
                }
                
                function resetSearch(){
                 jQuery('#search_section').show();
                 jQuery('#send_section').hide();
                 jQuery('#resetsearch').hide();
                 jQuery('.trecord').text(0);
                }

                function sendsms(){
                    var senderid = jQuery('#senderid').val();
                    var sacampaign_nonce = jQuery('#sacampaign_nonce').val();
                    var route = (jQuery('#route').val() != undefined)?jQuery('#route').val():'';
                    var template = jQuery('#sms_template').val();
                    var message = jQuery('#sa_message').val();
                    var order_statuses = jQuery('#order_statuses').val();
                    jQuery('#send_sms').css('disabled',true).html('Please Wait...');
                    
                    jQuery.ajax({
                        url: "<?php echo esc_url(admin_url('admin-ajax.php')); ?>",
                        type:'POST',
                        data:'action=process_campaign&senderid='+senderid+'&route='+route+'&message='+message+'&phone='+phone+'&type='+type+'&post_ids='+post_ids+'&order_statuses='+order_statuses+'&sacampaign_nonce='+sacampaign_nonce,
                         success : function(response){
                            jQuery('#send_sms').css('disabled',false).html('Send SMS');
                             if(response==1)
                             {
                                jQuery('#success_message').html(' <h3>Message sent successfully!</h3>').fadeOut(3e3,function(){jQuery("#success_message").html("")});
                             }else{
                                jQuery('#error_message').html(' <h3>Something went wrong!</h3>').fadeOut(3e3,function(){jQuery("#error_message").html("")});
                             }
                        },
                        
                    });
                }
        function insertAtCaret(e, t) {
            var s = document.getElementById(t);
            if (document.all)
                if (s.createTextRange && s.caretPos) {
                    var i = s.caretPos;
                    i.text = " " == i.text.charAt(i.text.length - 1) ? e + " " : e
                } else s.value = s.value + e;
            else if (s.setSelectionRange) {
                var r = s.selectionStart,
                    o = s.selectionEnd,
                    n = s.value.substring(0, r),
                    l = s.value.substring(o);
                s.value = n + e + l
            } else alert("This version of Mozilla based browser does not support setSelectionRange")
        }        
        jQuery(document).on("click",".smsalert_tokens a",function(){
            return insertAtCaret(jQuery(this).attr("data-val"),
            jQuery("#sa_message").attr("id"));
        });
               
    </script>
