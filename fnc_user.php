<?php
	require_once "../config.php";
	//kõik muutujad, mis deklareeritud väljaspool funktsiooni, on globaalsed
	//ja kättesaadavad massiivist GLOBALS
	
	function sign_up($first_name, $last_name, $birth_date, $gender, $email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset=("utf8");
		$stmt = $conn->prepare("INSERT INTO vp_users (firstname, lastname, birthdate, gender, email, password) values(?, ?, ?, ?, ?, ?)");
		echo $conn->error;
		//krüpteerime parooli
		$pwd_hash = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bind_param("sssiss", $first_name, $last_name, $birth_date, $gender, $email, $pwd_hash);
			
		if($stmt->execute()){
			$notice = "Uus kasutaja loodud!";
		} else {
			$notice = "Kasutaja loomisel tekkis tehnilise tõrge: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function sign_in($email, $password){
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$conn->set_charset("utf8");
			$stmt = $conn->prepare("SELECT id, password FROM vp_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //kasutaja on olemas, parool tuli ...
            if(password_verify($password, $password_from_db)){
                //parool õige, oleme sees!
				$_SESSION["user_id"] = $id_from_db; 
                $stmt->close();
                $conn->close();
                header("Location: home.php");
				//exit();
			} else {
				 $login_error = "Kasutajatunnus või salasõna oli pisut vale!";
			}
		} else {
			$login_error = "Kasutajatunnus või salasõna oli täitsa vale!";
		}
		
		$stmt->close();
		$conn->close();
		
		return $login_error;
	}