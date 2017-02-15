<?php
	class ControllerModuleGluuSSO extends Controller
	{
		public function install()
		{
			$this->load->model('module/gluu_sso');
			$this->model_module_gluu_sso->adding_gluu_data();
			$this->load->model('extension/event');
			$this->model_extension_event->addEvent('gluu_sso', 'post.customer.logout', 'module/gluu_sso/logout');
			
			$query = $this->db->query("SELECT `code` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'gluu_sso_status' ;");
			if (!$query->num_rows) {
				
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'gluu_sso', 'gluu_sso_status', '1', '0');");
			}
			$result = $this->db->query("SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE name IN ('Account', 'Checkout')");
			if ($result->num_rows > 0) {
				foreach ($result->rows as $row) {
					// Prevent Duplicates
					$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE layout_id = '" . intval($row['layout_id']) . "' AND code = 'gluu_sso' AND position='content_top'");
					
					// Add Position
					$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_module` SET layout_id = '" . intval($row['layout_id']) . "', code = 'gluu_sso', position='content_top', sort_order='1'");
				}
			}
			// Callback Handler
			if (defined('VERSION') && version_compare(VERSION, '2.2.0', '>=')) {
				$this->load->model('extension/event');
				$this->model_extension_event->addEvent('gluu_sso', 'catalog/controller/module/gluu_sso/before', 'module/gluu_sso');
			}
		}
		
		public function uninstall()
		{
		}
	$this->load->model('module/gluu_sso');
	
	$this->model_module_gluu_sso->uninstall();
	}
	public function index()
{
	$this->load->model('module/gluu_sso');
	$this->model_module_gluu_sso->adding_gluu_data();
	$this->load->language('module/gluu_sso');
	$this->document->setTitle($this->language->get('heading_title'));
	$this->document->addStyle('view/stylesheet/gluu_sso/gluu_sso.css');
	$this->load->model('setting/setting');
	if (!empty($_SESSION['message_error'])) {
	}
	$data['message_error'] = $_SESSION['message_error'];
	$_SESSION['message_error'] = '';
}
	else{
	$data['message_error'] = '';
}
	if
        public function edit() {
	$this->load->model('module/gluu_sso');
	if(!empty($_SESSION['message_error'])){
		$data['message_error'] = $_SESSION['message_error'];
		$_SESSION['message_error'] = '';
	}else{
		$data['message_error'] = '';
	}
	if(!empty($_SESSION['message_success'])){
		$data['message_success'] = $_SESSION['message_success'];
		$_SESSION['message_success'] = '';
	}else{
		$data['message_success'] = '';
	}
	if(!empty($_SESSION['openid_error'])){
		$data['openid_error'] = $_SESSION['openid_error'];
	}else{
		$data['openid_error'] = '';
	}
	if(!empty($_SESSION['openid_error_edit'])){
		$data['openid_error_edit'] = $_SESSION['openid_error_edit'];
	}else{
		$data['openid_error_edit'] = '';
	}
	$this->model_module_gluu_sso->adding_gluu_data();
	$this->load->language('module/gluu_sso');
	$this->document->setTitle($this->language->get('heading_title'));
	$this->document->addStyle('view/stylesheet/gluu_sso/gluu_sso.css');
	$this->load->model('setting/setting');
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
	}else{
		$data['gluu_is_oxd_registered']  = false;
	}
	$data['text_edit'] = $this->language->get('text_edit');
	$data['base_url'] = HTTPS_CATALOG;
	$customer_groups = $this->model_module_gluu_sso->getCustomerGroup();
	$user_types = array();
	foreach ($customer_groups as $customer_group){
		$user_types [] = array('name'=>$customer_group['name'], 'status'=>$customer_group['customer_group_id']);
	}
	$data['user_types'] = $user_types;
	if(!empty($gluu_other_config['gluu_oxd_id'])){
		$data['gluu_oxd_id'] = $gluu_other_config['gluu_oxd_id'];
	}else{
		$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
		return;
	}
	if(!empty($gluu_other_config['gluu_custom_logout'])){
		$data['gluu_custom_logout'] = $gluu_other_config['gluu_custom_logout'];
	}else{
		$data['gluu_custom_logout'] = HTTPS_CATALOG;
	}
	if(!empty($gluu_other_config['gluu_user_role'])){
		$data['gluu_user_role'] = $gluu_other_config['gluu_user_role'];
	}else{
		$data['gluu_user_role'] = $this->config->get('config_customer_group_id');;
	}
	if(!empty($gluu_other_config['gluu_provider'])){
		$data['gluu_provider'] = $gluu_other_config['gluu_provider'];
	}else{
		$data['gluu_provider'] = '';
	}
	
	$data['action'] = $this->url->link('module/gluu_sso/gluupostdata', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_edit'] = $this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_openidconfig'] = $this->url->link('module/gluu_sso/openidconfig', 'token=' . $this->session->data['token'], 'SSL');
	$data['cancel'] = $this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_general'] = $this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL');
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	
	$this->response->setOutput($this->load->view('module/gluu_sso/gluu_sso_edit.tpl', $data));
}
        public function openidconfig() {
	$this->load->model('module/gluu_sso');
	
	if( isset( $_POST['form_key_scope_delete'] ) and strpos( $_POST['form_key_scope_delete'], 'form_key_scope_delete' ) !== false ) {
		$get_scopes =   json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_scopes'),true);
		$up_cust_sc =  array();
		foreach($get_scopes as $custom_scop){
			if($custom_scop !=$_POST['delete_scope']){
				array_push($up_cust_sc,$custom_scop);
			}
		}
		$get_scopes = json_encode($up_cust_sc);
		$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes);
		
		
		$gluu_config =   json_decode($this->model_module_gluu_sso->gluu_db_query_select( "gluu_config"),true);
		$up_cust_scope =  array();
		foreach($gluu_config['config_scopes'] as $custom_scop){
			if($custom_scop !=$_POST['delete_scope']){
				array_push($up_cust_scope,$custom_scop);
			}
		}
		$gluu_config['config_scopes'] = $up_cust_scope;
		$gluu_config = json_encode($gluu_config);
		$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
		return true;
	}
	else if (isset($_POST['form_key_scope']) and strpos( $_POST['form_key_scope'], 'oxd_openid_config_new_scope' ) !== false) {
		if ($this->gluu_is_oxd_registered()) {
			if (!empty($_POST['new_value_scope']) && isset($_POST['new_value_scope'])) {
				
				$get_scopes =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_scopes"),true);
				if($_POST['new_value_scope'] && !in_array($_POST['new_value_scope'],$get_scopes)){
					array_push($get_scopes, $_POST['new_value_scope']);
				}
				$get_scopes = json_encode($get_scopes);
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes);
				return true;
			}
		}
	}
	else if( isset( $_REQUEST['form_key'] ) and strpos( $_REQUEST['form_key'], 'openid_config_page' ) !== false ) {
		$params = $_REQUEST;
		if(!empty($params['scope']) && isset($params['scope'])){
			$gluu_config =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_config"),true);
			$gluu_config['config_scopes'] = $params['scope'];
			$gluu_config = json_encode($gluu_config);
			$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
			return true;
		}
	}
	if(!empty($_SESSION['message_error'])){
		$data['message_error'] = $_SESSION['message_error'];
		$_SESSION['message_error'] = '';
	}
	else{
		$data['message_error'] = '';
	}
	if(!empty($_SESSION['message_success'])){
		$data['message_success'] = $_SESSION['message_success'];
		$_SESSION['message_success'] = '';
	}
	else{
		$data['message_success'] = '';
	}
	if(!empty($_SESSION['openid_error'])){
		$data['openid_error'] = $_SESSION['openid_error'];
	}
	else{
		$data['openid_error'] = '';
	}
	if(!empty($_SESSION['openid_error_edit'])){
		$data['openid_error_edit'] = $_SESSION['openid_error_edit'];
	}
	else{
		$data['openid_error_edit'] = '';
	}
	$this->model_module_gluu_sso->adding_gluu_data();
	$this->load->language('module/gluu_sso');
	$this->document->setTitle($this->language->get('heading_title'));
	$this->document->addStyle('view/stylesheet/gluu_sso/gluu_sso.css');
	$this->load->model('setting/setting');
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
	$data['text_edit'] = $this->language->get('text_edit');
	$data['base_url'] = HTTPS_CATALOG;
	$customer_groups = $this->model_module_gluu_sso->getCustomerGroup();
	$user_types = array();
	foreach ($customer_groups as $customer_group){
		$user_types [] = array('name'=>$customer_group['name'], 'status'=>$customer_group['customer_group_id']);
	}
	$data['user_types'] = $user_types;
	if(!empty($gluu_other_config['gluu_oxd_id'])){
		$data['gluu_oxd_id'] = $gluu_other_config['gluu_oxd_id'];
	}else{
		$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
		return;
	}
	if(!empty($gluu_other_config['gluu_custom_logout'])){
		$data['gluu_custom_logout'] = $gluu_other_config['gluu_custom_logout'];
	}else{
		$data['gluu_custom_logout'] = HTTPS_CATALOG;
	}
	if(!empty($gluu_other_config['gluu_user_role'])){
		$data['gluu_user_role'] = $gluu_other_config['gluu_user_role'];
	}else{
		$data['gluu_user_role'] = $this->config->get('config_customer_group_id');
	}
	if(!empty($gluu_other_config['gluu_provider'])){
		$data['gluu_provider'] = $gluu_other_config['gluu_provider'];
	}else{
		$data['gluu_provider'] = '';
	}
	$data['action'] = $this->url->link('module/gluu_sso/gluupostdata', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_edit'] = $this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_openidconfig'] = $this->url->link('module/gluu_sso/openidconfig', 'token=' . $this->session->data['token'], 'SSL');
	$data['action_general'] = $this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL');
	
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	
	$this->response->setOutput($this->load->view('module/gluu_sso/gluu_sso_openidconfig.tpl', $data));
}
        public function gluupostdata() {
	$this->load->model('module/gluu_sso');
	require_once(DIR_SYSTEM . 'library/oxd-rp/Register_site.php');
	require_once(DIR_SYSTEM . 'library/oxd-rp/Update_site_registration.php');
	$base_url = HTTPS_CATALOG;
	if( isset( $_REQUEST['submit'] ) and strpos( $_REQUEST['submit'], 'delete' )  !== false and !empty($_REQUEST['submit'])) {
		$this->model_module_gluu_sso->drop_table();
		unset($_SESSION['openid_error']);
		unset($_SESSION['openid_error_edit']);
		$_SESSION['openid_error'] = '';
		$_SESSION['openid_error_edit'] = '';
		$_SESSION['message_success'] = 'Configurations deleted Successfully.';
		$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
		return;
	}
	if( isset( $_REQUEST['form_key'] ) and strpos( $_REQUEST['form_key'], 'general_register_page' ) !== false ) {
		if(!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] != "on") {
			$_SESSION['message_error'] = 'OpenID Connect requires https. This plugin will not work if your website uses http only.';
			$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		if($_POST['gluu_user_role']){
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_user_role'] = $_POST['gluu_user_role'];
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}else{
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_user_role'] = 0;
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}
		if($_POST['gluu_users_can_register']==1){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', $_POST['gluu_users_can_register']);
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array()));
			}
		}
		if($_POST['gluu_users_can_register']==2){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', 2);
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array()));
			}
		}
		if($_POST['gluu_users_can_register']==3){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', 3);
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array()));
			}
		}
		if (empty($_POST['gluu_oxd_port'])) {
			$_SESSION['message_error'] = 'All the fields are required. Please enter valid entries.';
			$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		else if (intval($_POST['gluu_oxd_port']) > 65535 && intval($_POST['gluu_oxd_port']) < 0) {
			$_SESSION['message_error'] = 'Enter your oxd host port (Min. number 1, Max. number 65535)';
			$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		else if  (!empty($_POST['gluu_provider'])) {
			if (filter_var($_POST['gluu_provider'], FILTER_VALIDATE_URL) === false) {
				$_SESSION['message_error'] = 'Please enter valid OpenID Provider URI.';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
		}
		if(!empty($_POST['gluu_custom_logout'])){
			if (filter_var($_POST['gluu_custom_logout'], FILTER_VALIDATE_URL) === false) {
				$_SESSION['message_error'] = 'Please enter valid Custom URI.';
			}else{
				$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
				$gluu_other_config['gluu_custom_logout'] = $_POST['gluu_custom_logout'];
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
			}
		}
		else{
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_custom_logout'),true);
			$gluu_other_config['gluu_custom_logout'] = '';
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}
		if (isset($_POST['gluu_provider']) and !empty($_POST['gluu_provider'])) {
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_provider'] = $_POST['gluu_provider'];
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);
			$gluu_provider = $gluu_other_config['gluu_provider'];
			$json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
			$obj = json_decode($json);
			if(!empty($obj->userinfo_endpoint)){
				
				if(empty($obj->registration_endpoint)){
					$_SESSION['message_success'] = "Please enter your client_id and client_secret.";
					$gluu_config = json_encode(array(
						"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
						"admin_email" => $this->config->get('config_email'),
						"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
						"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
						"config_scopes" => ["openid","profile","email"],
						"gluu_client_id" => "",
						"gluu_client_secret" => "",
						"config_acr" => []
					));
					if($_POST['gluu_users_can_register']==2){
						$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
						array_push($config['config_scopes'],'permission');
						$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
					}
					$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
					if(isset($_POST['gluu_client_id']) and !empty($_POST['gluu_client_id']) and
						isset($_POST['gluu_client_secret']) and !empty($_POST['gluu_client_secret'])){
						$gluu_config = json_encode(array(
							"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
							"admin_email" => $this->config->get('config_email'),
							"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
							"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
							"config_scopes" => ["openid","profile","email"],
							"gluu_client_id" => $_POST['gluu_client_id'],
							"gluu_client_secret" => $_POST['gluu_client_secret'],
							"config_acr" => []
						));
						$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
						if($_POST['gluu_users_can_register']==2){
							$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
							array_push($config['config_scopes'],'permission');
							$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
						}
						if(!$this->gluu_is_port_working()){
							$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						$register_site = new Register_site();
						$register_site->setRequestOpHost($gluu_provider);
						$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
						$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
						$register_site->setRequestContacts([$gluu_config['admin_email']]);
						$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
						$get_scopes = json_encode($obj->scopes_supported);
						if(!empty($obj->acr_values_supported)){
							$get_acr = json_encode($obj->acr_values_supported);
							$get_acr = $this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr);
							$register_site->setRequestAcrValues($gluu_config['config_acr']);
						}
						else{
							$register_site->setRequestAcrValues($gluu_config['config_acr']);
						}
						if(!empty($obj->scopes_supported)){
							$get_scopes = json_encode($obj->scopes_supported);
							$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes);
							$register_site->setRequestScope($obj->scopes_supported);
						}
						else{
							$register_site->setRequestScope($gluu_config['config_scopes']);
						}
						$register_site->setRequestClientId($gluu_config['gluu_client_id']);
						$register_site->setRequestClientSecret($gluu_config['gluu_client_secret']);
						$status = $register_site->request();
						if(!$status['status']){
							if ($status['message'] == 'invalid_op_host') {
								$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
							if (!$status['status']) {
								$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
							if ($status['message'] == 'internal_error') {
								$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
						}
						$gluu_oxd_id = $register_site->getResponseOxdId();
						if ($gluu_oxd_id) {
							$gluu_provider = $register_site->getResponseOpHost();
							$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
							$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
							$gluu_other_config['gluu_provider'] = $gluu_provider;
							$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
							$_SESSION['message_success'] = 'Your settings are saved successfully.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						} else {
							$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
					}
					else{
						$_SESSION['openid_error'] = 'Error505.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
				else{
					
					$gluu_config = json_encode(array(
						"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
						"admin_email" => $this->config->get('config_email'),
						"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
						"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
						"config_scopes" => ["openid","profile","email"],
						"gluu_client_id" => "",
						"gluu_client_secret" => "",
						"config_acr" => []
					));
					$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
					if($_POST['gluu_users_can_register']==2){
						$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
						array_push($config['config_scopes'],'permission');
						$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
					}
					if(!$this->gluu_is_port_working()){
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if(!$this->gluu_is_port_working()){
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if(!$this->gluu_is_port_working()){
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					$register_site = new Register_site();
					$register_site->setRequestOpHost($gluu_provider);
					$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
					$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
					$register_site->setRequestContacts([$gluu_config['admin_email']]);
					$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
					$get_scopes = json_encode($obj->scopes_supported);
					if(!empty($obj->acr_values_supported)){
						$get_acr = json_encode($obj->acr_values_supported);
						$get_acr = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr));
						$register_site->setRequestAcrValues($gluu_config['config_acr']);
					}
					else{
						$register_site->setRequestAcrValues($gluu_config['config_acr']);
					}
					if(!empty($obj->scopes_supported)){
						$get_scopes = json_encode($obj->scopes_supported);
						$get_scopes = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes));
						$register_site->setRequestScope($obj->scopes_supported);
					}
					else{
						$register_site->setRequestScope($gluu_config['config_scopes']);
					}
					$status = $register_site->request();
					if(!$status['status']){
						if ($status['message'] == 'invalid_op_host') {
							$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						if (!$status['status']) {
							$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						if ($status['message'] == 'internal_error') {
							$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
					}
					$gluu_oxd_id = $register_site->getResponseOxdId();
					if ($gluu_oxd_id) {
						$gluu_provider = $register_site->getResponseOpHost();
						$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
						$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
						$gluu_other_config['gluu_provider'] = $gluu_provider;
						$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
						$_SESSION['message_success'] = 'Your settings are saved successfully.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					else {
						$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
			}
			else{
				$_SESSION['message_error'] = 'Please enter correct URI of the OpenID Provider';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
			
		}
		else{
			$gluu_config = json_encode(array(
				"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
				"admin_email" => $this->config->get('config_email'),
				"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
				"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
				"config_scopes" => ["openid","profile","email"],
				"gluu_client_id" => "",
				"gluu_client_secret" => "",
				"config_acr" => []
			));
			$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
			if($_POST['gluu_users_can_register']==2){
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}
			if(!$this->gluu_is_port_working()){
				$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
			$register_site = new Register_site();
			$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
			$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
			$register_site->setRequestContacts([$gluu_config['admin_email']]);
			$register_site->setRequestAcrValues($gluu_config['config_acr']);
			$register_site->setRequestScope($gluu_config['config_scopes']);
			$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
			$status = $register_site->request();
			
			if(!$status['status']){
				if ($status['message'] == 'invalid_op_host') {
					$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				if (!$status['status']) {
					$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				if ($status['message'] == 'internal_error') {
					$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
			}
			$gluu_oxd_id = $register_site->getResponseOxdId();
			if ($gluu_oxd_id) {
				$gluu_provider = $register_site->getResponseOpHost();
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
				$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
				$gluu_other_config['gluu_provider'] = $gluu_provider;
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
				$obj = json_decode($json);
				if(!$this->gluu_is_port_working()){
					$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				$register_site = new Register_site();
				$register_site->setRequestOpHost($gluu_provider);
				$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
				$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
				$register_site->setRequestContacts([$gluu_config['admin_email']]);
				$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
				
				$get_scopes = json_encode($obj->scopes_supported);
				if(!empty($obj->acr_values_supported)){
					$get_acr = json_encode($obj->acr_values_supported);
					$get_acr = $this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr);
					$register_site->setRequestAcrValues($gluu_config['config_acr']);
				}
				else{
					$register_site->setRequestAcrValues($gluu_config['config_acr']);
				}
				if(!empty($obj->scopes_supported)){
					$get_scopes = json_encode($obj->scopes_supported);
					$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes);
					$register_site->setRequestScope($obj->scopes_supported);
				}
				else{
					$register_site->setRequestScope($gluu_config['config_scopes']);
				}
				$status = $register_site->request();
				if(!$status['status']){
					if ($status['message'] == 'invalid_op_host') {
						$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if (!$status['status']) {
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if ($status['message'] == 'internal_error') {
						$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
				$gluu_oxd_id = $register_site->getResponseOxdId();
				if ($gluu_oxd_id) {
					$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
					$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
					$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
					$_SESSION['message_success'] = 'Your settings are saved successfully.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				else {
					$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
			}
			else {
				$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
		}
	}
	else if (isset( $_REQUEST['form_key'] ) and strpos( $_REQUEST['form_key'], 'general_oxd_edit' ) !== false) {
		
		if($_POST['gluu_user_role']){
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_user_role'] = $_POST['gluu_user_role'];
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}else{
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_user_role'] = 0;
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}
		if($_POST['gluu_users_can_register']==1){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', $_POST['gluu_users_can_register']);
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(null));
			}
		}
		if($_POST['gluu_users_can_register']==2){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', 2);
			
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(null));
			}
		}
		if($_POST['gluu_users_can_register']==3){
			$this->model_module_gluu_sso->gluu_db_query_update('gluu_users_can_register', 3);
			if(!empty(array_values(array_filter($_POST['gluu_new_role'])))){
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(array_unique(array_values(array_filter($_POST['gluu_new_role'])))));
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}else{
				$this->model_module_gluu_sso->gluu_db_query_update('gluu_new_role', json_encode(null));
			}
		}
		$get_scopes = json_encode(array("openid", "profile","email"));
		$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('get_scopes', $get_scopes);
		
		$gluu_acr = json_encode(array("none"));
		$gluu_acr = $this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $gluu_acr);
		
		if(!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] != "on") {
			$_SESSION['message_error'] = 'OpenID Connect requires https. This plugin will not work if your website uses http only.';
			$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		if (empty($_POST['gluu_oxd_port'])) {
			$_SESSION['message_error'] = 'All the fields are required. Please enter valid entries.';
			$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		else if (intval($_POST['gluu_oxd_port']) > 65535 && intval($_POST['gluu_oxd_port']) < 0) {
			$_SESSION['message_error'] = 'Enter your oxd host port (Min. number 0, Max. number 65535).';
			$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		if  (!empty($_POST['gluu_custom_logout'])) {
			if (filter_var($_POST['gluu_custom_logout'], FILTER_VALIDATE_URL) === false) {
				$_SESSION['message_error'] = 'Please enter valid Custom URI.';
			}else{
				$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
				$gluu_other_config['gluu_custom_logout'] = $_POST['gluu_custom_logout'];
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
			}
		}else{
			$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
			$gluu_other_config['gluu_custom_logout'] = '';
			$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		}
		$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
		$gluu_other_config['gluu_oxd_id'] = '';
		$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
		$gluu_config = array(
			"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
			"admin_email" => $this->config->get('config_email'),
			"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
			"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
			"config_scopes" => ["openid","profile","email"],
			"gluu_client_id" => "",
			"gluu_client_secret" => "",
			"config_acr" => []
		);
		
		$gluu_config = $this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($gluu_config));
		if($_POST['gluu_users_can_register']==2){
			$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
			array_push($config['config_scopes'],'permission');
			$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
		}
		$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
		$gluu_provider         = $gluu_other_config['gluu_provider'];
		if (!empty($gluu_provider)) {
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);
			$json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
			$obj = json_decode($json);
			if(!empty($obj->userinfo_endpoint)){
				if(empty($obj->registration_endpoint)){
					if(isset($_POST['gluu_client_id']) and !empty($_POST['gluu_client_id']) and
						isset($_POST['gluu_client_secret']) and !empty($_POST['gluu_client_secret']) and !$obj->registration_endpoint){
						$gluu_config = array(
							"gluu_oxd_port" => $_POST['gluu_oxd_port'],
							"admin_email" => $this->config->get('config_email'),
							"gluu_client_id" => $_POST['gluu_client_id'],
							"gluu_client_secret" => $_POST['gluu_client_secret'],
							"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
							"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
							"config_scopes" => ["openid", "profile","email"],
							"config_acr" => []
						);
						$gluu_config1 = $this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($gluu_config));
						if($_POST['gluu_users_can_register']==2){
							$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
							array_push($config['config_scopes'],'permission');
							$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
						}
						if(!$this->gluu_is_port_working()){
							$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						$register_site = new Register_site();
						$register_site->setRequestOpHost($gluu_provider);
						$register_site->setRequestAcrValues($gluu_config['config_acr']);
						$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
						$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
						$register_site->setRequestContacts([$this->config->get('config_email')]);
						$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
						if(!empty($obj->acr_values_supported)){
							$get_acr = json_encode($obj->acr_values_supported);
							$gluu_config = $this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $gluu_acr);
						}
						if(!empty($obj->scopes_supported)){
							$get_scopes = json_encode($obj->scopes_supported);
							$gluu_config = $this->model_module_gluu_sso->gluu_db_query_update('get_scopes', $get_scopes);
							$register_site->setRequestScope($obj->scopes_supported);
						}else{
							$register_site->setRequestScope($gluu_config['config_scopes']);
						}
						$register_site->setRequestClientId($_POST['gluu_client_id']);
						$register_site->setRequestClientSecret($_POST['gluu_client_secret']);
						$status = $register_site->request();
						if(!$status['status']){
							if ($status['message'] == 'invalid_op_host') {
								$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
							if (!$status['status']) {
								$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
							if ($status['message'] == 'internal_error') {
								$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
								$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
								return;
							}
						}
						$gluu_oxd_id = $register_site->getResponseOxdId();
						if ($gluu_oxd_id) {
							$gluu_provider = $register_site->getResponseOpHost();
							$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
							$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
							$gluu_other_config['gluu_provider'] = $gluu_provider;
							$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
							$_SESSION['message_success'] = 'Your settings are saved successfully.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						} else {
							$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
					}
					else{
						$_SESSION['openid_error_edit'] = 'Error506';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
				else{
					$gluu_config = array(
						"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
						"admin_email" => $this->config->get('config_email'),
						"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
						"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
						"config_scopes" => ["openid","profile","email"],
						"gluu_client_id" => "",
						"gluu_client_secret" => "",
						"config_acr" => []
					);
					$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($gluu_config)),true);
					if($_POST['gluu_users_can_register']==2){
						$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
						array_push($config['config_scopes'],'permission');
						$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
					}
					if(!$this->gluu_is_port_working()){
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					$register_site = new Register_site();
					$register_site->setRequestOpHost($gluu_provider);
					$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
					$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
					$register_site->setRequestContacts([$gluu_config['admin_email']]);
					$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
					$get_scopes = json_encode($obj->scopes_supported);
					if(!empty($obj->acr_values_supported)){
						$get_acr = json_encode($obj->acr_values_supported);
						$get_acr = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr));
						$register_site->setRequestAcrValues($gluu_config['config_acr']);
					}
					else{
						$register_site->setRequestAcrValues($gluu_config['config_acr']);
					}
					if(!empty($obj->scopes_supported)){
						$get_scopes = json_encode($obj->scopes_supported);
						$get_scopes = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes));
						$register_site->setRequestScope($obj->scopes_supported);
					}
					else{
						$register_site->setRequestScope($gluu_config['config_scopes']);
					}
					$status = $register_site->request();
					if(!$status['status']){
						if ($status['message'] == 'invalid_op_host') {
							$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						if (!$status['status']) {
							$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
						if ($status['message'] == 'internal_error') {
							$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
							$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
							return;
						}
					}
					$gluu_oxd_id = $register_site->getResponseOxdId();
					if ($gluu_oxd_id) {
						$gluu_provider = $register_site->getResponseOpHost();
						$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
						$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
						$gluu_other_config['gluu_provider'] = $gluu_provider;
						$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
						$_SESSION['message_success'] = 'Your settings are saved successfully.';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					else {
						$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
						$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
			}
			else{
				$_SESSION['message_error'] = 'Please enter correct URI of the OpenID Provider';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
		}
		else{
			$gluu_config = array(
				"gluu_oxd_port" =>$_POST['gluu_oxd_port'],
				"admin_email" => $this->config->get('config_email'),
				"authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso/login_by_sso',
				"post_logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
				"config_scopes" => ["openid","profile","email"],
				"gluu_client_id" => "",
				"gluu_client_secret" => "",
				"config_acr" => []
			);
			$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($gluu_config)),true);
			if($_POST['gluu_users_can_register']==2){
				$config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_config'),true);
				array_push($config['config_scopes'],'permission');
				$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', json_encode($config)),true);
			}
			if(!$this->gluu_is_port_working()){
				$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
			$register_site = new Register_site();
			$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
			$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
			$register_site->setRequestContacts([$gluu_config['admin_email']]);
			$register_site->setRequestAcrValues($gluu_config['config_acr']);
			$register_site->setRequestScope($gluu_config['config_scopes']);
			$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
			$status = $register_site->request();
			
			if(!$status['status']){
				if ($status['message'] == 'invalid_op_host') {
					$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				if (!$status['status']) {
					$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				if ($status['message'] == 'internal_error') {
					$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
			}
			$gluu_oxd_id = $register_site->getResponseOxdId();
			if ($gluu_oxd_id) {
				$gluu_provider = $register_site->getResponseOpHost();
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
				$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
				$gluu_other_config['gluu_provider'] = $gluu_provider;
				$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$json = file_get_contents($gluu_provider.'/.well-known/openid-configuration', false, stream_context_create($arrContextOptions));
				$obj = json_decode($json);
				if(!$this->gluu_is_port_working()){
					$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				$register_site = new Register_site();
				$register_site->setRequestOpHost($gluu_provider);
				$register_site->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
				$register_site->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
				$register_site->setRequestContacts([$gluu_config['admin_email']]);
				$register_site->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
				
				$get_scopes = json_encode($obj->scopes_supported);
				if(!empty($obj->acr_values_supported)){
					$get_acr = json_encode($obj->acr_values_supported);
					$get_acr = $this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr);
					$register_site->setRequestAcrValues($gluu_config['config_acr']);
				}
				else{
					$register_site->setRequestAcrValues($gluu_config['config_acr']);
				}
				if(!empty($obj->scopes_supported)){
					$get_scopes = json_encode($obj->scopes_supported);
					$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes);
					$register_site->setRequestScope($obj->scopes_supported);
				}
				else{
					$register_site->setRequestScope($gluu_config['config_scopes']);
				}
				$status = $register_site->request();
				if(!$status['status']){
					if ($status['message'] == 'invalid_op_host') {
						$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
						$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if (!$status['status']) {
						$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
						$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
					if ($status['message'] == 'internal_error') {
						$_SESSION['message_error'] = 'ERROR: '.$status['error_message'];
						$this->response->redirect($this->url->link('module/gluu_sso/edit', 'token=' . $this->session->data['token'], 'SSL'));
						return;
					}
				}
				$gluu_oxd_id = $register_site->getResponseOxdId();
				if ($gluu_oxd_id) {
					$gluu_provider = $register_site->getResponseOpHost();
					$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
					$gluu_other_config['gluu_oxd_id'] = $gluu_oxd_id;
					$gluu_other_config['gluu_provider'] = $gluu_provider;
					$gluu_other_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_other_config', json_encode($gluu_other_config)),true);
					$_SESSION['message_success'] = 'Your settings are saved successfully.';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
				else {
					$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
					$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
					return;
				}
			}
			else {
				$_SESSION['message_error'] = 'ERROR: OpenID Provider host is required if you don\'t provide it in oxd-default-site-config.json';
				$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
				return;
			}
		}
	}
	else if( isset( $_REQUEST['form_key'] ) and strpos( $_REQUEST['form_key'], 'general_oxd_id_reset' )  !== false and !empty($_REQUEST['resetButton'])) {
		$this->model_module_gluu_sso->drop_table();
		unset($_SESSION['openid_error']);
		unset($_SESSION['openid_error_edit']);
		$_SESSION['openid_error'] = '';
		$_SESSION['openid_error_edit'] = '';
		$_SESSION['message_success'] = 'Configurations deleted Successfully.';
		$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
	}
	else if( isset( $_REQUEST['form_key'] ) and strpos( $_REQUEST['form_key'], 'openid_config_page' ) !== false ) {
		$params = $_REQUEST;
		$message_success = '';
		$message_error = '';
		
		if($_POST['send_user_type']){
			$gluu_auth_type = $_POST['send_user_type'];
			$gluu_auth_type = $this->model_module_gluu_sso->gluu_db_query_update('gluu_auth_type', $gluu_auth_type);
		}else{
			$gluu_auth_type = $this->model_module_gluu_sso->gluu_db_query_update('gluu_auth_type', 'default');
		}
		if($_POST['send_user_check']){
			$gluu_send_user_check = $this->model_module_gluu_sso->gluu_db_query_update('gluu_send_user_check', 'yes');
		}else{
			$gluu_send_user_check = $this->model_module_gluu_sso->gluu_db_query_update('gluu_send_user_check', 'no');
		}
		
		
		if(!empty($params['scope']) && isset($params['scope'])){
			$gluu_config =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_config"),true);
			$gluu_config['config_scopes'] = $params['scope'];
			$gluu_config = json_encode($gluu_config);
			$gluu_config = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_config', $gluu_config),true);
		}
		if(!empty($params['scope_name']) && isset($params['scope_name'])){
			$get_scopes =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_scopes"),true);
			foreach($params['scope_name'] as $scope){
				if($scope && !in_array($scope,$get_scopes)){
					array_push($get_scopes, $scope);
				}
			}
			$get_scopes = json_encode($get_scopes);
			$get_scopes = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_scopes', $get_scopes),true);
		}
		$gluu_acr              = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_acr'),true);
		
		if(!empty($params['acr_name']) && isset($params['acr_name'])){
			$get_acr =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_acr"),true);
			foreach($params['acr_name'] as $scope){
				if($scope && !in_array($scope,$get_acr)){
					array_push($get_acr, $scope);
				}
			}
			$get_acr = json_encode($get_acr);
			$get_acr = json_decode($this->model_module_gluu_sso->gluu_db_query_update('gluu_acr', $get_acr),true);
		}
		$gluu_config =   json_decode($this->model_module_gluu_sso->gluu_db_query_select("gluu_config"),true);
		$gluu_oxd_id =   $this->model_module_gluu_sso->gluu_db_query_select("gluu_oxd_id");
		if(!$this->gluu_is_port_working()){
			$_SESSION['message_error'] = 'Can not connect to the oxd server. Please check the oxd-config.json file to make sure you have entered the correct port and the oxd server is operational.';
			$this->response->redirect($this->url->link('module/gluu_sso', 'token=' . $this->session->data['token'], 'SSL'));
			return;
		}
		$update_site_registration = new Update_site_registration();
		$update_site_registration->setRequestOxdId($gluu_oxd_id);
		$update_site_registration->setRequestAcrValues($gluu_config['acr_values']);
		$update_site_registration->setRequestAuthorizationRedirectUri($gluu_config['authorization_redirect_uri']);
		$update_site_registration->setRequestLogoutRedirectUri($gluu_config['post_logout_redirect_uri']);
		$update_site_registration->setRequestContacts([$gluu_config['admin_email']]);
		$update_site_registration->setRequestClientLogoutUri($gluu_config['post_logout_redirect_uri']);
		$update_site_registration->setRequestScope($gluu_config['config_scopes']);
		$status = $update_site_registration->request();
		$new_oxd_id = $update_site_registration->getResponseOxdId();
		if($new_oxd_id){
			$get_scopes = $this->model_module_gluu_sso->gluu_db_query_update('gluu_oxd_id', $new_oxd_id);
		}
		
		
		$_SESSION['message_success'] = 'Your OpenID connect configuration has been saved.';
		$_SESSION['message_error'] = $message_error;
		$this->response->redirect($this->url->link('module/gluu_sso/openidconfig', 'token=' . $this->session->data['token'], 'SSL'));
		exit;
	}
}
        public function gluu_is_oxd_registered(){
	$this->load->model('module/gluu_sso');
	$gluu_other_config             = json_decode($this->model_module_gluu_sso->gluu_db_query_select('gluu_other_config'),true);
	if(!empty($gluu_other_config['gluu_oxd_id'])){
		return $gluu_other_config['gluu_oxd_id'];
	}else{
		return 0;
	}
}
        public function gluu_is_port_working(){
	$this->load->model('module/gluu_sso');
	$config_option = json_decode($this->model_module_gluu_sso->gluu_db_query_select( 'gluu_config'),true);
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
    }


?>