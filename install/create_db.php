<?php
function get_id($ile) {
        $lista = "qwertyuioplkjhgfdsazxcvbnm";
        $char_array = preg_split("//", $lista);
        $pass = '';
        for($j=1; $j<=$ile; $j++) {
                $tmp = rand(0, 26);
                $znak = $char_array[$tmp];
                $pass = "$pass$znak";
        }
        return $pass;
	}
	
header('Content-Type: text/plain',true);

error_reporting(E_ALL);
ini_set('display_errors', '1');


echo "\nUWAGA!!! Plik ten sluzy tylko do wstepnej konfiguracji bazy i 
ze wzgledow bezpieczenstwa powinien zostac usuniety po utworzeniu bazy danych!
===============================================================================";

#config
$dbFile = '../sql/blog.db';

#utworz katalog z baza danych
if(!file_exists('../sql'))
{
	mkdir('../sql');
	chmod('../sql',0755);
}

#sprawdz czy plik bazy istnieje, jesli tak to zrobi kopie na wszelki wypadek ;)
if(file_exists($dbFile))
{
	$id = get_id(10);
	$newFileName = 'kopia_'.date('Y_m_d_h_i_s_').$id.'_blog.db';
	rename($dbFile,'../sql/'.$newFileName);
	
	#create new file
	$ourFileHandle = fopen($dbFile, 'w') or die("\n\ncan't open file");
	fclose($ourFileHandle);
	
	chmod($dbFile,0755);
	
	echo "\nSkopiowalem stary plik bazy do ".$newFileName." i utworzylem nowa baze!\n";
	
}
else
{
	#create new file
	$ourFileHandle = fopen($dbFile, 'w') or die("\n\ncan't open file");
	fclose($ourFileHandle);
	
	chmod($dbFile,0755);
	
	echo "\nUtworzylem nowy plik bazy. Nie bylo wczesniej pliku bazy!\n";
}

#process
	$db = new PDO("sqlite:".$dbFile);
	
	$db->query("CREATE TABLE user ( 
		id INTEGER PRIMARY KEY AUTOINCREMENT , 
		login TEXT,
		password TEXT,
		name TEXT,
		surname TEXT
	);");
	
	$db->query("CREATE TABLE wpis(
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		title TEXT,
		tresc TEXT,
		data_dodania INTEGER
	);");
	
	//level 1 - admin
	//password: asdf
	$db->exec("INSERT INTO user (id, login, password, name, surname) VALUES (
		1,
		'michal',
		'912ec803b2ce49e4a541068d495ab570',
		'Michał',
		'Cichoń'
	);");
	
	$db->exec("INSERT INTO wpis (title, tresc) VALUES (
		'Lubię rzepę',
		'Kocham rzepę. Jem ją na śniadanie, obiad, kolację, podwieczorek i przed snem.'
	);");
	
	echo "\n\nOK";
	