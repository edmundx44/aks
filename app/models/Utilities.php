<?php
namespace App\Models;
use Core\DB;
use Core\Input;
use Core\Model;
use App\Controllers\UtilitiesController;

class Utilities{


    public function __construct() {
    
	}


    /*------------------ USED THIS TO GET METACRITIC DISABLED OR NOT --------------*/
    public static function getMetacriticsNumberOfLinks($db){
        return $db;
        // $sql = "SELECT count(*) as count FROM `metacritic`.`statistics` WHERE `game_id` = $id";
        // return $db->query($sql)->first();
    }

    public static function getMetacriticsDisabledLinks($id){
        $sql = "SELECT count(*) as count1 FROM `metacritic`.`statistics` WHERE `game_id` = $id AND `status` = 1";
        return $db->query($sql)->first();
    }

}

