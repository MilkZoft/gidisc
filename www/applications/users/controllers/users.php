<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Users_Controller extends ZP_Controller {
	
	public function __construct() {		
		$this->Templates   = $this->core("Templates");
		$this->Users_Model = $this->model("Users_Model");
		
		$helpers = array("alerts", "router", "security", "sessions");
		$this->helper($helpers);

		$this->application = $this->app("users");
		
		$this->Templates->theme();
	}

	public function index() {
		redirect(path("users/cpanel/add/"));
	}

	public function sendEmail() {
		$this->Email = $this->core("Email");
		$this->Email->setLibrary("PHPMailer");
		
		$email   = POST("email");
		$subject = POST("subject");
		$message = POST("message");
		$name    = POST("name");

		$this->Email->email = $email;
		$this->Email->fromEmail = "contacto@gidisc.org";
		//$this->Email->fromName = $name;
		$this->Email->subject = $subject;
		$this->Email->IsHTML(true);
		$this->Email->message = '<p>Mensaje enviado por: '. $name .'</p> <p>'. $message .'</p>';
		$this->Email->send();
	}
	
	public function logout() {
		setcookie("ZanUser");
		setcookie("ZanUserPwd");
		setcookie("ZanUserID");
		setcookie("ZanUserType");
		setcookie("ZanUserTypeID");
		unsetSessions();
	}

	/*public function fix() {
		$this->Users_Model->fixUsers();
	}*/
		
	public function login($from = "users") {
		if(segment(2, isLang())) {
			$from = segment(2, isLang());
		} 
		
		$this->title("Login");
		$this->CSS("login", $this->application);
		
		if(POST("connect")) {
			if($this->Users_Model->isAdmin() or $this->Users_Model->isMember()) { 
				$user = $this->Users_Model->getUserData();
			} else { 
				$user = FALSE;
			}
			
			if($user) { 
				SESSION("ZanUser", 		 $user[0]["Username"]);
				SESSION("ZanUserPwd",    $user[0]["Password"]);
				SESSION("ZanUserID",     $user[0]["ID_User"]);
				SESSION("ZanUserType",   $user[0]["Type"]);
				SESSION("ZanUserTypeID", $user[0]["ID_Type_User"]);

				$token = $this->Users_Model->setToken($user[0]["ID_User"]);
				
				if(!$token) {
					redirect("cpanel/logout");
				}
				
				SESSION("ZanUserToken", $token);

				redirect(POST("URL"));
			} elseif($from === "cpanel") {
				showAlert("Incorrect Login", path("cpanel"));
			} else {
				$vars["href"] 	= path("users/login");
				$vars["alert"] 	= getAlert("Incorrect Login");
				$vars["view"]  	= $this->view("login", TRUE);
			}		
		} else {
			$vars["href"] = path("users/login");
			$vars["view"] = $this->view("login", TRUE);
		}
		
		$this->render("content", $vars);
	}
	
	private function recover() {
		if(segment(4)) {
			$from = segment(4);
		} else {
			$from = FALSE;
		}
		
		$this->title("Recover Password");
		$this->CSS("recover", $this->application);
		
		if(POST("change")) {			
			$vars["alert"] 	 = $this->Users_Model->change();
			$vars["tokenID"] = POST("tokenID");
			$vars["view"]  	 = $this->view("recover", TRUE);
		} elseif(POST("recover")) {
			$vars["alert"] = $this->Users_Model->recover();
			$vars["view"]  = $this->view("recover", TRUE);
		} elseif(segment(2) === "recover") {
			$token = segment(3);
			
			$tokenID = $this->Users_Model->isToken($token, "Recover");
			
			if($tokenID > 0) {
				$vars["tokenID"] = $tokenID;
				$vars["view"] 	 = $this->view("recover", TRUE);
			} else {
				redirect();
			}
		} else {
			$vars["view"] = $this->view("recover", TRUE);		
		}
		
		$this->render("content", $vars);
	}

	public function showPatients() {
		$photos = $this->Users_Model->getPhotos();

		if ($photos == FALSE) {

			print "<img src='". path("www/lib/themes/gidi/images/users.png", TRUE) ."' alt='Users' />";
			
		} else { 
			$i = 0;

			$href = path("users/cpanel/profile");

			print "<table>";
				print "<tr>";

				foreach($photos as $photo) {
					print "<td>";
						print "<a href='".$href."/".$photos[$i]["ID_Patient"]."'><img src='". get("webURL") ."/".$photos[$i]["url"]."' width='90px' height='90px'/></a>";
						print "<center>".$photos[$i]["name"]."</center>";
					print "</td>";
				
					$i++;
				}

				print "</tr>";
			print "</table>";
		}
	}
	
	public function register() {
		if(segment(3)) {
			$from = segment(3);
		} else {
			$from = FALSE;
		}
		
		if($from === "forums") { 
			$this->CSS("registerforums", $this->application, TRUE);
		} else { 
			$this->CSS("register", $this->application);
		}
		
		$this->title("Register");
				
		if(POST("register")) {
			if($from === "forums") {
				$vars["alert"] = $this->Users_Model->setUser("forums");

				if(is_array($vars["alert"])) {
					$vars["success"] = TRUE;
				}
				
				$vars["href"] = find("users" . _sh . "register" . _sh . $from);
				$vars["view"] = $this->view("register", $this->application, $vars);				
			} else {
				$vars["alert"] = $this->Users_Model->setUser();
				$vars["href"]  = find("users" . _sh . "register");
				$vars["view"]  = $this->view("register", TRUE);
			}
		} else {
			if($from === "forums") { 
				$vars["forums"] = TRUE;
				$vars["href"]	= find("users" . _sh . "register" . _sh . $from);
				$vars["view"]   = $this->view("register", $this->application);
			} else { 
				$vars["href"] = find("users" . _sh . "register");
				$vars["view"] = $this->view("register", $this->application);
			}			
		}
	
		$this->render("content", $vars);
	}
}
