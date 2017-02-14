<?php

class ControllerModuleGluuSSO extends Controller
{
    protected $error;

    public      function index                  ()
    {
        $this->load->model('module/gluu_sso');
        if(!$this->customer->isLogged () and $this->gluu_is_port_working() and !empty($this->request->get['route']) and $this->request->get['route'] == 'account/login'){
            $this->load->language ('module/gluu_sso');
            if(!empty($_SESSION['openid_error_message'])){
                $data['openid_error_message'] = $_SESSION['openid_error_message'];
                $_SESSION['openid_error_message'] = '';
            }
            else{
                $data['openid_error_message'] = '';
            }
            $data['script_logged'] = '';
            $data['user_is_logged'] = $this->customer->isLogged ();
            $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
            $data['heading_title']           = $this->language->get('heading_title');
            $data['get_scopes']              = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_scopes'),true);
            $data['gluu_config']             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
            $data['gluu_acr']                = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_acr'),true);
            $data['gluu_auth_type']          = $this->model_module_gluu_sso->gluu_db_query_select('gluu_auth_type');
            $data['gluu_send_user_check']    = $this->model_module_gluu_sso->gluu_db_query_select('gluu_send_user_check');
            $data['gluu_new_roles']          = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_new_role'));
            $data['gluu_users_can_register'] = $this->model_module_gluu_sso->gluu_db_query_select('gluu_users_can_register');
            if($this->gluu_is_oxd_registered()){
                $data['gluu_is_oxd_registered']  = $this->gluu_is_oxd_registered();
            }
            else{
                $data['gluu_is_oxd_registered']  = false;
            }
            //$data['text_edit'] = $this->language->get('text_edit');
            $data['base_url'] = HTTPS_SERVER;
            if(!empty($gluu_other_config['gluu_oxd_id'])){
                $data['gluu_oxd_id'] = $gluu_other_config['gluu_oxd_id'];
            }
            else{
                $data['gluu_oxd_id'] = false;
            }
            if(!empty($gluu_other_config['gluu_custom_logout'])){
                $data['gluu_custom_logout'] = $gluu_other_config['gluu_custom_logout'];
            }
            else{
                $data['gluu_custom_logout'] = '';
            }
            if(!empty($gluu_other_config['gluu_user_role'])){
                $data['gluu_user_role'] = $gluu_other_config['gluu_user_role'];
            }
            else{
                $data['gluu_user_role'] = 0;
            }
            if(!empty($gluu_other_config['gluu_provider'])){
                $data['gluu_provider'] = $gluu_other_config['gluu_provider'];
            }else{
                $data['gluu_provider'] = '';
            }
            $data['login_url'] = $this->login_url();
            return $this->show_template ($data);
        }
        else if(!empty($this->request->get['state']) and $this->gluu_is_port_working() and $this->request->get['route'] == 'account/logout'){
            $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
            if(!empty($gluu_other_config['gluu_custom_logout'])){
                $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
	            if($gluu_custom_logout == HTTPS_CATALOG){
		            $this->response->redirect($gluu_custom_logout);
		          }else{
		            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
		            return;
	            }
            }else{
	            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
	            return;
            }
        } else if($this->gluu_is_port_working() and $this->request->get['route'] == 'account/logout'){
            $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
            if(!empty($gluu_other_config['gluu_custom_logout'])){
                $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
            }else{
                $gluu_custom_logout = HTTPS_CATALOG;
            }
            $this->response->redirect($gluu_custom_logout);
            return;
        }


    }
    public      function logout                 (){
        $this->load->model('module/gluu_sso');
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
        $gluu_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);

