<?php
  //POSTパラメータを取得
  $id = $_POST["id"];
  $mode = $_POST["mode"];
  $type = $_POST["type"];
  $sleep = $_POST["sleep"];
  // sleep($sleep);  //Timeoutテスト用
  // echo "<div>あああああ</div><div>いいいいい</div><div>ううううう</div>";
  
 $json = '[
   {
     "id":"'.$id.'",
     "mode":"'.$mode.'",
     "type":"'.$type.'"
   },
   {
    "id":"'.$id.'",
    "mode":"'.$mode.'",
    "type":"'.$type.'"
   }
 ]';
 echo $json;
exit;
?>
