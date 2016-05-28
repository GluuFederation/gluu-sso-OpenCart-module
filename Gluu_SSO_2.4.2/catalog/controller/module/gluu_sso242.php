<?php
class ControllerModuleGluuSSO242 extends Controller
{
    // Errors
    protected $error;

    /*
    *   Showing selected icons
    */
    public function index ($setting)
    {
        require_once(DIR_SYSTEM . 'library/oxd-rp-242/Get_authorization_url.php');
        require_once(DIR_SYSTEM . 'library/oxd-rp-242/Get_tokens_by_code.php');
        require_once(DIR_SYSTEM . 'library/oxd-rp-242/Get_user_info.php');

        if( isset( $_REQUEST['session_state'] ) ) {
            $config_option = json_decode($this->gluu_db_query_select('oxd_config'),true);
            $oxd_id = $this->gluu_db_query_select('oxd_id');
            $get_tokens_by_code = new Get_tokens_by_code();
            $get_tokens_by_code->setRequestOxdId($oxd_id);
            $get_tokens_by_code->setRequestCode($_REQUEST['code']);
            $get_tokens_by_code->setRequestState($_REQUEST['state']);
            $get_tokens_by_code->setRequestScopes($config_option["scope"]);
            $get_tokens_by_code->request();
            $get_tokens_by_code_array = $get_tokens_by_code->getResponseObject()->data->id_token_claims;

            $get_user_info = new Get_user_info();
            $get_user_info->setRequestOxdId($oxd_id);
            $get_user_info->setRequestAccessToken($get_tokens_by_code->getResponseAccessToken());
            $get_user_info->request();
            $get_user_info_array = $get_user_info->getResponseObject()->data->claims;

            $_SESSION['user_oxd_id_token']= $get_tokens_by_code->getResponseIdToken();
            $_SESSION['user_oxd_access_token']= $get_tokens_by_code->getResponseAccessToken();
            $_SESSION['session_states']= $_REQUEST['session_state'];
            $_SESSION['states']= $_REQUEST['state'];

            $reg_first_name = '';
            $reg_last_name = '';
            $reg_email = '';
            $reg_home_phone_number = '';
            $reg_phone_mobile_number = '';
            if($get_user_info_array->given_name[0]){
                $reg_first_name = $get_user_info_array->given_name[0];
            }elseif($get_tokens_by_code_array->given_name[0]){
                $reg_first_name = $get_tokens_by_code_array->given_name[0];
            }
            if($get_user_info_array->family_name[0]){
                $reg_last_name = $get_user_info_array->family_name[0];
            }elseif($get_tokens_by_code_array->family_name[0]){
                $reg_last_name = $get_tokens_by_code_array->family_name[0];
            }
            if($get_user_info_array->email[0]){
                $reg_email = $get_user_info_array->email[0];
            }elseif($get_tokens_by_code_array->email[0]){
                $reg_email = $get_tokens_by_code_array->email[0];
            }
            if($get_user_info_array->phone_number[0]){
                $reg_home_phone_number = $get_user_info_array->phone_number[0];
            }elseif($get_tokens_by_code_array->phone_number[0]){
                $reg_home_phone_number = $get_tokens_by_code_array->phone_number[0];
            }
            if($get_user_info_array->phone_mobile_number[0]){

                $reg_phone_mobile_number = $get_user_info_array->phone_mobile_number[0];
            }elseif($get_tokens_by_code_array->phone_mobile_number[0]){
                $reg_phone_mobile_number = $get_tokens_by_code_array->phone_mobile_number[0];
            }

            $phone = $reg_home_phone_number . ', '. $reg_phone_mobile_number;

            $user_data = array(
                'user_first_name' => $reg_first_name,
                'user_last_name' => $reg_last_name,
                'user_email' => $reg_email,
                'user_phone_number' => $phone
            );
            if($customer_id = $this->get_by_email($reg_email)){
                if ($this->login ($customer_id))
                {
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                }
            }
            else if (($customer_id = $this->add_customer ($user_data)) !== false)
            {
                if ($this->login ($customer_id))
                {
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                }
            }
        }
        else if( isset( $_REQUEST['app_name'] ) ) {
            $get_authorization_url = new Get_authorization_url();
            $get_authorization_url->setRequestOxdId($this->gluu_db_query_select('oxd_id'));
            $get_authorization_url->setRequestAcrValues([$_REQUEST['app_name']]);
            $get_authorization_url->request();
            header('Location: '.$get_authorization_url->getResponseAuthorizationUrl());
            exit;
        }

        // Load Language
        $this->load->language ('module/gluu_sso242');
        $data['script_logged'] = '';
        $data['user_is_logged'] = $this->customer->isLogged ();

        $data['messageConnectProvider'] = $this->language->get('messageConnectProvider');
        $data['messageSiteRegisteredSuccessful'] = $this->language->get('messageSiteRegisteredSuccessful');
        $data['messageScopeDeletedSuccessful'] = $this->language->get('messageScopeDeletedSuccessful');
        $data['messageConfigurationsDeletedSuccessful'] = $this->language->get('messageConfigurationsDeletedSuccessful');
        $data['messageScriptDeletedSuccessful'] = $this->language->get('messageScriptDeletedSuccessful');
        $data['messageYourConfiguration'] = $this->language->get('messageYourConfiguration');
        $data['messageOpenIDConnectConfiguration'] = $this->language->get('messageOpenIDConnectConfiguration');
        $data['messageSorryUploading'] = $this->language->get('messageSorryUploading');
        $data['messageSwitchedOn'] = $this->language->get('messageSwitchedOn');

        $data['get_scopes'] =   json_decode($this->gluu_db_query_select('scopes'),true);
        $data['oxd_config'] =   json_decode($this->gluu_db_query_select('oxd_config'),true);
        $custom_scripts = json_decode($this->gluu_db_query_select('custom_scripts'),true);
        $data['custom_scripts'] = $custom_scripts;
        $data['iconSpace'] = $this->gluu_db_query_select('iconSpace');
        $data['iconCustomSize'] = $this->gluu_db_query_select('iconCustomSize');
        $data['iconCustomWidth'] = $this->gluu_db_query_select('iconCustomWidth');
        $data['iconCustomHeight'] = $this->gluu_db_query_select('iconCustomHeight');
        $data['loginCustomTheme'] = $this->gluu_db_query_select('loginCustomTheme');
        $data['loginTheme'] = $this->gluu_db_query_select('loginTheme');
        $data['iconCustomColor'] = $this->gluu_db_query_select('iconCustomColor');

        $data['base_url'] = HTTPS_SERVER;
        if($this->gluu_db_query_select('oxd_id')){
            $data['oxd_id'] = $this->gluu_db_query_select('oxd_id');
        }else{
            $data['oxd_id'] = '';
        }

        $enableds = array();
        foreach($custom_scripts as $custom_script){
            $enableds[] = array('enable'=>$this->gluu_db_query_select($custom_script['value']."Enable"), 'value'=>$custom_script['value'], 'name'=>$custom_script['name'], 'image'=>$custom_script['image']);
        }
        $data['enableds'] = $enableds;
        // Display Wiget
        return $this->show_template ($data);
    }

