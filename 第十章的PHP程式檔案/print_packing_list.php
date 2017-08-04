<?php 
  include("connect_dbs.php"); 
  $ssql="select * from bookstores where no=".$_REQUEST["no"];
  $cur=$conn->query($ssql);
  $rec=$cur->fetch();
  $name=$rec["name"];
?>
<html>
<head>
<title>列印給<?php echo $name;?>的出貨單</title>
<style type="text/css" media="screen">
	.nodisplay
        {
		display:none;
	}
</style>
<script language="javascript">

  var EndOfStory =6;

  function CmToPt(x) //將cm單位轉換成point
  {
     return x*72/2.54; //72pt為一英吋
  }

  function OrdersToWord() //將頁面的Orders內容導入Word
  {
     var objWord = new ActiveXObject("Word.Application"); //開啟Word應用程式
         objWord.Caption = "出貨單";         //定義視窗名稱
     var objDoc = objWord.Documents.Add();     //新增一個文件
         objWord.Application.Visible = true;   //讓Word應用程式可以被使用者看見
     var objSelection = objWord.Selection;     //文件中的插入點,預設為文件的起始處

     //頁面設定  
     objDoc.PageSetup.PaperSize = 7; //A4 紙
     objDoc.PageSetup.Orientation = 1; //設定紙張的方向, 直式: 0(預設), 橫式: 1
     objDoc.PageSetup.LeftMargin = CmToPt(4); //設定左邊界4cm
     objDoc.PageSetup.RightMargin = CmToPt(4);
     objDoc.PageSetup.TopMargin = CmToPt(2);
     objDoc.PageSetup.BottomMargin = CmToPt(2);      
      
     // 表格1 之前的文字
     objSelection.TypeText("BOB物流中心—出貨單\n"); //新增一行文字
     objDoc.Paragraphs(1).Alignment = 1;        //第一段向中對齊，中:1, 右:2, 左:0(預設)
     var Font1 = objDoc.Paragraphs(1).Range.Font;
     Font1.size = 20;                      //設定第一段文字大小
     Font1.Bold = 1;                       //設定為粗體字
     Font1.Underline = 1;                  //設定加底線
     Font1.NameFarEast = "標楷體";         //設定中文字型字體
     Font1.NameAscii = "Times New Roman";  //設定英文字型字體

     //設定第二段(含)以後的段落格式。
     objSelection.ParagraphFormat.LineSpacingRule = 4; //固定行高:4, 單行間距:0(預設)
     objSelection.ParagraphFormat.LineSpacing = 20;    //行高20pt
     objSelection.Font.Size = 14;                    //設定第二段(含)以後的文字大小
     objSelection.TypeText("出貨單號：100120");
     objSelection.ParagraphFormat.TabStops.Add(CmToPt(16),0);  //加一個距左邊界16公分且向左對齊的定位點, 中:1, 右:2, 左:0
     var today = new Date();               //取得今天日期
     var daystr = today.getFullYear() + "/" + (today.getMonth()+1) +  "/"+ today.getDate();
     objSelection.TypeText('\t'+"填單日期："+ daystr +'\n');   //加一個tab鍵再印日期
     objSelection.TypeText("買方(廠商)名稱："+form1.name.value+"\t訂單編號：100112\n");
     objSelection.TypeText("買方(廠商)地址：高雄市\t買方電話：07-7574321\n");
     objDoc.Paragraphs(4).LineUnitAfter = 0.5;   //設定第四段與後段距離0.5列
 
     // 表格 1
     var Lenr = prnT.rows.length; //列數
     var Lenc = prnT.rows(1).cells.length; //欄數
     var tbl1 = objDoc.Tables.Add(objSelection.Range,Lenr+1,Lenc); //新增一個表格
     colwidth = new Array(CmToPt(2.5),CmToPt(5),CmToPt(2.6),CmToPt(4.5),CmToPt(2.2),CmToPt(2.2),CmToPt(2.5)); //定義各欄欄寬
     colalign = new Array(1,0,0,0,2,2,2); //定義各欄文字對齊方式 

 　  for (j=0;j<Lenc;j++) 
     { 
        tbl1.Columns(j+1).PreferredWidth = colwidth[j]; //設定各欄欄寬
        tbl1.Columns(j+1).Select();  //將游標移至每一欄
        objSelection.ParagraphFormat.Alignment = colalign[j];　//設定各欄文字對齊方式 
     }
     tbl1.Borders.InsideLineStyle = 1;   //設定內框線條, 單線:1, 雙線:7 虛線:2 
     tbl1.Borders.OutsideLineStyle = 1;  //設定外框線條  
     tbl1.Rows(1).Borders(-3).LineStyle = 7; //將第一列的下框線設定成雙線。[框線代碼]上:-1, 下:-3, 左:-2, 右:-4
     tbl1.Rows(1).Select();　//選取第一列
     objSelection.ParagraphFormat.Alignment = 4; //設定表頭文字的對齊方式為分散對齊
 
     objDoc.Tables(1).Rows.Alignment = 1;　//將表格置中
     objDoc.Tables(1).Select();　　　　　　//選取表格
     objSelection.ParagraphFormat.LineSpacingRule = 0; //設定表格的段落格式為單行間距
     objSelection.Font.Size = 12; 　　　　　　　//設定表格文字的性質
     objSelection.Font.NameFarEast = "新細明體"; 
   	
     //將網頁的表格資料逐一匯入Word文件的表格中
     var sum = 0;	
     for (i=0;i<Lenr;i++) 
        for (j=0;j<Lenc;j++)
        if (i==0 || j<4)
           tbl1.Cell(i+1, j+1).Range.Text = prnT.rows(i).cells(j).innerText; 
        else
           switch(j)
           {
              case 4: tbl1.Cell(i+1, j+1).Range.Text = eval(prnT.rows(i).cells(j).innerText)+"元"; break;
              case 5: tbl1.Cell(i+1, j+1).Range.Text = eval(prnT.rows(i).cells(j).innerText)+"本"; break;
              case 6: tbl1.Cell(i+1, j+1).Range.Text = eval(prnT.rows(i).cells(j).innerText)+"元";
                      sum += eval(prnT.rows(i).cells(j).innerText); break;
           }
     tbl1.Cell(Lenr+1, 1).Merge(tbl1.Cell(Lenr+1,7)); //將最後一列的所有欄位合併
     
     tbl1.Cell(Lenr+1, 1).Range.Text ="貨　款　總　計　： NT$ "+ sum + "元整";
     tbl1.Rows(Lenr+1).Select();                //選取最後一列
     objSelection.ParagraphFormat.Alignment = 1; //設定最後一列的段落向中對齊
     objSelection.Font.Size = 14; 　　　　　　　//設定最後一列文字的性質
     objSelection.Font.Bold = 1; 
     objSelection.Font.NameFarEast = "標楷體"; 

  　 // 表格 1 之後的文字
     objSelection.EndKey(EndOfStory);   //表格完成後,游標會停在第一格,故需將它移至文末
     objSelection.TypeText("公司地址：高雄市楠梓區卓越二路\t公司電話：07-7221234\n");
     n = objDoc.Paragraphs.Count; 　    //取得目前段落的編號(32) 
     objDoc.Paragraphs(n-1).LineUnitBefore = 0.5;  //設定前一段的格式：與前段距離0.5列
     objSelection.TypeText("經辦人員：曾守正\t公司傳真：07-7225667\n");

     objSelection.TypeParagraph();   //新增段落,  亦可用  objSelection.TypeText('\n')
     n = objDoc.Paragraphs.Count;    //取得目前段落的編號(34) 
     objDoc.Paragraphs(n-1).Borders(-3).LineStyle = 4;  //設定前一段的格式：將下框線設定成大間隔虛線

     objSelection.TypeText("簽　收　單\n");
     n = objDoc.Paragraphs.Count;   //取得目前段落的編號(35) 
     objDoc.Paragraphs(n-1).Range.Font.size = 20; //設定前一段的格式
     objDoc.Paragraphs(n-1).Range.Font.Bold = 1;
     objDoc.Paragraphs(n-1).Alignment = 1;
     objDoc.Paragraphs(n-1).LineSpacingRule = 0;
     objDoc.Paragraphs(n-1).LineUnitBefore = 0.5;   

     // 表格 2
     var Lenr = 2; //列數
     var Lenc = 7; //欄數
     var tbl2 = objDoc.Tables.Add(objSelection.Range,Lenr,Lenc); //新增一個表格
     colwidth = new Array(CmToPt(3.5),CmToPt(6),CmToPt(3),CmToPt(2.5),CmToPt(0.7),CmToPt(1),CmToPt(4.3)); //定義各欄欄寬
     colalign = new Array(1,1,1,1,1,1,0); //定義各欄文字對齊方式 
     rowtext1 = new Array("客戶簽收\n(請寫全名)","送 達 時 間","承運公司","製單人員"); //定義第一列文字的內容
     rowtext2 = new Array("","    年   月   日   時","新竹貨運","曾守正");             //定義第二列文字的內容
 
　   for (j=0;j<Lenc;j++) 
     { 
        tbl2.Columns(j+1).PreferredWidth = colwidth[j]; //設定各欄欄寬
        tbl2.Columns(j+1).Select();  //將游標移至每一欄
        objSelection.ParagraphFormat.Alignment = colalign[j];　//設定每欄文字對齊方式 
     }
     tbl2.Borders.InsideLineStyle = 1;   //設定內框線條, 單線:1, 雙線:7 虛線:2 
     tbl2.Borders.OutsideLineStyle = 1;  //設定外框線條
     tbl2.Columns(5).Borders(-1).LineStyle = 0; //[框線代碼]上:-1, 下:-3, 左:-2, 右:-4, 水平:-5, 垂直:-6
     tbl2.Columns(5).Borders(-5).LineStyle = 0;
     tbl2.Columns(5).Borders(-3).LineStyle = 0;
     tbl2.Columns(6).Cells.Merge();    //將第6行的所有欄位合併
     tbl2.Columns(7).Cells.Merge();
     
     objDoc.Tables(2).Rows.Alignment = 1;　//將表格置中
     objDoc.Tables(2).Select();　　　　　//選取表格
     objSelection.ParagraphFormat.LineSpacingRule = 0;
     objSelection.Font.Size = 12; 　　　　　　　//設定表格文字的性質
     objSelection.Font.NameFarEast = "新細明體";

     for (j=0;j<4;j++)
     { 
         tbl2.Cell(1, j+1).Range.Text = rowtext1[j]; //設定表格2第一列的內容
         tbl2.Cell(1, j+1).VerticalAlignment = 1;    //設定表格2第一列的文字垂直向中對齊
         tbl2.Cell(2, j+1).Range.Text = rowtext2[j]; //設定表格2第二列的內容
         tbl2.Cell(2, j+1).VerticalAlignment = 1;    //設定表格2第二列的文字垂直向中對齊
     }
     tbl2.Cell(1, 6).Range.Text ="附註";
     tbl2.Cell(1, 6).VerticalAlignment = 1; 
     tbl2.Cell(1, 7).Range.Text ="貨品請當場點收、妥善保管。簽收完畢後，若有短缺，請自行負責。";

　　 // 表格 2 之後的文字
     objSelection.EndKey(EndOfStory);   //表格完成後,游標會停在第一格,故需將它移至文末
     objSelection.TypeText("收到貨品後，請簽收並將此簽收單傳真至07-7225667，謝謝！\t出貨單號：100120\n");
     n = objDoc.Paragraphs.Count;       //取得目前段落的編號 
     objDoc.Paragraphs(n-1).LineUnitBefore = 0.5; //設定前一段的格式：與前段距離0.5列    
}
</script>
</head>
<body bgcolor="#ffffcc" alink=green vlink=blue>
<form name="form1">
<input type=hidden name="name" value=<?php echo $name;?>>
</form>
<div class="screen nodisplay"> <!—讓以下的表格資料不會在網頁上顯現--->
<table id="prnT">
<tr><th>書籍編號<th>書籍名稱<th>作 者
<th>出版社<th>單 價<th>數 量<th>小 計</tr>
<?php
   //組合一個查詢指令
   $ssql="select books.id, bookname, author, publisher, price,  quantity, quantity * price as total " . "from books, orders where books.id=orders.id and orders.no=".$_REQUEST["no"];
   //執行一個查詢指令並將結果放進$cur變數中
   $cur=$conn->query($ssql);
   $recno=0;
   $num=0; $sum=0;
   //取出查詢結果的欄位內容
   while ($rec=$cur->fetch())
   {
      echo "<tr bgcolor='#ffccff'>";
      echo "<td align=center>" . $rec["id"] . "<td align=center>" . $rec["bookname"] . "<td align=center>" . $rec["author"];
      echo "<td align=center>" . $rec["publisher"] . "<td align=center>" . $rec["price"];
      echo "<td align=center>" . $rec["quantity"] . "<td align=right>" . $rec["total"]. "</tr>";
      $recno++;
   }
?>
</table>
</div>
<script language="JavaScript">
  OrdersToWord();
  window.alert('資料已完全匯入 Word，請到 Word 文件中進行列印！\n\n然後按下 [確定] 以回到原網頁！');
  location.href("print_books.php");
</script>
</body>
</html>