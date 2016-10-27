<?php

if (!class_exists("InvStringDynArray")) {
/**
 * InvStringDynArray
 */
class InvStringDynArray {
}}

if (!class_exists("IWSDLPublishservice")) {
/**
 * IWSDLPublishservice
 *
 */
class IWSDLPublishservice extends SoapClient {
	/**
	 * Default class map for wsdl=>php
	 * @access private
	 * @var array
	 */
	private static $classmap = array(
		"InvStringDynArray" => "InvStringDynArray",
	);

	/**
	 * Constructor using wsdl location and options array
	 * @param string $wsdl WSDL location for this service
	 * @param array $options Options for the SoapClient
	 */
	public function __construct($wsdl="http://webservice.dkvistun.is/DemoDev/dkwsitemscgi.exe/wsdl/IWSDLPublish", $options=array()) {
		foreach(self::$classmap as $wsdlClassName => $phpClassName) {
		    if(!isset($options['classmap'][$wsdlClassName])) {
		        $options['classmap'][$wsdlClassName] = $phpClassName;
		    }
		}
		parent::__construct($wsdl, $options);
	}

	/**
	 * Checks if an argument list matches against a valid argument type list
	 * @param array $arguments The argument list to check
	 * @param array $validParameters A list of valid argument types
	 * @return boolean true if arguments match against validParameters
	 * @throws Exception invalid function signature message
	 */
	public function _checkArguments($arguments, $validParameters) {
		$variables = "";
		foreach ($arguments as $arg) {
		    $type = gettype($arg);
		    if ($type == "object") {
		        $type = get_class($arg);
		    }
		    $variables .= "(".$type.")";
		}
		if (!in_array($variables, $validParameters)) {
		    throw new Exception("Invalid parameter types: ".str_replace(")(", ", ", $variables));
		}
		return true;
	}

	/**
	 * Service Call: GetPortTypeList
	 * @return 
	 * @throws Exception invalid function signature message
	 */
	public function GetPortTypeList() {
		return $this->__soapCall("GetPortTypeList", array());
	}


	/**
	 * Service Call: GetWSDLForPortType
	 * @return 
	 * @throws Exception invalid function signature message
	 */
	public function GetWSDLForPortType() {
		return $this->__soapCall("GetWSDLForPortType", array());
	}


	/**
	 * Service Call: GetTypeSystemsList
	 * @return 
	 * @throws Exception invalid function signature message
	 */
	public function GetTypeSystemsList() {
		return $this->__soapCall("GetTypeSystemsList", array());
	}


	/**
	 * Service Call: GetXSDForTypeSystem
	 * @return 
	 * @throws Exception invalid function signature message
	 */
	public function GetXSDForTypeSystem() {
		return $this->__soapCall("GetXSDForTypeSystem", array());
	}


}}

?>