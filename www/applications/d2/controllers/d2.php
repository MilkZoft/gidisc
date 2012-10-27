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
			$answers1  = "1|4|6|12|17|26|31|43"; #POST("var_kuest1");
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

			$parts1  = explode("|", $answers1);
			$parts2  = explode("|", $answers2);
			$parts3  = explode("|", $answers3);
			$parts4  = explode("|", $answers4);
			$parts5  = explode("|", $answers5);
			$parts6  = explode("|", $answers6);
			$parts7  = explode("|", $answers7);
			$parts8  = explode("|", $answers8);
			$parts9  = explode("|", $answers9);
			$parts10 = explode("|", $answers10);
			$parts11 = explode("|", $answers11);
			$parts12 = explode("|", $answers12);
			$parts13 = explode("|", $answers13);
			$parts14 = explode("|", $answers14);

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

			$total = $t1 + $t2 + $t3 + $t4 + $t5 + $t6 + $t7 + $t8 + $t9 + $t10 + $t11 + $t12 + $t13 + $t14; 

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

			$oe1  = sizeof(array_diff($corrects1,  $parts1));  $ce1  = 0; $te1  = 0;
			$oe2  = sizeof(array_diff($corrects2,  $parts2));  $ce2  = 0; $te2  = 0;
			$oe3  = sizeof(array_diff($corrects3,  $parts3));  $ce3  = 0; $te3  = 0;
			$oe4  = sizeof(array_diff($corrects4,  $parts4));  $ce4  = 0; $te4  = 0;
			$oe5  = sizeof(array_diff($corrects5,  $parts5));  $ce5  = 0; $te5  = 0;
			$oe6  = sizeof(array_diff($corrects6,  $parts6));  $ce6  = 0; $te6  = 0;
			$oe7  = sizeof(array_diff($corrects7,  $parts7));  $ce7  = 0; $te7  = 0;
			$oe8  = sizeof(array_diff($corrects8,  $parts8));  $ce8  = 0; $te8  = 0;
			$oe9  = sizeof(array_diff($corrects9,  $parts9));  $ce9  = 0; $te9  = 0;
			$oe10 = sizeof(array_diff($corrects10, $parts10)); $ce10 = 0; $te10 = 0;
			$oe11 = sizeof(array_diff($corrects11, $parts11)); $ce11 = 0; $te11 = 0;
			$oe12 = sizeof(array_diff($corrects12, $parts12)); $ce12 = 0; $te12 = 0;
			$oe13 = sizeof(array_diff($corrects13, $parts13)); $ce13 = 0; $te13 = 0;
			$oe14 = sizeof(array_diff($corrects14, $parts14)); $ce14 = 0; $te14 = 0;
			die(var_dump($oe3));
			for($i = 0; $i <= count($corrects1) - 1; $i++) {
				if(isset($parts1[$i])) {
					if($parts1[$i] != $corrects1[$i]) {
						$ce1++;
					}
				} 
			}

			$te1 = $ce1 + $oe1;

			for($i = 0; $i <= count($corrects2) - 1; $i++) {
				if(isset($parts2[$i])) {
					if($parts2[$i] != $corrects2[$i]) {
						$ce2++;
					}
				} 
			}

			$te2 = $ce2 + $oe2;

			for($i = 0; $i <= count($corrects3) - 1; $i++) {
				if(isset($parts3[$i])) {
					if($parts3[$i] != $corrects3[$i]) {
						$ce3++;
					}
				}
			}

			$te3 = $ce3 + $oe3;
		
			for($i = 0; $i <= count($corrects4) - 1; $i++) {
				if(isset($parts4[$i])) {
					if($parts4[$i] != $corrects4[$i]) {
						$ce4++;
					}
				}
			}

			$te4 = $ce4 + $oe4;

			for($i = 0; $i <= count($corrects5) - 1; $i++) {
				if(isset($parts5[$i])) {
					if($parts5[$i] != $corrects5[$i]) {
						$ce5++;
					}
				}
			}

			$te5 = $ce5 + $oe5;

			for($i = 0; $i <= count($corrects6) - 1; $i++) {
				if(isset($parts6[$i])) {
					if($parts6[$i] != $corrects6[$i]) {
						$ce6++;
					}
				}
			}

			$te6 = $ce6 + $oe6;

			for($i = 0; $i <= count($corrects7) - 1; $i++) {
				if(isset($parts7[$i])) {
					if($parts7[$i] != $corrects7[$i]) {
						$ce7++;
					}
				}
			}

			$te7 = $ce7 + $oe7;

			for($i = 0; $i <= count($corrects8) - 1; $i++) {
				if(isset($parts8[$i])) {
					if($parts8[$i] != $corrects8[$i]) {
						$ce8++;
					}
				}
			}

			$te8 = $ce8 + $oe8;

			for($i = 0; $i <= count($corrects9) - 1; $i++) {
				if(isset($parts9[$i])) {
					if($parts9[$i] != $corrects9[$i]) {
						$ce9++;
					}
				}
			}

			$te9 = $ce9 + $oe9;

			for($i = 0; $i <= count($corrects10) - 1; $i++) {
				if(isset($parts10[$i])) {
					if($parts10[$i] != $corrects10[$i]) {
						$ce10++;
					}
				}
			}

			$te10 = $ce10 + $oe10;

			for($i = 0; $i <= count($corrects11) - 1; $i++) {
				if(isset($parts11[$i])) {
					if($parts11[$i] != $corrects11[$i]) {
						$ce11++;
					}
				}
			}

			$te11 = $ce11 + $oe11;

			for($i = 0; $i <= count($corrects12) - 1; $i++) {
				if(isset($parts12[$i])) {
					if($parts12[$i] != $corrects12[$i]) {
						$ce12++;
					}
				}
			}

			$te12 = $ce12 + $oe12;

			for($i = 0; $i <= count($corrects13) - 1; $i++) {
				if(isset($parts13[$i])) {
					if($parts13[$i] != $corrects13[$i]) {
						$ce13++;
					}
				}
			}

			$te13 = $ce13 + $oe13;

			for($i = 0; $i <= count($corrects14) - 1; $i++) {
				if(isset($parts14[$i])) {
					if($parts14[$i] != $corrects14[$i]) {
						$ce14++;
					}
				}
			}

			$te14 = $ce14 + $oe14;

			$te = $te1 + $te2 + $te3 + $te4 + $te5 + $te6 + $te7 + $te8 + $te9 + $te10 + $te11 + $te12 + $te13 + $te14;

			die(var_dump($te));
		#}
	}
}