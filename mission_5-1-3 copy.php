<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>mission_3-5 sql ver</title>
    </head>
    <body>
         <!--mission_1-20を使う　数値を扱うのでtype="text"からnumberへ-->
        <form action="" method="post">
            <h3/>【投稿フォーム】</h3>
            <input type="string" name="name" placeholder="Name"><br>
            <input type="string" name="comment" placeholder="Comment">
            <input type="string" name="pass1" placeholder="Password">
            <button type="submit" name="flag" value=1>投稿</button><br><br>
            
            <h3/>【削除フォーム】</h3>
            <input type="number" name="dstep" placeholder="Delete Number">
            <input type="password" name="pass2" placeholder="Password">
            <button type="submit" name="dflag" value=1 >削除</button><br><br>
            
            <h3/>【編集フォーム】</h3>
            <input type="number" name="estep" placeholder="Edit Number">
            <input type="password" name="pass3" placeholder="Password">
            <button type="submit" name="eflag" value=1>編集</button>
            
           
        </form>
        <?php
        //DB接続設定
        $dsn='データベース名';
        $user='ユーザー名';
        $password='パスワード';
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        //テーブル作成
        $sql="CREATE TABLE IF NOT EXISTS mission5"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."submitDate datetime,"
        ."password char"
        .");";
        $stmt=$pdo->query($sql);
           //新規投稿関係
           $name=$_POST["name"];
           $comment=$_POST["comment"];
           $submitDate=date("Y/m/d/H:i:s");
           //削除関係
           $dstep=$_POST["dstep"];
           $dflag=$_POST["dflag"];
           //編集関係
           $estep=$_POST["estep"];
           $eflag=$_POST["eflag"];
           //パスワード
           $pass1=$_POST["pass1"];//新規投稿
           $pass2=$_POST["pass2"];//削除
           $pass3=$_POST["pass3"];//編集
           
           //削除
           if($dflag==1 && !empty($pass2)){
               $sql=$pdo->prepare("DELETE FROM mission5 WHERE id=:id");
               $sql->bindParam(':id',$dstep);
               $sql->execute();
           //編集
           }elseif($eflag==1 && !empty($name && $comment && $pass3)){
               $id=$estep; //変更する投稿番号
               $sql='UPDATE mission5 SET name=:name,comment=:comment WHERE id=:id';
               $stmt=$pdo->prepare($sql);
               $stmt->bindParam(':name',$name,PDO::PARAM_STR);
               $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
               $stmt->bindParam(':id',$estep);
               $stmt->execute();
           }else{
               //データ入力
               if(!empty($name && $comment && $pass1)){
               $sql=$pdo->prepare("INSERT INTO mission5(name,comment,submitDate)VALUES(:name,:comment,:submitDate)");
               $sql->bindParam(':name',$name,PDO::PARAM_STR);
               $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
               $sql->bindParam(':submitDate',$submitDate);
               $sql->execute();
               }
           }
           //表示
           echo "表示中"."<br>";
           $sql='SELECT*FROM mission5';
           $stmt=$pdo->query($sql);
           $results=$stmt->fetchAll();
           foreach($results as $row){
               //$rowの中にはテーブルのカラム名が入る
               echo $row['id'].',';
               echo $row['name'].',';
               echo $row['comment'].',';
               echo $row['submitDate'].'<br>';
               echo "<hr>";
           }
           ?>
    </body>
</html>
    </body>
    </html>