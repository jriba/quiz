<?php 
    class database{
        // Seting DB configs.
        private $host = 'localhost';
        private $db_name = 'QUIZ';
        private $db_user = 'root';
        private $password = '';
        public $con;

        // creating connection for DB
        private function getConnection(){
            $this->con = null;
            try{
                $this->conn = new mysqli($this->host, $this->db_user, $this->password, $this->db_name);
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }

        /**
         * fetchig data from db 
         *
         * @param string $query - sql query
         * @return array $res - all selected values from db
         */
        public function getData(string $query = null){
            $res = array();
            if($query != null){

                $conn = $this->getConnection();
                $result = $conn->query($query);
                if (!empty($result)){
                    while($row = $result->fetch_assoc()) {
                        $res[] = $row;
                    }
                } else {
                    return  "Sorry, No data found!";
                }
            }else{
                return "Data NOT found";
            }
            return $res;
        }

        /**
         * Inserting data in database
         *
         * @param string $query - sql string for data insert
         * @return void
         */
        public function insertData(string $query = null){
            $result = array();
            if($query != null){
                $conn = $this->getConnection();
                $result = $conn->query($query);
                if (!empty($result)){
                    return  "Sorry, No data found!";
                }
            }else{
                return "Data NOT found";
            }
            return $result;
        }
    }
?>