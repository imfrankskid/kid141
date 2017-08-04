<?php 
   include("connect_dbs.php"); 
   session_start();
?>
<html>
<head>
<title>完成更新 Books 關聯表中指定的資料</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<?php
   //產生一個update指令
   $usql = "update Books set " . $_SESSION["setstr"] . " where " . $_SESSION["updatecond"];
   echo "<br>所產生的 SQL 指令為：" . $usql;
   echo "<table border=0><tr><td width=900>";
   echo "<td><input type='button' value='回更新網頁' OnClick=location.href('update_books.php')>";
   echo "<td><input type='button' value='回首頁' OnClick=location.href('default.php')>";
   echo "</table>";
   //執行一個更新指令
   if ($conn->query($usql)) {     
      echo "<font size=4 color=brown><b>成功更新 Books 中的 " . $_SESSION["updateno"] . " 筆資料！";
      if ($_REQUEST["infrno"]>0)  //表示連鎖反應，一併更新Orders資料
      echo "連帶更新 Orders 中的 " . $_REQUEST["infrno"] . " 筆資料！";
      echo "<center>";
      echo "<h2><font color=green>資料更新後關聯表的內容<hr width=400>";
      echo "<table border=0>";
      echo "<tr valign=top>";
      echo "<td align=center><font size=4><b>Books</b></font><br>";
      echo "<table border=2>";
      echo "<tr bgcolor='#cc66ff'>";
      echo "<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者";
      echo "<th><font color=white>價格<th><font color=white>出版社";
      //執行一個查詢指令並將結果放進$cur變數中
      $cur=$conn->query("select * from Books"); 
      //取出查詢結果的欄位內容
      while ($rec=$cur->fetch())
      {
         echo "<tr bgcolor='#ffccff'>";
         echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
         echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"];
      }
      echo "</table>";
      if ($_REQUEST["infrno"]>0) {
         echo "<td width=30><td align=center><font size=4><b>Orders</b></font><br>";
         echo "<table border=2>";
         echo "<tr bgcolor='#cc66ff'>";
         echo "<th><font color=white>書局代號<th><font color=white>書名代號<th><font color=white>訂購數量";
         $cur=$conn->query("select * from Orders"); 
         while ($rec=$cur->fetch())
         {
            echo "<tr bgcolor='#ffccff' align=center>";
            echo "<td>" . $rec["no"] . "<td>" . $rec["id"] . "<td>" . $rec["quantity"];
         }
         echo "</table>";
      }
      echo "</table></center>";
   }
   else
   {
      echo "<font size=4 color=brown><b>更新失敗！</b><br>";
      echo "<font size=3 color=green>因為外來鍵的更新規則為<font color=brown>RESTRICTED</font>，";
      echo "且欲更新的主鍵值被關聯表Orders的外來鍵值參考到！";
   }
?>
</body>
</html>