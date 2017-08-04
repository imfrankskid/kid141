<?php include("connect_dbs.php"); ?>
<html>
<head>
<title>關聯表 Books 的表單列印</title>
</head>
<body bgcolor="#ffffcc" text="#ffffff" vlink=blue alink=black>
<center>
<table>
<td><img src="./image/book.jpg" width=90>
<td valign=bottom><h2><font color=brown>關聯表 Books 的表單列印</font></h2>
</table>
<table border=1 bordercolor="#008000">
<tr bgcolor="#669900">
<td><form action="print_books_all.php" method = "post">
列印 Books 的所有書籍資料
<td><input type="submit" value="執行"><tr>
</form>
<tr bgcolor="#669900">
<td><form action="print_packing_list.php" method="post">
列印給
<?php 
   //執行一個查詢指令並將結果放進$cur變數中
   $cur = $conn->query("select * from Bookstores");
   echo "<select name='no'>";
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   echo "<option value='" . $rec["no"] . "'>" . $rec["name"];
   echo "</select>的出貨單";
?>
<td><input type="submit" value="執行"><tr>
</form>
</table>
<pre>
<font size=3 color=red>注意！<font color=black>執行前請先將 IE 裡位於[網際網路選項]的 
選項<font color=blue>[未標示成安全的ActiveX控制項…]<font color=black>設定為<font color=red><b>提示</b></font>
</pre>
<a href="default.php">回上一頁</a>
</center>
</body>
</html>