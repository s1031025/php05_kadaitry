<?php
session_start();
//1. POSTデータ取得
$name   = filter_input( INPUT_POST, "name" );
$email  = filter_input( INPUT_POST, "email" );
$naiyou = filter_input( INPUT_POST, "naiyou" );
$age    = filter_input( INPUT_POST, "age" );

if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
    
    $file_name = $_FILES["upfile"]["name"];//ファイル名取得
    $tmp_path  = $_FILES["upfile"]["tmp_name"];//一時保存場所

    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = date("YmdHis").md5(session_id()) . "." . $extension;

    // FileUpload [--Start--]
    $img="";
    $file_dir_path = "upload/".$file_name;
    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
            chmod( $file_dir_path, 0644 );
            // $img = '<img src="'.$file_dir_path.'">';
        } else {
            // echo "Error:アップロードできませんでした。";
        }
    }
 }else{
    //  $img = "画像が送信されていません";
 }
//2. DB接続します
//include "../../includes/funcs.php";
include "funcs.php";
$pdo = db_con();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_an_table(name,email,naiyou,indate,age,img)VALUES(:name,:email,:naiyou,sysdate(),:age,:img)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':age', $age, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':img', $file_name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sqlError($stmt);
} else {
    //５．index.phpへリダイレクト
    header("Location: index.php");
    exit;
}
