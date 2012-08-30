<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Peabody_Controller extends ZP_Controller {
	public static $blocks = array();


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
			redirect("peabody/image/1/$age");
		} elseif($age == 5) {
			SESSION("Start", 10);

			redirect("peabody/image/10/$age");
		} elseif($age == 6) {
			SESSION("Start", 26);

			redirect("peabody/image/26/$age");
		} elseif($age == 7) {
			SESSION("Start", 38);

			redirect("peabody/image/38/$age");
		} elseif($age == 8) {
			SESSION("Start", 50);

			redirect("peabody/image/50/$age");
		} elseif($age == 9) {
			SESSION("Start", 60);

			redirect("peabody/image/60/$age");
		} elseif($age == 10) {
			SESSION("Start", 70);

			redirect("peabody/image/70/$age");
		} elseif($age == 11) {
			SESSION("Start", 77);

			redirect("peabody/image/77/$age");
		} elseif($age == 12) {
			SESSION("Start", 82);

			redirect("peabody/image/82/$age");
		} elseif($age == 13) {
			SESSION("Start", 86);

			redirect("peabody/image/86/$age");
		} elseif($age == 14) {
			SESSION("Start", 90);

			redirect("peabody/image/90/$age");
		}
	}

	public function getLimit($block) {
		$parts = explode("-", $block);

		return (count($parts) == 2) ? $parts : FALSE;
	}

	public function getBlock($error) {
		switch((int) $error) {
			case 1:  return "1-8";   break;
			case 2:  return "2-9";   break;
			case 3:  return "3-10";  break;
			case 4:  return "4-11";  break;
			case 5:  return "5-12";  break;
			case 6:  return "6-13";  break;
			case 7:  return "7-14";  break;
			case 8:  return "8-15";  break;
			case 9:  return "9-16";  break;
			case 10: return "10-17"; break;
			case 11: return "11-18"; break;
			case 12: return "12-19"; break;
			case 13: return "13-20"; break;
			case 14: return "14-21"; break;
			case 15: return "15-22"; break;
			case 16: return "16-23"; break;
			case 17: return "17-24"; break;
			case 18: return "18-25"; break;
			case 19: return "19-26"; break;
			case 20: return "20-27"; break;
			case 21: return "21-28"; break;
			case 22: return "22-29"; break;
			case 23: return "23-30"; break;
			case 24: return "24-31"; break;
			case 25: return "25-32"; break;
			case 26: return "26-33"; break;
			case 27: return "27-34"; break;
			case 28: return "28-35"; break;
			case 29: return "29-36"; break;
			case 30: return "30-37"; break;
			case 31: return "31-38"; break;
			case 32: return "32-39"; break;
			case 33: return "33-40"; break;
			case 34: return "34-41"; break;
			case 35: return "35-42"; break;
			case 36: return "36-43"; break;
			case 37: return "37-44"; break;
			case 38: return "38-45"; break;
			case 39: return "39-46"; break;
			case 40: return "40-47"; break;
			case 41: return "41-48"; break;
			case 42: return "42-49"; break;
			case 43: return "43-50"; break;
			case 44: return "44-51"; break;
			case 45: return "45-52"; break;
			case 46: return "46-53"; break;
			case 47: return "47-54"; break;
			case 48: return "48-55"; break;
			case 49: return "49-56"; break;
			case 50: return "50-57"; break;
			case 51: return "51-58"; break;
			case 52: return "52-59"; break;
			case 53: return "53-60"; break;
			case 54: return "54-61"; break;
			case 55: return "55-62"; break;
			case 56: return "56-63"; break;
			case 57: return "57-64"; break;
			case 58: return "58-65"; break;
			case 59: return "59-66"; break;
			case 60: return "60-67"; break;
			case 61: return "61-68"; break;
			case 62: return "62-69"; break;
			case 63: return "63-70"; break;
			case 64: return "64-71"; break;
			case 65: return "65-72"; break;
			case 66: return "66-73"; break;
			case 67: return "67-74"; break;
			case 68: return "68-75"; break;
			case 69: return "69-76"; break;
			case 70: return "70-77"; break;
			case 71: return "71-78"; break;
			case 72: return "72-79"; break;
			case 73: return "73-80"; break;
			case 74: return "74-81"; break;
			case 75: return "75-82"; break;
			case 76: return "76-83"; break;
			case 77: return "77-84"; break;
			case 78: return "78-85"; break;
			case 79: return "79-86"; break;
			case 80: return "80-87"; break;
			case 81: return "81-88"; break;
			case 82: return "82-89"; break;
			case 83: return "83-90"; break;
			case 84: return "84-91"; break;
			case 85: return "85-92"; break;
			case 86: return "86-93"; break;
			case 87: return "87-94"; break;
			case 88: return "88-95"; break;
			case 89: return "89-96"; break;
			case 90: return "90-97"; break;
			case 91: return "91-98"; break;
			case 92: return "92-99"; break;
			case 93: return "93-100"; break;
			case 94: return "94-101"; break;
			case 95: return "95-102"; break;
			case 96: return "96-103"; break;
			case 97: return "97-104"; break;
			case 98: return "98-105"; break;
			case 99: return "99-106"; break;
			case 100: return "100-107"; break;
			case 101: return "101-108"; break;
			case 102: return "102-109"; break;
			case 103: return "103-110"; break;
			case 104: return "104-111"; break;
			case 105: return "105-112"; break;
			case 106: return "106-113"; break;
			case 107: return "107-114"; break;
			case 108: return "108-115"; break;
			case 109: return "109-116"; break;
			case 110: return "110-117"; break;
			case 111: return "111-118"; break;
			case 112: return "112-119"; break;
			case 113: return "113-120"; break;
			case 114: return "114-121"; break;
			case 115: return "115-122"; break;
			case 116: return "116-123"; break;
			case 117: return "117-124"; break;
			case 118: return "118-125"; break;
		}

		return FALSE;
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

	public function image($number, $age = 0) {
		$data = $this->Peabody_Model->getWord($number);
		
		#$_SESSION["LastBlockError"] = array("59", "62", "63", "64", "65");
		#die("si");
		
		echo "<pre>";

		echo "Block: ". var_dump(SESSION("Block"));
		echo "LastBlockError: ". var_dump(SESSION("LastBlockError"));
		echo "FirstBlockComplete:". var_dump(SESSION("FirstBlockComplete"));
		
		echo "</pre>";

		if($data) {
			if(POST("validate")) {
				if((int) POST("option") == (int) $data[0]["Answer"]) {
					$correct = 1;

					$findBlock = $this->Peabody_Model->findBlock($number);

					if(!is_array($findBlock)) {
						$block = $findBlock;
					} else {
						$block = $findBlock[0]["ID_Block"];
					}

					if(!SESSION("FirstBlockComplete")) {
						if($block) {
							$total = $this->Peabody_Model->getAnswers($block, TRUE);

							if($total["incorrects"] == 6) {
								redirect("peabody/finished/$age");
							} elseif($total["corrects"] == 8) {
 								SESSION("FirstBlockComplete", TRUE);
 								SESSION("Block", FALSE);
							} else {
								$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 1, 1);

								if(!$findAnswer) {
									$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 1, 1);

									$total = $this->Peabody_Model->getAnswers($block, TRUE);

									if($total["incorrects"] == 6) {
										redirect("peabody/finished/$age");
									} elseif($total["corrects"] == 8) {
	 									SESSION("FirstBlockComplete", TRUE);
	 									SESSION("Block", FALSE);

	 									$newBlock = TRUE;
									}
								}
							}
						}
					} else { 
						if(isset($_SESSION["LastBlockError"]) and is_array($_SESSION["LastBlockError"])) { 
							foreach($_SESSION["LastBlockError"] as $block) {
								$total = $this->Peabody_Model->getAnswers($block);
								
								if($total["incorrects"] == 6) {
									redirect("peabody/finished/$age");
								} elseif($total["total"] == 8) { 
									array_shift($_SESSION["LastBlockError"]);
								} else {
									$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 1);

									if(!$findAnswer) {
										$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 1);

										$total = $this->Peabody_Model->getAnswers($block);
										
										if($total["incorrects"] == 6) {
											redirect("peabody/finished/$age");
										} elseif($total["total"] == 8) {
											array_shift($_SESSION["LastBlockError"]);
										}
									}	
								}
							}
						} else { 
							$findBlock = $this->Peabody_Model->findBlock($number, TRUE);

							if(!is_array($findBlock)) {
								$block = $findBlock;
							} else {
								$block = $findBlock[0]["ID_Block"];
							}

							if($block) {
								$total = $this->Peabody_Model->getAnswers($block);

								if(is_array($total) and $total["incorrects"] == 6) {
									redirect("peabody/finished/$age");
								} elseif(is_array($total) and $total["total"] == 8) {
									$_SESSION["LastBlockError"] = array_shift($_SESSION["LastBlockError"]);

									if(!is_array($_SESSION["LastBlockError"])) {
										$_SESSION["LastBlockError"] = FALSE;
									}
								} else {
									$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 1);

									if(!$findAnswer) {
										$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 1);

										$total = $this->Peabody_Model->getAnswers($block);
										
										if($total["incorrects"] == 6) {
											redirect("peabody/finished/$age");
										} elseif($total["total"] == 8) {
											reset($_SESSION["LastBlockError"]);

											array_shift($_SESSION["LastBlockError"]);
										} elseif(!is_array($_SESSION["LastBlockError"])) { 
											unset($_SESSION["LastBlockError"]);

											$_SESSION["LastBlockError"] = array($block);
										}
									}	
								}	
							}
						}
					}
				} else {
					$correct = 0;

					if(!SESSION("FirstBlockComplete")) {
						$findBlock = $this->Peabody_Model->findBlock($number);

						if(!is_array($findBlock)) {
							$block = $findBlock;
						} else {
							$block = $findBlock[0]["ID_Block"];
						}

						if(isset($_SESSION["LastBlockError"][0])) {
							$block = $_SESSION["LastBlockError"][0];

							$_SESSION["LastBlockError"] = array_shift($_SESSION["LastBlockError"]);

							if(!is_array($_SESSION["LastBlockError"])) {
								$_SESSION["LastBlockError"] = FALSE;
							}
						}

						if($findBlock) {
							$totalFirstBlock = $this->Peabody_Model->getTotalFirstBlock();

							if($totalFirstBlock > 0) {
								$this->Peabody_Model->resetAnswers();
							}

							$block = $this->Peabody_Model->findBlock($number, TRUE);

							$total = $this->Peabody_Model->getAnswers($block, TRUE);

							if($total["incorrects"] == 6) {
								redirect("peabody/finished/$age");
							} elseif($total["corrects"] == 8) {
 								SESSION("FirstBlockComplete", TRUE);
 								SESSION("Block", FALSE);
							} else {
								$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 0, 1);

								if(!$findAnswer) {
									$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 0, 1);

									$total = $this->Peabody_Model->getAnswers($block, TRUE);

									if($total["incorrects"] == 6) {
										redirect("peabody/finished/$age");
									} elseif($total["corrects"] == 8) {
	 									SESSION("FirstBlockComplete", TRUE);
	 									SESSION("Block", FALSE);
									}
								}
							}
						}
					} else {
						if(isset($_SESSION["LastBlockError"]) and is_array($_SESSION["LastBlockError"])) { 
							$block = $this->Peabody_Model->findBlock($number, TRUE);

							$_SESSION["LastBlockError"][] = $block;
							
							$i = 0;

							foreach($_SESSION["LastBlockError"] as $block) {
								$total = $this->Peabody_Model->getAnswers($block);
								
								if($total["incorrects"] == 6) {
									redirect("peabody/finished/$age");
								} elseif($total["total"] == 8) {
									array_shift($_SESSION["LastBlockError"]);								
								} else {
									$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 0);

									if(!$findAnswer) {
										$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 0);

										$total = $number - $block;
										
										if($total == 7) { 											
											array_shift($_SESSION["LastBlockError"]);
										}

										$total = $this->Peabody_Model->getAnswers($block);

										if($total["incorrects"] == 6) {
											redirect("peabody/finished/$age");
										} elseif($total["total"] == 8) {
											array_shift($_SESSION["LastBlockError"]);								
										}
									}
								}

								$i++;
							}
						} else { 
							$findBlock = $this->Peabody_Model->findBlock($number, TRUE);

							if(!is_array($findBlock)) {
								$block = $findBlock;
							} else {
								$block = $findBlock[0]["ID_Block"];
							}

							if($block) {
								$total = $this->Peabody_Model->getAnswers($block);

								if($total["incorrects"] == 6) {
									redirect("peabody/finished/$age");
								} elseif($total["total"] == 8) {
									array_shift($_SESSION["LastBlockError"]);
								} else {
									$findAnswer = $this->Peabody_Model->findAnswer(SESSION("ZanUserID"), $block, $number, 0);

									if(!$findAnswer) {
										$this->Peabody_Model->setAnswer(SESSION("ZanUserID"), $block, $number, 0);

										$total = $number - $block;

										if($total == 7) {
											array_shift($_SESSION["LastBlockError"]);
										} else {
											$_SESSION["LastBlockError"][] = $block;
										}
									}	
								}	
							}
						}
					}
				}

				if($age <= 4) {
					redirect("peabody/image/". ($number + 1) ."/$age");
				} else {
					if(POST("number") == 125) {
						redirect("peabody/finished/$age");
					}

					if(isset($newBlock) and SESSION("LastError") !== FALSE) {
						redirect("peabody/image/". (SESSION("LastError") + 1) ."/$age");
					} elseif(isset($newBlock)) {
						redirect("peabody/image/". ($number + 1) ."/$age");
					} elseif(SESSION("FirstBlockComplete") !== FALSE) {
						redirect("peabody/image/". ($number + 1) ."/$age");
					} elseif($correct == 1) {
						if(!SESSION("Error")) {
							redirect("peabody/image/". ($number + 1) ."/$age");
						} else {
							SESSION("Start", SESSION("Start") - 1);

							redirect("peabody/image/". SESSION("Start") ."/$age");	
						}
					} else {
						if($number == $this->getStart($age)) {
							SESSION("Last", $number);
							SESSION("First", TRUE);
						} elseif(!SESSION("Error")) {
							SESSION("LastError", $number);
						}

						SESSION("Error", 1);
						SESSION("Start", SESSION("Start") - 1);

						redirect("peabody/image/". SESSION("Start") ."/$age");
					}
				}
			} else {
				$this->show($data[0]["ID_Word"], $data[0]["Word"], $age);
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

	public function show($number, $word, $age) {
		$vars["number"] = $number;
		$vars["word"]   = $word;
		$vars["age"]	= $age;
		$vars["view"] 	= $this->view("image", TRUE);

		$this->render("content", $vars);
	}

	public function finished($age) {
		$corrects = $this->Peabody_Model->getCorrects(TRUE, TRUE);

		$score = $this->Peabody_Model->getScore($corrects);
		
		$this->Peabody_Model->setResult($score, $corrects);

		$vars["score"] = $score;
		$vars["view"]  = $this->view("finished", TRUE);

		$this->render("content", $vars);
		
		exit;
	}
	
}
