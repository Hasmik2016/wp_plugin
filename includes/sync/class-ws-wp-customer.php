<?php


class WsWpCustomerExporter {
    


    public static $customer_mappings;

    public static function email_exists( $email , $item ) {
        if ( $user = get_user_by('email', $email) ){

            return self::update_customer( $user->ID , $email ,$item );
        }else{

            return self::create_customer( $email , $item );
        }



    }

    /**
     *
     */
    public static function update_customer( $u_id , $email_address ,$item ){

        $username = explode('@', $email_address)[0];
        $password = wp_generate_password(8, false);
        if (self::should_overwrite('username') == '1') {
            wp_update_user(array('ID' => $u_id, 'user_login' => $username));
        }
        if (self::should_overwrite('password') == '1') {
            wp_update_user(array('ID' => $u_id, 'user_pass' => $password));
        }
        if (self::should_overwrite('b_name') == '1' && isset($item->Name)) {
            update_user_meta($u_id, "billing_first_name", $item->Name);
        }
        if (self::should_overwrite('b_address1') == '1' && isset($item->Address1)) {
            update_user_meta($u_id, "billing_address_1", $item->Address1);
        }
        if (self::should_overwrite('b_address2') == '1' && isset($item->Address2)) {
            update_user_meta($u_id, "billing_address_2", $item->Address2);
        }
        if (self::should_overwrite('b_city') == '1' && isset($item->City)) {
            update_user_meta($u_id, "billing_city", $item->City);
        }
        if (self::should_overwrite('b_zip_code') == '1' && isset($item->ZipCode)) {
            update_user_meta($u_id, "billing_postcode", $item->ZipCode);
        }
        if (self::should_overwrite('phone') == '1' && isset($item->Phone)) {
            update_user_meta($u_id, "billing_phone", $item->Phone);
        }
        ////
        if (self::should_overwrite('s_name') == '1' && isset($item->Name)) {
            update_user_meta($u_id, "shipping_first_name", $item->Name);
        }
        if (self::should_overwrite('s_address1') == '1' && isset($item->Address1)) {
            update_user_meta($u_id, "shipping_address_1", $item->Address1);
        }
        if (self::should_overwrite('s_address2') == '1' && isset($item->Address2)) {
            update_user_meta($u_id, "shipping_address_2", $item->Address2);
        }
        if (self::should_overwrite('s_city') == '1' && isset($item->City)) {
            update_user_meta($u_id, "shipping_city", $item->City);
        }
        if (self::should_overwrite('s_zip_code') == '1' && isset($item->ZipCode)) {
            update_user_meta($u_id, "shipping_postcode", $item->ZipCode);
        }
        if (self::should_overwrite('country_name') == '1' && isset($item->CountryName)) {
            update_user_meta($u_id, "shipping_country", $item->CountryName);
        }

        return true;
    }

