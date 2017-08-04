<?php 
   include("connect_dbs.php");
   session_start();           //開啟一個會期
   $_SESSION["updateid"]=0;   //初始一個會期變數updateid用來識別主鍵欄是否被更改
   $_SESSION["setstr"]="";    //初始一個會期變數setstr用來儲存資料更新的設定值
   include("SQLPROC.inc");
?>
<html>
<head>
<title>確認是否更新 Books 關聯表中指定的資料</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<font size=4><b>以下是關聯表 Books將要執行的更新動作</b></font><br>
<table border=0>
<tr valign=middle>
<td><table border=2>
<tr bgcolor="cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
<?php
   //產生一個update指令的set條件，存進會期變數setstr中，並回傳主鍵欄是否被更改的布林值於會期變數updateid中
   $_SESSION["updateid"]=csql($conn,"Books",'s',$_SESSION["setstr"]); 
   //新增一個暫存表格UBooks來放置Books中準備更新的值組
   $conn->query("select * into UBooks from Books where " . $_SESSION["updatecond"]); 
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query("select * from Books where " . $_SESSION["updatecond"]); 
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"];
       if ($_SESSION["updateid"]==1)
       $oid=$rec["id"];  //設定$oid為原來的主鍵值
       $recno++;
   }
?>
</table>
<td width=65 align=center><font color=red><b>更新為<br>--------></b>
<td><table border=2>
<tr bgcolor="cc66ff">
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
<?php
   //產生一個更新UBooks的update指令
   $usql = "update UBooks set " . $_SESSION["setstr"] . " where " . $_SESSION["updatecond"];
   $conn->query($usql);
   $cur=$conn->query("select * from UBooks"); 
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"];
       if ($_SESSION["updateid"]==1)
       {
          if ($oid==$rec["id"])
             $_SESSION["updateid"]=0;  //表主鍵欄沒有被更改
          else
             $nid=$rec["id"];          //表主鍵欄被更改，且更改後的主鍵值為$nid
       }
   }
?>
</table>
</table>
<?php
   $qsql="exec sp_fkeys Books";   //查詢Books有關的外來鍵規則
   $cur=$conn->query($qsql);        
   $rec=$cur->fetch(); 
   if ($rec["UPDATE_RULE"]=='0')  //外來鍵更新規則為CASCADE
     $dr = 'C';
   else 
     $dr = 'N';
   $infrno=0;   //與此筆Books值組有關聯的Orders值組數
   if ($_SESSION["updateid"]==1 && $dr=='C')
   {
      //執行一個查詢指令並將結果放進$data變數中
      $data=$conn->query("select count(*) from Orders where id=".$oid);
      $infrno=$data->fetchColumn();   //計算與此筆Books值組有關聯的Orders值組數
      if ($infrno>0)
      { 
         echo "<br><font size=4 color=red><b>注意！</b>";
         echo "<font color=green>與此關聯表有關的外來鍵更新規則為<font color=red><b>CASCADE</b></font>，<br>";
         echo "所以如果執行上述的更新動作，將會導致以下<font color=black><b>關聯表 Orders </b></font>的資料同時被更新！";
         echo "<table border=0><tr valign=middle>";
         echo "<td><table border=2>";
         echo "<tr bgcolor='cc66ff'>";
         echo "<th><font color=white>書局代號<th><font color=white>書名代號<th><font color=white>訂購數量";
         //新增一個暫存表格UOrders來放置Orders中準備更新的值組
         $conn->query("select * into UOrders from Orders where id=" . $oid); 
         $cur=$conn->query("select * from Orders where id=" . $oid); 
         while ($rec=$cur->fetch())
         {
             echo "<tr bgcolor='#ffccff' align=center>";
             echo "<td>" . $rec["no"] . "<td>" . $rec["id"] . "<td>" . $rec["quantity"];
         }
         echo "</table>";
         echo "<td width=65 align=center><font color=red><b>更新為<br>--------></b>";
         //產生一個更新UOrders的update指令
         $usql = "update UOrders set id=" . $nid;
         $conn->query($usql);
         $cur=$conn->query("select * from UOrders"); 
         echo "<td><table border=2>";
         echo "<tr bgcolor='cc66ff'>";
         echo "<th><font color=white>書局代號<th><font color=white>書名代號<th><font color=white>訂購數量";
         $cur=$conn->query("select * from UOrders"); 
         while ($rec=$cur->fetch())
         {
             echo "<tr bgcolor='#ffccff' align=center>";
             echo "<td>" . $rec["no"] . "<td>" . $rec["id"] . "<td>" . $rec["quantity"];
         }
         echo "</table>";
         echo "</table>";
      }
   }
   if ($infrno>0)
   $conn->query("drop table UOrders");  //移除暫存表格UOrders
   $conn->query("drop table UBooks");   //移除暫存表格UBooks
?>
<br>
<form action='update_books_action.php' method='post'>
<input type='hidden' name='infrno' value=<?php echo $infrno; ?>>
<input type='submit' value='確定更新'>&nbsp;&nbsp;
<input type='button' value='放棄' OnClick="<?php $_SESSION["updateid"]=0; ?>; location.href('update_books.php')">
</form>
</center>
</body>
</html>