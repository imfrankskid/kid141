<?php  include("connect_dbs.php"); ?>
<html>
<head>
<title>關聯表 Books 的查詢結果</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<h3>以下是訂購
<?php
  $ssql="select * from books where id=".$_REQUEST["bookid"];
  $cur=$conn->query($ssql);
  $rec=$cur->fetch();
  $price=$rec["price"];
  echo "<font color=brown>".$rec["bookname"] . "</font><font color=green>(單價" . $price . "元) </font>"; 
?>
的書局訂單資料</h3>
<table border=2 cellpadding=4>
<tr bgcolor="#cc66ff">
<th><font color=white>書局代號<th><font color=white>書局名稱<th><font color=white>所在縣市
<th><font color=white>數 量<th><font color=white>小 計</tr>
<?php
   //組合一個查詢指令
   $ssql="select bookstores.no, name, city, quantity, quantity *". $price . " as total " . "from bookstores, orders where bookstores.no=orders.no and orders.id=".$_REQUEST["bookid"];
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query($ssql);
   $recno=0;
   $num=0; $sum=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
      echo "<tr bgcolor='#ffccff'>";
      echo "<td align=center>" . $rec["no"] . "<td>" . $rec["name"] . "<td align=center>" . $rec["city"];
      echo "<td align=right>" . $rec["quantity"] . "本<td align=right>" . $rec["total"] . "元</tr>";
      $num += $rec["quantity"];
      $sum += $rec["total"];
      $recno++;
   }
   if ($recno!=0) 
   {
      echo "<tr bgcolor='#ffccff'>";
      echo "<td colspan=3 align=center><font color=green><b>合";
      for ($i=0; $i<10; $i++)
      echo "&nbsp;";
      echo "計<td align=right><font color=green><b>" . $num;
      echo "本<td align=right><font color=green><b>". $sum . "元</tr>";
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
