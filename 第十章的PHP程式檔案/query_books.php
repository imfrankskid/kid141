<?php include("connect_dbs.php"); ?>
<html>
<head>
<title>關聯表 Books 的資料查詢</title>
<script language = "JavaScript">
  function submit1()
  {
    var temp = form1.price.value
    if (isNaN(temp)==true || temp=="")  //Price不是整數
    {
       window.alert("Price 必須是整數才行!")
       form1.price.value = ""
       form1.price.focus()
       return
    }
    form1.submit()
    return
  }
</script>
</head>

<body bgcolor="#ffffcc" text="#ffffff" vlink=blue alink=black>
<center>
<table>
<td><img src="./image/book.jpg" width=90>
<td valign=bottom><h2><font color=brown>關聯表 Books 的資料查詢</font></h2>
</table>
<table border=1 bordercolor="#008000">
<tr bgcolor="#669900">
<td><form action="query_books_all.php" method = "post">
查詢 Books 的所有書籍資料
<td><input type="submit" value="執行"><tr>
</form>
<tr bgcolor="#669900">
<td><form action="query_price.php"  method="post" name = "form1">
查詢 Books 中所有 price 
<select name="rel">
<option value=">">大於
<option value=">=">大於等於
<option value="<">小於
<option value="<=">小於等於
<option value="=">等於
<option value="<>">不等於
</select>
<input type="text" name="price" size=4 maxlength=4>的書籍資料
<td><input type="button" onClick = "submit1()" value="執行"><tr>
</form>
<tr bgcolor="#669900">
<td><form action="query_order.php" method="post">
<?php 
   //執行一個查詢指令並將結果放進$cur變數中
   $cur = $conn->query("select * from Books");
   echo "查詢書籍<select name='bookid'>";
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
      echo "<option value='" . $rec["id"] . "'>" . $rec["bookname"];
   }
   echo "</select>的訂購資訊";
?>
<td><input type="submit" value="執行"><tr>
</form>
</table>
<br><a href="default.php">回上一頁</a>
</center>
</body>
</html>