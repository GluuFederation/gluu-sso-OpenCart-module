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
                        array('name'=>'Google','image'=>'view/image/icons/google.png','value'=>'gplus'),
                        array('name'=>'Basic','image'=>'view/image/icons/basic.png','value'=>'basic'),
                        array('name'=>'Duo','image'=>'view/image/icons/duo.png','value'=>'duo'),
                        array('name'=>'U2F token','image'=>'view/image/icons/u2f.png','value'=>'u2f')
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

}

?>