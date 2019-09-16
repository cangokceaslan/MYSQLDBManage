<?php 
Class MYSQLDBManage extends Export{
    public function __construct($host,$username,$password,$db){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
    }
    public function connect(){
        $conn_str = 'mysql:host='.$this->host.';dbname='.$this->db;
        try{
            $conn = new PDO($conn_str,$this->username,$this->password) or die("WTF");
            return $conn;
        }catch (PDOException $e) {
            echo "<style>body{background:red !important;}</style>";
            die("<a href='http://google.com/search?q=".$e->getMessage()."' style='color:white;text-decoration: none;'><h2>".$e->getMessage() . "</h2></a><h3 style='color:white;'>Please Correct Your Mistake !!!!!!!</h3>");
        }
    }
    public function check_connection($error = "not"){
        $conn_str = 'mysql:host='.$this->host.';dbname='.$this->db;
        try{
            $conn = new PDO($conn_str,$this->username,$this->password);
            if($error == "show"){
                echo "<style>body{background:green !important;}</style>";
                echo "<h2 style='color:white;'>CONNECTION ESTABLISHED</h2>";
            }
            return true;
        }catch (PDOException $e) {
            if($error == "show"){
                echo "<style>body{background:red !important;)</style>";
                die("<a href='http://google.com/search?q=".$e->getMessage()."' style='color:white;text-decoration: none;'><h2>".$e->getMessage() . "</h2></a>");
                return false;
            }else{
                return false;
            }
        }
    }
    public function checkTable($table){
        $sql = "SHOW TABLES LIKE '$table'";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $conn = null;
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if($data != null){
            return true;
        }else{
            return false;
        }

    }
    public function createTable($name,$info){
        $columns = $info["columns"];
        $types = $info["types"];
        $keys = $info["keys"];
        $len = count($columns);
        $tableStr = "";
        for($i = 0; $i < $len; $i++){
            if($i == $len-1){
                $tableStr .= $columns[$i]." ".$types[$i]." ".$keys[$i];
            }else{
                $tableStr .= $columns[$i]." ".$types[$i]." ".$keys[$i].",";
            }
        }
        $sql = "CREATE TABLE $name ($tableStr)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $count = $stmt->rowCount();
        if($data != null){
            return true;
        }else{
            return false;
        }
    }
    public function preventAttacks($data){
        $finished = [];
        $temp = "";
        define('CHARSET', 'ISO-8859-1');
        define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
        for($i = 0; $i < count($data); $i++){
            $temp = htmlspecialchars($data[$i], REPLACE_FLAGS,CHARSET, true);
            $temp1 = htmlentities($temp,REPLACE_FLAGS,CHARSET, true);
            if($temp1 == $data[$i]){
                $temp2 = str_replace(["'",'"'],["\'",'\"'],$temp1);
                array_push($finished,$temp2);
            }else{
                $temp2 = "-";
                array_push($finished,$temp2);
            }
        }
        return $finished;
    }
    public function run($sql,$error="not",$fetch="assoc"){
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $conn = null;
        if($error == "show"){
        if($stmt->errorInfo()[0] > 0){
            echo "<style>body{background:red !important;)</style>";
            echo "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
        }
        }
        if($fetch == "assoc"){
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }else if($fetch == "array"){
            $data = $stmt->fetchAll();
        }
            return ["data"=>$data,"rows"=>$stmt->rowCount()];
    }
    public function insert($table,$keys,$values,$error="not"){
        $conn = $this->connect();
        $keys_str = "";
        $values_str = "";
        $length_keys_str = count($keys);
        $length_values_str = count($values);
        if($length_keys_str == $length_values_str){
        for($i = 0; $i < $length_keys_str; $i++){
            if($i == 0){
                $keys_str = "(".$keys[$i];
                $values_str = "('".$values[$i]."'";
            }else if($i == $length_keys_str-1){
                $keys_str = $keys_str.",".$keys[$i].")";
                $values_str = $values_str.",'".$values[$i]."')";
                
            }else{
                $keys_str = $keys_str.",".$keys[$i];
                $values_str = $values_str.",'".$values[$i]."'";
            }
        }
        $sql = "INSERT INTO ".$table.$keys_str." VALUES ".$values_str.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($error == "show"){
            if($stmt->errorInfo()[0] != 0){
                print "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
                print "<style>body{background:red !important;)</style>";
            }
        }
        if($stmt->rowCount() == 1){
            return true;
        }else{
            return false;
        }
        }else{
            echo "<style>body{background:red !important;)</style>";
            die("<h2 style='color:white;'>Error, Please adjust Keys and Values with same length<br/></h2><h3 style='color:white;'>Please Correct Your Mistake !!!!!!!</h3>");
        }
    }
    public function update($table,$keys,$values,$where_str,$error="not"){
        $conn = $this->connect();
        $update_str = "";
        $length_keys_str = count($keys);
        $length_values_str = count($values);
        if($length_keys_str == $length_values_str){
        for($i = 0; $i < $length_keys_str; $i++){
            if($i == 0){
                $update_str = $keys[$i]." = '".$values[$i]."', ";
            }else if($i == $length_keys_str-1){
                $update_str = $update_str.$keys[$i]." = '".$values[$i]."'";
            }else{
                $update_str = $update_str.$keys[$i]." = '".$values[$i]."', ";
            }
        }
        $sql = "UPDATE ".$table." SET ".$update_str." WHERE ".$where_str.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($error == "show"){
            if($stmt->errorInfo()[0] != 0){
                print "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
                print "<style>body{background:red !important;)</style>";
            }
        }
        if($stmt->rowCount() == 1){
            return true;
        }else{
            return false;
        }
        }else{
            echo "<style>body{background:red !important;)</style>";
            die("<h2 style='color:white;'>Error, Please adjust Keys and Values with same length<br/></h2><h3 style='color:white;'>Please Correct Your Mistake !!!!!!!</h3>");
        }
    }
    public function select($table,$select_keys,$where_str,$fetch_type,$error="not",$attacks="search"){
        $sql = "SELECT ".$select_keys." FROM ".$table." WHERE ".$where_str.";";
        //echo $sql;
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($error == "show"){
            if($stmt->errorInfo()[0] != 0){
                print "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
                print "<style>body{background:red !important;)</style>";
            }
        }
        if($fetch_type == "assoc"){
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }else if($fetch_type == "array"){
            $result = $stmt->fetchAll(\PDO::FETCH_NUM);
        }else{
            echo "Enter a right Keyword";
        }
        //echo $sql;
        return $result;
    }
    public function delete($table,$where_str,$error="not"){
        $conn = $this->connect();
        $sql = "DELETE FROM ".$table." WHERE ".$where_str;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($error == "show"){
            if($stmt->errorInfo()[0] != 0){
                print "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
                print "<style>body{background:red !important;)</style>";
            }
        }
        if($stmt->rowCount() == 1){
            return true;
        }else{
            return false;
        }
    }
    public function inner_join($table,$ontable,$joiningtable,$onjoining){
        $create = $table." INNER JOIN ".$joiningtable." ON ".$table.".".$ontable." = ".$joiningtable.".".$onjoining;
        return $create;
    }
    public function search($table,$column,$search,$where_str,$fetch_type="assoc"){
        $col_str = "";
        $length_column = count($column);
        for($i = 0;$i < $length_column; $i++){
            if($length_column != 0 && $i < $length_column-1){
                $col_str = $col_str."LOWER(CONCAT(".$column[$i].")) LIKE LOWER('%".$search."%') OR ";
            }else{
                $col_str = $col_str."LOWER(CONCAT(".$column[$i].")) LIKE LOWER('%".$search."%')";
            }
        }
        $where_search_str = $col_str." AND ".$where_str;
        $conn = $this->connect();
        $sql = "SELECT * FROM ".$table." WHERE ".$where_search_str.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($error == "show"){
            if($stmt->errorInfo()[0] != 0){
                print "<h2 style='color:white;'>SQLSTATE ERROR CODE [".$stmt->errorInfo()[1]."] <br/>".$stmt->errorInfo()[2]."</h2>";
                print "<style>body{background:red !important;)</style>";
            }
        }
        if($fetch_type == "assoc"){
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }else if($fetch_type == "array"){
            $result = $stmt->fetchAll(\PDO::FETCH_NUM);
        }else{
            echo "Enter a right Keyword";
        }
        return $result;
    }
}
abstract Class Types{
    const FETCH_ASSOC = 'assoc';
    const FETCH_ARRAY = 'array';
    const SHOW_ERROR = 'show';
}
Class Export{
    function __construct(){
    }
    public function exportXML($root_element_name,$keys,$data){
        $file_name = "download.xml";
        header("Content-Disposition: attachment; filename=$file_name");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/xml");
        $this->readyXML($root_element_name,$keys,$data);
    }
    public function showXML($root_element_name,$keys,$data){
        header("Content-type: text/xml");
        $this->readyXML($root_element_name,$keys,$data);
    }
    public function readyXML($root_element_name,$keys,$data){
        $xml = new SimpleXMLElement("<{$root_element_name}></{$root_element_name}>");
        $str = "";
        $count = count($data);
        if($count >= 1){
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><".$root_element_name.">";
        for($i = 0; $i < $count; $i++){
            $str = $str.$this->assocArrayToXML($data[$i],$xml->addChild($keys));
        }
            echo $str."</".$root_element_name.">";
        }else{
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><".$root_element_name.">";
            $str = $str.$this->assocArrayToXML($data[0],$xml->addChild($keys));
            echo $str."</".$root_element_name.">";
        }
    }
    private function assocArrayToXML($ar,$xml){
        $f = create_function('$f,$c,$a',' 
                foreach($a as $k=>$v) { 
                    if(is_array($v)) { 
                        $ch=$c->addChild($k); 
                        $f($f,$ch,$v); 
                    } else { 
                        $c->addChild($k,$v); 
                    } 
                }');
            $f($f,$xml,$ar);
        return $xml->asXML(); 
    }
    public function exportJSON($data){
        header('Content-Type: application/json');
        header("Content-Disposition: attachment; filename=$file_name");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo json_encode($data);
    }
    public function showJSON($data){
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function exportCSV($keys,$data){
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->outputCSV($keys,$data);
    }
    public function showCSV($keys,$values){
        header('Content-type: text/plain');
        $data = array_merge($keys,$values);
        foreach ($data as $row) {
            $numItems = count($row);
            $i = 0;
            foreach($row as $veri){
                if(++$i === $numItems){
                    echo $veri."\n";
                }else{
                    echo $veri.",";
                }
                
            }
        }
    }
    public function outputCSV($keys,$values,$file_name = 'file.csv') {
         $data = array_merge($keys,$values);
         $output = fopen("php://output", "w");
         foreach ($data as $row) {
             fputcsv($output, $row);
         }
         fclose($output);
     }
}

?>