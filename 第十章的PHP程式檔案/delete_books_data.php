<?php 
   include("connect_dbs.php");
   session_start( );           //開啟一個會期
   $_SESSION["delcond"]="";    //初始一個會期變數delcond用來儲存刪除資料的條件
   $_SESSION["delno"]=0;       //初始一個會期變數delno用來儲存刪除資料的筆數
   include("SQLPROC.inc"); 
?>
<html>
<head>
<title>列出 Books 關聯表中將被刪除的資料</title>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<center>
<br>
<font size=4><b>以下是關聯表 Books 中符合刪除條件的資料</b></font><br>
<table border=2>
<tr bgcolor='#cc66ff'>
<th><font color=white>編號<th><font color=white>書名<th><font color=white>作者
<th><font color=white>價格<th><font color=white>出版社
<?php
   $qsql="exec sp_fkeys Books";   //查詢Books有關的外來鍵規則
   $cur=$conn->query($qsql);        
   $rec=$cur->fetch(); 
   if ($rec["DELETE_RULE"]=='0')  //外來鍵刪除規則為CASCADE
     $dr = 'C';
   else 
     $dr = 'N';
   //產生一個delete指令的where條件子句，存進會期變數delcond中
   csql($conn, "Books",'w',$_SESSION["delcond"]); 
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query("select * from Books where " . $_SESSION["delcond"]); 
   $recno=0;
   $idno=0; $infrno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr bgcolor='#ffccff'>";
       echo "<td align=center>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td align=right>" . $rec["price"] . "<td>" . $rec["publisher"];
       $recno++;
       if ($dr=='C')
       {
         //執行一個查詢指令並將結果放進$data變數中
         $data=$conn->query("select count(*) from Orders where id=" . $rec["id"]);
         $n=$data->fetchColumn();        //計算與此筆Books值組有關聯的Orders值組數
         if ($n>0) 
         {
            $orderarr[$idno++]=$rec["id"]; //記錄會影響Orders的書籍編號id
            $infrno += $n;                 //累加關聯表Orders中受影響的值組數
         }
       }
   }
?>
</table>
<br>
<?php
   if ($recno!=0)
   {
      if ($dr=='C' && $infrno!=0)
      {
         echo "<font size=4 color=red><b>注意！</b>";
         echo "<font color=green>與此關聯表有關的外來鍵刪除規則為<font color=red><b>CASCADE</b></font>，<br>";
         echo "所以刪除以上資料時，將會導致以下<font color=black><b>關聯表 Orders </b></font>的資料一併被刪除！";
         echo "<table border=2>";
         echo "<tr bgcolor='#cc66ff'>";
         echo "<th><font color=white>書局代號<th><font color=white>書名代號<th><font color=white>訂購數量"; 
         for ($i=0; $i<$idno; $i++)
         {         
            $cur=$conn->query("select * from Orders where id=" . $orderarr[$i]); 
            while ($rec=$cur->fetch())
            {
               echo "<tr bgcolor='#ffccff' align=center>";
               echo "<td>" . $rec["no"] . "<td>" . $rec["id"] . "<td>" . $rec["quantity"];
            }
         }
         echo "</table><br>";
      }
      $_SESSION["delno"]=$recno;
      echo "<form action='delete_books_action.php' method='post' name = 'form1'>";
      echo "<input type='hidden' name='infrno' value='".$infrno."'>";
      echo "<input type='submit' value='確定刪除'> ";
      echo "&nbsp;&nbsp;<input type='button' value='放棄' OnClick='history.back()'>";
      echo "</form>";
   }
   else
   {
      echo "<br><br><h2><font color = red> 抱歉! 沒有任何資料! </font></h2>";
      echo "<br><a href='delete_books.php'>回上一頁</a>";
   }
?>
</center>
</body>
</html>