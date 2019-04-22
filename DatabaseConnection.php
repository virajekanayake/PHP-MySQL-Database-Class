<?php

/*

Copyright 2016 Viraj Ekanayake <virajekanayake@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

*/

class DatabaseConnection
{
     protected static $connection;


     private function getConnection() {
        if(!isset(self::$connection)) {
            $config = parse_ini_file('DbConfig.ini');
            self::$connection = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
            self::$connection->set_charset("utf8");
        }
        if(self::$connection === false) {
            return false;
        }
        return self::$connection;
    }

    /**
     * Insert data to MySQL Database
     * @param  string $query mysql insert/update query
     * @return boolean $result returns 1 on success
     */

     public function insertQuery($query) {
        $connection = $this -> getConnection();
        $result = $connection -> query($query);
        return $result;
    }

    /**
     * Retrieve data from MySQL Database
     * @param  string $query mysql select query
     * @return boolean $result returns 1 on success
     */
     public function selectQuery($query) {
        $rows = array();
        $result = $this -> insertQuery($query);
        if($result === false) {
            return false;
        }
        while ($row = $result -> fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Return Error
    public function getError() {
        $connection = $this -> getConnection();
        return $connection -> error;
    }
    /**
     * remove quotes from a string
     * @param  string $value string to be escaped
     * @return string string after escaping single quotations
     */
    public function escapeQuote($value) {
        $connection = $this -> getConnection(); // get mysql connection
        return "'" . $connection -> real_escape_string(trim($value)) . "'";
    }


    /**
     * Get the current server time in following format
     * @return string string date
     */
    public function getCurrentTime(){
        date_default_timezone_set('Asia/Colombo');
        $current_time = date('m/d/Y h:i:s a', time());
        return $current_time;
    }

    /**
     * remove quotes from a string
     * @param  string $value string nee to remove quotes
     * @return string string after escaping single quotations
     */
    public function removeQuotes($value){
       $replacedvalue = str_replace("'", "", $value) ;
       return $replacedvalue;
    }


}
?>
