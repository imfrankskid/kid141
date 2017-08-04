<html>
<title>一個有彈跳視窗的 PHP 程式</title>
<head>
<script language="JavaScript">
   function winStart()
   {  
    var now=new Date();
    var cond;
    cond="現在時間是: "+now.getHours()+"時"+now.getMinutes()+"分\n\n";
    if (now.getHours()<12)
       cond+="早安! ";
    else
       cond+="午安! ";
     cond
     window.alert(cond+" 歡迎光臨本網站！");
   } 
</script>
</head>
<body bgcolor="#ccff99" onLoad="winStart()">
</body>
</html>
