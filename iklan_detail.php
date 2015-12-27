<link href="config/css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="config/css/galleriffic-5.css" type="text/css" />

<script type="text/javascript" src="js/jquery.history.js"></script>
<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
<!-- We only want the thunbnails to display when javascript is disabled -->
<script type="text/javascript">
	document.write('<style>.noscript { display: none; }</style>');
</script>
<script src="js/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#pesane").hide();	
	$('a[rel*=facebox]').facebox({
		loadingImage : 'img/loading.gif',
		closeImage   : 'img/closelabel.png'
	  });
	loadcomment();
});

<!--FOR COOKIES-->
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
	alert("Ad Saved !");
}		

function loadcomment()
{
	 var idadv = document.getElementById("idadv").value;
	 var limit = document.getElementById("limit").value;
	 var page = document.getElementById("page").value;
	 var tabele =  "commentadv"; 
	 var dataString = 'idadv='+ idadv + '&limit='+limit+ '&page='+page+ '&tabele='+tabele;
	 $.ajax({
		  type: "POST",
		  url: "modulee/comments/loadcomment.php",
		  data: dataString,
		  cache: false,
		  success: function(html){ 
		  document.getElementById("commentshow").innerHTML =html;
		  }
	 });
	 // hitung jumlah page
	 $.ajax({
		  type: "POST",
		  url: "modulee/comments/countcomment.php",
		  data: dataString,
		  cache: false,
		  success: function(max)
		  { 	
			document.getElementById("maxpage").value=max;
			if(page<max)
			{		
				$("#shownext").show();
			}	
			else
			{
				$("#shownext").hide();
			}	
			// cek tombol less perlu apa nda
			if(page>1)
			{
				$("#showprev").show();
			}
			else
			{
				$("#showprev").hide();
			}	
		  }
	 });
	//alert("aq diload lagi");
};

function deletecomment(idcomment)
{
	if (confirm("Are you sure you want to delete this comment?"))
	{
	 var tabele =  "commentadv"; 
	 var dataString = 'idcomment='+ idcomment +'&tabele='+tabele; 
	 $.ajax({
	  type: "POST",
	  url: "modulee/comments/deletecomment.php",
	  data: dataString,
	  cache: false,
	  success: function(html)
	  { 
		loadcomment();	  	  
	  }	 
	  });	
	}	
};

function sendcomment()
{
	var cek = document.getElementById("isikomen").value ;
	 if(cek=="")
	  {
			alert("Comment can't be blank !");
			$("#isikomen").focus();
			return false;	
	  }
  var idadv = document.getElementById("idadv").value ;
  var idmember =  $('#idmember').val(); 
  var isikomen =  $('#isikomen').val(); 
  var tabel =  "commentadv"; 
  var dataString = 'idadv='+ idadv + '&idmember='+idmember+ '&isikomen='+isikomen+ '&tabel='+tabel;
   
  $.ajax({
	  type: "POST",
	  url: "modulee/comments/sendcomment.php",
	  data: dataString,
	  cache: false,
	  success: function(html)
	  {
		document.getElementById("isikomen").value ="";
		loadcomment();
	  }	 
  }); 
};

function next()
{ 
	var page = $('#page').val();
	var maxpage = $('#maxpage').val();
	if(page<maxpage){page++;}
	document.getElementById('page').value=page;
	loadcomment();
}; 

function prev(){
	var page = $('#page').val();
	var maxpage = $('#maxpage').val();
	if(page>1){page--;}
	document.getElementById('page').value=page;
	loadcomment();
};
</script>
<script type="text/javascript" >
function klikBack()
{
window.location='buy-sale';
};

function sendmessage(){
var idsender = document.getElementById("idsender").value; 
	   var idreceiver = document.getElementById("idreceiver").value; 
	   var isipesan = document.getElementById("isipesan").value; 
	   var dataString = 'idsender='+ idsender +'&idreceiver='+ idreceiver +'&isipesan='+ isipesan;
	   document.getElementById('pesane').value="";
	   $.ajax({
           type: "POST",
           url: "modulee/profile/sendmessage.php",
           data: dataString,
           cache: false,
           success: function(html)
		   {    
			//alert(html); 
		    document.getElementById("pesane").innerHTML =html;	
           }
        });	
	   $("#pesane").show();
	   document.getElementById('isipesan').value="";
};

