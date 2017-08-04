<html>
<head>
<title>查詢天秤書局所訂購的書</title>
</head>
<body bgcolor="#ffe6cc" alink=green vlink=blue>
<center>
<br>
<h3>以下是<font color=brown>天秤書局</font>所訂購的書</h3>
<table border = 1>
<tr bgcolor="#cc66ff">
<th><font color=white>書名<th><font color=white>作者<th><font color=white>價格
<th><font color=white>出版社<th><font color=white>數量</tr>
<?php
   //建立一個資料庫伺服器連結，並選取工作的資料庫
   $connectionInfo = array("UID" => "sa", "PWD" => "1234", "Database"=>"BOB","CharacterSet" => "UTF-8");
   $conn = sqlsrv_connect("(local)", $connectionInfo);
   $qsql="select * from Bookstores, Orders, Books where name='天秤書局' and Bookstores.no=Orders.no and Orders.id=Books.id";
   $cur = sqlsrv_query($conn, $qsql);         //執行一個查詢指令並將結果放進$cur變數中
   $recno=0;
   while ($rec=sqlsrv_fetch_array($cur))      //取出查詢結果的欄位內容
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["bookname"] . "<td align=center>" . $rec["author"];
       echo "<td align=center>" . $rec["price"] . "元<td align=center>" . $rec["publisher"];
       echo "<td align=center>" . $rec["quantity"] . "本";
       echo "</tr>";
       $recno++;
   }
   sqlsrv_close($conn);
?>
</table>
<?php
   if ($recno==0) 
      echo "<br><br> <h2> <font color = red> 抱歉! 沒有任何資料! </font></h2>";
?>
<br>
</center>
</body>
</html>