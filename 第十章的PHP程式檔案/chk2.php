<html>
<head>
<title>檢查使用者帳號與密碼</title>
</head>
<body>
<?php
   $SQLString = "select * from UserList where UserName='".$_REQUEST["UserName"]."' and Password='".$_REQUEST["Password"]."'";  
   $connectionInfo = array("UID" => "sa", "PWD" => "11", "Database"=>"BOB","CharacterSet" => "UTF-8");
   $conn = sqlsrv_connect("(local)", $connectionInfo);
   $cur = sqlsrv_query($conn, $SQLString);         //執行一個查詢指令並將結果放進$cur變數中
   $recno=0;
   if (sqlsrv_fetch_array($cur))      //找到資料
   {
       echo "使用者 ".$_REQUEST["UserName"]." 登入";
       echo "<script>window.alert('歡迎光臨！');";
       echo "location('10-3.php');</script>";
   }
   else
   {
       echo "<script>window.alert('抱歉！使用者名稱或密碼錯誤，請重新輸入！');";
       echo "location('chk1.php');</script>";
   }      
 ?>
</body>
</html>