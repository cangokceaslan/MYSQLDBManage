<?php 
require("./src/MYSQLDBManage.php");

$manage = new MYSQLDBManage("127.0.0.1","root","root","example");
if($manage->checkTable("people1")){
    echo "Tablo Mevcut";
}else{

    $arr = array(
       "columns"=>["id","name","surname","tel","email"],
       "types"=>["int","varchar(255)","varchar(255)","varchar(255)","varchar(255)"],
       "keys"=>["NOT NULL UNIQUE","NOT NULL","NOT NULL","NOT NULL","NOT NULL"]
    );
    $sql = $manage->createTable("people1",$arr);
    echo "Tablo Yaratildi";


}
?>