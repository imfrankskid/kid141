<?xml version="1.0" encoding="Big5"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
  <html>
    <body bgcolor="#ffe680">
      <center><h2>我的書籍清單</h2>
        <table border="1">
          <tr bgcolor="#9acd32"><th>書名</th><th>作者</th><th>價格</th></tr>
          <xsl:for-each select="/書籍資料/書籍">
            <xsl:sort select="價格"/> <xsl:sort select="作者"/>
            <tr>
              <td align="center"><xsl:value-of select="書名"/></td>
              <td align="center"><xsl:value-of select="作者"/></td>
              <td align="center"><I><xsl:value-of select="價格"/></I></td>
            </tr>
          </xsl:for-each>
        </table>
      </center>
    </body>
  </html>
</xsl:template>
</xsl:stylesheet>
