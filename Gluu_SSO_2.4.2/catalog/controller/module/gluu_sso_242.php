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



}

?>