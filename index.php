<?php 
require('./src/MYSQLDBManage.php');
abstract Class TableNames{

}
$manage = new MYSQLDBManage("127.0.0.1:3306","root","root","example");
//$checkConnection = $manage->check_connection(Types::SHOW_ERROR);
if($manage->checkTable("image")){

}else{
    $json = array(
        "columns"=>["id","name","can"],
        "types"=>["int","varchar(255)","varchar(255)"],
        "keys"=>["NOT NULL UNIQUE AUTO_INCREMENT","NOT NULL",""]
    );
    $manage->createTable("image8",$json);
}
// $sql = "INSERT INTO person(id,name,surname,number,date) VALUES (21,'Can','Gokceaslan','05444850586','2019-09-12');";
// $inner_join = $manage->inner_join(TableNames::tables[2],"product_id",TableNames::tables[1],"id");
// $sql = "SELECT * FROM person WHERE 1";
// $result = $manage->run($sql,$assoc=Types::FETCH_ASSOC);
// print_r($result);
//$result = $manage->search("person",TableNames::table_keys["person"],"Can","1");
// $manage->showXML("Data","element",$result);
//$manage->showJSON($result);
// $exportjson = $manage->exportCSV(Array(TableNames::table_keys["person"]),$result);
// $showxml = $manage->showJSON($result);
// $variable = $manage->preventAttacks(["<section>BASIUDFHASDUH</section>","<script>alert('Can')</script>","<script>","'","CAN"]);
// $showxml = $manage->showJSON($variable);
// $is_done = $manage->insert(TableNames::tables[0],TableNames::table_keys["person"],[32,"Can","Gokceaslan","05230000000","2019-06-29"],Types::SHOW_ERROR);
// $is_done = $manage->update(TableNames::tables[0],TableNames::table_keys["person"],[550,"Can","Amcan","05442342523","2019-10-11"],"id=32",Types::SHOW_ERROR);
/* $is_done = $manage->delete(TableNames::tables[0],"id=550",Types::SHOW_ERROR);
if($is_done){
    echo "DONE";
}else{
    echo "ERROR";
} */
// $where = $manage->preventAttacks(["1",'"tryout"','<a href="./can.php">tryout</a>']);
// $data = $manage->select(TableNames::tables[0],"*","1",Types::FETCH_ASSOC,Types::SHOW_ERROR);
// $data = [["id"=>"1","name"=>"Can","surname"=>"Gökçeaslan","photos"=>["long"=>"https://cangokceaslan.github.io/images/cangokceaslan-long.jpg","normal"=>"https://cangokceaslan.github.io/images/cangokceaslan.jpg"]]];
// $showxml = $manage->showXML("Data","person",$data);
// $showjson = $manage->exportCSV(Array(TableNames::table_keys["person"]),$data);
// $showcsv = $manage->showCSV(Array(TableNames::table_keys["person"]),$data);
// $exportxml = $manage->exportXML("Can","cancan",$data);
// $exportjson = $manage->exportJSON($data);
// $exportcsv = $manage->exportCSV(Array(TableNames::table_keys["person"]),$data);
// if($is_done){
//     echo "Done";
// }else{
//     echo "Not Done";
// }
//$manage->showJSON($data);
?>