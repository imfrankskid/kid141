<?php  include("connect_dbs.php"); ?>
<html>
<head>
<title>刪除Books關聯表的資料</title>
<script language = "JavaScript">
  function load1()
  {
    form1.id.focus()
    return
  }

  function submit1()
  {

    var temp1 = form1.id.value
    var temp2 = form1.bookname.value
    var temp3 = form1.author.value
    var temp4 = form1.price.value
    var temp5 = form1.publisher.value
    var Errf = 0
    var Msg = ""
  
    if (temp1 != "" &&  isNaN(temp1)==true)
    {
        Msg = "Id 不可以放非整數的值! "
        Errf = 1
    }
    if (temp4 != "" &&  isNaN(temp4)==true)
    {
       Msg = Msg + "Price 不可以放非整數的值!"
       Errf = Errf + 2
    }
    if (temp1=="" && temp2=="" && temp3=="" && temp4=="" && temp5=="")
    {
       Msg = "不可以不輸入條件!"
       Errf = 4
    }
    if (Errf!=0) 
    {
       window.alert(Msg)
       switch(Errf)
       {
         case 1:
         case 4: form1.id.value = ""
                 form1.id.focus()
                 break
         case 2: form1.price.value = ""
                 form1.price.focus()     
                 break
         case 3: form1.id.value = ""
                 form1.price.value = ""
                 form1.id.focus()     
       }
       return
    }
    form1.submit()
    return
  }
</script>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue onLoad="load1()">
<center>
<br>
<form action="delete_books_data.php" method="post" name = "form1">
<h3>請輸入書籍資料要做刪除的條件</h3>
<table border=2>
<tr bgcolor="cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
</tr>
<tr>
<td><input type="text" size="3" name="id" maxlength="3">
<td>
<?php
   //執行一個查詢指令並將結果放進$cur變數中
   $cur1=$conn->query("select distinct bookname from Books"); 
   echo "<select name='bookname'>";
   echo "<option value=''>  ";
   //取出查詢結果的欄位內容
   while ($rec=$cur1->fetch())
   {
      if ($rec["bookname"]!="")
      echo "<option value='" . $rec["bookname"] . "'>" . $rec["bookname"];
   }
?>
<td><input type="text" size="20" name="author" maxlength="20">
<td><input type="text" size="4" name="price" maxlength="4">
<td><input type="text" size="20" name="publisher" maxlength="20">
</table>
<br>
<input type="button" onClick = "submit1()" value="送出">
&nbsp;&nbsp;<input type="reset" value="清除">
</form>
<br>
<font size=4 color=green><b>以下是關聯表 Books 的內容(資料刪除前)</b></font>
<br>
<table border=2>
<tr bgcolor="cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
</tr>
<?php
   //執行一個查詢指令並將結果放進$cur變數中
   $cur2=$conn->query("select * from Books"); 
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur2->fetch())
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
<br><a href="default.php">回上一頁</a>
</center>
</body>
</html>