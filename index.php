<?php
session_start();
if (isset($_SESSION['adzuser'])){header('Location:./mainmenu.php');}
include "library/conn.php";
include "library/global.php";

$pesan='';
if(isset($_POST['submit']))
{
	// posting results
	$user= $_POST['user'];
	$pass=$_POST['pass'];

	if((!empty($user))&&(!empty($pass)))
	{
		$query = "SELECT *, md5(password) as password2 FROM user WHERE username='$user' AND active=1";
		$result=mysql_query($query);
		if(mysql_num_rows($result) < 0)
		{
			$pesan = 'Invalid username!';
		}
		else
		{	
			$query = "SELECT * FROM user WHERE username='$user' AND password=md5('$pass')";
			$result=mysql_query($query);
			if(mysql_num_rows($result) > 0)
			{
				$baris= mysql_fetch_assoc($result);
			
				$_SESSION['adzuser'] = $baris['username'];
				$_SESSION['adzusertype'] = $baris['usertype'];
				
				// taking ip user
				$client_ip = getIP();
				 
				//update last login
				$query="UPDATE user SET lastlogin=now(), iplastlogin='$client_ip' WHERE iduser='".$baris['iduser']."'";
				mysql_query($query);
				$mesg="Welcome ". $_SESSION['adzuser'];
				?>
				<script type="text/javascript">
				alert("<?php echo $mesg; ?>");
				window.location="./mainmenu.php";
				</script>
				<?php
			}
			else
			{
				$pesan = 'Username and Password you have entered is invalid !';
			}
		}
	}
	else
	{
		$pesan = 'Please fill in the username and password .';
	}
	?>
	<script type="text/javascript">
	alert("<?php echo $pesan; ?>");
	</script>
	<?php
}
?>
<link href="library/style.css" rel="stylesheet" media="all" />


<div id="login_wrap">
<img src="img_interface/logo.png" />
<b><br/>LOGIN - RORIPON</b>
<form action='index.php' method='POST'>
<table width="300" height="100" border="0" align='center' cellpadding=2 cellspacing=2>
<tr>
  <td height="30" colspan="2">Username : <input type="text" name="user" id="user"></td>
</tr>
<tr>
  <td height="30" colspan="2">Password : <input type="password" name="pass" id="pass"></td>
</tr>
<tr>
	<td width="130"><input type="reset" name="reset" id="reset" value="Reset" class="pressed"></td>
	<td width="50"><input type="submit" name="submit" id="submit" value="Login" class="pressed"></td>
</tr>
</table>
</form>
</div>