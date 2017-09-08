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
	<b><a href=# onclick="javascript:saveMaillist();">[Save maillist]</a> <br>
</td>

<td  valign=top>
	<b>Password:</b><br>
	<input type=password id="passwd" size=100 value=""> (hint: het DAX passwd)
	<br>
	<br>

	<b>Maillist:</b><br>
	<textarea rows="45" cols="130" id="maillistText" >
<?php
$merge = file_get_contents('maillist.txt');
echo $merge;
?>
	</textarea>
</td>

</tr>
</table>
</body>
</html>
