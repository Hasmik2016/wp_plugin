<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://tactica.is
 * @since      1.0.0
 *
 * @package    Ws_Wp_Sync
 * @subpackage Ws_Wp_Sync/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Ws_Wp_SoapWrapper
 * @subpackage Ws_Wp_SoapWrapper/admin
 *
 */
class Ws_Wp_SoapWrapper {


	public $do_orders = false;
	public $do_products = false;
	private $soap;
	/**
	 * The soap handle
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The soap handle of the plugin
	 */
	private $sproxy;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string $name The name of this plugin.
	 * @var      string $version The version of this plugin.
	 */
	private $valid = false;

	public function __construct() {
		global $WsWp_admin, $WsWp_i18n;
		try {
			//$soap = new soapclient('http://webservice.dkvistun.is/DemoDev/dkwsitemscgi.exe/wsdl/IItemService');
			//$soap->setCredentials("ws.dev","Code2make","basic");
			/*$soap = new SoapClient("http://webservice.dkvistun.is/DemoDev/dkwsitemscgi.exe/wsdl/IItemService");*/
			/*$generator = new \Wsdl2PhpGenerator\Generator();
			$generator->generate(
				new \Wsdl2PhpGenerator\Config(array(
						'inputFile' => 'http://webservice.dkvistun.is/DemoDev/dkwsitemscgi.exe/wsdl/IItemService',
						'outputDir' => plugin_dir_path( __FILE__ ).'/tmp',
						'namespaceName' => 'urn:dkWSValueObjects'
				)));
			*/
			$config = $WsWp_admin->get_config_settings();
			if ( isset( $config->message ) ) {
				$config = $config->message;
				if ( isset( $config->api_user ) && isset( $config->api_password ) && isset( $config->api_user ) ) {
					WsWpLogger::append_dev( __( "Attempting to establish soap connection .", $WsWp_i18n->get_domain() ) );
					if ( class_exists( "SOAPClient" ) ) {
						$params      = array( "trace" => true, );
						$soap        = new SoapClient( $config->api_url . "/wsdl/IItemService", $params );
						$auth        = array(
							'Username' => $config->api_user,
							'Password' => $config->api_password,
						);
						$header      = new SoapHeader( 'urn:dkWSValueObjects', 'BasicSecurity', $auth, false );
						$headers_set = $soap->__setSoapHeaders( $header );
						if ( ! $headers_set ) {
							WsWpLogger::append_dev( __( "A problem occurred when trying to set the headers, execution stopped.", $WsWp_i18n->get_domain() ) );
							WsWpLogger::writeLogs();

							return 0;
						}
						//printr($soap->__getFunctions());
						//printr($soap->__getTypes());
						$this->soap        = $soap;
						$this->valid       = true;
						$this->do_orders   = $config->orders_active;
						$this->do_products = $config->products_active;
						//deleting error notice if happened previously
						delete_transient( 'ws_wp_api_not_return_credentials' );
						delete_transient( 'ws_wp_api_soap_disabled' );
						WsWpLogger::append_dev( __( "Soap connection established.", $WsWp_i18n->get_domain() ) );
					} else {
						$this->valid = false;
						WsWpLogger::append_auth_error( __( 'Soap is not enabled, please enable soap for the plugin to work', $WsWp_i18n->get_domain() ) );
						WsWpLogger::append_dev( __( "Soap is not enabled, please enable soap for the plugin to work.", $WsWp_i18n->get_domain() ) );
						set_transient( 'ws_wp_api_soap_disabled', true );
					}
				} else {
					$this->valid = false;
					WsWpLogger::append_auth_error( __( 'The connection string is not valid, a soap connection couldn\'t be created. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
					WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
					set_transient( 'ws_wp_api_not_return_credentials', true );
				}
				//deleting error notice if happened previously
				delete_transient( 'ws_wp_api_not_return' );
			} else {
				WsWpLogger::append_auth_error( __( 'The connection string is not valid, a soap connection couldn\'t be created. Either the api url is not added correctly, or you are not a registered client!', $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( "The connection string is not valid, a soap connection couldn't be created. Either the api url is not added correctly, or you are not a registered client!", $WsWp_i18n->get_domain() ) );
				set_transient( 'ws_wp_api_not_return', true );
			}
			//deleting error notice if happened previously
			delete_transient( 'ws_wp_dk_api_not_return' );
		} catch ( Exception $e ) {
			$this->soap  = null;
			$this->valid = false;
			WsWpLogger::append_dev( __( 'The api used by the ws-wp-sync plugin didn\'t work. It may be a temporary failure.' . PHP_EOL . ' Api Error:' . PHP_EOL, $WsWp_i18n->get_domain() ) . '<i>' . $e->getMessage() . '</i>' );
			WsWpLogger::append_auth_error( __( 'The api used by the ws-wp-sync plugin didn\'t work. It may be a temporary failure. If this message keeps showing up, you may want to contact the administrator.', $WsWp_i18n->get_domain() ) );
			set_transient( 'ws_wp_dk_api_not_return', true );
			set_transient( 'ws_wp_dk_api_error', $e->getMessage() );
		}

		//$this->sproxy = $soap->getProxy();
	}

	public function is_valid() {
		return $this->valid;
	}

	public function soap() {
		return $this->soap;
	}


	public function proxy( $action ) {
		if ( $this->is_valid() ) {
			if ( is_callable( array( $this->proxy, $action ) ) ) {
				return $this->proxy->$action();
			} else {
				return 0;
			}
		} else {
			return - 1;
		}

	}

	public function get_attachment( $attach_id ) {
		global $WsWp_i18n;
		if ( $this->is_valid() ) {
			try {
				$image = $this->soap()->GetAttachment( $attach_id );

				return $image;
			} catch ( SoapFault $fault ) {
				WsWpLogger::append_product_log( __( "Attachment threw error ", $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_item_sync_error( __( "Attachment threw error ", $WsWp_i18n->get_domain(), $WsWp_i18n->get_domain() ) );
				WsWpLogger::append_dev( __( " Error: Product Import threw error for an attachement:  ", $WsWp_i18n->get_domain() ) . PHP_EOL . __( "Fault code: ", $WsWp_i18n->get_domain() ) . $fault->faultcode . PHP_EOL . __( "Fault string: ", $WsWp_i18n->get_domain() ) . $fault->faultstring . PHP_EOL . PHP_EOL . "Error:" . $fault->getMessage() . PHP_EOL );
				WsWpLogger::writeLogs();
			}


		}
	}


}
