<?xml version="1.0" encoding="Big5"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
  <html>
    <body bgcolor="#ffe680">
      <center><h2>�ڪ����y�M��</h2>
        <table border="1">
          <tr bgcolor="#9acd32"><th>�ѦW</th><th>�@��</th><th>����</th></tr>
          <xsl:for-each select="/���y���/���y">
            <xsl:sort select="����"/> <xsl:sort select="�@��"/>
            <tr>
              <td align="center"><xsl:value-of select="�ѦW"/></td>
              <td align="center"><xsl:value-of select="�@��"/></td>
              <td align="center"><I><xsl:value-of select="����"/></I></td>
            </tr>
          </xsl:for-each>
        </table>
      </center>
    </body>
  </html>
</xsl:template>
</xsl:stylesheet>
