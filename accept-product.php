<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_POST['action'])){header("location:javascript://history.go(-1)");}
if (!isset($_POST['target'])){header("location:javascript://history.go(-1)");;}
if (!isset($_POST['ide'])){header("location:javascript://history.go(-1)");;}
include "top.php";
include "../modulee/classMailer.php";

$action=$_POST['action'];//accept or reject
$target=$_POST['target'];//products or advertisement
$ide=$_POST['ide'];
$msg=$_POST['reason'];
$namaproduct=$_POST['namaproduct'];
$namamember=$_POST['namamember'];
$email=$_POST['emailmember'];
$greet1="";
$media="";
$namafield="";
$prod="";
$statusaktif=1;

//filtering the target
if($target=="products")
{
	$media="World Trade on Roripon.com";
	$namafield="idproduct";
	$prod="product";
}
else
{
	$media="Buy And Sale on Roripon.com";
	$namafield="idadv";
	$prod="advertisement";
}

// filtering the action
if($action=="accept")
{
	$statusaktif="1";
	$greet1="Dear Customer,<br>
			We are pleased to inform you that your ".$prod." ".$namaproduct." from ".$media." with ".$prod." id ".$ide." has been accepted.<br>
			Please feel free to check it on Roripon.com<br>
			You can also edit the information of your ".$prod." via I Rori after you sign in to Roripon.<br>
			nb : ".$msg."<br><br>
			Have a nice day !<br><br>
			Roripon Administrator";
}
else
{
	$statusaktif="3";
	$greet1="Dear Customer,<br>
			We are sorry to inform you that your ".$prod." ".$namaproduct." from ".$media." with ".$prod." id ".$ide." has been rejected because <br>
			".$msg."<br>
			Please check it immediately on Roripon.com<br>
			You can also edit the information of your ".$prod." via I Rori after you sign in to Roripon.<br>
			Have a nice day !<br><br>
			Roripon Administrator";
}

	// saving the data
	$query="UPDATE ".$target." ";
	$query.="SET active=".$statusaktif.", inputdate=now() WHERE ".$namafield."='$ide'";
	$result=mysql_query($query);
		
	// sending email to customer related about the action
	$emailsender = "cs@roripon.com";
	$emailreceiver = $email;
	$namapengirim = "Roripon.com";
	$namapenerima = $namamember;
	$subject="Feedback about your product in roripon.com";

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
