<?php include("connect_dbs.php"); ?>
<html>
<head>
<title>查詢 Books 關聯表內容</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<h3>以下是關聯表<font color=brown> Books</font> 目前的內容</h3>
<table border = 1>
<tr bgcolor="#cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
</tr>
<?php
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query("select * from Books");   
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"] . "</tr>";
       $recno++;
   }
?>
</table>
<?php
   if ($recno==0) 
      echo "<br><br><h3><font color = red> 抱歉! 沒有任何資料! </font></h3>";
?>
<br>
<table>
<td><a href="query_books.php">回上一頁</a>
<td width=20>
<td><a href="default.php">回首頁</a>
</table>
</center>
</body>
</html>