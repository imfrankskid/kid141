<?php
   //檢查$a是否為關聯表$tname的主鍵，若是則傳回1, 否則傳回0
   function check_key($conn, $tname, $a)
   {
     //查詢關聯表$tname的主鍵欄位
     $qsql="select * from INFORMATION_SCHEMA.KEY_COLUMN_USAGE where TABLE_NAME='".$tname. "' and substring(constraint_name, 1, 3) = 'PK_'"; 
     //執行一個查詢指令並將結果放進$cur變數中  
     $cur=$conn->query($qsql);
     //取出查詢結果的欄位內容
     while ($rec=$cur->fetch())
     {
        $x=$rec["COLUMN_NAME"]; 
        if ($x==$a)             
        return 1;
     }
     return 0;
   }

  //根據$c的指示，組成一個SQL指令所需要的資料字串，然後儲存在字串$rsql中傳回
  //如果更新的欄位中包含主鍵則傳回1, 否則傳回0
   function csql($conn, $tname, $c, &$rsql)
   {
     //查詢關聯表$tname各個欄位的名稱與資料型態
     $qsql="select * from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='" . $tname ."'";
     //執行一個查詢指令並將結果放進$cur變數中
     $cur=$conn->query($qsql);
     $rsql="";
     $f=0; $uk=0;
     switch ($c)
     {
       case 'v':                      //設定insert指令values條件的區隔符號為", "
       case 's': $d=", ";    break;   //設定update指令set條件的區隔符號為", "
       case 'w': $d=" and "; break;   //設定where條件的區隔符號為"and "
     } 
     //取出查詢結果的欄位內容
     while ($rec=$cur->fetch())
     {
        $a=$rec["COLUMN_NAME"];         //取出欄位名稱
        $Tvalue=ltrim($_REQUEST[$a]);   //去掉該欄位資料前面的空白
        if (strlen($Tvalue)!=0)         //表示該欄位有輸入資料
        {
           if ($f==1)  
           $rsql=$rsql . $d;            //從第二個條件開始, 前面加上區隔符號$d
           if ($c=='s')
           {
              if ($uk==0 && check_key($conn,$tname,$a)==1)
              $uk=1;  //表示更改主鍵欄的值
           }
           if ($c=='s' || $c=='w')
           $rsql=$rsql . $a . "=";      //若是set或where條件, 則加上欄位名稱 
           $tp=$rec["DATA_TYPE"];
           if ($tp=="int" || $tp=="smallint" || $tp=="tinyint" || $tp=="bigint" || $tp=="decimal" || 
               $tp=="float" || $tp=="real" || $tp=="bit" || $tp=="money" || $tp=="smallmoney")
               $rsql=$rsql . $Tvalue;                //在條件中加上數值資料
           else
               $rsql=$rsql . "'" . $Tvalue . "'";    //在條件中加上字串資料
           if ($f==0)                   
           $f=1;                         //表示已經建構完第一個條件
        }
        else
        {
           if ($c=='v')
           { 
              if ($f==1)  
              $rsql=$rsql . $d;         //從第二個條件開始, 前面加上區隔符號$d    
              $rsql=$rsql . "NULL";     //為沒有輸入資料的欄位, 在values條件中補上NULL
              if ($f==0)
              $f=1;                     //表示已經建構完第一個條件
           }
        }
     }
     return $uk;
   }
?>