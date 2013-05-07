<?php

class Tok3nApiV1{
		
		var $tok3nSecretKey = "";
		var $tok3nPublicKey = "";
		var $tok3nURL = "http://my.tok3n.com";
		
		function Tok3nApiV1($secret, $public){
			$this->tok3nSecretKey = $secret;
			$this->tok3nPublicKey = $public;
		}
	
		function getRemote($url){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			return curl_exec($ch); 
		}
		
		/*
			API V1 Methods
		*/
		function getActiveSession(){
			$url = $this->tok3nURL."/api/v1/getSession?secretKey=".$this->tok3nSecretKey;
			return $this->getRemote($url);
		}
		
		function getAccesUrl($callback,$callbackdata){
			$session = $this->getActiveSession();
			return $this->tok3nURL."/login.do?publicKey=".$this->tok3nPublicKey."&session=$session&callbackurl=$callback&callbackdata=$callbackdata";
		}
		
		function getJsClientUrl($action="Tok3n"){
			 $url = $this->tok3nURL."/api/v1/client.js?publicKey=".$this->tok3nPublicKey."&actionName=$action";
			 return $url;
		}
		
		function validateOTP($userKey, $otp){
			$url = $this->tok3nURL."/api/v1/otpValid?SecretKey=".$this->tok3nSecretKey."&UserKey=$userKey&otp=$otp";
			
			$output = $this->getRemote($url);
						
			$data = json_decode($output);	
			if ($data->Error != ""){
				return "ERROR:".$data->Error;
			}else{
				return $data->Result;
			}
		}
		
		
	}

?>