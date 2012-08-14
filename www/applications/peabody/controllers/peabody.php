<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Peabody_Controller extends ZP_Controller {

	static $data = NULL;

	public function __construct() {
		$this->Templates   = $this->core("Templates");
		$this->Peabody_Model = $this->model("Peabody_Model");

		$this->helpers();
		
		$this->application = $this->app("peabody");
		
		$this->Templates->theme();
	}
	
	public function index() {
		if(!POST("start")) {
			$vars["view"] = $this->view("age", TRUE);

			$this->render("content", $vars);
		}
	}

	public function age($age) {
		if($age == 3 or $age == 4) {
			redirect("peabody/image/1/1/$age");
		} elseif($age == 5) {
			SESSION("Start", 10);

			redirect("peabody/image/10/1/$age");
		} elseif($age == 6) {
			SESSION("Start", 26);

			redirect("peabody/image/26/1/$age");
		} elseif($age == 7) {
			SESSION("Start", 38);

			redirect("peabody/image/38/1/$age");
		} elseif($age == 8) {
			SESSION("Start", 50);

			redirect("peabody/image/50/1/$age");
		} elseif($age == 9) {
			SESSION("Start", 60);

			redirect("peabody/image/60/1/$age");
		} elseif($age == 10) {
			SESSION("Start", 70);

			redirect("peabody/image/70/1/$age");
		} elseif($age == 11) {
			SESSION("Start", 77);

			redirect("peabody/image/77/1/$age");
		} elseif($age == 12) {
			SESSION("Start", 82);

			redirect("peabody/image/82/1/$age");
		} elseif($age == 13) {
			SESSION("Start", 86);

			redirect("peabody/image/86/1/$age");
		} elseif($age == 14) {
			SESSION("Start", 90);

			redirect("peabody/image/90/1/$age");
		}
	}

	public function start() {
		if(POST("start")) {
			if(POST("age") >= 3 and POST("age") <= 14) {
				redirect("peabody/age/". POST("age"));
			} else {
				showAlert("La edad es inválida", path("peabody"));
			}
		}
	}

	public function image($number, $block = 1, $age = 0) {
		#____(SESSION("Corrects"));
		#SESSION("Corrects", 7);
		#unset($_SESSION["Success"]);
		#die("SSS");
		$data = $this->Peabody_Model->getWord($number);

		echo "<pre style='background-color: #FFF'>";
		echo "ChangeBlock = ". var_dump(SESSION("ChangeBlock")) ."<br />";
		echo "Success = ". var_dump(SESSION("Success")) ."<br />";
		echo "Last = ". var_dump(SESSION("Last")) ."<br />";
		echo "Corrects = ". var_dump(SESSION("Corrects")) ."<br />";
		echo "Error = ". var_dump(SESSION("Error")) ."<br />";
		echo "First = ". var_dump(SESSION("First")) ."<br />";
		echo "LastError = ". var_dump(SESSION("LastError")) ."<br />";
		echo "</pre>";

		if($data) {
			if(POST("validate")) {
				if((int) POST("option") == (int) $data[0]["Answer"]) {
					$data[0]["Correct"] = 1;
					$data[0]["Block"]   = POST("block");

					if($number == $this->getStart($age)) {
						SESSION("Last", $number);
						SESSION("Corrects", 1);
					} else {
						SESSION("Corrects", SESSION("Corrects") + 1);

						if(SESSION("Corrects") == 8) {
							$newBlock = TRUE;
						}
					}
				} else {
					$data[0]["Correct"] = 0;
					
					if(SESSION("ChangeBlock") === 1) {
						$data[0]["Block"]   = POST("block");
					} else {
						$data[0]["Block"]   = "2";

						SESSION("ChangeBlock", 1);
					}
				}

				$data[0]["Word"]    = decode($data[0]["Word"]);
				$data[0]["ID_User"] = SESSION("ZanUserID");
				$data[0]["Age"]     = POST("age");

				$this->Peabody_Model->setWord($data[0]);

				$corrects 	 = $this->Peabody_Model->getCorrects($block, $age);
				$incorrects  = $this->Peabody_Model->getIncorrects($block, $age);

				if($block == 1) {
					$total = count($corrects);
				} else {
					$total = count($corrects) + count($incorrects);
				}

				if(count($incorrects) == 6) {
					redirect("peabody/finished/$age");
				} elseif($total == 8) {
					$block++;
				}

				if($age <= 4) {
					redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
				} else {
					if(POST("number") == 125) {
						redirect("peabody/finished/$age");
					}
					
					if(SESSION("Success")) {
						redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
					} elseif($data[0]["Correct"] == 1) { 
						if(!SESSION("Error")) {
							redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
						} elseif(SESSION("Error") and SESSION("Corrects") == 8) {
							SESSION("Error", FALSE);
							SESSION("Success", TRUE);
				
							if($block == 1 or isset($newBlock)) { 
								unset($newBlock);
								
								if(SESSION("First") === TRUE) {
									redirect("peabody/image/". (SESSION("Last") + 1) ."/$block/". POST("age"));
								} else {
									redirect("peabody/image/". (SESSION("LastError") + 1) ."/2/". POST("age"));
								}
							} else { 
								redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
							}
						} else { 
							if($block == 1) {
								SESSION("Start", SESSION("Start") - 1);

								redirect("peabody/image/". SESSION("Start") ."/$block/". POST("age"));							
							} else {
								redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
							}
						}
					} else {  
						if($block == 1) {
							if($number == $this->getStart($age)) {
								SESSION("Last", $number);
								SESSION("Corrects", 0);
								SESSION("First", TRUE);
							} elseif(!SESSION("Error")) {
								SESSION("LastError", $number);
							}

							SESSION("Error", 1);
							SESSION("Start", SESSION("Start") - 1);

							redirect("peabody/image/". SESSION("Start") ."/$block/". POST("age"));
						} else {
							redirect("peabody/image/". ($number + 1) ."/$block/". POST("age"));
						}
					}
				}
			} else {
				$this->show($data[0]["ID_Word"], $data[0]["Word"], $block, $age);
			}
		}
	}

	public function getStart($age) {
		if($age == 5) {
			return 10;
		} elseif($age == 6) {
			return 26;
		} elseif($age == 7) {
			return 38;
		} elseif($age == 8) {
			return 50;
		} elseif($age == 9) {
			return 60;
		} elseif($age == 10) {
			return 70;
		} elseif($age == 11) {
			return 77;
		} elseif($age == 12) {
			return 82;
		} elseif($age == 13) {
			return 86;
		} elseif($age == 14) {
			return 90;
		}
	}

	public function show($number, $word, $block, $age) {
		$vars["number"] = $number;
		$vars["word"]   = $word;
		$vars["age"]	= $age;
		$vars["block"]  = $block;
		$vars["view"] 	= $this->view("image", TRUE);

		$this->render("content", $vars);
	}

	public function finished($age) {
		$corrects = $this->Peabody_Model->getCorrects(TRUE, TRUE);

		if(isset($corrects["low"]) and $corrects["low"] > 0) {
			$j = 0;

			for($i = ($corrects["low"] - 1); $i >= 1; $i--) {
				$j++;
			}

			$corrects = count($corrects["data"]) + $j;
		} elseif(isset($corrects["low"]) and $corrects["low"] == 0) {
			$corrects = $this->getStart($age) - 6;
		} else {
			$corrects = count($corrects);
		}

		$score = $this->Peabody_Model->getScore($corrects);
		
		$this->Peabody_Model->setResult($score, $corrects);

		$vars["view"] = $this->view("finished", TRUE);

		$this->render("content", $vars);
		
		exit;
	}
	
}
