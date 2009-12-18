<?php

class eCode
{
	private $key; 

	function __construct($senha)
	{
		// gera a chave privada
		$this->getChavePrivada($senha);
	}
	
	
	// gera a chave privada
	private function getChavePrivada($senha)
	{
		$key = 0;
		$s = sha1($senha);
		$t = strlen($s);
		$a = array();
		
		for($i=0;$i<$t;$i++)
		{
			// cod ASCII da letra atual
			$c = ord($s{$i});
			
			// soma o cod ASCII
			$key = $key + $c;
		}	
		
		$this->key = $key;
	}
	
	
	function encode($str)
	{
		$t = strlen($str);
		$a = array();
		for($i=0;$i<$t;$i++)
		{
			// cod ASCII da letra atual
			$c = ord($str{$i});
			
			// multiplica pela a chave privada
			$c = $c * $this->key;
			
			// converte para hexdecimal
			$c = dechex($c);
						
			// adiciona num array
			$a[] = $c;
		}
		
		return join($a, ',');
	}
	
	function decode($code)
	{
		$a = array();
		foreach(explode(',', $code) as $s)
		{
			// converte para decimal
			$s = hexdec($s);
			
			// divide pela chave privada
			$s = ($s / $this->key);
			
			// adiciona num array
			$a[] = chr($s);
		}

		return join($a, '');;
	}	
}
?>
