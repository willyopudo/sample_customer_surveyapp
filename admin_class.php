<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM users where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password')
					$v = md5($v);
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
				if($k =='password')
					$v = md5($v);
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_page_img(){
		extract($_POST);
		if($_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
				if($move){
					$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
					$hostName = $_SERVER['HTTP_HOST'];
						$path =explode('/',$_SERVER['PHP_SELF']);
						$currentPath = '/'.$path[1]; 
   						 // $pathInfo = pathinfo($currentPath); 

					return json_encode(array('link'=>$protocol.'://'.$hostName.$currentPath.'/admin/assets/uploads/'.$fname));

				}
		}
	}

	function save_survey(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO survey_set set $data");
		}else{
			$save = $this->db->query("UPDATE survey_set set $data where id = $id");
		}

		if($save)
			return 1;
	}
	function delete_survey(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM survey_set where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function save_question(){
		extract($_POST);
            $max_question = $this->db->query("SELECT MAX(order_by) FROM questions GROUP BY survey_id HAVING survey_id = {$sid} ")->fetch_column();
            if(isset($max_question) &&  $max_question > 0){
                $data = " order_by= $max_question";
            }
            else
                $data = " order_by= 1";
			$data .= ", survey_id=$sid ";
			$data .= ", question='$question' ";
			$data .= ", type='$type' ";
			if($type != 'textfield_s'){
				$arr = array();
				foreach ($label as $k => $v) {
					$i = 0 ;
					while($i == 0){
						$k = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
						if(!isset($arr[$k]))
							$i = 1;
					}
					$arr[$k] = $v;
                    if($type == 'radio_opt' && isset($radio_inline))
                        $arr["inline"] = $radio_inline;
				}
			$data .= ", frm_option='".json_encode($arr)."' ";
			}else{
			$data .= ", frm_option='' ";
			}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO questions set $data");
		}else{
			$save = $this->db->query("UPDATE questions set $data where id = $id");
		}

		if($save)
			return 1;
	}
	function delete_question(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM questions where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function action_update_qsort(){
		extract($_POST);
		$i = 0;
		foreach($qid as $k => $v){
			$i++;
			$update[] = $this->db->query("UPDATE questions set order_by = $i where id = $v");
		}
		if(isset($update))
			return 1;
	}
    function save_answer_user(){
        extract($_POST);
            $data = " email = '$custemail' , firstname = '$firstname', lastname = '$lastname', survey_id = '$survey_id1'";
            $insertedId = 0;
            if(!$this->db->query("INSERT INTO survey_user set $data")){
                return("Error description: " . $this->db->error);
            }
            else{
               
                $insertedId = $this->db->insert_id;
               
            }
            return $insertedId;
    }
    function save_answer_service(){
        extract($_POST);
            $data = " storenumber = '$storenumber' , servicedate = '$servicedate $servicehour:$serviceminute:00', transactionnumber = '$txnumber1'";
            // exit(var_dump($data));
            $insertedId = 0;
            if(!$this->db->query("INSERT INTO survey_service set $data")){
                return("Error description: " . $this->db->error);
            }
            else{
               
                $insertedId = $this->db->insert_id;
               
            }
            return $insertedId;
    }
	function save_answer(){
		extract($_POST);
            //exit(var_dump($_POST));
			foreach($qid as $k => $v){
				$data = " survey_id=$survey_id , survey_user_id = $survey_user_id , survey_service_id = $survey_service_id ";
				$data .= ", question_id='$qid[$k]' ";
                if(isset($_SESSION['login_id'])){
				    $data .= ", user_id='{$_SESSION['login_id']}' ";
                }
                else{
                    $data .= ", user_id='6' ";
                }
				if($type[$k] == 'check_opt'){
					$data .= ", answer='[".implode("],[",$answer[$k])."]' ";
				}else{
					$data .= ", answer='$answer[$k]' ";
				}
				$save[] = $this->db->query("INSERT INTO answers set $data");
			}
					

		if(isset($save))
			return 1;
	}
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = ".$id);
		if($delete){
			return 1;
		}
	}

    function getAllStores(){
		$qry = $this->db->query("SELECT id, store_code, name, location FROM subz_stores order by id asc ");
        $response = [];
		if($qry && $qry->num_rows > 0){
            $response["data"] = $qry->fetch_all();
			return json_encode($response);
		}
        else{
            return '{"status" : "0", "resultdesc" : "no records found"}';
        }
	}

    function getAllSurveySubmissions(){
		$qry = $this->db->query("select a.answer,q.question,q.frm_option,ss.storenumber,zs.name AS storename, su.email AS cust_email, a.date_created, ss.transactionnumber  from answers a 
        inner join questions q on a.question_id = q.id
        inner join survey_service ss on a.survey_service_id = ss.id
        inner join survey_user su on su.id = a.survey_user_id
        inner join subz_stores zs on zs.id = ss.storenumber");
        $response = array();
		if($qry && $qry->num_rows > 0){
            while($row = $qry->fetch_assoc()){
                $newArr = array();
                $possible_answers = json_decode($row['frm_option']);
                //var_dump($row);
                $answer = $row['answer'];
                $newArr[] = substr($row['question'],0,40).'...';
                $newArr[] = $row['frm_option'] != '' ? $possible_answers->$answer : $row['answer'];
                $newArr[] = $row["storename"];
                $newArr[] = $row["cust_email"];
                $newArr[] = $row["transactionnumber"];
                $newArr[] = $row["date_created"];
                
                $response["data"][] = $newArr;
            }
            //var_dump($response);
            //$response["data"] = $qry->fetch_all();
			return json_encode($response);
		}
        else{
            return '{"status" : "0", "resultdesc" : "no records found"}';
        }
	}

    function getSurveyTotalsByStore(){
		$qry = $this->db->query("select count(a.id) AS total_surveys,b.name AS store_name from survey_service a
        right join subz_stores b on b.id = a.storenumber
        group by b.name ");
        //var_dump($qry->fetch_all());
		if($qry && $qry->num_rows > 0){
			return json_encode($qry->fetch_all());
		}
        else{
            return '{"status" : "0", "resultdesc" : "no records found"}';
        }
	}

    function getSatisfactionScoreByStore(){
		$qry = $this->db->query("select a.answer,q.frm_option,ss.storenumber,zs.name AS storename from answers a 
        inner join questions q on a.question_id = q.id
        inner join survey_service ss on a.survey_service_id = ss.id
        right join subz_stores zs on zs.id = ss.storenumber
        where  q.question like '%Are you likely to return%'; ");
        //var_dump($qry->fetch_all());
		if($qry && $qry->num_rows > 0){
			return json_encode($qry->fetch_all());
		}
        else{
            return '{"status" : "0", "resultdesc" : "no records found"}';
        }
	}
}