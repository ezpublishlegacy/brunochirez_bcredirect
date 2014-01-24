<?php

class BcRedirectOperator {
    function __construct() {
        $this->http_codes = array(
            301,
            302,
            303
        );
    }

    function operatorList() {
        return array('redirect');
    }

    function namedParameterPerOperator() {
        return true;
    }

    function namedParameterList() {
        return array(
			'redirect' => array('http_code' => array('type' => 'integer', 'required' => false, 'default' => 301))
        );
    }

    function modify($tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement) {
        switch($operatorName) {
            case 'redirect':
			    $http_code = $namedParameters['http_code'];
                if(!in_array($http_code, $this->http_codes)) {
                    eZExecution::cleanExit();
                }
                

                $redirectUri = $operatorValue;
                eZURI::transformURI($redirectUri);
                eZHTTPTool::redirect($redirectUri, array(), $http_code);
                eZExecution::cleanExit();
            break;
            default:
                $tpl->warning($operatorName, "Unknown input type '$operatorName'", $placement);
        }
    }
}
