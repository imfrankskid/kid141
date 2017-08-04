<html>
<head>
<title>使用者輸入帳號與密碼</title>
</head>
<body>
<form  action="chk2.php" method="POST"  name="form1">
  使用者名稱： <input type="text" name="UserName" size=10><p>
  密碼： <input type="text" name="Password" size=10><p>
  <input type="submit" value="確定">  <input type="reset"  value="清除">
  <input type="hidden" name="UserChk" value="form1">
</form>
</body>
</html>