<?php
/**
 * htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
 *  include "../../includes/funcs.php";
 * "../"は一つ上の階層、"../../"２つ上の階層を意味します。
 */

//共通に使う関数を記述
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function db_con(){
    define("DB_NAME","gs_db5");
    define("DB_HOST","localhost");
    define("DB_ID","root");
    define("DB_PW","");
    try {
        $pdo = new PDO('mysql:dbname='.DB_NAME.';charset=utf8;host='.DB_HOST,DB_ID,DB_PW);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB-Connection-Error:'.$e->getMessage());
      }      
}

function redirect($page){
    header("Location: ".$page);
    exit;
}

function sqlError($stmt){ 
    $error = $stmt->errorInfo();
    exit("ErrorSQL:".$error[2]);
}

function sessChk(){
    if(!isset($_SESSION["chk_ssid"]) || 
        $_SESSION["chk_ssid"]!=session_id()){
        exit("Error");
    }else{
        session_regenerate_id(true);
        $_SESSION["chk_ssid"]=session_id();
    }
}
