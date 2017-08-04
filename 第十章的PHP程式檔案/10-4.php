<?php
   //將字串$str的字元編碼由Big5轉換為UTF-8傳回。
   function toUTF8($str='')
   {
      return iconv("Big5","UTF-8",$str);
   }
?>
<html>
<head>
<title>查詢 Bookstores 關聯表內容</title>
</head>
<body bgcolor="#ffe6cc" alink=green vlink=blue>
<center>
<br>
<h3> 以下是關聯表<font color=brown> Bookstores</font> 目前的內容</h3>
<table border = 1>
<tr bgcolor="#cc66ff">
<th><font color=white>編號<th><font color=white>書局名稱
<th><font color=white>等級<th><font color=white>所在城市</tr>
<?php
   $cnc= odbc_connect("BOB_DSN", "sa", "1234");  //建立與資料庫的連線$cnc
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=odbc_exec($cnc,"select no, rtrim(name) as name, rank, rtrim(city) as city from Bookstores"); 
   $recno=0;
   while ($rec=odbc_fetch_array($cur))         //取出查詢結果的欄位內容
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["no"] . "<td align=center>" . toUTF8($rec["name"]);
       echo "<td align=center>" . $rec["rank"] . "<td align=center>" . toUTF8($rec["city"]);;
       echo "</tr>";
       $recno++;
   }
   odbc_close($cnc);
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
