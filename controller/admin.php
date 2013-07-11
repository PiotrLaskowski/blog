<?php
/**
 * Kontroler panelu administracyjnego
 * @author Michał Cichoń
 *
 */
class Admin extends Controller
{
	
	public function __construct()
	{
		parent::Controller();
	}
	
	
	public function index()
	{
		if($this->_user->getIdLoggedUser() == null)
		{
			header('Location: logowanie.html');
			exit;
		}
		$this->_view = new View('admin');
		$this->_view->add('pokaz_active','class="active"');
		$this->_view->add('logged_as',$this->_user->getName());
		
		$wpis = new Wpis();
		$wpisy = $wpis->getAllWpisy();
		
		$content = '<table border="0" style="width: 100%" class="normalTable">
		<tr class="headerTable"><td>Tytuł wpisu</td><td>-</td><td>-</td></tr>';
		$col1 = '#F0FAFF';
		$col2 = '#F0FAEE';
		$col = $col1;
		foreach($wpisy as $row)
		{
			$content .= '<tr style="background-color: '.$col.'"><td>'.$row['title'].'</td><td><a href="admin,edytuj,'.$row['id'].'.html">edytuj</a></td><td><a onclick="return confirm(\'Czy na pewno chcesz usunąć?\')" href="admin,usun,'.$row['id'].'.html">usuń</a></td></tr>';
			$col = ($col == $col1) ? $col2 : $col1;
		}
		
		$content .= '</table>';
		$this->_view->add('content',$content);
		
		echo $this->_view->load();
	}
	
	/**
	 * Edycja wpisu
	 */
	public function edytuj()
	{
		if($this->_user->getIdLoggedUser() == null)
		{
			header('Location: logowanie.html');
			exit;
		}
		$this->_view = new View('admin');
		$this->_view->add('pokaz_active','class="active"');
		$this->_view->add('logged_as',$this->_user->getName());
		
		$wpis = new Wpis();
		
		$id = $_GET['id'] ? $_GET['id'] : 1;
		
		$wpisek = $wpis->getWpisById($id);
		
		$content = '
		<form action="admin,zapisz.html" method="post">
		<div id="account">
		<div class="field">
		<label for="title">Tytuł wpisu</label>
		<input type="text" name="form[title]" id="title" value="'.$wpisek['title'].'" />
		</div>
		
		<div class="field">
		<label for="tresc">Treść wpisu</label>
		<textarea id="tresc" name="form[tresc]">'.$wpisek['tresc'].'</textarea>
		</div>
		<div style="clear:both;">&nbsp;</div>
		<div class="submit">
		<input type="submit" name="submit" value="Zapisz" />
		<input type="hidden" name="form[id]" value="'.$wpisek['id'].'" />
		</div>
		</form>
		';
		
		
		$content .= '</div>';
		$this->_view->add('content',$content);
		
		echo $this->_view->load();
	}
	
	/**
	 * Dodawanie wpisu
	 */
	public function dodaj()
	{
		if($this->_user->getIdLoggedUser() == null)
		{
			header('Location: logowanie.html');
			exit;
		}
		$this->_view = new View('admin');
		$this->_view->add('dodaj_active','class="active"');
		$this->_view->add('logged_as',$this->_user->getName());
		
		$content = '
		<form action="admin,zapisz.html" method="post">
		<div id="account">
		<div class="field">
		<label for="title">Tytuł wpisu</label>
		<input type="text" name="form[title]" id="title" value="" />
		</div>
		
		<div class="field">
		<label for="tresc">Treść wpisu</label>
		<textarea id="tresc" name="form[tresc]"></textarea>
		</div>
		<div style="clear:both;">&nbsp;</div>
		<div class="submit">
		<input type="submit" name="submit" value="Zapisz" />
		<input type="hidden" name="form[id]" value="0" />
		</div>
		</form>
		';
		
		
		$content .= '</div>';
		$this->_view->add('content',$content);
		
		echo $this->_view->load();
	}
	
	/**
	 * Zapisywanie wpisu
	 */
	public function zapisz()
	{
		if($this->_user->getIdLoggedUser() == null)
		{
			header('Location: logowanie.html');
			exit;
		}
		$form = $_POST['form'];
		$wpis = new Wpis();
		
		$form['title'] = trim(strip_tags($form['title']));
		$form['tresc'] = trim(strip_tags(nl2br($form['tresc'])));
		
		if($form['id'] > 0)
		{
			$wpis->update($form['id'], $form['title'], $form['tresc']);
			header('Location: admin.html');
			exit;
		}
		else{
			$wpis->insert($form['title'], $form['tresc']);
			header('Location: admin.html');
			exit;
		}
		
			
			
	}
	
	/**
	 * usuwanie wpisu
	 * Enter description here ...
	 */
	public function usun()
	{
		if($_GET['id'])
		{
			$wpis = new Wpis();
			$wpis->delete($_GET['id']);
			header('Location: admin.html');
			exit;
		}
		header('Location: admin.html');
	}
}