function deleteads(idadv,idmember,idpengiklan)
{
	if (confirm('Are you sure you want to delete this advertisement ?'))
	{
		if(idmember="1"){alert("Please login first !");return false;}
		if(idpengiklan!=idmember){alert("You don't have access to this advertisement !");return false;}		
		else 
		{
		   var dataString = 'idadv='+ idadv;
		   $.ajax({
			   type: "POST",
			   url: "modulee/ajax-deleteadv.php",
			   data: dataString,
			   cache: false,
			   success: function(html)
			   {    
				alert(html); 
			   }
		   });	
		}
	}
};
</script>

<?php 
require_once("config/conn.php");
if(isset($_GET["ide"]))
{
	$idadv = $_GET["ide"];
	$_POST["idadv"] = $_GET["ide"];
	$sql = "update advertisement set view=view+1,  lastviewed=now()  where idadv = ".$idadv ;
	$Qrs = mysql_query($sql);
}
else if(isset($_GET["ide"]) && isset($_GET["page"]) ){
		$idadv = $_GET["ide"];
		$_POST["idadv"] = $_GET["ide"];
}
else  header('Location:./index.php');
	
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

$pageUR = curPageURL();

function makeClickableLinks($text)
{

        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2" target=_blank>\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
        '<a href="mailto:\\1" target=_blank>\\1</a>', $text);
        return $text;
}

