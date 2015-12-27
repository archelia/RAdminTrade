<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

$query="SELECT * FROM pages ORDER by active desc";
$result=mysql_query($query);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<table width="60%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Page List</h4></td>
</tr>
<tr>
	<td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<td align="center" width="10%">ID</td>
		<td align="center" width="20%">Name</td>
		<td align="center" width="30%">Headline</td>
		<td align="center" width="20%">Link</td>
		<td align="center" width="10%">Edit</td>
		<td align="center" width="10%">Delete</td>
	</tr>

	<?php
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="left">'.$row["idpage"].'</td>
			<td align="left">'.$row["pagename"].'</td>
			<td align="left">'.$row["pageheadline"].'</td>
			<td align="left">'.$row["pagelink"].'</td>
			<td align="center">';
			?>
			<form action="edit-page.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Edit">
				<input type="hidden" name="ide" id="ide" value='.$row["idpage"].'>		
				</form> ';
		echo '</td>
		<td align="center">';
		if ($row["active"]==0){echo "Deleted";} else {
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idpage"].'>
				<input type="hidden" name="tabel" id="tabel" value="pages">
				<input type="hidden" name="namaid" id="namaid" value="idpage">	
				<input type="hidden" name="page" id="page" value="list-pages.php">		
				</form> ';}
		echo '</td>
			</tr> ';
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td width="40%" align="right">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<form action="create-page.php" method="POST">
	<td width="60%" align="left">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new page">
	</td>
	</form>	
</tr>
