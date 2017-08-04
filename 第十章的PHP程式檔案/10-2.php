<html>
<head>
<title>一個簡單的 PHP 程式</title>
</head>
<body bgcolor="#ffe6cc">
<?php
   echo "以下的程式會漸次將字體放大：<br><br>";
   for ($x=3; $x<=7; $x++)
   {
       echo "<font Size = ".$x.">";
       echo "這是 ".$x." 點的字。";
       echo "</font><br>";
   }
?>
<hr>
<h2>完畢!</h2>
</body>
</html>
