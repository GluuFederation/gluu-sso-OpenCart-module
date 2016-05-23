<?php

/*
 * Module controller for frontend page
*/
class ControllerModuleGluuSSO242 extends Controller
{

    /*
     * Creating customer
    */
    public function add_customer($data)
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
        return false;
    }

    /*
     * Generating random hash by lenght
    */
    public function generate_hash ($length)
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

        // Done
        return $hash;
    }

    /*
     * Logining customer
    */
    public function login($customer_id)
    {
        // Retrieve the customer
        $result = $this->db->query ("SELECT email FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . intval ($customer_id) . "'")->row;
        if (is_array ($result) && ! empty ($result['email']))
        {
            // Login
            if ($this->customer->login($result['email'], '', true))
            {
                unset($this->session->data['guest']);

                // Default Shipping Address
                $this->load->model('account/address');

                if ($this->config->get('config_tax_customer') == 'payment')
                {
                    $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                if ($this->config->get('config_tax_customer') == 'shipping')
                {
                    $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                // Add to activity log
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                );

                $this->model_account_activity->addActivity('login', $activity_data);

                // Logged in
                return true;
            }
        }

        // Not logged in
        return false;
    }

    /*
     * Checking customer by email
    */
    public function get_by_email ($email)
    {
        $sql = "SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE email  = '" . $this->db->escape ($email) . "'";
        $result = $this->db->query ($sql)->row;
        if (is_array ($result) && !empty ($result ['customer_id']))
        {
            return $result ['customer_id'];
        }

        // Not found.
        return false;
    }

    
}

?>