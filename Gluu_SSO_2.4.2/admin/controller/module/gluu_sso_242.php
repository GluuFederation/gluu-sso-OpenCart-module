<?php

/*
 * Module controller
*/
class ControllerModuleGluuSSO242 extends Controller
{

    /*
     * Module installation function
    */
    public function install()
    {
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
                        array('name'=>'Google','image'=>'view/image/gluu_sso_242/google.png','value'=>'gplus'),
                        array('name'=>'Basic','image'=>'view/image/gluu_sso_242/basic.png','value'=>'basic'),
                        array('name'=>'Duo','image'=>'view/image/gluu_sso_242/duo.png','value'=>'duo'),
                        array('name'=>'U2F token','image'=>'view/image/gluu_sso_242/u2f.png','value'=>'u2f')
                    )
                )
            );
        }
        if(!json_decode($this->gluu_db_query_select('oxd_config'),true)){
            $this->gluu_db_query_insert('oxd_config',json_encode(array(
                        "oxd_host_ip" => '127.0.0.1',
                        "oxd_host_port" =>8099,
                        "admin_email" => '',
                        "authorization_redirect_uri" => $base_url.'?_action=plugin.gluu_sso-login-from-gluu',
                        "logout_redirect_uri" => $base_url.'?_action=plugin.gluu_sso-login-from-gluu',
                        "scope" => ["openid","profile","email","address","clientinfo","mobile_phone","phone"],
                        "grant_types" =>["authorization_code"],
                        "response_types" => ["code"],
                        "application_type" => "web",
                        "redirect_uris" => [ $base_url.'?_action=plugin.gluu_sso-login-from-gluu' ],
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
     * Module loading page
    */
    public function index() {

        $this->load->language('module/gluu_sso_242');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addStyle('view/stylesheet/gluu_sso_242/gluu_sso_242.css');

        $this->load->model('setting/setting');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');

        $data['General'] = $this->language->get('General');
        $data['OpenIDConnect'] = $this->language->get('OpenIDConnect');
        $data['OpenCartConfig'] = $this->language->get('OpenCartConfig');
        $data['helpTrouble'] = $this->language->get('helpTrouble');
        $data['gluu_sso'] = $this->language->get('gluu_sso');
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
        $data['serverConfig'] = $this->language->get('serverConfig');
        $data['allScopes'] = $this->language->get('allScopes');
        $data['name'] = $this->language->get('name');
        $data['or'] = $this->language->get('or');
        $data['isExist'] = $this->language->get('isExist');
        $data['delete'] = $this->language->get('delete');
        $data['addScopes'] = $this->language->get('addScopes');
        $data['default'] = $this->language->get('Default');
        $data['Height'] = $this->language->get('Height');
        $data['Square'] = $this->language->get('Square');
        $data['Preview'] = $this->language->get('Preview');
        $data['Shape'] = $this->language->get('Shape');
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
        $data['doocumentation242'] = $this->language->get('doocumentation242');
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
        $data['selected_icon'] = $this->selected_icon();
        $data['base_url'] = HTTPS_SERVER;
        $data['oxd_id'] = 'oxd_id';
        $data['action'] = $this->url->link('module/gluu_sso_242', 'token=' . $this->session->data['token'], 'SSL');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/gluu_sso_242.tpl', $data));
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
}

?>