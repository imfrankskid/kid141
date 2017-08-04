<?php require_once("connect_dbs.php"); ?>
<?php
   $editFormAction = $_SERVER['PHP_SELF'];
   if (isset($_REQUEST["UserChk"]) && ($_REQUEST["UserChk"] == "form1"))
   {
     if (isset($_REQUEST["UserName"]) && isset($_REQUEST["Password"]))
     {
         //利用使用者輸入的Username與Password資料來組合SQL語法
         $SQLString = "select * from UserList where UserName='".$_REQUEST["UserName"]."' and Password='".$_REQUEST["Password"]."'";       
         //執行一個查詢指令並將結果放進$cur變數中
         $cur=$conn->query($SQLString); 
         //檢查使用者輸入資料是否正確
         if ($cur->fetch())
         {
            session_start( );
            $_SESSION["UserName"]=$_REQUEST["UserName"];
            echo "使用者 ".$_REQUEST["UserName"]." 登入";
            echo "<script>window.alert('歡迎光臨！');";
            echo "location('10-3.php');</script>";
         }
         else
            echo "<script>window.alert('抱歉！使用者名稱或密碼錯誤，請重新輸入！');</script>"; 
      }
  }    
?>
<html>
<head>
<title>使用者輸入帳號與密碼</title>
</head>
<body>
<form  action=<?php echo $editFormAction; ?> method="POST"  name="form1">
  使用者名稱： <input type="text" name="UserName" size=10><p>
  密碼： <input type="text" name="Password" size=10><p>
  <input type="submit" value="確定">  &nbsp;<input type="reset"  value="清除">
  <input type="hidden" name="UserChk" value="form1">
</form>
</body>
</html>