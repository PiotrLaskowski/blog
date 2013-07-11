<?php
/**
 * Model wpisu, umożliwia edycje, utworzenie i usunięcie wpisów
 * @author Michał
 *
 */
class Wpis extends Model
{
	function __construct()
	{
		parent::Model();
	}
	
	/**
	 * Zwraca wszystkie wpisy w kolejnosci malejącej
	 */
	function getAllWpisy()
	{
		$q = $this->_db->query("SELECT * FROM wpis ORDER BY id DESC;");
		$array = $q->fetchAll();
		if(!empty($array)) return $array;
		else return null;
	}
	
	
	/**
	 * Zwraca wpis o zadanym id
	 * @param $id identyfikator wpisu
	 */
	function getWpisById($id)
	{
		$q = $this->_db->query("SELECT * FROM wpis WHERE id='".$id."';");
		$r = $q->fetch();
		if(!empty($r)) return $r;
		else return null;
	}
	
	/**
	 * Aktualizuje wpis
	 * @param $id identyfikator wpisu
	 * @param $title tytuł wpisu
	 * @param $tresc tresc wpisu
	 */
	function update($id, $title, $tresc)
	{
		return $this->_db->query("UPDATE wpis 
		SET title='".$title."',
		tresc='".$tresc."'
		WHERE id='".$id."';"
		);
	}
	
	/**
	 * Wstawia nowy wpis
	 * @param $title tytul wpisu
	 * @param $tresc tresc wpisu
	 */
	function insert($title, $tresc)
	{
		$data_dodania = time();
		return $q = $this->_db->query("INSERT INTO wpis (id, title, tresc, data_dodania) VALUES (
		null,
		'".$title."',
		'".$tresc."',
		'".$data_dodania."'
		);");
	}
	
	/**
	 * Usuwa wpis (permamentnie!)
	 * @param $id identyfikator usuwanego wpisu
	 */
	function delete($id)
	{
		return $this->_db->query("DELETE FROM wpis WHERE id='".$id."'");
	}
	
}