<?php
    $class = file_get_contents($_SERVER['DOCUMENT_ROOT']."/RServer.php");
    #$class = str_replace("\n","",$class);
    #$class = str_replace("\r","",$class);
    
    #echo $class;
    
    $pattern = "/\/\*[^\/]*\*\//im";
    preg_match_all($pattern, $class, $methods);
    #print_r($methods);
    
    $ms = [];
    foreach($methods[0] as $m){
        #echo $m."\n";
        preg_match_all("/\@[a-zA-Z]+\s[a-zA-Z]+\s[a-zA-Z]+/",$m,$data);
        $ms[]=$data;
    }
    
    #print_r($ms);
    
/**
 * 
 * 
 * #CLASSNAME# = RServices
 * #LOCATION# = "http://services.retarcorp.com/server.php"
 * #MESSAGES# = 
 * <message name='#METHOD_NAME#Request'>
      <part name='#ARGUMENT_NAME#' type='xsd:#ARGUMENT_TYPE' />
      
    </message>
    
    <message name='#METHOD_NAME#Response'>
      <part name='data' type='xsd:#METHOD_RETURN_TYPE#'/>
    </message>
 * 
 * #BINDINGOPERATIONS# = 
 * <operation name='#METHOD_NAME#'> 
        <input> 
           <soap:body use='encoded' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/> 
        </input> 
        
        <output> 
           <soap:body use='encoded' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/> 
        </output> 
    </operation>
 *  
 * 
 * 
 * #OPERATIONS# = 
 * <operation name='#METHOD_NAME#'> 
        <input message='tns:#METHOD_NAME#Request'/> 
        <output message='tns:#METHOD_NAME#Response'/> 
    </operation>
 * 
 * */

$WSDLTemplate = "<?xml version='1.0' encoding='UTF-8' ?> 
<definitions name='#CLASSNAME#' targetNamespace='http://example.org/'  xmlns:tns='http://example.org/'  xmlns:soap='http://schemas.xmlsoap.org/wsdl/soap/'  xmlns:xsd='http://www.w3.org/2001/XMLSchema'  xmlns:soapenc='http://schemas.xmlsoap.org/soap/encoding/'  xmlns:wsdl='http://schemas.xmlsoap.org/wsdl/'  xmlns='http://schemas.xmlsoap.org/wsdl/'> 
    #MESSAGES#

    <portType name='#CLASSNAME#PortType'> 
        #OPERATIONS#
    </portType> 
    
    <binding name='#CLASSNAME#Binding' type='tns:#CLASSNAME#PortType'> 
        <soap:binding style='rpc' transport='http://schemas.xmlsoap.org/soap/http'/> 
        #BINDINGOPERATIONS#
    </binding>
    
    <service name='#CLASSNAME#'> 
        <port name='#CLASSNAME#Port' binding='#CLASSNAME#Binding'> 
            <soap:address location='#SERVERLOCATION#'/>
        </port> 
    </service>

</definitions>";



$WSDLResult = str_replace("#CLASSNAME#","RServer",$WSDLTemplate);
$WSDLResult = str_replace("#SERVERLOCATION#","http://services.retarcorp.com/server.php",$WSDLResult);

$messages = "";
$operations = "";
$bindingoperations = "";

$operationsTemplate = "

        <operation name='#METHOD_NAME#'> 
            <input message='tns:#METHOD_NAME#Request'/> 
            <output message='tns:#METHOD_NAME#Response'/> 
        </operation>
    ";
    
$bindingTemplate = "

        <operation name='#METHOD_NAME#'> 
            <input> 
               <soap:body use='encoded' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/> 
            </input> 
            
            <output> 
               <soap:body use='encoded' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/> 
            </output> 
        </operation>
    ";
foreach($ms as $m){
    $method= "";
    $returnType = "";
    $ops = [];
    $parts = "";
    foreach($m[0] as $line){
        $line = explode(" ",$line);
        switch($line[0]){
            case "@method":{
                $method = $line[2];
                $returnType = $line[1];
                break;
            }
            case "@param":{
                $ops[] = $line[1];
                $parts.="\n\t<part name='{$line[2]}' type='xsd:{$line[1]}' />";
                break;
            }
        }
    }
    
    $operations.=str_replace("#METHOD_NAME#",$method, $operationsTemplate);
    $bindingoperations.=str_replace("#METHOD_NAME#",$method, $bindingTemplate);
    
    
    
    $messages.="
    
    <message name='".$method."Request'>$parts
    </message>
    
    <message name='".$method."Response'>
        <part name='data' type='xsd:".$returnType."'/>
    </message>";
}

$WSDLResult = str_replace("#MESSAGES#",$messages, $WSDLResult);
$WSDLResult = str_replace("#OPERATIONS#",$operations, $WSDLResult);
$WSDLResult = str_replace("#BINDINGOPERATIONS#",$bindingoperations, $WSDLResult);



#header("Content-Type: text/xml");
file_put_contents($_SERVER['DOCUMENT_ROOT']."/definitions.wsdl",$WSDLResult);
#echo $WSDLResult;
