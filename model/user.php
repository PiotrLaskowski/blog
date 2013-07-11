<?php 
/**
 * Model użytkownika
 * @author Michał
 *
 */
class User extends Model
{	
	public function __construct()
	{
		$this->_db = Db::instance('sql/blog.db');
	}
	
	/**
	 * Logowanie uzytkownika do panelu admina
	 * @param String $username nazwa uzytkownika
	 * @param String $password haslo uzytkownika
	 */
	public function login($username, $password)
	{
		$md5_password = md5($password);
		$p = $this->_db->query("SELECT * FROM user WHERE login='".$username."' AND password='".$md5_password."' LIMIT 1");
		$row = $p->fetch();
		
		//nie znaleziono uzytkownika
		if(empty($row))
		{
			return null;
		}
		else
		{			
			$_SESSION['i7cichon_login'] = @$row['login'];
			$_SESSION['i7cichon_name'] = @$row['name'];
			$_SESSION['i7cichon_surname'] = @$row['surname'];
			$_SESSION['i7cichon_user_id'] = @$row['id'];
			
			return session_id();
		}
		return null;
		
	}
	
	/**
	 * Zwraca identyfikator uzytkownika jesli jest zalogowany
	 * @return int $id
	 */
	public function getIdLoggedUser()
	{
		if(!empty($_SESSION))
			return @$_SESSION['i7cichon_user_id'];
		else
			return null;
	}
	
	public function logout()
	{
		unset($_SESSION['i7cichon_name']);
		unset($_SESSION['i7cichon_surname']);
		unset($_SESSION['i7cichon_user_id']);
		session_destroy();
		header("Location: index.php");
	}
	
	/**
	 * Zwraca nazwe uzytkownika
	 * @return String nazwa usera
	 */
	public function getName()
	{
		return @$_SESSION['i7cichon_name'].' '.@$_SESSION['i7cichon_surname'];
	}
	
	/**
	 * Zwraca dane o uzytkowniku (wszystkie)
	 * @return Array dane uzytkownika
	 */
	public function getUserData()
	{
		if(@$_SESSION['i7cichon_name'])
		{
			return array(
			'name' => $_SESSION['i7cichon_name'],
			'id' => $_SESSION['i7cichon_user_id'],
			'surname'=> $_SESSION['i7cichon_surname']
			);
		}
	}
	
	/**
	 * Sprawdza czy uzytkownik istnieje w systemie
	 * @param String $login
	 */
	public function checkIfUserExist($login)
	{
		$p = $this->_db->query("SELECT COUNT(*) as ile FROM user WHERE login='".$login."'");
		$row = $p->fetch();
		if($row['ile'] > 0) return true;
		else false;
	}
	
	/**
	 * Rejestracja uzytkownikas
	 * @param unknown_type $name
	 * @param unknown_type $surname
	 * @param unknown_type $password
	 * @param unknown_type $login
	 */
	public function register($name, $surname, $password, $login)
	{
		return $this->_db->query("INSERT INTO user ( id , name, password, login, surname ) 
		VALUES ( null , '".$name."' , '".md5($password)."', '".$login."', '".$surname."') ");
	}
	
	/**
	 * Zwraca sesje uzytkownikas
	 */
	public function sessionExist()
	{
		return $this->getIdLoggedUser();		
	}
	
	private $_db = null;

}