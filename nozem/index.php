<html>

    <head>
        <title>N&N Mailer</title>
        <link rel="stylesheet" href="site.css"/>
        <script src="nozem.js"></script>
        <script src="jquery-1.11.1.min.js"></script>
    </head>

<body>

<table border=0 width=100%>
<tr>
<td width=400px valign=top>
	<b>stap1:</b>&nbsp;<a href=# onclick="javascript:saveMergeFile();">[Save merge file]</a> <br>
	<br>
	<b>stap2:</b>&nbsp;<a target=_blank href="mail/index.html">[View merged message]</a> <br>
	<br>
	<b>stap3:</b>&nbsp;<a href=# onclick="javascript:sendTestEmail();">[Send test email]</a> <br>
	<br>
	<b>stap4:</b>&nbsp;<a target=_blank href="maillist.php">[Edit maillist]</a> <br>
	<br>
	<br>
	<br>
	<b>stap5:</b>&nbsp;<a href=# onclick="javascript:sendBulk();">[Send to all users]</a> <br>
	<br>
	<b>stap6:</b>&nbsp;<a target=_blank href="result.php">[Bekijk laatste resultaat]</a> <br>
</td>

<td  valign=top>
	<b>Password:</b><br>
	<input type=password id="passwd" size=100 value=""> (hint: het DAX passwd)
	<br>
	<br>
	<b>Subject:</b><br>
	<input type=text id="subject" size=100 value="De Nozem en de Non agenda">
	<br>
	<br>
	<b>Test email address:</b><br>
	<input type=text id="testEmail" size=100 value="robbert@vdzon.com">
	<br>
	<br>
	<b>Merge text:</b><br>
	<textarea rows="45" cols="130" id="mergeText" >
<?php
$merge = file_get_contents('mail/merge.txt');
echo $merge;
?>
	</textarea>
</td>

</tr>
</table>
</body>
</html>