?>
<?php
	$sql = "SELECT a.*, cr.symbol, d.membername, d.telephone, d.location, d.email, date(d.joindate) as joindate, d.idyahoo, d.fbpage, d.twitter, d.pinbb, c.categoryname, b.cityname, t.countryname ";
	$sql.= "from advertisement a ";
	$sql.= "left join currency cr on a.idcurr=cr.idcurr ";
	$sql.= "left join city b on a.advidcity=b.idcity ";
	$sql.= "left join country t on b.idcountry=t.idcountry ";
	$sql.= "left join advcategory c on a.idadvcategory=c.idadvcategory ";
	$sql.= "left join member d on a.idmember=d.idmember where idadv=".$idadv;
	$QdataHalDepan = mysql_query($sql);
	if($dataHalDepan=mysql_fetch_array($QdataHalDepan)) {					
?>
<link rel="stylesheet" type="text/css" href="modulee/csskuw.css"/>
<?php
	$filecat="advertisement?ide=";
	$qcatlist="SELECT * FROM advcategory WHERE active=1 AND idadvcategory NOT IN (1,2,7,9,5,4) ORDER BY categoryname ASC";
	$resqcat=mysql_query($qcatlist);
?>
<?php
if(date("Y-m-d")<"2013-03-06")
{
?>
	<table width="100%">
      <tr>
      	<td align="center">
      	<a href="http://rorisvangoghpainting.roripon.com" target="_blank"><img src="img/bannergogh.jpg"></a>
      	</td>
      </tr>
      </table>
<?php 
}
?>
<div id="pagedetail" name="pagedetail" width="" align="center" class="stylesiji2">
<!--
<div style="float:left;margin-top:10px;" onclick="javascript:klikBack();" class="tombol"><b>Home</b></div>
-->
<div style="float:left;margin-top:10px;margin-left:10px;" class="styleabukecil">
<?php 
	echo '<a href="buy-sale" class="abuclass">Buy - Sale</a> > <a href="advertisement?ide='.$dataHalDepan['idadvcategory'].'" class="abuclass">'.$dataHalDepan['categoryname'].'</a> > '.ucwords($dataHalDepan['advtitle']);
?>
</div>

<div style="float:right;margin-right:15px;margin-top:15px;">  

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="700" rowspan="6" valign="top">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				
				<tr>
					<td valign="middle" align="left"   width="540" height="40">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>	
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td width="1%" rowspan="5">
								<form name="form1" method="" action="">
									<input type="hidden" name="idmember" id="idmember" value="<?php echo $_SESSION["rorimember"];?>">
									<input type="hidden" name="idadv" id="idadv" value="<?php echo $idadv;?>">
									<input type="hidden" name="limit" id="limit" value="10">
									<input type="hidden" name="page" id="page" value="1">
									<input type="hidden" name="maxpage" id="maxpage" value="<?php echo ceil(mysql_num_rows($QdataHalDepan)/10); ?>">
								</form>
							</td>
						<table cellspacing="4" cellpadding="0" width="100%" style="color:#585858;">
						</tr>
						<tr>
						<p align="center"><b style="font-size:35px;">
							<?php 
								echo ucwords($dataHalDepan["advtype"])." : ";
								echo ucwords($dataHalDepan["advtitle"]);
							?></b></p><br/>
						<td width="75%" valign="top" align="center">                                              
								<?php
									
						$filename  = 'img_adv/'.$dataHalDepan["idadv"].'_1.jpg';
                        $filename2 = 'img_adv/'.$dataHalDepan["idadv"].'_2.jpg';
                        $filename3 = 'img_adv/'.$dataHalDepan["idadv"].'_3.jpg';
                        $filename4 = 'img_adv/'.$dataHalDepan["idadv"].'_4.jpg';
                        $filename5 = 'img_adv/'.$dataHalDepan["idadv"].'_5.jpg';
                        $filename6 = 'img_adv/'.$dataHalDepan["idadv"].'_6.jpg';
                        $filename7 = 'img_adv/'.$dataHalDepan["idadv"].'_7.jpg';
                        $filename8 = 'img_adv/'.$dataHalDepan["idadv"].'_8.jpg';
						
						$filenames = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_1.jpg';
                        $filenames2 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_2.jpg';
						$filenames3 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_3.jpg';
						$filenames4 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_4.jpg';
						$filenames5 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_5.jpg';
						$filenames6 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_6.jpg';
						$filenames7 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_7.jpg';
						$filenames8 = 's_imgAdv/s_'.$dataHalDepan["idadv"].'_8.jpg';
						?>
                        
                        <div id="page" style="width:575px;">
			<div id="container" style="width:700px !important;height:750px !important;">
				<!-- Start Advanced Gallery Html Containers -->				
				<div class="navigation-container">
					<div id="thumbs" class="navigation">
						<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
					
						<ul class="thumbs noscript">
                        <?php
							
						if (file_exists($filename)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename.'" title="Picture #1">
									<img src="https://www.roripon.com/'.$filename.'" alt="Picture #1" width="70px" />
								</a>
							</li>';
						}
						if (file_exists($filename2)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename2.'" title="Picture #2">
									<img src="https://www.roripon.com/'.$filename2.'" alt="Picture #2" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename3)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename3.'" title="Picture #3">
									<img src="https://www.roripon.com/'.$filename3.'" alt="Picture #3" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename4)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename4.'" title="Picture #4">
									<img src="https://www.roripon.com/'.$filename4.'" alt="Picture #4" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename5)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename5.'" title="Picture #5">
									<img src="https://www.roripon.com/'.$filename5.'" alt="Picture #5" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename6)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename6.'" title="Picture #6">
									<img src="https://www.roripon.com/'.$filename6.'" alt="Picture #6" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename7)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename7.'" title="Picture #7">
									<img src="https://www.roripon.com/'.$filename7.'" alt="Picture #7" width="70px"/>
								</a>
							</li>';
						}
						if (file_exists($filename8)) 
						{
							echo '
							<li>
								<a class="thumb" href="https://www.roripon.com/'.$filename8.'" title="Picture #8">
									<img src="https://www.roripon.com/'.$filename8.'" alt="Picture #8" width="70px"/>
								</a>
							</li>';
						}
						
						?>	
							
						</ul>
						<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
					</div>
				</div>
				<div class="content">
					<div class="slideshow-container">
						<div id="controls" class="controls"></div>
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container">
						<div class="photo-index"></div>
					</div>
				</div>
				<!-- End Gallery Html Containers -->
				<div style="clear: both;"></div>
			</div>
		</div>												
							</td>
							<td valign="top" align="left" width="30%">
							<div class="price"><span class="idr"><?php echo $dataHalDepan["symbol"]; ?></span><h1><strong><?php echo nl2br(number_format($dataHalDepan["advprice"],0,",","."));?></strong></h1></div>
							<div style="margin-top:65px;display:block;width:240px;background-image: url(images/wood2.png);" class="web_border">
							<?php 
							echo '<table width="100%">';
							echo '<tr><td align="center" style="margin-top:10px;"><b><a class="aclass" style="font-size:20px;" href="profile?idm='.$dataHalDepan["idmember"].'">'.ucwords($dataHalDepan["membername"]).'</a></b></td></tr>';
							$filename = 'modulee/fotomember/'.$dataHalDepan["idmember"].'.jpg';
																				
							if (file_exists($filename)) {
							echo '<tr><td align="center"><a href="profile?idm='.$dataHalDepan["idmember"].'"><img src='.$filename.' width="100"  height="100" class="web_detprod" style="float:center;"></a></td></tr>';
							}else{
							echo '<tr><td align="center"><a href="profile?idm='.$dataHalDepan["idmember"].'"><img src="modulee/fotomember/default.jpg" width="100" height="100" class="web_detprod" style="float:center;"></a></td></tr>';
							}
							echo '<tr><td align="center" class="styleloro" style="font-size:11px;"><i>member since : '.$dataHalDepan["joindate"].'</i></td></tr></table>';
							echo '<table width="100%" class=""><tr><td>';
							echo '<tr><td colspan="2">&nbsp;</td></tr>';
							echo '<tr><td><img src="img/map.png" style="float:left;" alt="location"/></td><td>'.ucwords($dataHalDepan["location"]).'</td></tr>';
							echo '<tr><td><img src="img/facebook.png" style="float:left;"/></td><td>'.$dataHalDepan["fbpage"].'</td></tr>';
							echo "<tr><td><img src='img/yahoo.png' style='float:left;'/></td><td><a href='ymsgr:sendIM?".$dataHalDepan["idyahoo"]."' title='".$dataHalDepan["idyahoo"]."'><img border='0' src='http://opi.yahoo.com/online?u=".$dataHalDepan["idyahoo"]."&m=g&t=2' /></a></td></tr>";
							echo '<tr><td><img src="img/twitter.png" style="float:left;"/></td><td>'.ucwords($dataHalDepan["twitter"]).'</td></tr>';
							echo '<tr><td><img src="img/bb.png" style="float:left;"/></td><td><b>';
									if($dataHalDepan["pinbb"]==""){echo "-";} else {echo $dataHalDepan["pinbb"];}
							echo '</b></td></tr>';
							$phonec = $dataHalDepan["telephone"];
							$lenght = strlen($phonec);
							$phony = substr_replace($phonec,'xxxx',$lenght-4,4);
							echo '<tr><td><img src="img/telephone.png" style="float:left;"/></td><td><b id="phon" onclick="phones()" class="pointer">'.$phony.'</b></td></tr>';
							echo '<tr><td><img src="img/mail.png" style="float:left;" alt="email"/></td><td style="font-size:14px;">';
							if(!isset($_SESSION['rorimember']))echo $dataHalDepan["email"];
							else
							{
							echo '<a href="#infoz" rel="facebox">'.$dataHalDepan["email"].'</a>';	  
							$sql = mysql_query("select membername, email from member where idmember='".$_SESSION['rorimember']."'");
							$sqlR = mysql_fetch_array($sql);
							?>
							<div id="infoz" style="display:none;">
								<form id='kirimimel' name='kirimimel' class='formemail' method='post' action='sendemail' autocomplete='off'>
									<b style="font-size:20px;margin-bottom:20px;">Send Email</b>
									<div>
										<label for="pengirim" class="labelemail">From : </label>
										<input name="pengirim" id="pengirim" class="inputemail" type="text" value="<?php echo $sqlR['email'];?>" readonly/>
										<input name="namapengirim" id="namapengirim" type="hidden" value="<?php echo $sqlR['membername'];?>"/>
									</div>
									<div>
										<label for="penerima" class="labelemail">To : </label>
										<input name="penerima" id="penerima" class="inputemail" type="text" value="<?php echo $dataHalDepan["email"]; ?>" readonly/>
										<input name="namapenerima" id="namapenerima" type="hidden" value="<?php echo $dataHalDepan["membername"]; ?>"/>
									</div>
									<div>
										<label for="subjectpenerima" class="labelemail">Subject : </label>
										<input name="subject" id="subject" class="inputemail" type="text" value="<?php echo ucwords($dataHalDepan["advtitle"]); ?>" readonly/>
									</div>
									<div>
										<label for="messages" class="labelemail">Message : </label>
										<textarea name="emailmsg" id="emailmsg" class="textareaemail"></textarea>
									</div>
									<div>
										<br/>
										<div style="width:350px;margin-left:10px;">
											<p class="styleloro"><b>Tips !</b></p><br/>
											<p class="styleabang" style="margin-left:1px;margin-right:1px;">
											<b>
												Beware of scamming.<br/>
												Do not pay upfront.<br/>
												Check the clarity of the supplier and product before you buy.<br/>
												Roripon do not submit any proof of payments to the buyer.
											</b>
											</p>
										</div>
									</div>
									<div>
									<br/>
									<input id='btnSendEmail' name='btnSendEmail' type='submit' value='Send' class="tombol" style="height:40px;">
									</div>
								</form> 
							</div>
							<?php
							}
							echo '</td></tr>';
							echo '<tr><td colspan="2">&nbsp;</td></tr>';
							echo '<tr><td colspan="2" align="right" class="" style="font-size:11px;">viewed : '.$dataHalDepan["view"].' times&nbsp;&nbsp;</td></tr>';
							echo '</table>';
							?>
							<script>
							function phones()
							{
								page =  "<?php echo $phonec;?>";
								document.getElementById("phon").innerHTML = page;
							}
							</script>
							</div>
							<br>
							<div style="margin-top:1px;margin-right:1px;margin-left:1px;display:block;background-image: url(images/wood.jpg);width:240px;" class="web_border">
								&nbsp;<br>
								<div style="width:220px;margin-left:10px;">
								<p class="styleloro"><b>Tips !</b></p><br/>
								<p class="styleabang" style="margin-left:1px;margin-right:1px;"><b>
									Beware of scamming.<br/>
									Do not pay upfront.<br/>
									Check the clarity of the supplier and product before you buy.</b>
								</p>
								</div>
								&nbsp;<br>
							</div>
						</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<?php 
						if ($dataHalDepan["active"]==5)
						{
							echo "<img src='img/sold.png' style='margin-bottom:-465px;position:relative;z-index:99;' width='705' height='537'>";
						}
						?>
						<!--AD OPTION-->
                      	<tr>
							<td align="left" height="30" class="styleabu" style="margin-left:1em;" colspan="2">AD OPTIONS</td>
						</tr>
						<tr>			
							<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
						</tr>
                        <tr>
							<td style="line-height:2em;" colspan="2">
                            <table width="100%">
                            	<tr>
                                    <td>
                                    <div>

