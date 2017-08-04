<html>
<head>
<title>查詢訂購水滸傳的書局資料</title>
</head>
<body bgcolor="#ffe6cc" alink=green vlink=blue>
<center>
<br>
<h3> 以下是訂購<font color=brown>水滸傳</font>的書局與數量</h3>
<table border = 1>
<tr bgcolor="#cc66ff">
<th><font color=white>書局名稱<th><font color=white>等級<th><font color=white>所在城市
<th><font color=white>訂購數量</tr>
<?php
   //建立一個資料庫伺服器連結，並選取工作的資料庫
   $conn = new PDO("sqlsrv:server=localhost;Database=BOB", "sa", "1234");
   $qsql="select * from Bookstores, Orders, Books where bookname='水滸傳' and Bookstores.no=Orders.no and Orders.id=Books.id";
   $recno=0;
   foreach ($conn->query($qsql) as $rec)      //執行一個查詢指令並取出查詢結果的欄位內容
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["name"] . "<td align=center>" . $rec["rank"];
       echo "<td align=center>" . $rec["city"] . "<td align=center>" . $rec["quantity"]."本";
       echo "</tr>";
       $recno++;
    }
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