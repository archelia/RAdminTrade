<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

$query="SELECT p.* FROM promo p ";
$query.="ORDER by active desc";
$result=mysql_query($query);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="list" style="margin-top:1.5em;">
<table width="80%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Promo List</h4></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th align="center" width="10%">ID</th>
		<th align="center" width="40%">Promo Name</th>
		<th align="center" width="10%">Price Category A</th>
		<th align="center" width="10%">Price Category B</th>
		<th align="center" width="10%">Price Category C</th>
		<th align="center" width="10%">Air Time</th>
		<th align="center" width="5%">Edit</th>
		<th align="center" width="5%">Delete</th>
	</tr>
	<?php
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="right">'.$row["idpromo"].'</td>
			<td align="left">'.$row["promoname"].'</td>
			<td align="right">'.number_format($row["price1"],0,",",".").'</td>
			<td align="right">'.number_format($row["price2"],0,",",".").'</td>
			<td align="right">'.number_format($row["price3"],0,",",".").'</td>
			<td align="right">'.$row['airtime'].' day(s)</td>
			<td align="center">';
			?>
			<form action="edit-promo.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Edit">
				<input type="hidden" name="ide" id="ide" value='.$row["idpromo"].'>		
				</form> ';
		echo '</td>
		<td align="center">';
		if ($row["active"]==0){echo "Deleted";} else {
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idpromo"].'>
				<input type="hidden" name="tabel" id="tabel" value="promo">
				<input type="hidden" name="namaid" id="namaid" value="idpromo">	
				<input type="hidden" name="page" id="page" value="list-promo.php">		
				</form> ';}
		echo '</td>
			</tr> ';
	}
	?>
	</table>
</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="40%" align="right">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<form action="create-promo.php" method="POST">
	<td width="60%" align="left">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new promo">
	</td>
	</form>	
</tr>
</table>
</div>