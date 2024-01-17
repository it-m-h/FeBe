<?php

declare(strict_types=1);

namespace lib;

abstract class Domain {
    public static function initDomain() {
        // init Domain - Database
        //if (!isset($_SESSION['DB'])) {
            $db = new \PDO('sqlite:'.DB_FILE);
            $sql = 'SELECT * FROM domain WHERE domain_name = "'.DOMAIN.'" AND domain_active = 1';
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $temp = $stmt->fetchAll();
            if (count($temp) > 0 && isset($temp[0]['domain_database'])) {
                //$db = BASEPATH.'data'.DS.$temp[0]['domain_database'];
                $db = $temp[0]['domain_database'];
                $_SESSION['DB'] = $db;
            } 
            $db = null;
        //}
    }
}