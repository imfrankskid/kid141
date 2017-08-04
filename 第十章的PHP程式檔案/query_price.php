<?php  include("connect_dbs.php"); ?>
<html>
<head><title>關聯表 Books 的查詢結果</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<h3>以下是價格 
<font color = brown><?php echo $_REQUEST["rel"]. $_REQUEST["price"]; ?></font>
 的書籍資料</h3>
<table border=2>
<tr bgcolor="#cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>出版社<th><font color=white>價格
</tr>
<?php
   //組合一個查詢指令
   $ssql="select * from books where price ". $_REQUEST["rel"] . $_REQUEST["price"];
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query($ssql);
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td align=center>" . $rec["bookname"];
       echo "<td align=center>" . $rec["author"] . "<td align=center>" . $rec["publisher"];
       echo "<td align=center>" . $rec["price"];
       echo "</tr>";
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