        if(!empty($gluu_other_config['gluu_oxd_id'])){
            $gluu_oxd_id = $gluu_other_config['gluu_oxd_id'];
        }else{
            $gluu_oxd_id = '';
        }
        if(!empty($gluu_other_config['gluu_custom_logout'])){
            $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
        }else{
            $gluu_custom_logout = HTTPS_CATALOG;
        }
        if(!empty($gluu_other_config['gluu_user_role'])){
            $gluu_user_role = $gluu_other_config['gluu_user_role'];
        }else{
            $gluu_user_role = 0;
        }
        if(!empty($gluu_other_config['gluu_provider'])){
            $gluu_provider = $gluu_other_config['gluu_provider'];
        }else{
            $gluu_provider = '';
        }
        if(isset($_SESSION['session_in_op'])){
            if(time()<(int)$_SESSION['session_in_op']) {
                require_once(DIR_SYSTEM . 'library/oxd-rp/Logout.php');
                $arrContextOptions=array(
                  "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                  ),
                );
                $json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
                $obj = json_decode($json);

                if (!empty($obj->end_session_endpoint ) or $gluu_provider == 'https://accounts.google.com') {
                    if (!empty($_SESSION['user_oxd_id_token'])) {
                        if ($gluu_oxd_id && $_SESSION['user_oxd_id_token'] && $_SESSION['session_in_op']) {
                            $logout = new Logout();
                            $logout->setRequestOxdId($gluu_oxd_id);
                            $logout->setRequestIdToken($_SESSION['user_oxd_id_token']);
                            $logout->setRequestPostLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
                            $logout->setRequestSessionState($_SESSION['session_state']);
                            $logout->setRequestState($_SESSION['state']);
                            $logout->request();
                            unset($_SESSION['user_oxd_access_token']);
                            unset($_SESSION['user_oxd_id_token']);
                            unset($_SESSION['session_state']);
                            unset($_SESSION['state']);
                            unset($_SESSION['session_in_op']);
                            header("Location: " . $logout->getResponseObject()->data->uri);
                            exit;
                        }
                    }
                } else {
                    session_destroy();
                    unset($_SESSION['user_oxd_access_token']);
                    unset($_SESSION['user_oxd_id_token']);
                    unset($_SESSION['session_state']);
                    unset($_SESSION['state']);
                    unset($_SESSION['session_in_op']);
                }
            }
        }
        @session_destroy();
    }
    public      function login_by_sso           (){
        $this->load->model('module/gluu_sso');
        require_once(DIR_SYSTEM . 'library/oxd-rp/Get_tokens_by_code.php');
        require_once(DIR_SYSTEM . 'library/oxd-rp/Get_user_info.php');

        if( isset( $_REQUEST['session_state'] ) ) {
            if (isset($_REQUEST['error']) and strpos($_REQUEST['error'], 'session_selection_required') !== false) {
                header("Location: " . $this->prompt_login_url('login'));
                exit;
            }
            $gluu_other_config       = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
            if(!empty($gluu_other_config['gluu_oxd_id'])){
                $gluu_oxd_id = $gluu_other_config['gluu_oxd_id'];
            }
            else{
                $gluu_oxd_id = '';
            }
            $gluu_new_roles          = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_new_role'));
            $gluu_users_can_register = $this->model_module_gluu_sso->gluu_db_query_select('gluu_users_can_register');
            $get_tokens_by_code = new Get_tokens_by_code();
            $get_tokens_by_code->setRequestOxdId($gluu_oxd_id);
            $get_tokens_by_code->setRequestCode($_REQUEST['code']);
            $get_tokens_by_code->setRequestState($_REQUEST['state']);
            $get_tokens_by_code->request();

            $get_tokens_by_code_array = array();
            if(!empty($get_tokens_by_code->getResponseObject()->data->id_token_claims))
            {
                $get_tokens_by_code_array = $get_tokens_by_code->getResponseObject()->data->id_token_claims;
            }
            else{
                $_SESSION['openid_error_message'] = 'Missing claims : Please talk to your organizational system administrator or try again.';
                echo "<script type='application/javascript'>
                      location.href='".$this->url->link('account/login', '', 'SSL')."';
                     </script>";
                exit;
            }

            $get_user_info = new Get_user_info();
            $get_user_info->setRequestOxdId($gluu_oxd_id);
            $get_user_info->setRequestAccessToken($get_tokens_by_code->getResponseAccessToken());
            $get_user_info->request();
            $get_user_info_array = $get_user_info->getResponseObject()->data->claims;
            $_SESSION['session_in_op'] = $get_tokens_by_code->getResponseIdTokenClaims()->exp[0];
            $_SESSION['user_oxd_id_token'] = $get_tokens_by_code->getResponseIdToken();
            $_SESSION['user_oxd_access_token'] = $get_tokens_by_code->getResponseAccessToken();
            $_SESSION['session_state'] = $_REQUEST['session_state'];
            $_SESSION['state'] = $_REQUEST['state'];
            $get_user_info_array = $get_user_info->getResponseObject()->data->claims;
            $reg_first_name = '';
            $reg_last_name = '';
            $reg_country = '';
            $reg_city = '';
            $reg_region = '';
            $reg_postal_code = '';
            $reg_fax = '';
            $reg_home_phone_number = '';
            $reg_phone_mobile_number = '';
            $reg_street_address = '';
            $reg_street_address_2 = '';
            $reg_user_permission = '';
            if (!empty($get_user_info_array->email[0])) {
                $reg_email = $get_user_info_array->email[0];
            } elseif (!empty($get_tokens_by_code_array->email[0])) {
                $reg_email = $get_tokens_by_code_array->email[0];
            }else{
                $_SESSION['openid_error_message'] = 'Missing claim : (email). Please talk to your organizational system administrator.';
                echo "<script type='application/javascript'>
                      location.href='".$this->url->link('account/login', '', 'SSL')."';
                     </script>";
                exit;
            }
            if (!empty($get_user_info_array->given_name[0])) {
                $reg_first_name = $get_user_info_array->given_name[0];
            } elseif (!empty($get_tokens_by_code_array->given_name[0])) {
                $reg_first_name = $get_tokens_by_code_array->given_name[0];
            }
            if (!empty($get_user_info_array->family_name[0])) {
                $reg_last_name = $get_user_info_array->family_name[0];
            } elseif (!empty($get_tokens_by_code_array->family_name[0])) {
                $reg_last_name = $get_tokens_by_code_array->family_name[0];
            }
            if (!empty($get_user_info_array->country[0])) {
                $reg_country = $get_user_info_array->country[0];
            } elseif (!empty($get_tokens_by_code_array->country[0])) {
                $reg_country = $get_tokens_by_code_array->country[0];
            }
            if (!empty($get_user_info_array->locality[0])) {
                $reg_city = $get_user_info_array->locality[0];
            } elseif (!empty($get_tokens_by_code_array->locality[0])) {
                $reg_city = $get_tokens_by_code_array->locality[0];
            }
            if (!empty($get_user_info_array->postal_code[0])) {
                $reg_postal_code = $get_user_info_array->postal_code[0];
            } elseif (!empty($get_tokens_by_code_array->postal_code[0])) {
                $reg_postal_code = $get_tokens_by_code_array->postal_code[0];
            }
            if (!empty($get_user_info_array->phone_number[0])) {
                $reg_home_phone_number = $get_user_info_array->phone_number[0];
            } elseif (!empty($get_tokens_by_code_array->phone_number[0])) {
                $reg_home_phone_number = $get_tokens_by_code_array->phone_number[0];
            }
            if (!empty($get_user_info_array->phone_mobile_number[0])) {
                $reg_phone_mobile_number = $get_user_info_array->phone_mobile_number[0];
            } elseif (!empty($get_tokens_by_code_array->phone_mobile_number[0])) {
                $reg_phone_mobile_number = $get_tokens_by_code_array->phone_mobile_number[0];
            }
            if (!empty($get_user_info_array->street_address[0])) {
                $reg_street_address = $get_user_info_array->street_address[0];
            } elseif (!empty($get_tokens_by_code_array->street_address[0])) {
                $reg_street_address = $get_tokens_by_code_array->street_address[0];
            }
            if (!empty($get_user_info_array->street_address[1])) {
                $reg_street_address_2 = $get_user_info_array->street_address[1];
            } elseif (!empty($get_tokens_by_code_array->street_address[1])) {
                $reg_street_address_2 = $get_tokens_by_code_array->street_address[1];
            }
            if (!empty($get_user_info_array->region[0])) {
                $reg_region = $get_user_info_array->region[0];
            } elseif (!empty($get_tokens_by_code_array->region[0])) {
                $reg_region = $get_tokens_by_code_array->region[0];
            }

            $username = '';
            if (!empty($get_user_info_array->user_name[0])) {
                $username = $get_user_info_array->user_name[0];
            } else {
                $email_split = explode("@", $reg_email);
                $username = $email_split[0];
            }
            if(!empty($get_user_info_array->permission[0])){
                $world = str_replace("[","",$get_user_info_array->permission[0]);
                $reg_user_permission = str_replace("]","",$world);
            }elseif(!empty($get_tokens_by_code_array->permission[0])){
                $world = str_replace("[","",$get_user_info_array->permission[0]);
                $reg_user_permission = str_replace("]","",$world);
            }
              $bool = false;
              if($gluu_users_can_register == 2 and !empty($gluu_new_roles)){
	              foreach ($gluu_new_roles as $gluu_new_role) {
		              if (strstr($reg_user_permission, $gluu_new_role)) {
			              $bool = true;
		              }
	              }
	              if(!$bool){
		              $_SESSION['openid_error_message'] = 'You are not authorized for an account on this application. If you think this is an error, please contact your OpenID Connect Provider (OP) admin.';
		              $this->response->redirect($this->gluu_sso_doing_logout($get_tokens_by_code->getResponseIdToken(), $_REQUEST['session_state'], $_REQUEST['state']));
		              return;
                }
              }
            $phone = $reg_home_phone_number . ', '. $reg_phone_mobile_number;
            if($this->admin_login($reg_email)){
                $token = token(32);
                $this->session->data['token'] = $token;
	            $customer_data = array(
		            'customer_first_name' => $reg_first_name,
		            'customer_last_name' => $reg_last_name,
		            'customer_email' => $reg_email,
		            'customer_telephone' => $phone,
		            'customer_fax' => $reg_fax,
		            'customer_company' => $reg_first_name,
		            'customer_address_1' => $reg_street_address,
		            'customer_address_2' => $reg_street_address_2,
		            'customer_city' => $reg_city,
		            'customer_postcode' => $reg_postal_code,
		            'customer_country' => $reg_country,
		            'customer_zone' => $reg_region
	            );
	            $customer_id = $this->get_by_email($reg_email);
	            if($customer_id){
		            if ($this->login ($customer_id))
		            {
			            $this->model_module_gluu_sso->editCustomer ($customer_id,$customer_data);
/*			            echo '<script type="text/javascript">   window.open("'.$this->url->link('account/account', '', 'SSL').'", "_blank"); </script>';*/
			            header('Location: /admin/index.php?route=common/dashboard&token='.$token);
			            exit;
		            }
	            }
	            else {
		            
		            if($gluu_users_can_register == 3){
			            $_SESSION['openid_error_message'] = 'You are not authorized for an account on this application. If you think this is an error, please contact your OpenID Connect Provider (OP) admin.';
			            $this->response->redirect($this->gluu_sso_doing_logout($get_tokens_by_code->getResponseIdToken(), $_REQUEST['session_state'], $_REQUEST['state']));
			            return;
		            }
		            else{
			            if (($customer_id = $this->add_customer ($customer_data)) !== false){
				            if ($this->login ($customer_id))
				            {
					            header('Location: /admin/index.php?route=common/dashboard&token='.$token);
					            exit;
				            }
			            }
		            }

	            }

            }
            else{
                $customer_data = array(
                  'customer_first_name' => $reg_first_name,
                  'customer_last_name' => $reg_last_name,
                  'customer_email' => $reg_email,
                  'customer_telephone' => $phone,
                  'customer_fax' => $reg_fax,
                  'customer_company' => $reg_first_name,
                  'customer_address_1' => $reg_street_address,
                  'customer_address_2' => $reg_street_address_2,
                  'customer_city' => $reg_city,
                  'customer_postcode' => $reg_postal_code,
                  'customer_country' => $reg_country,
                  'customer_zone' => $reg_region
                );
                $customer_id = $this->get_by_email($reg_email);
                if($customer_id){
                    if ($this->login ($customer_id))
                    {
	                      $this->model_module_gluu_sso->editCustomer ($customer_id,$customer_data);
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                        return;
                    }
                }
                else {
                    if($gluu_users_can_register == 3){
                        $_SESSION['openid_error_message'] = 'You are not authorized for an account on this application. If you think this is an error, please contact your OpenID Connect Provider (OP) admin.';
	                    $this->response->redirect($this->gluu_sso_doing_logout($get_tokens_by_code->getResponseIdToken(), $_REQUEST['session_state'], $_REQUEST['state']));
	                    return;
                    }
                    if (($customer_id = $this->add_customer ($customer_data)) !== false){
                        if ($this->login ($customer_id))
                        {
                            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                            return;
                        }
                    }
                }
            }

        }

    }

    private     function show_template          ($data)
    {
        $temp = $this->get_template ('module/gluu_sso');
        return $this->load->view ($temp , $data);
    }
    private     function get_template           ($template)
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
    public      function add_customer           ($data)
    {
        $this->load->model('module/gluu_sso');
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);

        if(!empty($gluu_other_config['gluu_user_role'])){
            $gluu_user_role = $gluu_other_config['gluu_user_role'];
        }else{
            $gluu_user_role = $this->config->get('config_customer_group_id');
        }
        $this->load->model('account/customer');
        $this->load->model('account/customer_group');
        $country_id = $this->model_module_gluu_sso->getCountry_by_iso($data ['customer_country'])['country_id'] ? $this->model_module_gluu_sso->getCountry_by_iso($data ['customer_country'])['country_id'] : 0;
        $zone_id = $this->model_module_gluu_sso->getZone($data ['customer_zone'],$country_id)['zone_id'] ? $this->model_module_gluu_sso->getZone($data ['customer_zone'],$country_id)['zone_id'] : 0;

        $customer_data = array(
            'customer_group_id' => $gluu_user_role,
            'firstname' => $data ['customer_first_name'],
            'lastname' => $data ['customer_last_name'],
            'email' => $data ['customer_email'],
            'telephone' => $data ['customer_telephone'],
            'fax' => $data ['customer_fax'],
            'password' => $this->generate_hash (8),
            'company' => '',
            'address_1' => $data ['customer_address_1'],
            'address_2' => $data ['customer_address_2'],
            'city' => $data ['customer_city'],
            'postcode' => $data ['customer_postcode'],
            'country_id' => $country_id,
            'zone_id' => $zone_id
        );

        $customer_id = $this->model_account_customer->addCustomer($customer_data);

        if (is_numeric ($customer_id))
        {
            return $customer_id;
        }

        // Error
        return false;
    }
    public      function login                  ($customer_id)
    {
        $this->load->model('module/gluu_sso');
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
    public      function get_by_email           ($email)
    {
        $sql = "SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE email  = '" . $this->db->escape ($email) . "'";
        $result = $this->db->query ($sql)->row;

        if (is_array ($result) && !empty ($result ['customer_id']))
        {
            return $result ['customer_id'];
        }

        return false;
    }
    public      function generate_hash          ($length)
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
    public      function gluu_is_oxd_registered (){
        $this->load->model('module/gluu_sso');
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
        if(!empty($gluu_other_config['gluu_oxd_id'])){
            return $gluu_other_config['gluu_oxd_id'];
        }else{
            return 0;
        }
    }
    public      function login_url              (){
        $this->load->model('module/gluu_sso');
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
        $get_scopes              = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_scopes'),true);
        $gluu_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
        $gluu_acr                = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_acr'),true);
        $gluu_auth_type          = $this->model_module_gluu_sso->gluu_db_query_select('gluu_auth_type');
        $gluu_send_user_check    = $this->model_module_gluu_sso->gluu_db_query_select('gluu_send_user_check');
        $gluu_new_roles          = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_new_role'));
        $gluu_users_can_register = $this->model_module_gluu_sso->gluu_db_query_select('gluu_users_can_register');

        if(!empty($gluu_other_config['gluu_oxd_id'])){
            $gluu_oxd_id = $gluu_other_config['gluu_oxd_id'];
        }else{
            $gluu_oxd_id = false;
        }
        if(!empty($gluu_other_config['gluu_custom_logout'])){
            $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
        }else{
            $gluu_custom_logout = HTTPS_CATALOG;
        }
        if(!empty($gluu_other_config['gluu_user_role'])){
            $gluu_user_role = $gluu_other_config['gluu_user_role'];
        }else{
            $gluu_user_role = $this->config->get('config_customer_group_id');
        }
        if(!empty($gluu_other_config['gluu_provider'])){
            $gluu_provider = $gluu_other_config['gluu_provider'];
        }else{
            $gluu_provider = '';
        }
        require_once(DIR_SYSTEM . 'library/oxd-rp/Get_authorization_url.php');

        $get_authorization_url = new Get_authorization_url();
        $get_authorization_url->setRequestOxdId($gluu_oxd_id);


        $get_authorization_url->setRequestScope($gluu_config['config_scopes']);
        if($gluu_auth_type != "default"){
            $get_authorization_url->setRequestAcrValues([$gluu_auth_type]);
        }else{
            $get_authorization_url->setRequestAcrValues(null);
        }
        $get_authorization_url->request();

        return $get_authorization_url->getResponseAuthorizationUrl();
    }
    public      function prompt_login_url       ($prompt){
        $this->load->model('module/gluu_sso');
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
        $get_scopes              = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_scopes'),true);
        $gluu_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
        $gluu_acr                = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_acr'),true);
        $gluu_auth_type          = $this->model_module_gluu_sso->gluu_db_query_select('gluu_auth_type');
        $gluu_send_user_check    = $this->model_module_gluu_sso->gluu_db_query_select('gluu_send_user_check');
        $gluu_new_roles          = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_new_role'));
        $gluu_users_can_register = $this->model_module_gluu_sso->gluu_db_query_select('gluu_users_can_register');

        if(!empty($gluu_other_config['gluu_oxd_id'])){
            $gluu_oxd_id = $gluu_other_config['gluu_oxd_id'];
        }else{
            $gluu_oxd_id = false;
        }
        if(!empty($gluu_other_config['gluu_custom_logout'])){
            $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
        }else{
            $gluu_custom_logout = '';
        }
        if(!empty($gluu_other_config['gluu_user_role'])){
            $gluu_user_role = $gluu_other_config['gluu_user_role'];
        }else{
            $gluu_user_role = 0;
        }
        if(!empty($gluu_other_config['gluu_provider'])){
            $gluu_provider = $gluu_other_config['gluu_provider'];
        }else{
            $gluu_provider = '';
        }
        require_once(DIR_SYSTEM . 'library/oxd-rp/Get_authorization_url.php');

        $get_authorization_url = new Get_authorization_url();
        $get_authorization_url->setRequestOxdId($gluu_oxd_id);


        $get_authorization_url->setRequestScope($gluu_config['config_scopes']);
        $get_authorization_url->setRequestPrompt($prompt);
        if($gluu_auth_type != "default"){
            $get_authorization_url->setRequestAcrValues([$gluu_auth_type]);
        }else{
            $get_authorization_url->setRequestAcrValues(null);
        }
        $get_authorization_url->request();

        return $get_authorization_url->getResponseAuthorizationUrl();
    }
    public      function gluu_is_port_working   (){
        $this->load->model('module/gluu_sso');
        $config_option = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
        $connection = @fsockopen('127.0.0.1', $config_option['gluu_oxd_port']);
        if (is_resource($connection))
        {
            fclose($connection);
            return true;
        }
        else
        {
            return false;
        }
    }
    public      function gluu_sso_doing_logout  ($user_oxd_id_token, $session_states, $state)
    {
        $this->load->model('module/gluu_sso');
        @session_start();
        $gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
        $gluu_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);

        if(!empty($gluu_other_config['gluu_oxd_id'])){
            $gluu_oxd_id = $gluu_other_config['gluu_oxd_id'];
        }else{
            $gluu_oxd_id = '';
        }
        if(!empty($gluu_other_config['gluu_custom_logout'])){
            $gluu_custom_logout = $gluu_other_config['gluu_custom_logout'];
        }else{
            $gluu_custom_logout = '';
        }
        if(!empty($gluu_other_config['gluu_user_role'])){
            $gluu_user_role = $gluu_other_config['gluu_user_role'];
        }else{
            $gluu_user_role = 0;
        }
        if(!empty($gluu_other_config['gluu_provider'])){
            $gluu_provider = $gluu_other_config['gluu_provider'];
        }else{
            $gluu_provider = '';
        }
        if(isset($_SESSION['session_in_op'])){
            if(time()<(int)$_SESSION['session_in_op']) {
                require_once(DIR_SYSTEM . 'library/oxd-rp/Logout.php');
                $arrContextOptions=array(
                  "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                  ),
                );
                $json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
                $obj = json_decode($json);

                if (!empty($obj->end_session_endpoint ) or $gluu_provider == 'https://accounts.google.com') {
                    if (!empty($_SESSION['user_oxd_id_token'])) {
                        if ($gluu_oxd_id && $_SESSION['user_oxd_id_token'] && $_SESSION['session_in_op']) {
                            $logout = new Logout();
                            $logout->setRequestOxdId($gluu_oxd_id);
                            $logout->setRequestIdToken($_SESSION['user_oxd_id_token']);
                            $logout->setRequestPostLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
                            $logout->setRequestSessionState($_SESSION['session_state']);
                            $logout->setRequestState($_SESSION['state']);
                            $logout->request();
                            unset($_SESSION['user_oxd_access_token']);
                            unset($_SESSION['user_oxd_id_token']);
                            unset($_SESSION['session_state']);
                            unset($_SESSION['state']);
                            unset($_SESSION['session_in_op']);
                            header("Location: " . $logout->getResponseObject()->data->uri);
                            exit;
                        }
                    }
                } else {
                    session_destroy();
                    unset($_SESSION['user_oxd_access_token']);
                    unset($_SESSION['user_oxd_id_token']);
                    unset($_SESSION['session_state']);
                    unset($_SESSION['state']);
                    unset($_SESSION['session_in_op']);
                }
            }
        }

        return $this->url->link('account/login', '', 'SSL');
    }
    public function admin_login($username) {
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE email = '" . $username . "'  AND status = '1'");

        if ($user_query->num_rows) {
            $this->session->data['user_id'] = $user_query->row['user_id'];


            return true;
        } else {
            return false;
        }
    }

}
?>

