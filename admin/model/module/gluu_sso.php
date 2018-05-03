<?php
	/**
	 * @copyright Copyright (c) 2017, Gluu Inc. (https://gluu.org/)
	 * @license	  MIT   License      : <http://opensource.org/licenses/MIT>
	 *
	 * @package	  OpenID Connect SSO Extension  by Gluu
	 * @category  Extension for OpenCart
	 * @version   3.1.1
	 *
	 * @author    Gluu Inc.          : <https://gluu.org>
	 * @link      Oxd site           : <https://oxd.gluu.org>
	 * @link      Documentation      : <https://oxd.gluu.org/docs/plugin/opencart/>
	 * @director  Mike Schwartz      : <mike@gluu.org>
	 * @support   Support email      : <support@gluu.org>
	 * @developer Volodya Karapetyan : <https://github.com/karapetyan88> <mr.karapetyan88@gmail.com>
	 *
	 *
	 * This content is released under the MIT License (MIT)
	 *
	 * Copyright (c) 2017, Gluu inc, USA, Austin
	 *
	 * Permission is hereby granted, free of charge, to any person obtaining a copy
	 * of this software and associated documentation files (the "Software"), to deal
	 * in the Software without restriction, including without limitation the rights
	 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	 * copies of the Software, and to permit persons to whom the Software is
	 * furnished to do so, subject to the following conditions:
	 *
	 * The above copyright notice and this permission notice shall be included in
	 * all copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	 * THE SOFTWARE.
	 *
	 */

	class ModelModuleGluuSSO extends Model
	{
		public function adding_gluu_data(){
			$base_url = HTTPS_CATALOG;
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gluu_table` (
                            `gluu_action` varchar(255) NOT NULL,
                            `gluu_value` longtext NOT NULL,
                            UNIQUE(`gluu_action`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

			if(!json_decode($this->gluu_db_query_select('gluu_scopes'))){
				$get_scopes = json_encode(array("openid", "profile","email"));
				$this->gluu_db_query_insert('gluu_scopes', $get_scopes);
			}
			if(!json_decode($this->gluu_db_query_select('gluu_acr'))){
				$custom_scripts = json_encode(array('none'));
				$this->gluu_db_query_insert('gluu_acr', $custom_scripts);
			}
			if(!json_decode($this->gluu_db_query_select('gluu_config'))){
				$gluu_config = json_encode(array(
					"gluu_oxd_port" =>8099,
					"admin_email" => $this->config->get('config_email'),
					"authorization_redirect_uri" => $base_url.'index.php?route=module/gluu_sso/login_by_sso',
					"post_logout_redirect_uri" => $base_url.'index.php?route=account/logout',
					"config_scopes" => ["openid","profile","email"],
					"gluu_client_id" => "",
					"gluu_client_secret" => "",
					"config_acr" => []
				));
				$this->gluu_db_query_insert('gluu_config', $gluu_config);
			}

			if(!$this->gluu_db_query_select('gluu_auth_type')){
				$gluu_auth_type = 'default';
				$this->gluu_db_query_insert('gluu_auth_type', $gluu_auth_type);
			}
			if(!$this->gluu_db_query_select('gluu_send_user_check')){
				$gluu_send_user_check = 'no';
				$this->gluu_db_query_insert('gluu_send_user_check', $gluu_send_user_check);
			}

			if(!$this->gluu_db_query_select('gluu_users_can_register')){
				$gluu_users_can_register = 1;
				$this->gluu_db_query_insert('gluu_users_can_register', $gluu_users_can_register);
			}
			if(!$this->gluu_db_query_select('gluu_new_role')){
				$this->gluu_db_query_insert('gluu_new_role', json_encode(array()));
			}
			if(!json_decode($this->gluu_db_query_select('gluu_other_config'))){
				$gluu_other_config = json_encode(array(
					'gluu_user_role'=>$this->config->get('config_customer_group_id'),
					'gluu_oxd_id' => '',
					'gluu_provider' => '',
					'gluu_custom_logout' => $base_url,
				));
				$this->gluu_db_query_insert('gluu_other_config', $gluu_other_config);
			}

		}
		public function uninstall() {
			$this->drop_table();
			$this->db->query("UPDATE `" . DB_PREFIX ."setting` SET `value` = '0' WHERE `key` = 'gluu_sso_status';");
		}
		public function gluu_db_query_update($gluu_action, $gluu_value){
			$this->db->query("UPDATE `" . DB_PREFIX . "gluu_table` SET `gluu_value` = '$gluu_value' WHERE `gluu_action` LIKE '$gluu_action'");
			$query = $this->db->query("SELECT `gluu_value` FROM `" . DB_PREFIX ."gluu_table` WHERE `gluu_action` LIKE '".$gluu_action."'");
			if($query->num_rows)
				return $gluu_value;
			else return '';
		}
		public function gluu_db_query_select($gluu_action){
			$query = $this->db->query("SELECT `gluu_value` FROM `" . DB_PREFIX ."gluu_table` WHERE `gluu_action` LIKE '".$gluu_action."'");
			if($query->num_rows)
				return $query->row['gluu_value'];
			else return '';
		}
		public function gluu_db_query_insert($gluu_action, $gluu_value){
			return $this->db->query("INSERT INTO `" . DB_PREFIX . "gluu_table` (gluu_action, gluu_value) VALUES ('$gluu_action','$gluu_value')");
		}
		public function getCustomerGroup(){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."customer_group_description ");
			return $query->rows;
		}
		public function drop_table(){
			$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX ."gluu_table`;");

		}
	}


?>