    public static function create_customer($email_address ,$item ){

        $username = explode('@', $email_address)[0];
        $password = wp_generate_password(8, false);
        $user_id = wc_create_new_customer($email_address, $username, $password);
        if ($user_id) {

            if (self::should_skip('b_name') == '0') {
                update_user_meta($user_id, "billing_first_name", (isset($item->Name)) ? $item->Name : '');
            } elseif(self::should_skip('b_name') == '1') {
                update_user_meta($user_id, "billing_first_name", '');
            }

            if (self::should_skip('b_address1') == '0') {
                update_user_meta($user_id, "billing_address_1", (isset($item->Address1)) ? $item->Address1 : '');
            } elseif(self::should_skip('b_address1') == '1') {
                update_user_meta($user_id, "billing_address_1", '');
            }

            if (self::should_skip('b_address2') == '0') {
                update_user_meta($user_id, "billing_address_2", (isset($item->Address2)) ? $item->Address2 : '');
            } elseif(self::should_skip('b_address2') =='1') {
                update_user_meta($user_id, "billing_address_2", '');
            }

            if (self::should_skip('b_city')== '0') {
                update_user_meta($user_id, "billing_city", (isset($item->City)) ? $item->City : '');
            } elseif(self::should_skip('b_city')== '1') {
                update_user_meta($user_id, "billing_city", '');
            }

            if (self::should_skip('b_zip_code') == '0') {
                update_user_meta($user_id, "billing_postcode", (isset($item->ZipCode)) ? $item->ZipCode : '');
            } elseif(self::should_skip('b_zip_code') == '1') {
                update_user_meta($user_id, "billing_postcode", '');
            }

            if (self::should_skip('phone') == '0') {
                update_user_meta($user_id, "billing_phone", (isset($item->Phone)) ? $item->Phone : '');
            } elseif(self::should_skip('phone') == '1') {
                update_user_meta($user_id, "billing_phone", '');
            }

            /////

            if (self::should_skip('s_name') == '0') {
                update_user_meta($user_id, "shipping_first_name", (isset($item->Name)) ? $item->Name : '');
            } elseif(self::should_skip('s_name') == '1') {
                update_user_meta($user_id, "shipping_first_name", '');
            }

            if (self::should_skip('s_address1') == '0') {
                update_user_meta($user_id, "shipping_address_1", (isset($item->Address1)) ? $item->Address1 : '');
            } elseif(self::should_skip('s_address1') == '1') {
                update_user_meta($user_id, "shipping_address_1", '');
            }

            if (self::should_skip('s_address2') == '0') {
                update_user_meta($user_id, "shipping_address_2", (isset($item->Address2)) ? $item->Address2 : '');
            } elseif(self::should_skip('s_address2') == '1') {
                update_user_meta($user_id, "shipping_address_2", '');
            }

            if (self::should_skip('s_city') == '0') {
                update_user_meta($user_id, "shipping_city", (isset($item->City)) ? $item->City : '');
            } elseif(self::should_skip('s_city') == '0') {
                update_user_meta($user_id, "shipping_city", '');
            }

            if (self::should_skip('s_zip_code') == '0') {
                update_user_meta($user_id, "shipping_postcode", (isset($item->ZipCode)) ? $item->ZipCode : '');
            } elseif(self::should_skip('s_zip_code') == '1') {
                update_user_meta($user_id, "shipping_postcode", '');
            }

            if (self::should_skip('country_name') == '0') {
                update_user_meta($user_id, "shipping_country", (isset($item->CountryName)) ? $item->CountryName : '');
            } elseif(self::should_skip('country_name') == '1') {
                update_user_meta($user_id, "shipping_country", '');
            }

            return true;
        }
    }

    public static function create_customer_from_item( $item )
    {
        if($item){
            $email_address = $item->Email;
            if (!empty($email_address)) {
                $result = self::email_exists( $email_address , $item);

                return $result;
            }
        }else{
            return false;
        }

    }

    public static function current_date() {
        return date( 'd/m/y H:i:s' );
    }

    public static function get_last_sync_id_customer() {
        $customer_id = get_option( 'ws_wp_last_sync_id_customer', 0 );

        return $customer_id;
    }

    public static function update_last_sync_id_customer( $id ) {
        update_option( 'ws_wp_last_sync_id_customer', $id );
    }

    public static function set_mappings() {
        self::set_customer_mappings();
    }

    public static function get_customer_mappings() {
        return self::$customer_mappings;
    }

