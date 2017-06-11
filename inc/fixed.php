<?php
function fixed($str){
//checkver($str);
	if (strpos($str,"{#showad:")!==false){
		$n=count(explode("{#showad:",$str));//循环之前取值
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#showad:","}");
			if ($cs<>''){$str=str_replace("{#showad:".$cs."}",showad($cs),$str);}
		}
	}
	if (strpos($str,"{#showzx:")!==false){
		$n=count(explode("{#showzx:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#showzx:","}");
			if ($cs<>''){$str=str_replace("{#showzx:".$cs."}",showzx($cs),$str);}
		}
	}
	if (strpos($str,"{#showzs:")!==false){
		$n=count(explode("{#showzs:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#showzs:","}");
			if ($cs<>''){$str=str_replace("{#showzs:".$cs."}",showzs($cs),$str);}
		}
	}

	if (strpos($str,"{#showannounce:")!==false){
		$n=count(explode("{#showannounce:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#showannounce:","}");
			if ($cs<>''){$str=str_replace("{#showannounce:".$cs."}",showannounce($cs),$str);}
		}
	}

	if (strpos($str,"{#showcookiezs:")!==false){
		$n=count(explode("{#showcookiezs:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#showcookiezs:","}");
			if ($cs<>''){$str=str_replace("{#showcookiezs:".$cs."}",showcookieszs($cs),$str);}
		}
	}

	if (strpos($str,"{#zsclass:")!==false){
		$n=count(explode("{#zsclass:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#zsclass:","}");
			$str=str_replace("{#zsclass:".$cs."}",showzsclass($cs),$str);
		}
	}
	if (strpos($str,"{#keyword:")!==false){
		$n=count(explode("{#keyword:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#keyword:","}");
			$str=str_replace("{#keyword:".$cs."}",showkeyword($cs),$str);
		}
	}
	if (strpos($str,"{#province:")!==false){
		$n=count(explode("{#province:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#province:","}");
			$str=str_replace("{#province:".$cs."}",showprovince($cs),$str);
		}
	}
	if (strpos($str,"{#sitecount:")!==false){
		$n=count(explode("{#sitecount:",$str));
		for ($i=1;$i<$n;$i++){
			$cs=strbetween($str,"{#sitecount:","}");
			$str=str_replace("{#sitecount:".$cs."}",sitecount($cs),$str);
		}
	}
	return $str;
}
?>