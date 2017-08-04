<?php 
   include("connect_dbs.php");
   session_start();              //開啟一個會期
   $_SESSION["updatecond"]="";   //初始一個會期變數updatecond用來儲存更新資料的條件
   $_SESSION["updateno"]=0;      //初始一個會期變數updateno用來儲存更新資料的筆數
   include("SQLPROC.inc");
?>
<html>
<head>
<title>列出 Books 關聯表中將被更新的資料</title>
<script language = "JavaScript">
  function submit1()
  {
    var temp = form1.price.value
    if (temp!="" && isNaN(temp)==true) 
    {
       window.alert("Price 不可以放非整數的值!")
       form1.price.value = ""
       form1.price.focus()
       return
    }
    form1.submit()
    return
  }
</script>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<font size=4><b>以下是關聯表 Books中符合更新條件的資料</b></font><br>
<table border=2>
<tr bgcolor="cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
<?php
   //產生一個 update指令的where條件子句，存進會期變數updatecond中
   csql($conn,"Books",'w',$_SESSION["updatecond"]);
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query("select * from Books where " . $_SESSION["updatecond"]); 
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"];
       $recno++;
   }
?>
</table>
<?php
   if ($recno!=0)
   {
      $_SESSION["updateno"]=$recno;
      echo "<form action='update_books_confirm.php' method='post' name = 'form1'>";
      echo "<br><h2><font color= green>請輸入更新值</font></h2>";
      echo "<table border=2>";
      echo "<tr bgcolor='#cc66ff'>";
      if ($recno==1)
      echo "<th><font color=white>編號";
      echo "<th><font color=white>書名<th><font color=white>作者";
      echo "<th><font color=white>價格<th><font color=white>出版社";
      echo "<tr>";
      if ($recno==1)
         echo "<td><input type='text' size=4 name='id' maxlength=4>";
      else
         echo "<input type='hidden' name='id' value=''>";
      echo "<td><input type='text' size=20 name='bookname' maxlength=20>";
      echo "<td><input type='text' size=20 name='author' maxlength=20>";
      echo "<td><input type='text' size=4 name='price' maxlength=4>";
      echo "<td><input type='text' size=20 name='publisher' maxlength=20>";
      echo "</table>";
      echo "<br><input type='button' onClick='submit1()' value='確定'>   ";
      echo "&nbsp;&nbsp;<input type='button' value='放棄' OnClick='history.back()'>";
      echo "</form>";
   }
   else
   {
      echo "<br><br><h2><font color = red> 抱歉! 沒有任何資料! </font></h2>";
      echo "<br><a href='update_books.php'>回上一頁</a>";
   }
?>
</center>
</body>
</html>
