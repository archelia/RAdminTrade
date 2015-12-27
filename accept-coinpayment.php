<link href="library/style.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>	
<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_POST['ide'])){header("location:javascript://history.go(-1)");;}
include "../modulee/classMailer.php";
include "library/conn.php";
include "library/global.php";

	$ide=$_POST['ide'];
	$email=$_POST['email'];
	$idmember=$_POST['idmember'];
	$statusaktif="1";
	
	// get the detail data
	$sqlc="SELECT p.*, g.name FROM purchase p, package g WHERE p.idpackage=g.idpackage AND idpurchase='$ide'";
	$resc=mysql_query($sqlc);
	$rowc=mysql_fetch_array($resc);
	
	$greet1="Dear Customer,<br>
			We are pleased to inform you that your Roripon Coins has been confirmed.<br>
			
			Here's the detail of your purchasing.
			Purchase ID    : ".$ide."
			Purchase Date  : ". date('d-m-Y H:i:s',$rowc['inputdate'])."
			Package name   : ".$rowc['name']."
			Coins(s) qty   : ".$rowc['qty']."
			Total		   : ".$rowc['price']."
			
			Thank You for your trust in Roripon.com<br>
			Please feel free to check it on www.roripon.com<br><br>
			
			Have a nice day !<br><br>
			Roripon Administrator";

	// update the status purchase
	$query="UPDATE purchase ";
	$query.="SET status=3, note='Success', inputdate=now() WHERE idpurchase='$ide'";
	$result=mysql_query($query);
	
	// checking if theres data in memberacc table
	$sqlcek="SELECT * FROM memberacc WHERE idmember='$_POST[idmember]'";
	$rescek=mysql_query($sqlcek);
	if(mysql_num_rows($rescek)>0)
	{
		// update the member account
		$query="UPDATE memberacc ";
		$query.="SET accbalance=accbalance+".$rowc['qty'].", lastupdate=now() WHERE idmember='$_POST[idmember]'";
		$result=mysql_query($query);
	}
	else
	{
		// update the member account
		$query="INSERT INTO memberacc ";
		$query.="VALUES ('$_POST[idmember]', '$_POST[qty]', now()) ";
		$result=mysql_query($query);
	}
		
	// if no create a row
	// creating in web message
	$message="Congratulation !! Your coin purchase with Purchase ID '$ide' has been successful. Please check I-Rori for further information.";
	$kode=0;
	// generate new id
	$sqlr = "SELECT max(idmessage) as newid from message ";
	$resultr = mysql_query($sqlr);
	if (mysql_num_rows($resultr)<1){$kode=1;}
	else
	{
	$rowr=mysql_fetch_array($resultr);
	$kode=$rowr['newid']+1;
	}
	$query="INSERT INTO messages ";
	$query.="VALUES('$kode','1111111111','$idmember','$message','inputdate','1')";
	$result=mysql_query($query);
		
	// sending email to customer related about the action
	$emailsender = "cs@roripon.com";
	$emailreceiver = $email;
	$namapengirim = "Roripon.com";
	$namapenerima = $namamember;
	$subject="Confirmation about your roricoins	in roripon.com";

	echo $isiemail = "
	<table width=\"625\" border=\"0\" align=\"center\" style=\"border:1px solid green\">
	  <tr>
		<td colspan='2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td align=\"right\">
			<img width=\"187\" height=\"88\" src=\"http://www.roripon.com/config/images/newtoplogo.png\" align=\"right\" />
		</td>
		<td width=\"605\"><p align=\"center\">
			<strong>PT.  RORI PON</strong><br />
			Jalan Dharmahusada Indah Utara Blok U/VI no. 319  Surabaya<br />
			Tlp. 031 83222289/99, 031 71998877.<br/> 
			Email  cs@roripon.com</p>
		</td>
	  </tr>	  
	  <tr>
		<td colspan='2'><hr color='green'></td>
	  </tr>
	  <tr>
		<td colspan='2'><i>You got this message via Roripon.com</i></td>
	  </tr>
	  <tr>
		<td align='left' colspan='2'>From : $namapengirim"."(".$emailsender.")</td>
	  </tr> 
	   <tr>
		<td align='left' colspan='2'>Subject : $subject</td>
	  </tr> 
	  <tr>
		<td colspan='2'>&nbsp;</td>
	  </tr> 
	  <tr>
		<td colspan='2'>".$greet1."
		</td>
	  </tr>
	</table>";

	$sender = new MailSender();
	$sender->set_from($emailsender);
	$sender->set_from_name($namapengirim);
	$sender->set_message($isiemail);
	$sender->set_subject($subject);
	$sender->set_to($emailreceiver);
	$sender->set_to_name($namapenerima);
	$sender->send();					
	if ($sender)
	{
	$pesan="An email has been sent to member's email address. Update ".$prod." success.";
	}
	echo "<script>alert(\"$pesan\");window.location='javascript:javascript:history.go(-2)';</script>";
?>
