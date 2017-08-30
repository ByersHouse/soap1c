<?php

function Connect1C(){
    if (!function_exists('is_soap_fault')){
      print 'Не настроен web сервер. Не найден модуль php-soap.';
      return false;
    }
    try {
        
        /*http://192.168.9.48/1C/ws/users.1cws?wsdl*/
      $cl = new SoapClient('http://192.168.9.48:8243/1C/ws/users.1cws?wsdl',
                               array('login'          => 'admin',
                                     'password'       => 'admin',
                                     'soap_version'   => SOAP_1_2,
                                     'cache_wsdl'     => WSDL_CACHE_NONE, //WSDL_CACHE_MEMORY, //, WSDL_CACHE_NONE, WSDL_CACHE_DISK or WSDL_CACHE_BOTH
                                     'exceptions'     => true,
                                     'trace'          => 1));
    }catch(SoapFault $e) {
      trigger_error('Ошибка подключения или внутренняя ошибка сервера. Не удалось связаться с базой 1С.',E_USER_ERROR ); //E_ERROR
      var_dump($e);
    }
    //echo 'Раз';
    if (is_soap_fault($cl)){
      trigger_error('Ошибка подключения или внутренняя ошибка сервера. Не удалось связаться с базой 1С.', E_USER_ERROR); //E_ERROR
      return false;
    }
    return $cl;
}
 
function GetData($idc, $txt){
      if (is_object($idc)){
 
        try {
          $par = array('zapros' => $txt);
          //var_dump($par);
        // $ret1c = $idc->hellobaza($par);
          
          $ret1c = $idc->Test($par);
        } catch (SoapFault $e) {
                      echo "ОШИБКА!!! </br>";
           var_dump($e);
        }   
      }
      else{
        echo 'Не удалось подключиться к 1С';
        var_dump($idc);
      }
    return $ret1c;
}
 
  $idc = Connect1C();
  $ret1c = GetData($idc, "привет");
  //var_dump($ret1c);
  $aa=$ret1c->return;
  echo "!!$aa!!";
