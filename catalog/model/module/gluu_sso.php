<?php
	
	class ModelModuleGluuSSO extends Model
	{
		public function gluu_db_query_select($gluu_action){
			$query = $this->db->query("SELECT `gluu_value` FROM `" . DB_PREFIX ."gluu_table` WHERE `gluu_action` LIKE '".$gluu_action."'");
			if($query->num_rows)
				return $query->row['gluu_value'];
			else return '';
		}
		public function getCountry_by_iso($iso_code_2) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE iso_code_2 LIKE '%" . $iso_code_2 . "%' AND status = '1'");

			return $query->row;
		}
		public function getZone($name,$country_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "_zone WHERE name LIKE '%" . $name . "%' AND country_id = '" . $country_id . "'");

			return $query->row;
		}
		public function editCustomer($customer_id,$data) {
			$this->load->model('module/gluu_sso');
			$query = '"UPDATE " . DB_PREFIX . "customer SET ';
			if($data['customer_first_name']){
				$query.= " firstname = '" .$this->db->escape($data['customer_first_name']). "',";
			}
			if($data['customer_last_name']){
				$query.= " lastname = '" .$this->db->escape($data['customer_last_name']). "',";
			}
			if($data['customer_email']){
				$query.= " email = '" .$this->db->escape($data['customer_email']). "',";
			}
			if($data['customer_telephone']){
				$query.= " telephone = '" .$this->db->escape($data['customer_telephone']). "',";
			}
			if($data['customer_fax']){
				$query.= " fax = '" .$this->db->escape($data['customer_fax']). "',";
			}
			if($data['customer_address_1']){
				$query.= " address_1 = '" .$this->db->escape($data['customer_address_1']). "',";
			}
			if($data['customer_address_2']){
				$query.= " address_2 = '" .$this->db->escape($data['customer_address_2']). "',";
			}
			if($data['customer_city']){
				$query.= " city = '" .$this->db->escape($data['customer_city']). "',";
			}
			if($data['customer_postcode']){
				$query.= " postcode = '" .$this->db->escape($data['customer_postcode']). "',";
			}
			$country_id = $this->getCountry_by_iso($data ['customer_country'])['country_id'] ? $this->getCountry_by_iso($data ['customer_country'])['country_id'] : 0;
			if($data['customer_country']){
				$query.= " country = '" .(int)$country_id. "',";
			}
			if($data['customer_zone']){
				$zone_id = $this->getZone($data ['customer_zone'],$country_id)['zone_id'] ? $this->getZone($data ['customer_zone'],$country_id)['zone_id'] : 0;
				
				$query.= " zone = '" .(int)$zone_id. "',";
			}
			if($data['customer_custom_field']){
				$query.= " custom_field = '".$this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '');
			}
			$query.= "' WHERE customer_id = '" . (int)$customer_id . "'";
			$this->db->query($query);
		}
	}
?>