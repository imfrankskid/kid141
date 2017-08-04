<?php 
   include("connect_dbs.php"); 
   include("SQLPROC.inc");
?>
<html>
<head>
<title>新增一筆資料到 Books 中</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<?php
   //執行一個查詢指令並將結果放進$data變數中
   $data=$conn->query("select count(*) from Books where id=".$_REQUEST["id"]);
   $num=$data->fetchColumn();          //檢查欲新增的資料是否已存在
   //產生一個insert指令中values()括弧內所需的資料字串，存進變數$rsql中
   csql($conn,"Books",'v',$rsql);   
   //產生一個insert指令
   $isql="insert into Books values (" . $rsql . ")";
   echo "<br>所產生的 SQL 指令為：" . $isql;
   if ($num==0)                         //欲新增的資料尚未存在
   {
      //執行一個新增指令
      $conn->query($isql);    
      echo "<h3><font color= brown> 成功新增一筆資料到 Books 中! </font></h3>";
      echo "<center>";
      echo "<br>";
      echo "<table border=2>";
      echo "<caption><font size=4><b>資料新增後的關聯表 Books 內容</b></font></caption>";
      echo "<tr bgcolor='#cc66ff'>";
      echo "<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者";
      echo "<th><font color=white>價格<th><font color=white>出版社";
      echo "</tr>";
      //執行一個查詢指令並將結果放進$cur變數中
      $cur=$conn->query("select * from Books"); 
      //取出查詢結果的欄位內容
      while ($rec=$cur->fetch())
      {
         echo "<tr bgcolor='#ffccff'>";
         echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
         echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"] . "</tr>";
      }
      echo "</table>";
      echo "</center>";
   }
   else
      echo "<h3><font color= brown> 新增失敗! 此編號的資料已經存在! </font></h3>";
?>
<center>
<br>
<table>
<td><a href="insert_books.php">回上一頁</a>
<td width=20>
<td><a href="default.php">回首頁</a>
</table>
</center>
</body>
</html>