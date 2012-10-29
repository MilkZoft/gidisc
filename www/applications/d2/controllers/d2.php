<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class D2_Controller extends ZP_Controller {
	public static $blocks = array();


	public function __construct() {
		$this->Templates   = $this->core("Templates");
		$this->Bta_Model = $this->model("D2_Model");

		$this->helpers();
		
		$this->application = $this->app("d2");
		
		$this->Templates->theme();
	}
	
	public function index() {
		$this->start();
	}

	public function start() {
		SESSION("btaURL", path("d2/finished"));
		
		$vars["swf"]  = path("swf/d2/d2.php", TRUE);
		$vars["view"] = $this->view("d2", TRUE);

		$this->render("content", $vars);
	}

	public function finished() {
		#if(POST("var_kuest1")) {
			$answers1  = "1|4|6|12|17|26|31|1"; #POST("var_kuest1");
			$answers2  = "10|39|46"; #POST("var_kuest2");
			$answers3  = "14|23|39|45"; #POST("var_kuest3");
			$answers4  = "6|14|37|43"; #POST("var_kuest4");
			$answers5  = "7|14|19|29|35|37|39|42|46"; #POST("var_kuest5");
			$answers6  = "1|3|4|21|20|23|26|33|37|39|42|45"; #POST("var_kuest6");
			$answers7  = "6|12|15|17|26|31|37"; #POST("var_kuest7");
			$answers8  = "7|14|24|37|39"; #POST("var_kuest8");
			$answers9  = "14|18|21"; #POST("var_kuest9");
			$answers10 = "4|12|45|17|25|29"; #POST("var_kuest10");
			$answers11 = "29|47"; #POST("var_kuest11");
			$answers12 = "1|9|36|39|45"; #POST("var_kuest12");
			$answers13 = "12|18|25|29"; #POST("var_kuest13");
			$answers14 = "29|36|37|39|41|46|47"; #POST("var_kuest14");

			$parts1  = array_values(array_diff(explode("|", $answers1),  array("")));
			$parts2  = array_values(array_diff(explode("|", $answers2),  array("")));
			$parts3  = array_values(array_diff(explode("|", $answers3),  array("")));
			$parts4  = array_values(array_diff(explode("|", $answers4),  array("")));
			$parts5  = array_values(array_diff(explode("|", $answers5),  array("")));
			$parts6  = array_values(array_diff(explode("|", $answers6),  array("")));
			$parts7  = array_values(array_diff(explode("|", $answers7),  array("")));
			$parts8  = array_values(array_diff(explode("|", $answers8),  array("")));
			$parts9  = array_values(array_diff(explode("|", $answers9),  array("")));
			$parts10 = array_values(array_diff(explode("|", $answers10), array("")));
			$parts11 = array_values(array_diff(explode("|", $answers11), array("")));
			$parts12 = array_values(array_diff(explode("|", $answers12), array("")));
			$parts13 = array_values(array_diff(explode("|", $answers13), array("")));
			$parts14 = array_values(array_diff(explode("|", $answers14), array("")));

			$last1  = end($parts1);
			$last2  = end($parts2);
			$last3  = end($parts3);
			$last4  = end($parts4);
			$last5  = end($parts5);
			$last6  = end($parts6);
			$last7  = end($parts7);
			$last8  = end($parts8);
			$last9  = end($parts9);
			$last10 = end($parts10);
			$last11 = end($parts11);
			$last12 = end($parts12);
			$last13 = end($parts13);
			$last14 = end($parts14);
		
			$t1  = sizeof($parts1); 
			$t2  = sizeof($parts2);
			$t3  = sizeof($parts3);
			$t4  = sizeof($parts4);
			$t5  = sizeof($parts5);
			$t6  = sizeof($parts6);
			$t7  = sizeof($parts7);
			$t8  = sizeof($parts8);
			$t9  = sizeof($parts9);
			$t10 = sizeof($parts10);
			$t11 = sizeof($parts11);
			$t12 = sizeof($parts12);
			$t13 = sizeof($parts13);
			$t14 = sizeof($parts14); 

			$corrects1  = array("1", "4", "6", "12", "17", "26", "31", "46");
			$corrects2  = array("7", "24", "39", "46");
			$corrects3  = array("1", "9", "14", "16", "23", "26", "39", "43", "45"); 
			$corrects4  = array("6", "14", "17", "31", "37", "43");
			$corrects5  = array("7", "14", "16", "19", "29", "33", "37", "39", "41", "42", "46");
			$corrects6  = array("1", "3", "4", "16", "20", "21", "23", "26", "37", "39", "41", "42", "45");
			$corrects7  = array("6", "12", "15", "17", "26", "31", "37", "43");
			$corrects8  = array("7", "14", "24", "35", "37", "39", "41");
			$corrects9  = array("13", "14", "16", "18", "21", "23", "36", "39", "41", "43", "45");
			$corrects10 = array("4", "12", "17", "25", "26", "29", "45");
			$corrects11 = array("7", "14", "16", "19", "24", "29", "35", "47");
			$corrects12 = array("1", "9", "16", "36", "39", "45");
			$corrects13 = array("12", "15", "17", "25", "29");
			$corrects14 = array("7", "16", "19", "29", "37", "39", "41", "47");

			$oe1  = sizeof($corrects1)  - sizeof($parts1);  $ce1  = 0;
			$oe2  = sizeof($corrects2)  - sizeof($parts2);  $ce2  = 0;
			$oe3  = sizeof($corrects3)  - sizeof($parts3);  $ce3  = 0;
			$oe4  = sizeof($corrects4)  - sizeof($parts4);  $ce4  = 0;
			$oe5  = sizeof($corrects5)  - sizeof($parts5);  $ce5  = 0;
			$oe6  = sizeof($corrects6)  - sizeof($parts6);  $ce6  = 0;
			$oe7  = sizeof($corrects7)  - sizeof($parts7);  $ce7  = 0;
			$oe8  = sizeof($corrects8)  - sizeof($parts8);  $ce8  = 0;
			$oe9  = sizeof($corrects9)  - sizeof($parts9);  $ce9  = 0;
			$oe10 = sizeof($corrects10) - sizeof($parts10); $ce10 = 0;
			$oe11 = sizeof($corrects11) - sizeof($parts11); $ce11 = 0;
			$oe12 = sizeof($corrects12) - sizeof($parts12); $ce12 = 0;
			$oe13 = sizeof($corrects13) - sizeof($parts13); $ce13 = 0;
			$oe14 = sizeof($corrects14) - sizeof($parts14); $ce14 = 0; 

			for($i = 0; $i <= count($corrects1) - 1; $i++) {
				if(isset($parts1[$i]) and !in_array($parts1[$i], $corrects1)) {
					$ce1++;				
				} 
			}
			
			for($i = 0; $i <= count($corrects2) - 1; $i++) {
				if(isset($parts2[$i]) and !in_array($parts2[$i], $corrects2)) {
					$ce2++;
				} 
			}

			for($i = 0; $i <= count($corrects3) - 1; $i++) {
				if(isset($parts3[$i]) and !in_array($parts3[$i], $corrects3)) {
					$ce3++;
				} 
			}
		
			for($i = 0; $i <= count($corrects4) - 1; $i++) {
				if(isset($parts4[$i]) and !in_array($parts4[$i], $corrects4)) {
					$ce4++;
				} 
			}

			for($i = 0; $i <= count($corrects5) - 1; $i++) {
				if(isset($parts5[$i]) and !in_array($parts5[$i], $corrects5)) {
					$ce5++;	
				} 
			}

			for($i = 0; $i <= count($corrects6) - 1; $i++) {
				if(isset($parts6[$i]) and !in_array($parts6[$i], $corrects6)) {
					$ce6++;
				} 
			}

			for($i = 0; $i <= count($corrects7) - 1; $i++) {
				if(isset($parts7[$i]) and !in_array($parts7[$i], $corrects7)) {	
					$ce7++;
				} 
			}

			for($i = 0; $i <= count($corrects8) - 1; $i++) {
				if(isset($parts8[$i]) and !in_array($parts8[$i], $corrects8)) {
					$ce8++;
				} 
			}

			for($i = 0; $i <= count($corrects9) - 1; $i++) {
				if(isset($parts9[$i]) and !in_array($parts9[$i], $corrects9)) {
					$ce9++;
				} 
			}

			for($i = 0; $i <= count($corrects10) - 1; $i++) {
				if(isset($parts10[$i]) and !in_array($parts10[$i], $corrects10)) {
					$ce10++;
				} 
			}

			for($i = 0; $i <= count($corrects11) - 1; $i++) {
				if(isset($parts11[$i]) and !in_array($parts11[$i], $corrects11)) {
					$ce11++;
				} 
			}

			for($i = 0; $i <= count($corrects12) - 1; $i++) {
				if(isset($parts12[$i]) and !in_array($parts12[$i], $corrects12)) {
					$ce12++;
				} 
			}

			for($i = 0; $i <= count($corrects13) - 1; $i++) {
				if(isset($parts13[$i]) and !in_array($parts13[$i], $corrects13)) {
					$ce13++;
				} 
			}

			for($i = 0; $i <= count($corrects14) - 1; $i++) {
				if(isset($parts14[$i]) and !in_array($parts14[$i], $corrects14)) {
					$ce14++;
				} 
			}

			$tw  = $t1  + $t2  + $t3  + $t4  + $t5  + $t6  + $t7  + $t8  + $t9  + $t10  + $t11  + $t12  + $t13  + $t14;
			$toe = $oe1 + $oe2 + $oe3 + $oe4 + $oe5 + $oe6 + $oe7 + $oe8 + $oe9 + $oe10 + $oe11 + $oe12 + $oe13 + $oe14;
			$tce = $ce1 + $ce2 + $ce3 + $ce4 + $ce5 + $ce6 + $ce7 + $ce8 + $ce9 + $ce10 + $ce11 + $ce12 + $ce13 + $ce14;
			$te  = $toe + $tce;
			$tn  = $last1 + $last2 + $last3 + $last4 + $last5 + $last6 + $last7 + $last8 + $last9 + $last10 + $last11 + $last12 + $last13 + $last14;

		#}
	}
}