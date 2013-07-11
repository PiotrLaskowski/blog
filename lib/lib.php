<?php
/**
 * Klasa pozwala na dostep do bazy danych
 * @author Michal Cichon
 * usage: buduj obiekt za pomoca Db::instance();
 *
 */
class Db
{
	/**
	 * Kontsruktor prywatny (wzorzec projektowy Singleton)
	 * @param $databaseFile lokalizacja pliku z baza
	 * @return void 
	 */
	private function __construct($databaseFile)
	{
		if(file_exists($databaseFile))
				$this->_handle = new PDO("sqlite:".$databaseFile);
		else 
			throw new Exception('Nie mo�na po��czy� si� z baz� danych.');
	}
	
	/**
	 * Metoda tworzy lub zwraca instancje klasy odpowiedzialnej za dostep do danych
	 * @param String $databaseFile
	 * @return Db instancja klasy
	 */
	static public function instance($databaseFile)
	{
		static $objDb;
		
		if(!isset($objDb))
		{
			$objDb = new Db($databaseFile);
		}
		
		return $objDb;
	}
	
	/**
	 * Wykonaj zapytanie do bazy danych
	 * @param String $query
	 * @throws Exception
	 */
	public function query($query)
	{
		$proc = $this->_handle->prepare($query);
		if($proc)
		$proc->execute();
		else throw new Exception("Zapytanie nie zwróciło objektu.");
		return $proc;
	}
		
	/**
	 * Zamknij dostep do bazy danych
	 */
	public function close()
	{
		$this->_handle=null;
	}
	
	/* vars */
	private $_handle;
}

/**
 * Klasa modelu danych
 * @author Michal Cichoń
 *
 */
class Model 
{
	public function Model()
	{
		$this->_db = Db::instance('sql/blog.db');
	}
}

/**
 * Klasa odpowiada za widok aplikacji
 * @author Michał Cichoń
 *
 */
class View 
{
	protected $_stylesheetPrefix = null;
	protected $_tpl;
	protected $_vars = array();
	
	/**
	 * Ustawia przedrostek CSS
	 * @param String $prefix przedrostek CSS
	 */
	public function setStylesheetPrefix($prefix)
	{
		$this->_stylesheetPrefix = $prefix;
	}
	
	/**
	 * Zwraca przedrostek CSS
	 */
	public function getStylesheetPrefix()
	{
		return $this->_stylesheetPrefix;	
	}
	
	/**
	 * Konstruktor widoku
	 * @param String $tplFilename nazwa pliku szablonu
	 * @throws Exception
	 */
	public function __construct($tplFilename)
	{
		$tplFilename = 'view/'.$tplFilename . '.php';
		//echo $tplFilename; exit;
		if(!file_exists($tplFilename))
		{
			throw new Exception("Podano niewlasciwa sciezke do szablonu.");
		}
		else
		{
			$this->_tpl = @file($tplFilename);
			$this->_tpl = implode("", $this->_tpl);
		}
	}
	
	/**
	 * Dodaje zmienną przekazywaną do widoku
	 * @param String $name nazwa zmiennej
	 * @param Mixed $value wartość zmiennej
	 */
	public function add($name, $value)
	{
		if(!empty($name) && !empty($value))
			$this->_vars[$name] = $value;
	}
	
	/**
	 * Dodaje tablice do widoku
	 * @param Mixed $array tablica dodawana do widoku
	 */
	public function addArray($array)
	{
		if(is_array($array) && !empty($array))
		{
			$this->_vars = array_merge($this->_vars, $array);
		}
	}
	
	/**
	 * Dodaje plik szablonu do widoku
	 * @param String $name nazwa szablonu
	 * @param String $filename nazwa pliku z szablonem
	 * @param Mixed $param dodaje parametr do szablonu
	 */
	public function addFile($name, $filename, $param=0)
	{
		if($param == 0)
		{
			if(file_exists('view/'.$filename.'.php'))
			{
				$value = implode('', file('templates/'.$filename.'.php'));
				$this->_vars[$name] = $value;
			}
		}
		else if(is_array($param))
		{
			$temp = new Template('templates/'.$filename.'.php');
			$temp->addArray($param);
			$this->_vars[$name] = $temp->load();
		}
		
	}
	
	/**
	 * Ładuje widok, zmienne do widoku
	 */
	public function load()
	{
		return @preg_replace('/{([^}]+)}/e', '$this->_vars["\\1"]', $this->_tpl);
	}
	
	/**
	 * Zwraca widok
	 */
	public function getParseTpl()
	{
		return $this->_tpl;
	}
}

/**
 * Kontroler nadzoruje dostep do danych i widoku
 * @author Michal
 *
 */
class Controller 
{
	protected $_view = null;
	protected $_user = null;
	
	public function Controller()
	{
		$this->_user = new User();
	}
}