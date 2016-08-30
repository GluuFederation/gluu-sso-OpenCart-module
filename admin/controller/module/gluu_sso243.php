<?php

/*
 * Module controller
*/
class ControllerModuleGluuSSO243 extends Controller
{

    /*
     * Adding necessary data for gluu module
    */
    public function adding_gluu_data(){
        $base_url = HTTPS_CATALOG;
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gluu_table` (
                            `gluu_action` varchar(255) NOT NULL,
                            `gluu_value` longtext NOT NULL,
                            UNIQUE(`gluu_action`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        if(!json_decode($this->gluu_db_query_select('scopes'),true)){
            $this->gluu_db_query_insert('scopes',json_encode(array("openid","profile","email","address","clientinfo","mobile_phone","phone")));
        }
        if(!json_decode($this->gluu_db_query_select('custom_scripts'),true)){
            $this->gluu_db_query_insert('custom_scripts',json_encode(array(
                        array('name'=>'Google','image'=>HTTP_CATALOG.'image/gluu_icon/google.png','value'=>'gplus'),
                        array('name'=>'Basic','image'=>HTTP_CATALOG.'image/gluu_icon/basic.png','value'=>'basic'),
                        array('name'=>'Duo','image'=>HTTP_CATALOG.'image/gluu_icon/duo.png','value'=>'duo'),
                        array('name'=>'U2F token','image'=>HTTP_CATALOG.'image/gluu_icon/u2f.png','value'=>'u2f')
                    )
                )
            );
        }
        if(!json_decode($this->gluu_db_query_select('oxd_config'),true)){
            $this->gluu_db_query_insert('oxd_config',json_encode(array(
                        "oxd_host_ip" => '127.0.0.1',
                        "oxd_host_port" =>8099,
                        "admin_email" => '',
                        "authorization_redirect_uri" => $base_url.'index.php?route=module/gluu_sso243',
                        "logout_redirect_uri" => $base_url.'index.php?route=account/logout',
                        "scope" => ["openid","profile","email","address","clientinfo","mobile_phone","phone"],
                        "grant_types" =>["authorization_code"],
                        "response_types" => ["code"],
                        "application_type" => "web",
                        "redirect_uris" => [ $base_url.'index.php?route=module/gluu_sso243' ],
                        "acr_values" => [],
                    )
                )
            );
        }
        if(!$this->gluu_db_query_select('iconSpace')){
            $this->gluu_db_query_insert('iconSpace','10');
        }
        if(!$this->gluu_db_query_select('iconCustomSize')){
            $this->gluu_db_query_insert('iconCustomSize','50');
        }
        if(!$this->gluu_db_query_select('iconCustomWidth')){
            $this->gluu_db_query_insert('iconCustomWidth','200');
        }
        if(!$this->gluu_db_query_select('iconCustomHeight')){
            $this->gluu_db_query_insert('iconCustomHeight','35');
        }
        if(!$this->gluu_db_query_select('loginCustomTheme')){
            $this->gluu_db_query_insert('loginCustomTheme','default');
        }
        if(!$this->gluu_db_query_select('loginTheme')){
            $this->gluu_db_query_insert('loginTheme','circle');
        }
        if(!$this->gluu_db_query_select('iconCustomColor')){
            $this->gluu_db_query_insert('iconCustomColor','#0000FF');
        }
    }

    /*
     * Module installation function
    */
    public function install()
    {
        $this->adding_gluu_data();
        $this->load->model('extension/event');
        $this->model_extension_event->addEvent('gluu_sso243', 'post.customer.logout', 'module/gluu_sso243/logout');

        $query = $this->db->query("SELECT `code` FROM `" . DB_PREFIX ."setting` WHERE `key` = 'gluu_sso243_status' ;");
        if(!$query->num_rows){

            $this->db->query("INSERT INTO `" . DB_PREFIX ."setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES (NULL, '0', 'gluu_sso243', 'gluu_sso243_status', '0', '0');");
        }
// Add to default positions
        $result = $this->db->query ("SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE name IN ('Account', 'Checkout')");
        if ($result->num_rows > 0)
        {
            foreach ($result->rows as $row)
            {
                // Prevent Duplicates
                $this->db->query ("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE layout_id = '".intval ($row['layout_id'])."' AND code = 'gluu_sso243' AND position='content_top'");

                // Add Position
                $this->db->query ("INSERT INTO `" . DB_PREFIX . "layout_module` SET layout_id = '".intval ($row['layout_id'])."', code = 'gluu_sso243', position='content_top', sort_order='1'");
            }
        }
        // Callback Handler
        if (defined ('VERSION') && version_compare (VERSION, '2.2.0', '>='))
        {
            $this->load->model('extension/event');
            $this->model_extension_event->addEvent('gluu_sso243', 'catalog/controller/module/gluu_sso243/before', 'module/gluu_sso243');
        }
    }

    /*
     * Module uninstallation function
    */
    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX ."gluu_table`;");
        $this->db->query("UPDATE `" . DB_PREFIX ."setting` SET `value` = '0' WHERE `key` = 'gluu_sso243_status';");
    }

    /*
     * Module loading page
    */
    public function index() {
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
        if(!empty($_SESSION['activ_tab'])){
            $data['activ_tab'] = $_SESSION['activ_tab'];
            $_SESSION['activ_tab'] = '';
        }else{
            $data['activ_tab'] = 'General';
        }
        $this->adding_gluu_data();
        $base_url = HTTPS_CATALOG;
        $this->load->language('module/gluu_sso243');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addStyle('view/stylesheet/gluu_sso243/gluu_sso243.css');
        $this->load->model('setting/setting');

        require_once(DIR_SYSTEM . 'library/oxd-rp-243/Register_site.php');
        require_once(DIR_SYSTEM . 'library/oxd-rp-243/Update_site_registration.php');
        if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'general_register_page' )               !== false ) {
            $config_option = json_encode(array(
                "oxd_host_ip" => '127.0.0.1',
                "oxd_host_port" =>$this->request->post['oxd_port'],
                "admin_email" => $this->request->post['loginemail'],
                "authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso243',
                "logout_redirect_uri" => HTTPS_CATALOG.'index.php?route=account/logout',
                "scope" => ["openid","profile","email","address","clientinfo","mobile_phone","phone"],
                "grant_types" =>["authorization_code"],
                "response_types" => ["code"],
                "application_type" => "web",
                "redirect_uris" => [ HTTPS_CATALOG.'index.php?route=module/gluu_sso243'],
                "acr_values" => [],
            ));
            $this->gluu_db_query_update('oxd_config', $config_option);
            $config_option = array(
                "oxd_host_ip" => '127.0.0.1',
                "oxd_host_port" =>$this->request->post['oxd_port'],
                "admin_email" => $this->request->post['loginemail'],
                "authorization_redirect_uri" => HTTPS_CATALOG.'index.php?route=module/gluu_sso243',
                "logout_redirect_uri" => HTTPS_CATALOG.'index.php?index.php?route=account/logout',
                "scope" => ["openid","profile","email","address","clientinfo","mobile_phone","phone"],
                "grant_types" =>["authorization_code"],
                "response_types" => ["code"],
                "application_type" => "web",
                "redirect_uris" => [ HTTPS_CATALOG.'index.php?route=module/gluu_sso243'],
                "acr_values" => [],
            );
            $register_site = new Register_site();
            $register_site->setRequestAcrValues($config_option['acr_values']);
            $register_site->setRequestAuthorizationRedirectUri($config_option['authorization_redirect_uri']);
            $register_site->setRequestRedirectUris($config_option['redirect_uris']);
            $register_site->setRequestGrantTypes($config_option['grant_types']);
            $register_site->setRequestResponseTypes(['code']);
            $register_site->setRequestLogoutRedirectUri($config_option['logout_redirect_uri']);
            $register_site->setRequestContacts([$config_option["admin_email"]]);
            $register_site->setRequestApplicationType('web');
            $register_site->setRequestClientLogoutUri($config_option['logout_redirect_uri']);
            $register_site->setRequestScope($config_option['scope']);
            $status = $register_site->request();

            if(!$status['status']){
                $_SESSION['message_error'] = $status['message'];
                $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
            }
            if($register_site->getResponseOxdId()){
                $oxd_id = $register_site->getResponseOxdId();
                if(!$this->gluu_db_query_select('oxd_id')){
                    $this->gluu_db_query_insert('oxd_id',$oxd_id);
                    $this->db->query("UPDATE `" . DB_PREFIX ."setting` SET `value` = '1' WHERE `key` = 'gluu_sso243_status';");
                }
            }
            $_SESSION['message_success'] = $this->language->get('messageSiteRegisteredSuccessful');
            $_SESSION['activ_tab'] = 'General';
            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
        }
        else if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'openid_config_delete_scop' )           !== false ) {

            $get_scopes =   json_decode($this->gluu_db_query_select('scopes'),true);
            $up_cust_sc =  array();

            foreach($get_scopes as $custom_scop){
                if($custom_scop !=$_REQUEST['value_scope']){
                    array_push($up_cust_sc,$custom_scop);
                }
            }

            $get_scopes = json_encode($up_cust_sc);
            $this->gluu_db_query_update('scopes', $get_scopes);
            $_SESSION['message_success'] = $this->language->get('messageScopeDeletedSuccessful');
            $_SESSION['activ_tab'] = 'OpenIDConnect';
            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
        }
        else if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'general_oxd_id_reset' )!== false and !empty($this->request->post['resetButton'])) {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX ."gluu_table`;");
            $this->adding_gluu_data();
            $_SESSION['message_success'] = $this->language->get('messageConfigurationsDeletedSuccessful');
            $_SESSION['activ_tab'] = 'General';
            $this->db->query("UPDATE `" . DB_PREFIX ."setting` SET `value` = '0' WHERE `key` = 'gluu_sso243_status';");
            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
        }
        else if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'openid_config_delete_custom_scripts' ) !== false ) {
            $get_scopes =   json_decode($this->gluu_db_query_select('custom_scripts'),true);
            $up_cust_sc =  array();
            foreach($get_scopes as $custom_scop){
                if($custom_scop['value'] !=$_REQUEST['value_script']){
                    array_push($up_cust_sc,$custom_scop);
                }
            }
            $get_scopes = json_encode($up_cust_sc);
            $this->gluu_db_query_update('custom_scripts', $get_scopes);
            $_SESSION['message_success'] = $this->language->get('messageScriptDeletedSuccessful');
            $_SESSION['activ_tab'] = 'OpenIDConnect';
            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
        }
        else if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'opencart_config_page' )           !== false ) {
            $this->gluu_db_query_update('loginTheme', $_REQUEST['gluuoxd_openid_login_theme']);
            $this->gluu_db_query_update('loginCustomTheme', $_REQUEST['gluuoxd_openid_login_custom_theme']);
            $this->gluu_db_query_update('iconSpace', $_REQUEST['gluuox_login_icon_space']);
            $this->gluu_db_query_update('iconCustomSize', $_REQUEST['gluuox_login_icon_custom_size']);
            $this->gluu_db_query_update('iconCustomWidth', $_REQUEST['gluuox_login_icon_custom_width']);
            $this->gluu_db_query_update('iconCustomHeight', $_REQUEST['gluuox_login_icon_custom_height']);
            $this->gluu_db_query_update('iconCustomColor', $_REQUEST['gluuox_login_icon_custom_color']);
            $_SESSION['message_success'] = $this->language->get('messageYourConfiguration');
            $_SESSION['activ_tab'] = 'OpenCartConfig';
            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
        }
        else if( isset( $this->request->post['form_key'] ) and strpos( $this->request->post['form_key'], 'openid_config_page' )                  !== false ) {
            $_SESSION['activ_tab'] = 'OpenIDConnect';
            $params = $this->request->post;
            $message_success = '';
            $message_error = '';
            if(!empty($params['scope']) && isset($params['scope'])){
                $oxd_config =   json_decode($this->gluu_db_query_select('oxd_config'),true);
                $oxd_config['scope'] = $params['scope'];
                $oxd_config = json_encode($oxd_config);
                $this->gluu_db_query_update('oxd_config',$oxd_config);
            }
            if(!empty($params['scope_name']) && isset($params['scope_name'])){
                $get_scopes =   json_decode($this->gluu_db_query_select('scopes'),true);
                foreach($params['scope_name'] as $scope){
                    if($scope && !in_array($scope,$get_scopes)){
                        array_push($get_scopes, $scope);
                    }
                }
                $get_scopes = json_encode($get_scopes);
                $this->gluu_db_query_update('scopes',$get_scopes);
            }
            $custom_scripts =   json_decode($this->gluu_db_query_select('custom_scripts'),true);
            foreach($custom_scripts as $custom_script){
                $action = $custom_script['value']."Enable";
                $value = $params['gluuoxd_openid_'.$custom_script['value'].'_enable'];
                $typeLogin =  $this->gluu_db_query_select($custom_script['value']."Enable");
                if(!$typeLogin){
                    $this->gluu_db_query_insert($action,$value);
                }
                if($value != NULL){
                    $this->gluu_db_query_update($action,'1');
                }else{
                    $this->gluu_db_query_update($action,'0');
                }
            }
            if(isset($params['count_scripts'])){
                $error_array = array();
                $error = true;
                $custom_scripts = json_decode($this->gluu_db_query_select('custom_scripts'),true);
                for($i=1; $i<=$params['count_scripts']; $i++){
                    if(isset($params['name_in_site_'.$i]) && !empty($params['name_in_site_'.$i]) && isset($params['name_in_gluu_'.$i]) && !empty($params['name_in_gluu_'.$i]) && isset($_FILES['images_'.$i]) && !empty($_FILES['images_'.$i])){
                        foreach($custom_scripts as $custom_script){
                            if($custom_script['value'] == $params['name_in_gluu_'.$i] || $custom_script['name'] == $params['name_in_site_'.$i]){
                                $error = false;
                                array_push($error_array, $i);
                            }
                        }
                        if($error){
                            $target_dir = DIR_IMAGE;
                            $target_file = $target_dir . basename($_FILES['images_'.$i]["name"]);
                            $uploadOk = 1;
                            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                            if (file_exists($target_file)) {
                                $target_file= $target_dir.$this->file_newname($target_dir, basename($_FILES['images_'.$i]["name"]));
                            }
                            if (move_uploaded_file($_FILES['images_'.$i]["tmp_name"], $target_file)) {
                                array_push($custom_scripts, array('name'=>$params['name_in_site_'.$i],'image'=>HTTP_CATALOG.'image/'. basename($_FILES['images_'.$i]["name"]),'value'=>$params['name_in_gluu_'.$i]));
                                $custom_scripts_json = json_encode($custom_scripts);
                                $this->gluu_db_query_update('custom_scripts', $custom_scripts_json);

                            } else {
                                $message_error.= $this->language->get('messageSorryUploading').$_FILES['images_'.$i]["name"].' '.$this->language->get('file').".<br/>";
                                break;
                            }

                        }else{
                            $message_error.=$this->language->get('name').' = '.$params['name_in_site_'.$i].' '.$this->language->get('or'). '  value = '. $params['name_in_gluu_'.$i] .' '.$this->language->get('isExist').'<br/>';
                            break;
                        }
                    }else{
                        if(!empty($params['name_in_site_'.$i]) || !empty($params['name_in_gluu_'.$i]) || !empty($_FILES['images_'.$i]["name"])){
                            $message_error.=$this->language->get('necessaryToFill').'<br/>';
                        }
                    }
                }
            }
            $config_option = json_decode($this->gluu_db_query_select('oxd_config'),true);
            $update_site_registration = new Update_site_registration();
            $update_site_registration->setRequestOxdId($this->gluu_db_query_select('oxd_id'));
            $update_site_registration->setRequestAcrValues($config_option['acr_values']);
            $update_site_registration->setRequestAuthorizationRedirectUri($config_option['authorization_redirect_uri']);
            $update_site_registration->setRequestRedirectUris($config_option['redirect_uris']);
            $update_site_registration->setRequestGrantTypes($config_option['grant_types']);
            $update_site_registration->setRequestResponseTypes(['code']);
            $update_site_registration->setRequestLogoutRedirectUri($config_option['logout_redirect_uri']);
            $update_site_registration->setRequestContacts([$config_option['admin_email']]);
            $update_site_registration->setRequestApplicationType('web');
            $update_site_registration->setRequestClientLogoutUri($config_option['logout_redirect_uri']);
            $update_site_registration->setRequestScope($config_option['scope']);
            $status = $update_site_registration->request();
            if(!$status['status']){
                $_SESSION['message_error'] = $status['message'];
                $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            }
            $_SESSION['message_success'] = $this->language->get('messageOpenIDConnectConfiguration');
            $_SESSION['message_error'] = $message_error;

            $this->response->redirect($this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL'));
            exit;
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['General'] = $this->language->get('General');
        $data['OpenIDConnect'] = $this->language->get('OpenIDConnect');
        $data['OpenCartConfig'] = $this->language->get('OpenCartConfig');
        $data['helpTrouble'] = $this->language->get('helpTrouble');
        $data['serverConfig'] = $this->language->get('serverConfig');
        $data['Shape'] = $this->language->get('Shape');
        $data['Preview'] = $this->language->get('Preview');
        $data['Square'] = $this->language->get('Square');
        $data['Height'] = $this->language->get('Height');
        $data['Default'] = $this->language->get('Default');
        $data['messageConnectProvider'] = $this->language->get('messageConnectProvider');
        $data['messageSiteRegisteredSuccessful'] = $this->language->get('messageSiteRegisteredSuccessful');
        $data['messageScopeDeletedSuccessful'] = $this->language->get('messageScopeDeletedSuccessful');
        $data['messageConfigurationsDeletedSuccessful'] = $this->language->get('messageConfigurationsDeletedSuccessful');
        $data['messageScriptDeletedSuccessful'] = $this->language->get('messageScriptDeletedSuccessful');
        $data['messageYourConfiguration'] = $this->language->get('messageYourConfiguration');
        $data['messageOpenIDConnectConfiguration'] = $this->language->get('messageOpenIDConnectConfiguration');
        $data['messageSorryUploading'] = $this->language->get('messageSorryUploading');
        $data['messageSwitchedOn'] = $this->language->get('messageSwitchedOn');
        $data['problemImapConnection'] = $this->language->get('problemImapConnection');
        $data['necessaryToFill'] = $this->language->get('necessaryToFill');
        $data['file_text'] = $this->language->get('file_text');
        $data['registerMessageConnectProvider'] = $this->language->get('registerMessageConnectProvider');
        $data['linkToGluu'] = $this->language->get('linkToGluu');
        $data['Instructions'] = $this->language->get('Instructions');
        $data['adminEmail'] = $this->language->get('adminEmail');
        $data['admin_email'] = $this->config->get('config_email');
        $data['hederGluu'] = $this->language->get('hederGluu');
        $data['portNumber'] = $this->language->get('portNumber');
        $data['Addacr'] = $this->language->get('Addacr');
        $data['Save'] = $this->language->get('Save');
        $data['EnterportNumber'] = $this->language->get('EnterportNumber');
        $data['InputScopeName'] = $this->language->get('InputScopeName');
        $data['exampleGoogle'] = $this->language->get('exampleGoogle');
        $data['scriptName'] = $this->language->get('scriptName');
        $data['next'] = $this->language->get('next');
        $data['resetConfig'] = $this->language->get('resetConfig');
        $data['allScopes'] = $this->language->get('allScopes');
        $data['name'] = $this->language->get('name');
        $data['or'] = $this->language->get('or');
        $data['isExist'] = $this->language->get('isExist');
        $data['delete'] = $this->language->get('delete');
        $data['addScopes'] = $this->language->get('addScopes');
        $data['DisplayName'] = $this->language->get('DisplayName');
        $data['ACRvalue'] = $this->language->get('ACRvalue');
        $data['Image'] = $this->language->get('Image');
        $data['multipleCustomScripts'] = $this->language->get('multipleCustomScripts');
        $data['allCustomScripts'] = $this->language->get('allCustomScripts');
        $data['BothFields'] = $this->language->get('BothFields');
        $data['OXDConfiguration'] = $this->language->get('OXDConfiguration');
        $data['GluuLoginConfig'] = $this->language->get('GluuLoginConfig');
        $data['Theme'] = $this->language->get('Theme');
        $data['Round'] = $this->language->get('Round');
        $data['NoApps'] = $this->language->get('NoApps');
        $data['LongButton'] = $this->language->get('LongButton');
        $data['CustomBackground'] = $this->language->get('CustomBackground');
        $data['RoundedEdges'] = $this->language->get('RoundedEdges');
        $data['Width'] = $this->language->get('Width');
        $data['SpaceBetweenIcons'] = $this->language->get('SpaceBetweenIcons');
        $data['SizeofIcons'] = $this->language->get('SizeofIcons');
        $data['CustomizeLoginIcons'] = $this->language->get('CustomizeLoginIcons');
        $data['CustomizeShape'] = $this->language->get('CustomizeShape');
        $data['CustomizeYourLogin'] = $this->language->get('CustomizeYourLogin');
        $data['manageAuthentication'] = $this->language->get('manageAuthentication');
        $data['doocumentation243'] = $this->language->get('doocumentation243');
        $data['selected_icon'] = $this->selected_icon();

        $data['get_scopes'] =   json_decode($this->gluu_db_query_select('scopes'),true);
        $data['oxd_config'] =   json_decode($this->gluu_db_query_select('oxd_config'),true);
        $data['custom_scripts'] =   json_decode($this->gluu_db_query_select('custom_scripts'),true);
        $data['iconSpace'] = $this->gluu_db_query_select('iconSpace');
        $data['iconCustomSize'] = $this->gluu_db_query_select('iconCustomSize');
        $data['iconCustomWidth'] = $this->gluu_db_query_select('iconCustomWidth');
        $data['iconCustomHeight'] = $this->gluu_db_query_select('iconCustomHeight');
        $data['loginCustomTheme'] = $this->gluu_db_query_select('loginCustomTheme');
        $data['loginTheme'] = $this->gluu_db_query_select('loginTheme');
        $data['iconCustomColor'] = $this->gluu_db_query_select('iconCustomColor');

        $data['base_url'] = HTTPS_CATALOG;
        $oxd_id = '';
        if($this->gluu_db_query_select('oxd_id')){
            $data['oxd_id'] = $this->gluu_db_query_select('oxd_id');
        }else{
            $data['oxd_id'] = '';
        }

        $data['action'] = $this->url->link('module/gluu_sso243', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/gluu_sso243.tpl', $data));
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
     * Insert data to db:gluu_table.
    */
    public function gluu_db_query_insert($gluu_action, $gluu_value){
        return $this->db->query("INSERT INTO `" . DB_PREFIX . "gluu_table` (gluu_action, gluu_value) VALUES ('".$gluu_action."', '".$gluu_value."')");
    }

    /*
     * Update data to db:gluu_table.
    */
    public function gluu_db_query_update($gluu_action, $gluu_value){
        return  $this->db->query("UPDATE `" . DB_PREFIX . "gluu_table` SET `gluu_value` = '".$gluu_value."' WHERE `gluu_action` LIKE '".$gluu_action."';");
    }

    /*
     * Html for selected custom script icons.
    */
    public function selected_icon(){
        $oxd_id = $this->gluu_db_query_select('oxd_id');
        $custom_scripts =   json_decode($this->gluu_db_query_select('custom_scripts'),true);
        $html = '';
        foreach ($custom_scripts as $custom_script) {

            $html.='<td style="width:25%"><input type="checkbox"';
            if (!$oxd_id) {
                $html.=' disabled ';
            }
            $html.='id="'.$custom_script['value'].'_enable" class="app_enable" name="gluuoxd_openid_'.$custom_script['value'].'_enable" value="1" onchange="previewLoginIcons();" ';
            if ($this->gluu_db_query_select($custom_script['value']."Enable")) $html.=" checked ";
            $html.="/><b>".$custom_script['name']."</b></td>";
        }
        return $html;
    }

    /*
     * Changing uploaded image name.
    */
    public function file_newname($path, $filename){
        if ($pos = strrpos($filename, '.')) {
            $name = substr($filename, 0, $pos);
            $ext = substr($filename, $pos);
        } else {
            $name = $filename;
        }

        $newpath = $path.'/'.$filename;
        $newname = $filename;
        $counter = 0;
        while (file_exists($newpath)) {
            $newname = $name .'_'. $counter . $ext;
            $newpath = $path.'/'.$newname;
            $counter++;
        }

        return $newname;
    }
}

?>