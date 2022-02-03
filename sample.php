<?php



// $list = array (
//     array('aaa', 'bbb', 'ccc', 'dddd'),
//     array('123', '456', '789'),
//     array('"aaa"', '"bbb"')
// );

// $fp = fopen('file.csv', 'w');

// foreach ($list as $fields) {
//     fputcsv($fp, $fields);
// }

// fclose($fp);
$x1 = '2323';
$x = strlen($x1);

if($x == '4') {
echo '0'.$x1; 
}

// $length = 12;
// $emp_net = 222230012;
//  $zero = '';

// for($i=0;$i<$length;$i++) {

//   if(strlen($emp_net) == $i) {
//     //echo "equal, length is ".strlen($emp_net);
//     $strl = strlen($emp_net);
//     $x = $length - $strl;

    

//     for($y=0;$y<$x;$y++) {
//         $emp_net  =  "0".$emp_net;
//     }
//   }
// }

// echo $emp_net;



// $n = 1.25;
// $whole = floor($n);      // 1
// $fraction = $n - $whole; // .25

// echo $whole.'<br>';
// echo $fraction;


// $query


// $file = "test.txt";
// $txt = fopen($file, "w") or die("Unable to open file!");
// fwrite($txt, "lorem ipsum");
// fclose($txt);

// header('Content-Description: File Transfer');
// header('Content-Disposition: attachment; filename='.basename($file));
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($file));
// header("Content-Type: text/plain");
// readfile($file);

// echo $date = date("Y-m-d H:i");$

// $myvalue = 's a';
// $arr = explode(' ',trim($myvalue));
// echo $arr[0]; // will print Test
 
    // $dbHost = 'localhost';
    // $dbUsername = 'root';
    // $dbPassword = '';
    // $dbName = 'dts';
    // $tables = '*';

    // $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

    // //get all of the tables
    // if($tables == '*'){
    //     $tables = array();
    //     $result = $db->query("SHOW TABLES");
    //     while($row = $result->fetch_row()){
    //         $tables[] = $row[0];
    //     }
    // }else{
    //     $tables = is_array($tables)?$tables:explode(',',$tables);
    // }

    // foreach($tables as $table){
    //     $result = $db->query("SELECT * FROM $table");
    //     $numColumns = $result->field_count;

    //     $return .= "DROP TABLE $table;";

    //     $result2 = $db->query("SHOW CREATE TABLE $table");
    //     $row2 = $result2->fetch_row();

    //     $return .= "\n\n".$row2[1].";\n\n";

    //     for($i = 0; $i < $numColumns; $i++){
    //         while($row = $result->fetch_row()){
    //             $return .= "INSERT INTO $table VALUES(";
    //             for($j=0; $j < $numColumns; $j++){
    //                 $row[$j] = addslashes($row[$j]);
    //                 $row[$j] = preg_replace("\n","\\n",$row[$j]);
    //                 if (isset($row[$j])){ 
    //                     $return .= '"'.$row[$j].'"' ; 
    //                 } else {
    //                     $return .= '""'; 
    //                 }
    //                 if ($j < ($numColumns-1)) {
    //                     $return.= ','; 
    //                 }
    //             }
    //             $return .= ");\n";
    //         }
    //     }

    //     $return .= "\n\n\n";
    // }

    // //save db file in same folder
    // $handle = fopen('db-backup-'.time().'.sql','w+');
    // fwrite($handle,$return);
    // fclose($handle);
?>