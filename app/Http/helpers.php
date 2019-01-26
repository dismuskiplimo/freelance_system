<?php
	function containsEmail($string){
		$pattern = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i';
		preg_match($pattern, $string, $matches);

		return empty($matches) ? false : true;
	}

	function containsPhoneNumber($string){
		$pattern = '/\d{6,}/';
		preg_match($pattern, $string, $matches);

		return empty($matches) ? false : true;
	}

	function containsSocial($string){
		$pattern = '/(skype|facebook|fb|email|e-mail|mail|messenger|whatsapp|twitter|instagram|linkedin|pintrest|tumbler|gmail|yahoo|address|number|phone)/i';
		preg_match($pattern, $string, $matches);

		return empty($matches) ? false : true;
	}

	function messageIsClean($string){
		if(containsEmail($string) || containsSocial($string) || containsPhoneNumber($string)){
			return false;
		}

		return true;
	}




?>