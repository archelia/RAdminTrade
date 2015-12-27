<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
// function to create url
jQuery(document).ready(function($) {
var currenturl = jQuery(location).attr('href');
//alert(currenturl);
$('.page').val(currenturl);
});
</script>

<table border="0" width="70%" cellpadding="1" cellspacing="1" align="center">
<tr>
	<td><h3>Welcome <?php echo $_SESSION['adzuser']; ?> !</h3></td>
</tr>
<tr>
	<td class="judul">New Member</td>
</tr>
<tr>
</tr>
	<td>
		<?php
		$query1 = "SELECT * FROM member WHERE active=1 ORDER BY joindate desc limit 10";
		$result1 = mysql_query($query1);
		?>
		<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#FFFFFF" border="1"  bordercolor="#CBC8C8">
		<tr>
			<th width="10%">ID</td>
			<th width="20%">Username</td>
			<th width="30%">Member Name</td>
			<th width="20%">Member Type</td>
			<th width="10%">Edit</td>
			<th width="10%">Delete</td>
		</tr>
		<?php
		while($row1 = mysql_fetch_array($result1))
		{

			echo '<tr>
				<td align="left">'.$row1["idmember"].'</td>
				<td align="left"><a href="detail-member.php?ide='.$row1["idmember"].'">'.$row1["username"].'</a></td>
				<td align="left"><a href="detail-member.php?ide='.$row1["idmember"].'">'.$row1["membername"].'</a>
					<br/><br/>';
				if($row1["location"]!=""){echo "<span style='color: #777;text-decoration: none;font-family: Arial, Tahoma, Sans-Serif;font-size: 11px;'>location : ".$row1["location"]."</span>";}
				echo '<br>'."<span style='color: #777;text-decoration: none;font-family: Arial, Tahoma, Sans-Serif;font-size: 11px;'>member since : ".date("d M Y",strtotime($row1["joindate"]))."</span>";
			echo '</td>
				
				<td align="left">';
				if ($row1["membertype"]==1) echo 'Copper';
				else if ($row1["membertype"]==2) echo 'Silver';
				else if ($row1["membertype"]==3) echo 'Gold';
				echo "<br/>";
				echo "register with :";
				if ($row1["verifycode"]=="hi rori") echo ' Hi Rori';
				else if ($row1["verifycode"]=="facebook") echo ' Facebook';
				else if ($row1["verifycode"]=="facebook verified") echo ' Facebook';
				else echo "roripon main";
				
			echo '</td>
				<td align="center">';
				?>
				<form action="edit-member.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Edit">
					<input type="hidden" name="page" id="page" value="" class="page">
					<input type="hidden" name="ide" id="ide" value='.$row1["idmember"].'>		
					</form> ';
			echo '</td>
			<td align="center">';
			if ($row1["active"]==0){echo "Deleted";} else {
				?>
				<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Delete">
					<input type="hidden" name="ide" id="ide" value='.$row1["idmember"].'>
					<input type="hidden" name="tabel" id="tabel" value="member">
					<input type="hidden" name="namaid" id="namaid" value="idmember">	
					<input type="hidden" name="page" id="page" value="" class="page">		
					</form> ';}
			echo '</td>
				</tr> ';
		}
		?>
		</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td class="judul">New Product</td>
</tr>
<tr>
	<td>
	<?php
	$query2="SELECT p.*, c.categoryname, s.subcategoryname FROM products p, category c, subcategory s WHERE p.idsubcategory=s.idsubcategory and s.idcategory=c.idcategory ";
	$query2.="ORDER by p.inputdate desc limit 10";
	$result2=mysql_query($query2);
	?>
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#FFFFFF" border="1"  bordercolor="#CBC8C8">
	<tr>
		<th width="10%">ID</td>
		<th width="30%">Name</td>
		<th width="15%">Category</td>
		<th width="15%">Subcategory</td>
		<th width="10%">Status</td>
		<th width="10%">Detail</td>
		<th width="10%">Delete</td>
	</tr>
	<?php
	while($row2 = mysql_fetch_array($result2))
	{
		if ($row2["active"]=='0')echo '<tr bgcolor="#D8D8D8">';
		else if ($row2["active"]=='3')echo '<tr bgcolor="#BE81F7">';
		else if ($row2["active"]=='2')echo '<tr bgcolor="#F2F5A9">';
		else echo '<tr>';
		echo '<td align="left">'.$row2["idproduct"].'</td>
			<td align="left">'.$row2["productname"].'</td>';
		echo '</td>
			<td align="left">'.$row2["categoryname"].'</td>
			<td align="left">'.$row2["subcategoryname"].'</td>';
		echo '<td align="center">';
		switch ($row2["active"]) 
		{
		case 0:
			echo "Deleted";
			break;
		case 1:
			echo "Active";
			break;
		case 2:
			echo "Pending";
			break;
		case 3:
			echo "Rejected";
			break;
		}
		echo '</td>';
		echo '<td align="center">';
			?>
			<form action="detail-product.php" method="POST" onsubmit="return confirm('See detail product?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Detail">
				<input type="hidden" name="page" id="page" value="" class="page">		
				<input type="hidden" name="ide" id="ide" value='.$row2["idproduct"].'>		
				</form> ';
		echo '</td>
		<td align="center">';
		if ($row2["active"]==0){echo "Deleted";} else {
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row2["idproduct"].'>
				<input type="hidden" name="tabel" id="tabel" value="products">
				<input type="hidden" name="namaid" id="namaid" value="idproduct">	
				<input type="hidden" name="page" id="page" value="" class="page">		
				</form> ';}
		echo '</td>
			</tr> ';
	}
	?>
	</table>
	<br>	
	<?php
	$jum2=0;
	$query22="SELECT idproduct FROM products WHERE active=2 ";
	$result22=mysql_query($query22);
	$jum2=mysql_num_rows($result22);
	?>
	</td>
</tr>
<tr>
	<td align="right">
	<b><label class="keterangan" align="right">There are <?php echo $jum2; ?> products pending</label></b>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td class="judul">New Advertisement</td>	
</tr>
<tr>
	<td>
	<?php
	$query3 = "SELECT a.*, c.categoryname FROM advertisement a, advcategory c WHERE a.idadvcategory=c.idadvcategory ";
	$query3 .="ORDER BY inputdate desc limit 10";
	$result3=mysql_query($query3);
	?>
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#FFFFFF" border="1"  bordercolor="#CBC8C8">
	<tr>
		<th width="5%">ID</td>
		<th width="25%">Ad Title</td>
		<th width="20%">Ad Category</td>
		<th width="20%">Detail</td>
		<th width="20%">Status</td>
		<th width="10%">Delete</td>
	</tr>
	<?php
	while($row3 = mysql_fetch_array($result3))
	{
		if ($row3["active"]=='0')echo '<tr bgcolor="#D8D8D8">';
		else if ($row3["active"]=='3')echo '<tr bgcolor="#BE81F7">';
		else if ($row3["active"]=='2')echo '<tr bgcolor="#F2F5A9">';
		else echo '<tr>';
		echo '<td align="right">'.$row3["idadv"].'</td>
			<td align="left">'.$row3["advtitle"].'</td>
			<td align="left">'.$row3["categoryname"].'</td>';		
			?>
			<form action="detail-advertisement.php" method="POST" onsubmit="return confirm('See detail Ad?');">		
			<?php
			echo '<td align="center">';
			echo '<input type="submit" name="submit" id="submit" value="Detail">
				<input type="hidden" name="ide" id="ide" value='.$row3["idadv"].'>	
				<input type="hidden" name="page" id="page" value="" class="page">
				</form></td>' ;	
		echo '<td align="center">';
			switch ($row3["active"]) 
			{
			case 0:
				echo "Deleted";
				break;
			case 1:
				echo "Active";
				break;
			case 2:
				echo "Pending";
				break;
			case 3:
				echo "Rejected";
				break;
			}
		echo '</td>';
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
		echo '<td align="center">';
			if ($row3["active"]==0){echo "Deleted";} else {	
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row3["idadv"].'>
				<input type="hidden" name="tabel" id="tabel" value="advertisement">
				<input type="hidden" name="namaid" id="namaid" value="idadv">	
				<input type="hidden" name="page" id="page" value="" class="page">';}
		echo '</td></form>
			</tr> ';
	}
	?>
	</table>
	<br>
	<?php
	$date = strtotime(now);
	
	$date = strtotime("-90 day", $date);	
	$date1= date('Y-m-d', $date);
   
	$jum3=0;
	$query33="SELECT idadv FROM advertisement WHERE active=2 and inputdate>='$date1'";
	$result33=mysql_query($query33);
	$jum3=mysql_num_rows($result33);
	?>
	</td>
</tr>
<tr>
	<td align="right">
	<b><label class="keterangan" >There are <?php echo $jum3; ?> advertisement pending since <?php echo date('d M Y', $date); ?></label></b>
	</td>
</tr>
</table>
