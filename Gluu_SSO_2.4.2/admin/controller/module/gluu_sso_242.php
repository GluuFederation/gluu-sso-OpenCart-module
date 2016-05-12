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
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gluu_table` (
                            `gluu_action` varchar(255) NOT NULL,
                            `gluu_value` longtext NOT NULL,
                            UNIQUE(`gluu_action`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    }

    /*
     * Module loading page
    */
    public function index() {

    }


}

?>