<script>var fbShare = {
url: '<?php echo curPageURL();?>',
size: 'small',
badge_text: 'C0C0C0',
badge_color: 'CC00FF'
}</script>
    <script src="http://widgets.fbshare.me/files/fbshare.js"></script>
	
	<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_link { padding:2px 0 0 20px; height:16px; background:url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top left; }</style><a rel="nofollow" href="http://www.facebook.com/share.php?u=%3c;url>" onclick="return fbs_click()" target="_blank" class="fb_share_link">Share on Facebook </a>

	<script>
<g:plus action="share" annotation="bubble" href="<?php echo curPageURL();?>"></g:plus>
			<!-- Place this tag after the last share tag. -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $pageUR;?>" data-via="roripondotcom" data-lang="en" data-text="<?php echo ucwords($dataHalDepan["advtitle"]);?>">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>								
<a data-pin-config="beside" href="//pinterest.com/pin/create/button/?url=https%3A%2F%2Fwww.roripon.com%2Fdetailads%3Fide%3D<?php echo $idadv; ?>&media=https%3A%2F%2Fwww.roripon.com%2Fimg_adv%2F<?php echo $idadv; ?>_1.jpg&description=Roripon%20Buy%20%26%20Sale" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
</div>
                                    </td>
                                    <td><a href="sendreport?idadv=<?php echo $idadv;?>" rel="facebox"><div class="buttonz">Report Ad<img src='images/edit.png' width='20' height='20' style="float:left;margin-top:5px;margin-left:2px;"/></div></a></td>
                                    <div id="report" style="display:none;">
								
							</div>
								    <td><div class="buttonz" style="cursor:pointer;" onclick="createCookie('favorit[<?php echo $idadv?>]','<?php echo $pageUR?>',360);">Save Ad<img src='images/star.png' width='25' height='25' style="float:left;"/></div></td>
                                    <td>
										<?php 
										$rmember="1";
										if(isset($_SESSION['rorimember']))$rmember=$_SESSION['rorimember'];
										?>
										<div class="buttonz" onclick="deleteads(<?php echo $dataHalDepan["idadv"].",".$rmember.",".$dataHalDepan["idmember"] ; ?>);" style="cursor:pointer;">Delete Ad<img src='images/delete.png' width='20' height='20' style="float:left;margin-top:5px;margin-left:2px;"/></div></td>
                            	</tr>
                            </table>
                            </td>
                         </tr>
						<tr>
							<td align="left" height="30" class="styleabu" style="margin-left:1em;" colspan="2">DETAIL</td>
						</tr>
						<tr>			
							<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
						</tr>
						<tr>
							<td style="line-height:2em;" colspan="2">
							<table class="web_border" background="images/container.png" width="95%" style="color:#424242;margin-top:1em;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							
							<tr><td width="15%">Category</td><td width="5%">:</td><td width="80%"><?php echo ucwords($dataHalDepan["categoryname"]);?></td></tr>
							<tr><td>Location</td><td>:</td><td><?php echo ucwords(strtolower($dataHalDepan["cityname"]))." - ".$dataHalDepan["countryname"];?></td></tr>
							<tr><td>Price</td><td>:</td><td><?php echo $dataHalDepan["symbol"]; ?> <?php echo nl2br(number_format($dataHalDepan["advprice"],0,",","."));?></td></tr>											
							</table>
							</td>
						</tr>
						<?php 
						$qfield="SELECT f.fieldname, fa.* FROM fields f, field_advdetail fa WHERE fa.idfield=f.idfield AND fa.idadv='$dataHalDepan[idadv]'";
						$resfield=mysql_query($qfield);
						if(mysql_num_rows($resfield)>0)
						{?>
						<tr>
							<td style="line-height:2em;" colspan="2">
							<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-top:1em;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<?php
							while($rowfield=mysql_fetch_array($resfield))
							{							
							echo '<tr><td width="35%">'.ucwords($rowfield['fieldname']).'</td><td width="5%">:</td><td width="65%">'.ucwords($rowfield['value']).'</td></tr>
								 ';
							}
							?>
							</table>
							</td>
						</tr>
						<?php 
						} ?>
					</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" height="30" class="styleabu">&nbsp;CONDITION</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
				</tr>
				<tr>
					<td background="images/titik.gif"></td>
				</tr>
				<tr>
					<td style="line-height:2em;" colspan="2" >
						<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-top:1em;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<tr>
								<td><?php echo makeClickableLinks(nl2br($dataHalDepan["advcondition"]));?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" height="30" class="styleabu">&nbsp;DESCRIPTION</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;" class=""></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
				$flatken = str_replace("&nbsp;"," ",$dataHalDepan["advdesc"]);
				?>
				<tr>
					<td colspan="2">
						<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<tr><td><?php echo makeClickableLinks($flatken);?></td></tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" height="30" class="styleabu">&nbsp;COMMENTS</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;" class=""></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php if(isset($_SESSION['rorimember'])){ ?>
				<tr>
					<td colspan="2">
					<table width="95%" align="center" style="margin-top:1em;" border="0" class="web_border" background="images/container.png" >
						<tr valign="top">
							<td width="70" rowspan="2">
								<?php
								$filename2 = 'modulee/fotomember/'.$_SESSION["rorimember"].'.jpg';
								if (file_exists($filename2)) {
								echo '<a href="profile?idm='.$_SESSION["rorimember"].'"><img src='.$filename2.' width="68"  height="68" class="web_detprod" style="float:center;"></a>';
								}else{
								echo '<a href="profile?idm='.$_SESSION["rorimember"].'"><img src="modulee/fotomember/default.jpg" width="68" height="68" class="web_detprod" style="float:center;"></a>';
								}
								?>
							</td>
							<td>
								<p class="styleabu11" style="margin-top:10px;">&nbsp;<?php echo $sqlR['membername'];?></p>
							</td>
						</tr>
						<tr valign="bottom">
							<td align="left">
								<form name="form2">
								<textarea name="isikomen" id="isikomen" cols="80" rows="3" placeholder="type your comment here"></textarea><a href="javascript:sendcomment();" class="tombol" style="margin-top:-36px;margin-left:440px;float:left;">Send</a>
								</form>
							</td>		
						</tr>						
						<tr>
							<td>&nbsp;</td>		
							<td>&nbsp;</td>
						</tr>						
						</table>
					</td>
				</tr>
				<?php } else {?>
				<tr>
					<td colspan="2" class="styleloro">
					<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-top:1em;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<tr><td>Please login to leave a comment</td></tr>
						</table>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="95%" align="center" border="0" id="commentshow" name="commentshow" class="web_border" background="images/container.png" >
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="95%" align="center" border="0" id="nextprev" name="nextprev" class="web_border" background="images/container.png" >
						<tr>
							<td width="35%">&nbsp;</td>
							<td width="10%" align="right">&nbsp;<div id="shownext"><a href="javascript:next();" class="tombol">More</a></div></td>
							<td width="10%" align="left">&nbsp;<div id="showprev"><a href="javascript:prev();" class="tombol">Less</a></div></td>
							<td width="">&nbsp;</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
				if(isset($_SESSION['rorimember']))
				{
				?>				
				<tr>
					<td align="left" height="30"  colspan="2" class="styleabu">&nbsp;SEND MESSAGE TO SELLER</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action="" method="POST" name="fsendmsg" id="fsendmsg">
						<table width="90%" align="left" style="margin-left:2em;margin-top:1em;">
						<tr>
							<td colspan="2">
							<p class="styleloro">Send message to : <?php echo $dataHalDepan["membername"]; ?></p>
							<p class="styleabang" id="pesane">&nbsp;</p>
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="isipesan" id="isipesan" cols="70" rows="7" placeholder="type your message here"></textarea>
							</td>
							<td align="left" width="30%" valign="bottom">
								<input type="hidden" name="idsender" id="idsender" value="<?php echo $_SESSION['rorimember']; ?>">
								<input type="hidden" name="idreceiver" id="idreceiver" value="<?php echo $dataHalDepan['idmember'] ?>">
								<input type="button" name="sendmssg" id="sendmssg" value="Send" class="tombol" style="float:left;height:40px;margin-left:-180px;" onclick="sendmessage();"> 
							</td>
						</tr>						
						</table>
						</form>
					</td>
				</tr>				
				<?php 
				}?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" height="30" class="styleabu">&nbsp;SELLER'S OTHER ADVERTISEMENT</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						// query for the latest product
						$qadv="SELECT * FROM advertisement WHERE idmember='$dataHalDepan[idmember]' AND active=1 AND idadv!='$dataHalDepan[idadv]' ORDER BY inputdate DESC limit 8";
						$resadv=mysql_query($qadv);
						$i=0;
						if(mysql_num_rows($resadv)==0)
						{
						echo '						  
						<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-top:1em;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<tr><td>There is no product to display</td></tr>
						</table>';
						} 
						else
						{
						echo '
						<table border="0" width="95%" align="center"  cellspacing="20" style="color:#424242;margin-top:1em;margin-left:1.5em;">
						<tr>';
						
						while($rowadv=mysql_fetch_array($resadv))
						{
							if (($i % 4)==0){echo "</tr><tr>";}
							echo '
							 <td width="25%">
							 <table border="2" align="center" BORDERCOLOR="silver" height="180">
							 <tr>
								<td align="center" width="150"><a href="detailads?ide='.$rowadv['idadv'].'">'.ucwords(strtolower(substr($rowadv['advtitle'], 0, 30))).'</a></td>
							 </tr>
							 <tr>
								<td align="center">';
								$gambar="img_adv/".$rowadv['idadv']."_1.jpg";
								$namahal=ucwords($dataHalDepan["advtitle"]);
								$namahal=str_replace(" ","_",$namahal);
								if(file_exists($gambar))
								echo '				
									<a href="detailads?n='.$namahal.'&ide='.$rowadv['idadv'].'">
									<img src="'.$gambar.'" width="120" height="90"></a>';
								else echo '
									<a href="detailads?n='.$namahal.'&ide='.$rowadv['idadv'].'">
									<img src="images/noimage.jpg" width="120" height="90"></a>';	
							echo '	
								</td>
							 </tr>
							 <tr>
								<td style="font-size:x-small;" align="right">viewed : '.$rowadv['view'].' times</td>
							 </tr>
							</table>
							</td>
							';
							$i++;
						  }
						  echo '
						  </tr>
						</table>';
						}
						?>	 					
					</td>
				</tr>
								<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" height="30" class="styleabu">&nbsp;SIMILIAR ADS FROM OTHER SELLER</td>
				</tr>
				<tr>			
					<td align="left" colspan="2"><hr color="silver" style="width:98%;"></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						// query for the latest product
						$qadv="SELECT * FROM advertisement a, advcategory c WHERE a.idadvcategory=c.idadvcategory AND a.idadvcategory='$dataHalDepan[idadvcategory]' AND a.active=1 AND a.idadv!='$dataHalDepan[idadv]' AND a.idmember!='$dataHalDepan[idmember]' ORDER BY inputdate DESC limit 4";
						$resadv=mysql_query($qadv);
						$i=0;
						if(mysql_num_rows($resadv)==0)
						{
						echo '						  
						<table width="95%" class="web_border" background="images/container.png" style="color:#424242;margin-top:5px;margin-left:1.5em;" cellpadding="2" cellspacing="2">
							<tr><td>There is no product to display</td></tr>
						</table>';
						} 
						else
						{
						echo '
						<table border="0" width="95%" align="center"  cellspacing="20" style="color:#424242;margin-left:1.5em;">
						<tr>';
						
						while($rowadv=mysql_fetch_array($resadv))
						{
							if (($i % 4)==0){echo "</tr><tr>";}
							echo '
							 <td width="25%">
							 <table border="2" align="center" BORDERCOLOR="silver" height="180">
							 <tr>
								<td align="center" width="150"><a href="detailads?ide='.$rowadv['idadv'].'">'.ucwords(strtolower(substr($rowadv['advtitle'], 0, 30))).'</a></td>
							 </tr>
							 <tr>
								<td align="center">';
								$gambar="img_adv/".$rowadv['idadv']."_1.jpg";
								$namahal=ucwords($dataHalDepan["advtitle"]);
								$namahal=str_replace(" ","_",$namahal);
								if(file_exists($gambar))
								echo '				
									<a href="detailads?n='.$namahal.'&ide='.$rowadv['idadv'].'">
									<img src="'.$gambar.'" width="120" height="90"></a>';
								else echo '
									<a href="detailads?n='.$namahal.'&ide='.$rowadv['idadv'].'">
									<img src="images/noimage.jpg" width="120" height="90"></a>';	
							echo '	
								</td>
							 </tr>
							 <tr>
								<td style="font-size:x-small;" align="right">viewed : '.$rowadv['view'].' times</td>
							 </tr>
							</table>
							</td>
							';
							$i++;
						  }
						  echo '
						  </tr>
						</table>';
						}
						?>	 					
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>	
		</td>	
	</tr>	
</table>
<?php } ?>
	</td>
