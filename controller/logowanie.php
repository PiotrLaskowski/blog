<?php
/**
 * Kontroler odpowiadajacy za logowanie uzytkownikow
 * @author Michał Cichoń
 *
 */
class Logowanie extends Controller
{
	protected $_view = null;
	public function Logowanie()
	{
		
	}
	public function index()
	{
		$view = new View('login');
		echo $view->load();
	}
	
	/**
	 * Logowanie uzytkownika
	 * @param Array $form dane logowania
	 */
	public function loguj($form=null)
	{
		$user = new User();
		if($user->login($form['login'], $form['password']) != null)
			header('Location: admin.html');
		else
		{
			$view = new View('login');
			$view->add('error', 'Błędne dane logowania');
			echo $view->load();
		}
		
	}
	
	/**
	 * Wylogowywanie uzytkownika
	 * @param Array $form dane wylogowywawcze
	 */
	public function wyloguj($form=null)
	{
		$user = new User();
		$user->logout();
	}
}