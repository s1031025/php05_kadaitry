<?php
session_start();
if( $_SESSION["sess_id"]==session_id() ){
    //新しいSessionIDを発行
    session_regenerate_id();
    //新SessionIDを取得して変数を上書き
    $_SESSION["sess_id"] = session_id();
    //echo してAjaxに値を戻してあげます。 
    echo session_id();
}else{
    echo "false";
}



?>


