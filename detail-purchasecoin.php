<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_POST['ide'])){header('Location:./list-products.php');}
include "top.php";

//load data produk
$query="SELECT p.*, c.categoryname, s.subcategoryname, m.membername, m.telephone, m.email, m.idyahoo, m.fbpage, m.twitter, m.joindate, r.symbol, ";
$query .="co.countryname, pr.provincename, ci.cityname ";
$query .="FROM products p, category c, subcategory s, member m, currency r, country co, province pr, city ci ";
$query .="WHERE p.idsubcategory=s.idsubcategory and s.idcategory=c.idcategory and p.idmember=m.idmember and p.idcurr=r.idcurr ";
$query .="and p.port=ci.idcity and ci.idprovince=pr.idprovince and pr.idcountry=co.idcountry ";
$query .="and p.idproduct='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_array($result);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="isi" name="isi" style="" align="center">
<h2>Product Detail</h2>
<table width="55%" border="0" cellspacing="3" cellpadding="3" align="center" bgcolor="#99FFCA">
<tr>
	<td align="left" colspan="5" bgcolor="#FFFFFF"><b>Member Data</b></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Member Name</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['membername']; ?></td>
</tr>
<tr>
	<td align="right">Member ID</td>
	<td align="center" >:</td>
	<td align="left" colspan="3"><?php echo $row['idmember']; ?></td>
</tr>
<tr>
	<td align="right">Telephone</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['telephone']; ?></td>
</tr>
<tr>
	<td align="right">Email</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['email']; ?></td>
</tr>
<tr>
	<td align="right">Facebook</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['fbpage']; ?></td>
</tr>
<tr>
	<td align="right">Twitter</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['twitter']; ?></td>
</tr>
<tr>
	<td align="right">Member Since</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['joindate']; ?></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Product Picture</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5" align="center" >
		<div style="margin-left:30px;">
		<?php 
		$carigbr="SELECT * from tpicproductiklan where idIklan='$row[idproduct]'";
		$resgbr=mysql_query($carigbr);
		if(mysql_num_rows($resgbr)<1)
		echo '<img src="../images/noimage.jpg" width="120" height="">';
		else
		{
			while($rowgbr=mysql_fetch_array($resgbr))
			{ 
				$gbr="../modulee/upload_iklan/imgz_iklan/".$rowgbr['filePicture'];
				if(file_exists($gbr))
				echo '<img src="'.$gbr.'" width="120" height="">&nbsp;'; 		 
				else echo '<img src="../images/noimage.jpg" width="120" height="">&nbsp;'; 		 
			} 
		}
		?>
		</div>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Product Data</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Product ID</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['idproduct']; ?></td>
</tr>
<tr>
	<td align="right">Product Name</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['productname']; ?></td>
</tr>
<tr>
	<td align="right">Product Category</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['categoryname']." >> ".$row['subcategoryname']; ?></td>
</tr>
<tr>
	<td align="right">Port</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo ucwords(strtolower($row['cityname']))." >> ".ucwords(strtolower($row['provincename']))." >> ".$row['countryname']; ?></td>
</tr>
<tr>
	<td align="right">Product Price</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['symbol']." ".number_format($row["productprice"],0,",","."); ?></td>
</tr>
<tr>
	<td align="right">Minimal Order</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['minorder']; ?> pcs</td>
</tr>
<tr>
	<td align="right">Supply Ability</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['supplyability']; ?></td>
</tr>
<tr>
	<td align="right">Packaging Detail</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['packagingdetail']; ?></td>
</tr>
<tr>
	<td align="right">Payment Term</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['deliverydetail']; ?></td>
</tr>
<tr>
	<td align="right">Delivery Detail</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['deliverydetail']; ?></td>
</tr>
<tr>
	<td align="right">Product Specifications</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['productspec']; ?></td>
</tr>
<tr>
	<td align="right">Product Description</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['productdesc']; ?></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td align="right">Negotiable</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php if ($row['negotiable']==1) echo "Yes"; else echo "No" ; ?></td>
</tr>
<tr>
	<td align="right">Input Date</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['inputdate']; ?></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Respond to this Product</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<form action="accept-product.php" method="POST" onsubmit="return confirm('Are you sure want to proceed?');">
<tr>
	<td align="right">Response</td>
	<td align="center">:</td>
	<td align="left" colspan="3">
		<Input type = 'Radio' Name ='action' value= 'accept' checked>Accept
		<Input type = 'Radio' Name ='action' value= 'reject'>Reject	
	</td>
</tr>
<tr>
	<td align="right">Reason</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><textarea name="reason" id="reason" cols="30" rows="5"></textarea></td>
</tr>
<tr>
	<td align="right" width="30%">&nbsp;</td>
	<td align="center" width="10%">&nbsp;</td>
	<td align="left" width="10%">
			<input type="submit" name="submit" id="submit" value="Submit">
			<input type="hidden" name="ide" id="ide" value="<?php echo $row['idproduct']; ?>">
			<input type="hidden" name="namaproduct" id="namaproduct" value="<?php echo $row['productname']; ?>">
			<input type="hidden" name="target" id="target" value="products">
			<input type="hidden" name="namamember" id="namamember" value="<?php echo $row['membername']; ?>">
			<input type="hidden" name="emailmember" id="emailmember" value="<?php echo $row['email']; ?>">
		</td>	
	<td align="left" width="50%">&nbsp;</td>
	<td align="left" width="10%">&nbsp;</td>
</tr>
</form>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5"><input type="button" name="submit" id="sumbit" value="Back" onclick="klikBack();" style="width:70px;"></td>
</tr>
</table>
</div>