    public static function set_customer_mappings() {
        global $WsWp_i18n;
        self::$customer_mappings = array(
            'recordId'          => array(
                'name'        => __( 'Unique item id', $WsWp_i18n->get_domain() ),
                'hide'        => 1,
                'options'     => array(
                    'RecordId' => 1
                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
            ),

            'username'              => array(
                'name'        => __( 'Customer Userame', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 0,
                'skip'        => 1
            ),

            'password'              => array(
                'name'        => __( 'Customer Password', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 0,
                'skip'        => 1
            ),

            'b_name'              => array(
                'name'        => __( 'Billing Customer Name', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),

            'b_address1'              => array(
                'name'        => __( 'Billing Address1', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),

            'b_address2'              => array(
                'name'        => __( 'Billing Address2', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),
            'b_city'       => array(
                'name'        => __( 'Billing City', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),

            'b_zip_code'       => array(
                'name'        => __( 'Billing ZipCode', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),



            'phone'       => array(
                'name'        => __( 'Phone', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),

            's_name'              => array(
                'name'        => __( 'Shipping Customer  Name', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),

            's_address1'              => array(
                'name'        => __( 'Shipping Address1', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),

            's_address2'              => array(
                'name'        => __( 'Shipping Address2', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,
                ),
                'overwrite'   => 0,
                'd_overwrite' => 1,
                'skip'        => 0
            ),
            's_city'       => array(
                'name'        => __( 'Shipping City', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),

            's_zip_code'       => array(
                'name'        => __( 'Shipping ZipCode', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),
            'country_name'       => array(
                'name'        => __( 'CountryName', $WsWp_i18n->get_domain() ),
                'options'     => array(
                    'Description'  => 1,

                ),
                'overwrite'   => 1,
                'd_overwrite' => 0,
                'skip'        => 0
            ),




        );

        if ( self::$customer_mappings ) {
            foreach ( self::$customer_mappings as $key => $item ) {
                if ( isset( $item['hide'] ) && ( $item['hide'] == 1 ) ) {
                    continue;
                }
                $option = get_option( 'ws_wp_customer_mappings_' . $key );
                if ( $option ) {
                    $opt = self::$customer_mappings[ $key ];
                    foreach ( $option as $k => $value ) {
                        if ( isset( $opt[ $k ] ) ) {
                            if ( is_array( $value ) ) {
                                if ( $value ) {
                                    foreach ( $value as $sk => $svalue ) {
                                        if ( isset( $opt[ $k ][ $sk ] ) ) {
                                            $opt[ $k ][ $sk ] = $svalue;
                                        }
                                    }
                                }
                            } else {
                                $opt[ $k ] = $value;
                            }
                        }
                    }
                    self::$customer_mappings[ $key ] = $opt;
                }
            }
        }

    }



    public static function sync_item( $item ) {

        self::set_customer_mappings();
        if(self::create_customer_from_item( $item )){
            return true;
        }else{
            return false;
        }
    }





    public static function get_selected_option( $name ) {
        $customer_mappings = self::$customer_mappings;
        if ( $customer_mappings ) {
            if ( isset( $customer_mappings[ $name ] ) ) {
                if ( isset( $customer_mappings[ $name ]['options'] ) ) {
                    foreach ( $customer_mappings[ $name ]['options'] as $key => $checked ) {
                        if ( $checked ) {
                            return $key;
                        }
                    }
                }
            }
        }

        return null;
    }


    protected static function should_overwrite( $name ) {
        $customer_mappings = self::$customer_mappings;
        if ( $customer_mappings ) {
            if ( isset( $customer_mappings[ $name ] ) ) {
                if ( isset( $customer_mappings[ $name ]['overwrite'] ) && 1 == $customer_mappings[ $name ]['overwrite'] ) {
                    return 1;
                } elseif ( isset( $customer_mappings[ $name ]['overwrite'] ) && 0 == $customer_mappings[ $name ]['overwrite'] ) {
                  return 0;
                }
            }
        }

        return null;
    }



    protected static function should_skip( $name ) {
        $customer_mappings = self::$customer_mappings;
        if ( $customer_mappings ) {
            if ( isset( $customer_mappings[ $name ] ) ) {
                if ( isset( $customer_mappings[ $name ]['skip'] ) && 1 == $customer_mappings[ $name ]['skip'] ) {
                    return 1;
                } elseif ( isset( $customer_mappings[ $name ]['skip'] ) && 0 == $customer_mappings[ $name ]['skip'] ) {
                    return 0;
                }
            }
        }

        return null;
    }




}