</tr>
</table>
</div>
</div>
<br>
<div class="stylesiji" style="float:left;margin-bottom:10px;margin-left:20px;width:1000px;">
	<?php 
		include("modulee/advbottomcategory.php");
	?>
</div>

<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li, div.navigation a.pageLink').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     10000,
					numThumbs:                 10,
					preloadAhead:              10,
					enableTopPager:            false,
					enableBottomPager:         false,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             true,
					autoStart: 				   false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);

						// Update the photo index display
						this.$captionContainer.find('div.photo-index')
							.html('Photo '+ (nextIndex+1) +' of '+ this.data.length);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						var prevPageLink = this.find('a.prev').css('visibility', 'hidden');
						var nextPageLink = this.find('a.next').css('visibility', 'hidden');
						
						// Show appropriate next / prev page links
						if (this.displayedPage > 0)
							prevPageLink.css('visibility', 'visible');

						var lastPage = this.getNumPages() - 1;
						if (this.displayedPage < lastPage)
							nextPageLink.css('visibility', 'visible');

						this.fadeTo('fast', 1.0);
					}
				});

				/**************** Event handlers for custom next / prev page links **********************/

				gallery.find('a.prev').click(function(e) {
					gallery.previousPage();
					e.preventDefault();
				});

				gallery.find('a.next').click(function(e) {
					gallery.nextPage();
					e.preventDefault();
				});

				/****************************************************************************************/

				/**** Functions to support integration of galleriffic with the jquery.history plugin ****/

				// PageLoad function
				// This function is called when:
				// 1. after calling $.historyInit();
				// 2. after calling $.historyLoad();
				// 3. after pushing "Go Back" button of a browser
				function pageload(hash) {
					// alert("pageload: " + hash);
					// hash doesn't contain the first # character.
					if(hash) {
						$.galleriffic.gotoImage(hash);
					} else {
						gallery.gotoIndex(0);
					}
				}

				// Initialize history plugin.
				// The callback is called at once by present location.hash. 
				$.historyInit(pageload, "advanced.html");

				// set onlick event for buttons using the jQuery 1.3 live method
				$("a[rel='history']").live('click', function(e) {
					if (e.button != 0) return true;

					var hash = this.href;
					hash = hash.replace(/^.*#/, '');

					// moves to a new page. 
					// pageload is called at once. 
					// hash don't contain "#", "?"
					$.historyLoad(hash);

					return false;
				});

				/****************************************************************************************/
			});
		</script>