    /*
    *   Logout from gluu
    */
    public function logout(){
        if( isset( $this->request->get['state'] ) and isset( $this->request->get['session_state'] ) ) {
            session_destroy();
            unset($_SESSION['user_oxd_access_token']);
            unset($_SESSION['user_oxd_id_token']);
            unset($_SESSION['session_states']);
            unset($_SESSION['states']);
            header("Location: ".HTTPS_SERVER);
            exit;
        }else{
            require_once(DIR_SYSTEM . 'library/oxd-rp-242/Logout.php');
            $config_option = json_decode($this->gluu_db_query_select('oxd_config'),true);
            $oxd_id = $this->gluu_db_query_select('oxd_id');
            $logout = new Logout();
            $logout->setRequestOxdId($oxd_id);
            $logout->setRequestIdToken($_SESSION['user_oxd_id_token']);
            $logout->setRequestPostLogoutRedirectUri($config_option['logout_redirect_uri']);
            $logout->setRequestSessionState($_SESSION['session_states']);
            $logout->setRequestState($_SESSION['states']);
            $logout->request();
            unset($_SESSION['user_oxd_access_token']);
            unset($_SESSION['user_oxd_id_token']);
            unset($_SESSION['session_states']);
            unset($_SESSION['states']);
            header("Location: ".$logout->getResponseObject()->data->uri);
            exit;
        }
    }

