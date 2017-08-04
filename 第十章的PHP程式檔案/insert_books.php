<?php  include("connect_dbs.php"); ?>
<html>
<head>
<title>新增一筆記錄到Books關聯表中</title>
<script language = "JavaScript">
  function load1()
  {
    form1.id.focus()
    return
  }

  function trim(string)
  {
    return string.replace(/^\s+|\s+$/g,"");
  }

  function submit1()
  {
    var temp1 = trim(form1.id.value)
    var temp2 = form1.price.value
    if (temp1=="") 
    {
       var Msg = "編號 id 是主鍵，務必要輸入!"
       var Errf = 1
    }
    else
    {
       if (isNaN(temp1)==false) 
       {
          if (isNaN(temp2)==false || temp2=="")
             Errf = 0
          else
          {
             Msg = "價格 price 必須是整數!"
             Errf = 2
          }
        }
        else
        {
          if (isNaN(temp2)==false || temp2=="")
          { 
             Msg = "編號 id 必須是整數!"
             Errf = 3
          }
          else
          {
             Msg = "編號 id 、價格 price 都必須是整數!"
             Errf = 4
          }
       }
    }
    if (Errf!=0)
    {
       window.alert(Msg)
       switch(Errf)
       {
         case 1:
         case 3: form1.id.value = ""
                 form1.id.focus()
                 break
         case 2: form1.price.value = ""
                 form1.price.focus()     
                 break
         case 4: form1.id.value = ""
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
<body bgcolor="#ffffcc" vlink=blue alink=black onLoad="load1()">
<form action="insert_books_action.php" method="POST" name="form1">
<center>
<br>
<h3>請填寫欲新增的<font color=blue> Books </font>
資料 (<font color= red>編號</font>一定要填!)</h3>
<table border=2>
<tr bgcolor="#cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
</tr>
<tr>
<td><input type="text" size="3" name="id" maxlength="3">
<td><input type="text" size="24" name="bookname" maxlength="50">
<td><input type="text" size="20" name="author" maxlength="20">
<td><input type="text" size="4" name="price" maxlength="4">
<td><input type="text" size="20" name="publisher" maxlength="20">
</tr>
</table>
<br>
<input type="button" onClick = "submit1()" value="送出">
&nbsp;&nbsp;<input type="reset" value="清除">
</form>
<center>
<br>
<font size=4 color=green><b>以下是關聯表 Books 目前的內容</b></font>
<br>
<table border=2>
<tr bgcolor="cc66ff">
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
<BR><a href="default.php">回上一頁</a>
</center>
</body>
</html>