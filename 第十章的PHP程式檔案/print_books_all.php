<?php include("connect_dbs.php"); ?>
<html>
<head>
<title>列印 Books 關聯表內容</title>
<style type="text/css" media="screen">
	.nodisplay
        {
		display:none;
	}
</style>
<script language="javascript">

  var EndOfStory = 6; //以變數EndOfStory代表文末代碼6

  function CmToPt(x) //將cm單位轉換成point
  {
     return x*72/2.54; //72pt為一英吋
  }

  function BooksToWord() //將頁面的Books資料導入Word
  {
     var objWord = new ActiveXObject("Word.Application"); //開啟Word應用程式
         objWord.Caption = "書籍清冊";         //定義視窗名稱
     var objDoc = objWord.Documents.Add();     //新增一個文件
         objWord.Application.Visible = true;   //讓Word應用程式可以被使用者看見
     var objSelection = objWord.Selection;     //文件中的插入點,預設為文件的起始處

     //頁面設定  
     objDoc.PageSetup.PaperSize = 7;      //A4 紙
     objDoc.PageSetup.Orientation = 0;         //設定紙張方向, 直式: 0(預設), 橫式: 1
     objDoc.PageSetup.LeftMargin = CmToPt(2);     //設定頁面左邊界為2cm
     objDoc.PageSetup.RightMargin = CmToPt(2);    //設定頁面右邊界為2cm
     objDoc.PageSetup.TopMargin = CmToPt(2.5);    //設定頁面上邊界為2.5cm
     objDoc.PageSetup.BottomMargin = CmToPt(2.5); //設定頁面下邊界為2.5cm
      
     // 表格之前的文字
     objSelection.TypeText("經銷書籍明細清冊\n"); //新增一行文字
     objDoc.Paragraphs(1).Alignment = 1;        //第一段向中對齊，中:1, 右:2, 左:0(預設)
     var Font1 = objDoc.Paragraphs(1).Range.Font;
     Font1.size = 20;                      //設定第一段文字大小
     Font1.Bold = 1;                       //設定為粗體字
     Font1.NameFarEast = "標楷體";         //設定中文字型字體
     Font1.NameAscii = "Times New Roman";  //設定英文字型字體

     objSelection.Font.size = 14;                     //設定第二段(含)以後的文字大小
     objSelection.TypeText("製表單位：BOB物流中心");
     objSelection.ParagraphFormat.TabStops.Add(CmToPt(17),2);  //加一個距左邊界17公分且向右對齊的定位點, [定位點代號]中:1, 右:2, 左:0
     var today = new Date();               //取得今天日期
     var daystr = today.getFullYear() + "/" + (today.getMonth()+1) +  "/"+ today.getDate();
     objSelection.TypeText('\t'+"製表日期："+ daystr +'\n');   //加一個tab鍵再印日期

     // 表格 1
     var Lenr = prnT.rows.length;           //列數
     var Lenc = prnT.rows(1).cells.length;  //欄數
     var tbl = objDoc.Tables.Add(objSelection.Range,Lenr,Lenc); //新增一個表格
     colwidth = new Array(CmToPt(2.7),CmToPt(4.7),CmToPt(2.8),CmToPt(2),CmToPt(4.6)); //定義各欄欄寬
     colalign = new Array(1,0,0,2,0); //定義各欄文字對齊方式 

 　  for (j=0;j<Lenc;j++) 
     { 
        tbl.Columns(j+1).PreferredWidth = colwidth[j]; //設定各欄欄寬
        tbl.Columns(j+1).Select();  //將游標移至每一欄
        objSelection.ParagraphFormat.Alignment = colalign[j];　//設定各欄文字對齊方式 
     }

     tbl.Borders.InsideLineStyle = 1;   //設定內框線條, 單線:1, 雙線:7 虛線:2 
     tbl.Borders.OutsideLineStyle = 1;  //設定外框線條  
     tbl.Rows(1).Borders(-3).LineStyle = 7; //將第一列的下框線設定成雙線。[框線代號]上:-1, 下:-3, 左:-2, 右:-4
     tbl.Rows(1).Select();　//選取第一列
     objSelection.ParagraphFormat.Alignment = 4; //設定表頭文字的對齊方式為分散對齊
 
     objDoc.Tables(1).Rows.Alignment = 1;　//將表格置中
     objDoc.Tables(1).Select();　　　　　　//選取表格
     objSelection.Font.Size = 12; 　　　　　　　//設定表格文字的性質
     objSelection.Font.NameFarEast = "新細明體"; 
   		
     //將網頁的表格資料逐一匯入Word文件的表格中
     for (i=0;i<Lenr;i++) 
        for (j=0;j<Lenc;j++)
        if (i==0 || j!=3) 
           tbl.Cell(i+1, j+1).Range.Text = prnT.rows(i).cells(j).innerText; 
        else
           tbl.Cell(i+1, j+1).Range.Text = eval(prnT.rows(i).cells(j).innerText)+"元"; //將資料加上單位

　　 // 表格之後的文字
     objSelection.EndKey(EndOfStory);   //表格完成後,游標會停在第一格,故需將它移至文末
     objSelection.ParagraphFormat.LineUnitBefore = 0.5; //與前段距離0.5列
     objSelection.TypeText("製表人員：");
     objSelection.Font.Underline = 1;   //設定加底線
     objSelection.TypeText("           \n");
}
</script>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<div class="screen nodisplay"> <!—讓以下的表格資料不會在網頁上顯現--->
<table id="prnT">
<tr><th>書籍編號<th>書籍名稱<th>作者<th>單價<th>出版社</tr>
<?php
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query("select * from Books");   
   $recno=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
       echo "<tr><td>" . $rec["id"] . "<td>" . $rec["bookname"] . "<td>" . $rec["author"];
       echo "<td>" . $rec["price"] . "<td>" . $rec["publisher"] . "</tr>";
       $recno++;
   }
?>
</table>
</div>
<script language="JavaScript">
  BooksToWord();
  window.alert('資料已完全匯入 Word，請到 Word 文件中進行列印！\n\n然後按下 [確定] 以回到原網頁！');
  location.href("print_books.php");
</script>
</body>
</html>