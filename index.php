<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php" enctype="multipart/form-data">
  <div class="jumbotron">
   <fieldset>
    <legend>フリーアンケート</legend>
     <label>名前：<input type="text" name="name"></label><br>
     <label>Email：<input type="text" name="email"></label><br>
     <label>年齢：<input type="text" name="age"></label><br>
     <label><textArea name="naiyou" rows="4" cols="40"></textArea></label><br>
     <input type="file" name="upfile">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<?php
//tmhOAuth.phpをインクルードします。ファイルへのパスはご自分で決めて下さい。
require_once("./tmhOAuth.php");

//Access Tokenの設定 apps.twitter.com でご確認下さい。
//Consumer keyの値を格納
$sConsumerKey = "TYrknBghWeXbaOhSta8Mcnjr9";
//Consumer secretの値を格納
$sConsumerSecret = "AlJLh0zIDOapNYe5E2zFlVYHNWx8JVdvKMBj5YGmO1WmpaP0SL";
//Access Tokenの値を格納
$sAccessToken = "151081451-3fkbyo2mwuvkawpvWrk1YPzPmQZUOlD2vse6oiS0";
//Access Token Secretの値を格納
$sAccessTokenSecret = "BHQssEjx3yIoVatBZicpXCGNbx8oH4fbYPeinDHYb6l5r";

//OAuthオブジェクトを生成する
$twObj = new tmhOauth(
						array(
						"consumer_key" => 		$sConsumerKey,
						"consumer_secret" => 	$sConsumerSecret,
						"token" => 				$sAccessToken,
						"secret" => 			$sAccessTokenSecret,
						"curl_ssl_verifypeer" => false,
						)
					);

//Twitter REST API 呼び出し
$code = $twObj->request( 'GET', "https://api.twitter.com/1.1/statuses/home_timeline.json",array("count"=>"10"));

// statuses/home_timeline.json の結果をjson文字列で受け取り配列に格納
$aResData = json_decode($twObj->response["response"], true);

//配列を展開
if(isset($aResData['errors']) && $aResData['errors'] != ''){
	?>
	取得に失敗しました。<br/>
	エラー内容：<br/>
	<pre>
	<?php var_dump($aResData); ?>
	</pre>
<?php
}else{
	//配列を展開
	$iCount = sizeof($aResData);
	for($iTweet = 0; $iTweet<$iCount; $iTweet++){
		$iTweetId =                 $aResData[$iTweet]['id'];
		$sIdStr =                   (string)$aResData[$iTweet]['id_str'];
		$sText=                     $aResData[$iTweet]['text'];
		$sName=                     $aResData[$iTweet]['user']['name'];
		$sScreenName=               $aResData[$iTweet]['user']['screen_name'];
		$sProfileImageUrl =         $aResData[$iTweet]['user']['profile_image_url'];
		$sCreatedAt =               $aResData[$iTweet]['created_at'];
		$sStrtotime=                strtotime($sCreatedAt);
		$sCreatedAt =               date('Y-m-d H:i:s', $sStrtotime);
		?>
		<hr/>
		<h3><?php echo $sName; ?>さんのつぶやき</h3>
		<ul>
		<li>IDNO[id] : <?php echo $iTweetId; ?></li>
		<li>名前[name] : <?php echo $sIdStr; ?></li>
		<li>スクリーンネーム[screen_name] : <?php echo $sScreenName; ?></li>
		<li>プロフィール画像[profile_image_url] : <img src="<?php echo $sProfileImageUrl; ?>" /></li>
		<li>つぶやき[text] : <?php echo $sText; ?></li>
		<li>ツイートタイム[created_at] : <?php echo $sCreatedAt; ?></li>
		</ul>
<?php
	}//end for
}
?>

<!-- Main[End] -->


</body>
</html>
