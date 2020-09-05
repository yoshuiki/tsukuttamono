<?php
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//4-1で書いた「// DB接続設定」のコードの下に続けて記載する。


//新規投稿
if(!empty($_POST["name"]) && !empty($_POST["comment"])
    &&empty($_POST["delete"]) &&empty($_POST["edit"])
    &&empty($_POST["editnumber"])
    &&!empty($_POST["valpassword"])&&$_POST["valpassword"]=="anaya"){
	$sql = $pdo -> prepare("INSERT INTO mission51 (name, comment,date) 
	VALUES (:name, :comment, :date)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$date = date("Y/m/d H:i:s");
	$name = $_POST["name"];
	$comment = $_POST["comment"];//好きな名前、好きな言葉は自分で決めること
	
	$sql -> execute();

	//bindParamの引数名（:name など）はテーブルのカラム名に併せるとミスが少なくなります。
	//最適なものを適宜決めよう。
	//$rowの添字（[ ]内）は、4-2で作成したカラムの名称に併せる必要があります。
	/*$sql = 'SELECT * FROM tbtest51';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}*/
        
    }
	
	//削除
	if(!empty($_POST["delete"])&&empty($_POST["editnumber"])
	&&!empty($_POST["delpassword"])&&$_POST["delpassword"]=="anaya"){
	$id = $_POST["delete"];
	$sql = 'delete from mission51 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$sql = 'SELECT * FROM mission51 WHERE id=:id ';
$stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
$stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
$stmt->execute();                             // ←SQLを実行する。
$results = $stmt->fetchAll(); 
	}
	
	//編集
if(!empty($_POST["edit"])&&!empty($_POST["editpassword"])
&&$_POST["editpassword"]=="anaya"){
$id = $_POST["edit"];
$sql = 'SELECT * FROM mission51 WHERE id=:id ';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll();
foreach($results as $row2){
    
$editnumber = $id;
$editname = $row2['name'];
$editcomment = $row2['comment'];
}}

//bindParamの引数（:nameなど）は4どんな名前のカラムを設定したかで変える必要がある。
	if(!empty($_POST["editnumber"])&&
	!empty($_POST["name"]) && !empty($_POST["comment"])
	&&!empty($_POST["valpassword"])&&$_POST["valpassword"]=="anaya"){
	$id = $_POST["editnumber"]; //変更する投稿番号
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	//変更したい名前、変更したいコメントは自分で決めること
	$date = date("Y/m/d H:i:s");
	$sql = 'UPDATE mission51 SET name=:name,comment=:comment,date=:date WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$stmt->execute();
	$sql = 'SELECT * FROM mission51 WHERE id=:id ';
$stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
$stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
$stmt->execute();                             // ←SQLを実行する。
}
	
$sql = 'SELECT * FROM mission51';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	echo "<hr>";
	}
?>

<form action="" method="post">
        <input type="text" name="name" value=
        "<?php if(!empty($_POST["edit"])){echo $editname;}?>" 
        placeholder="なまえ"><br>
        
        <input type="text" name="comment" value=
        "<?php if(!empty($_POST["edit"])){echo $editcomment;}?>" 
        placeholder="こめんと">
        
        <input type="text" name="valpassword" placeholder="パスワード">
         
        <input type="text" name="editnumber" value=
        "<?php if(!empty($_POST["edit"])){echo $editnumber;}?>" 
        placeholder="編集中の番号">
        <input type="submit" name="submit"><br><br>
        
        <input type="text" name="delete" placeholder="番号">
        <input type="text" name="delpassword" placeholder="パスワード">
        <input type="submit" value="削除"><br><br>
        
        <input type="text" name="edit" placeholder="番号"/>
        <input type="text" name="editpassword" placeholder="パスワード">
        <input type="submit" value="編集">
    </form>