    /*
     * Select data from db:gluu_table.
    */
    public function gluu_db_query_select($gluu_action){
        $query = $this->db->query("SELECT `gluu_value` FROM `" . DB_PREFIX ."gluu_table` WHERE `gluu_action` LIKE '".$gluu_action."'");
        if($query->num_rows)
            return $query->row['gluu_value'];
        else return '';


    }

    /*
     * Showing module widget
    */
    private function show_template ($data)
    {
        $temp = $this->get_template ('module/gluu_sso242');
        return $this->load->view ($temp , $data);
    }

    /*
     * Checking version OpenCart template
    */
    private function get_template ($template)
    {
        if (defined ('VERSION') && version_compare (VERSION, '2.2.0', '>='))
        {
            $template_file = '/template/'. $template .'.tpl';
            $template_folder = $this->config->get ('config_template');
            $template_folder = (file_exists (DIR_TEMPLATE . $template_folder . $template_file) ? $template_folder : '');
            $template_v = $template;
        }
        else
        {
            $template_file = '/template/'. $template .'.tpl';
            $template_folder = $this->config->get ('config_template');
            $template_folder = (file_exists (DIR_TEMPLATE . $template_folder . $template_file) ? $template_folder : 'default');
            $template_v = $template_file;
        }
        return ($template_folder . $template_v);
    }

    /*
     * Creating customer
    */
    protected function add_customer($data)
    {
        $this->load->model('account/customer');
        $this->load->model('account/customer_group');

        $customer_data = array(
            'customer_group_id' => $this->config->get('config_customer_group_id'),
            'firstname' => $data ['user_first_name'],
            'lastname' => $data ['user_last_name'],
            'email' => $data ['user_email'],
            'telephone' => $data ['user_phone_number'],
            'fax' => '',
            'password' => $this->generate_hash (8),
            'company' => '',
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'postcode' => '',
            'country_id' => 0,
            'zone_id' => 0
        );

        $customer_id = $this->model_account_customer->addCustomer($customer_data);

        if (is_numeric ($customer_id))
        {
            return $customer_id;
        }

        // Error
        return false;
    }


    /*
     * Logining customer
    */
    protected function login($customer_id)
    {
        $result = $this->db->query ("SELECT email FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . intval ($customer_id) . "'")->row;
        if (is_array ($result) && ! empty ($result['email']))
        {
            if ($this->customer->login($result['email'], '', true))
            {
                unset($this->session->data['guest']);

                $this->load->model('account/address');

                if ($this->config->get('config_tax_customer') == 'payment')
                {
                    $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                if ($this->config->get('config_tax_customer') == 'shipping')
                {
                    $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                );

                $this->model_account_activity->addActivity('login', $activity_data);

                return true;
            }
        }
        return false;
    }

    /*
     * Checking customer by email
    */
    protected function get_by_email ($email)
    {
        $sql = "SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE email  = '" . $this->db->escape ($email) . "'";
        $result = $this->db->query ($sql)->row;

        if (is_array ($result) && !empty ($result ['customer_id']))
        {
            return $result ['customer_id'];
        }

        return false;
    }

    /*
     * Generating random hash by lenght
    */
    protected function generate_hash ($length)
    {
        $hash = '';

        for($i = 0; $i < $length; $i ++)
        {
            do
            {
                $char = chr (mt_rand (48, 122));
            }
            while ( !preg_match ('/[a-zA-Z0-9]/', $char) );

            $hash .= $char;
        }

        return $hash;
    }



}
?>