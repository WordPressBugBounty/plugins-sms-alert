<?php
/**
 * SmsCampaign helper.
 *
 * PHP version 5
 *
 * @category Handler
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 */

if (! defined('ABSPATH') ) {
    exit;
}
    
/**
 * PHP version 5
 *
 * @category Handler
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 * SmsCampaign class
 */
class SmsCampaign
{

    /**
     * Construct function.
     *
     * @return string
     */
    public function __construct()
    {
        $user_authorize = new smsalert_Setting_Options();
        if ($user_authorize->is_user_authorised()) {           
            add_filter("bulk_actions-users", array( $this, 'addUsersAction' ), 1);
            add_filter('handle_bulk_actions-users', array( $this, 'usersSendsms' ), 10, 3);
            add_filter('bulk_actions-edit-shop_order', array( $this, 'addOrdersAction' ), 1);
            add_filter('handle_bulk_actions-edit-shop_order', array( $this, 'ordersSendsms' ), 10, 3);
            add_action('wp_ajax_process_campaign', array( $this, 'processCampaign' ));
            add_action('wp_ajax_nopriv_process_campaign', array( $this, 'processCampaign' ));
            add_action('admin_menu', array( $this, 'smscampaignMenu'));
        }
    }
    
    /**
     * Add smscampaign menu.
     *
     * @return array
     */
    public function smscampaignMenu()
    {
        add_submenu_page('options.php', 'All Smscampaign', 'All Smscampaign', 'manage_options', 'sa-smscampaign', array( $this,'saSmscampaign'));
    }
    
    /**
     * Add smscampaign page.
     *
     * @return array
     */
    public function saSmscampaign()
    {
        $params =array(
        'post_ids'=> array(),
        'type'=> 'order_status_data',
                
        );
        echo get_smsalert_template('template/sms_campaign.php', $params, true);
        exit();
    }
    
    /**
     * Add send sms action at user listing page.
     *
     * @param array $actions actions.
     *
     * @return array
     */
    public function addUsersAction($actions)
    {
        $actions['sa_user_sendsms'] = __('Send SMS', 'sms-alert');

        return $actions;
    }
    
    /**
     * Send sms function at user listing page.
     *
     * @param string $redirect_to redirect_to.
     * @param string $doaction    doaction.
     * @param array  $post_ids    post_ids.
     *
     * @return array
     */
    public function usersSendsms($redirect_to, $doaction, $post_ids)
    {

        if ('sa_user_sendsms' === $doaction ) {
            $params =array(
            'post_ids'=> $post_ids,
            'type'=> 'users_data',
                
            );
            echo get_smsalert_template('template/sms_campaign.php', $params, true);
            exit();
        }
    }
    
    /**
     * Add send sms action at order listing page.
     *
     * @param array $actions actions.
     *
     * @return array
     */
    public function addOrdersAction($actions)
    {
        $actions['sa_order_sendsms'] = __('Send SMS', 'sms-alert');

        return $actions;
    }
    
    /**
     * Send sms function at order listing page.
     *
     * @param string $redirect_to redirect_to.
     * @param string $doaction    doaction.
     * @param array  $post_ids    post_ids.
     *
     * @return array
     */
    public function ordersSendsms($redirect_to, $doaction, $post_ids)
    {

        if ('sa_order_sendsms' === $doaction ) {
            $params =array(
            'post_ids'=> $post_ids,
            'type'=> 'orders_data',
                
            );
            echo get_smsalert_template('template/sms_campaign.php', $params, true);
            exit();
        }
    }
    
    /**
     * Process sms campign function.
     *
     * @return int
     */
    public function processCampaign()
    {
		$order_statuses = isset($_POST['order_statuses']) ? sanitize_text_field($_POST['order_statuses']) : '';
		$searchdata = isset($_POST['searchdata']) ? sanitize_text_field($_POST['searchdata']) : '';
		$senderid = isset($_POST['senderid']) ? sanitize_text_field($_POST['senderid']) : '';
		$route = isset($_POST['route']) ? sanitize_text_field($_POST['route']) : '';
		$message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
		$phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
		$type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
		$post_ids = isset($_POST['post_ids']) ? sanitize_text_field($_POST['post_ids']) : '';
		
		
        if (!empty($order_statuses) && !empty($searchdata)) {
            $datas = self::getOrdersPhone($order_statuses);
            echo count($datas);
            die();
        } 

        if (!empty($senderid) && !empty($route) && !empty($message) && !empty($order_statuses) || !empty($phone)) {
            $datas = array();
            $phone = trim($phone);
            if (empty($phone)) {
                $phones = self::getOrdersPhone($order_statuses);
            } else {
                $phones = explode(",", $phone);
            }
            $post_ids = !empty($post_ids)?explode(",", $post_ids):'';
            foreach ($phones as $key=>$data) {
                $phone = is_array($data)?$data['phone']:$data;
                $post_id = !empty($post_ids)?$post_ids[$key]:$data['order_id'];
                $message = apply_filters('before_sa_campaign_send', $message, $type, $post_id);
                $datas[] = array('number' => $phone, 'sms_body' => $message);
            }          
            $resp    = SmsAlertcURLOTP::sendSmsXml($datas, $senderid, $route);
            $response_arr = json_decode($resp, true);
            if ('success' === $response_arr['status'] ) {
                echo '1';
            } else {
                echo '0';
            }
            die();
        }    
    }
    
    /**
     * Get orders phone.
     *
     * @param array $statuses statuses.
     *
     * @return array
     */
    public function getOrdersPhone($statuses)
    {
        $args = array(
        'status' => explode(',', $statuses),
        'limit'  => -1,
        );
        $orders = wc_get_orders($args);
        $user_phones = array();
        foreach ($orders as $key => $order) {
            $phone = $order->get_billing_phone();
            $user_phones[$key]['phone'] = $phone;
            $user_phones[$key]['order_id'] = $order->get_id();
        }
        return $user_phones;
    }

}
new SmsCampaign();
?>
