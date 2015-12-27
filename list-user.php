<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

$query="SELECT * FROM user ORDER by active desc";
$result=mysql_query($query);
$jum=0;
if($result){$jum=mysql_num_rows($result);}
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<table width="60%" cellspacing="2" cellpadding="2" align="center" border="0" class="tabelluar">
<tr>
	<td align="left" colspan="2" class="judul">USER LIST</td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" border="1">
		<tr>
			<th width="10%">ID</td>
			<th width="30%">Username</td>
			<th width="40%">User Type</td>
			<th width="10%">Edit</td>
			<th width="10%">Delete</td>
		</tr>
		<?php
		while($row = mysql_fetch_array($result))
		{
			echo '<tr>
				<td align="right">'.$row["iduser"].'</td>
				<td align="left">'.$row["username"].'</td>
				<td align="left">';
				if ($row["usertype"]=1) echo 'Administrator';
				else if ($row["usertype"]=2) echo 'Marketting';
			echo '</td>
				<td align="center">';
				?>
				<form action="edit-user.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Edit">
					<input type="hidden" name="ide" id="ide" value='.$row["iduser"].'>		
					</form> ';
			echo '</td>
			<td align="center">';
			if ($row["active"]==0){echo "Deleted";} else {
				?>
				<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Delete">
					<input type="hidden" name="ide" id="ide" value='.$row["iduser"].'>
					<input type="hidden" name="tabel" id="tabel" value="user">
					<input type="hidden" name="namaid" id="namaid" value="iduser">	
					<input type="hidden" name="page" id="page" value="list-user.php">		
					</form> ';}
			echo '</td>
				</tr> ';
		}
		?>
		<tr>
			<td colspan="10" class="keterangan" align="right">Number of user : <?php echo $jum; ?>&nbsp;</td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td width="40%" align="right">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<form action="create-user.php" method="POST">
	<td width="60%" align="left">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new user">
	</td>
	</form>	
</tr>
</table>