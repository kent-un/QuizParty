<?php

class connectionDb
{
	public $db;

	public function __construct(){
		$this->db = NULL;
		$this->connectDb();
		return $this->db; 
	}

	public function connectDb()
	{
		/* Récupération du contenu du fichier .json */
		$contenu_fichier_json = file_get_contents('json/infos.json');
		/* Les données sont récupérées sous forme de tableau (true) */
		$dbInfos = json_decode($contenu_fichier_json, true);
		try{
			$db = new PDO('mysql:host=' . $dbInfos['hostname'] . ';dbname=' . $dbInfos['dbname'], $dbInfos['dbuser'], $dbInfos['dbpassword']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$db->exec("SET NAMES utf8");
			if (!empty($db))
			{
				$this->db = $db;
			}
		}
		catch (Exception $e) {
			die ('Erreur : ' . $e->getMessage());
		}
		return $this->db;
	}
}

?>