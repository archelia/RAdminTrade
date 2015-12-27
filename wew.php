<?php
for ($i = 1; $i ; $i++) 
{
	
    echo $i;
}

/*
SELECT * , DATE_ADD( startdate, INTERVAL airtime
DAY ) AS dayend
FROM purchasepromo

SELECT * FROM (
SELECT * 
FROM (
SELECT a.* , DATE_ADD( p.startdate, INTERVAL p.airtime
DAY ) AS enddate
FROM advertisement a, purchasepromo p
WHERE a.idadv = p.idadv
)q
)z
WHERE enddate < NOW( )
UNION
SELECT a.*, DATE_ADD( now(), INTERVAL 30 DAY ) AS enddate
FROM advertisement a
WHERE a.idadv NOT IN z


SELECT * FROM (
	SELECT a.* , DATE_ADD( p.startdate, INTERVAL p.airtime
	DAY ) AS enddate
	FROM advertisement a, purchasepromo p
	WHERE a.idadv = p.idadv
) q
WHERE enddate < NOW()
UNION
SELECT a.*, DATE_ADD( now(), INTERVAL 30 DAY ) AS enddate
FROM advertisement a
WHERE a.idadv NOT IN
(SELECT * 
FROM (
SELECT a.* , DATE_ADD( p.startdate, INTERVAL p.airtime
DAY ) AS enddate
FROM advertisement a, purchasepromo p
WHERE a.idadv = p.idadv
)a
WHERE enddate < NOW())

*/				
		$sql1="left join currency b on a.idcurr=b.idcurr ";
			$sql1.="left join city c on a.advidcity=c.idcity ";
			$sql1.="left join province p on p.idprovince=c.idprovince ";
			$sql1.="left join country d on d.idcountry=c.idcountry ";
			$sql1.="left join advcategory e on a.idadvcategory=e.idadvcategory ";
			$sql1.="WHERE (a.active = 1 or a.active=5) ";
			if($idcat!=""){$sql1.="AND a.idadvcategory=".$idcat." ";}
			
			if($negara!=""){$sql1.="AND d.idcountry=".$negara." ";}		
			if($propinsi!=""){$sql1.="AND p.idprovince=".$propinsi." ";}		
			if($kota!=""){$sql1.="AND c.idcity=".$kota." ";}					
			if($tipeiklan!=""){$sql1.="AND a.advtype='".$tipeiklan."' ";}
			if($kondisi!=""){$sql1.="AND a.status_barang='".$kondisi."' ";}
			if($category!=""){$sql1.="AND a.idadvcategory='".$category."' ";}
			if($katakunci!=""){$sql1.="AND a.advtitle like '%".$katakunci."%' ";}
			
			$sql00="SELECT * FROM (";
			$sql0.="SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname , DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate ";
			$sql0.="from advertisement a ";
			$sql0.="left join purchasepromo pp on a.idadv = pp.idadv ";
			$sql0.=$sql1.") ";
			$sql=$sql00.$sql0."a ";
			$sql.="WHERE enddate < now() ";
			$sql.="UNION ";		
			$sql.="SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname, DATE_ADD( now(), INTERVAL 30 DAY ) AS enddate ";
			$sql.="from advertisement a ";
			$sql.=$sql1;	
			$sql.="AND a.idadv NOT IN (SELECT idadv FROM (".$sql0." g WHERE enddate < now()) ";
		
			if($susunan!="")
			{
				$sql.="ORDER BY ";
				if($susunan=="1"){$sql.="a.inputdate desc ";}
				else if($susunan=="2"){$sql.="a.inputdate asc ";}
				else if($susunan=="3"){$sql.="a.advtitle asc ";}
				else if($susunan=="4"){$sql.="a.advtitle desc ";}
				else if($susunan=="5"){$sql.="symbol asc, advprice asc ";}
				else if($susunan=="6"){$sql.="symbol asc, advprice desc ";}
			}
			else{$sql.="ORDER BY inputdate DESC ";}
			$sql2 = $sql;
			$sql.="LIMIT $posisi, $batas";
			$res=mysql_query($sql);
}
// top listing querry

			$sql0 ="SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname ";
			$sql0.="from advertisement a ";
			$sql1="left join currency b on a.idcurr=b.idcurr ";
			$sql1="left join city c on a.advidcity=c.idcity ";
			$sql1="left join province p on p.idprovince=c.idprovince ";
			$sql1="left join country d on d.idcountry=c.idcountry ";
			$sql1.="left join advcategory e on a.idadvcategory=e.idadvcategory ";
			$sql1.="WHERE (a.active = 1 or a.active=5) ";
			if($idcat!=""){$sql1.="AND a.idadvcategory=".$idcat." ";}
			
			if($negara!=""){$sql1.="AND d.idcountry=".$negara." ";}		
			if($propinsi!=""){$sql1.="AND p.idprovince=".$propinsi." ";}		
			if($kota!=""){$sql1.="AND c.idcity=".$kota." ";}					
			if($tipeiklan!=""){$sql1.="AND a.advtype='".$tipeiklan."' ";}
			if($kondisi!=""){$sql1.="AND a.status_barang='".$kondisi."' ";}
			if($category!=""){$sql1.="AND a.idadvcategory='".$category."' ";}
			if($katakunci!=""){$sql1.="AND a.advtitle like '%".$katakunci."%' ";}
			
			if($susunan!="")
			{
				$sql.="ORDER BY ";
				if($susunan=="1"){$sql.="a.inputdate desc ";}
				else if($susunan=="2"){$sql.="a.inputdate asc ";}
				else if($susunan=="3"){$sql.="a.advtitle asc ";}
				else if($susunan=="4"){$sql.="a.advtitle desc ";}
				else if($susunan=="5"){$sql.="symbol asc, advprice asc ";}
				else if($susunan=="6"){$sql.="symbol asc, advprice desc ";}
			}
			else{$sql.="ORDER BY inputdate DESC ";}
			$sql2 = $sql;
			$sql.="LIMIT $posisi, $batas";
			$res=mysql_query($sql);
			
			
// cek promo 1 1
$sqlcek1="SELECT * FROM purchasepromo WHERE idadv='$ide' AND DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate WHERE idpromo='102'";
$rescek1=mysql_query($sqlcek1);
$rowcek1=mysql_fetch_array($rescek1);
if($rowcek1){echo "";}

$sqlcek2="SELECT * FROM purchasepromo WHERE idadv='$ide' AND DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate WHERE idpromo='103'";
$rescek2=mysql_query($sqlcek2);
$rowcek2=mysql_fetch_array($rescek2);
if($rowcek1){echo "";}

$sqlcek3="SELECT * FROM purchasepromo WHERE idadv='$ide' AND DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate WHERE idpromo='104'";
$rescek3=mysql_query($sqlcek3);
$rowcek3=mysql_fetch_array($rescek3);
if($rowcek1){echo "";}

// do some function
while($ro1=mysql_fetch_array($r1))
{
	
	$promo1,$promo2,$promo3,$promo4=0;
	$promolink=0;
	echo "<img src='img/sold.png' style='margin-bottom:-465px;position:relative;z-index:99;' width='705' height='537'>";
	// if ada promo dengan id nya maka
	// cek apakah prmonya masih aktif
	// bila iya set css
	// tidak muncul

?>
SELECT * FROM 
	(SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname , DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate 
	from advertisement a inner join purchasepromo pp on a.idadv = pp.idadv inner join currency b on a.idcurr=b.idcurr inner join city c on a.advidcity=c.idcity inner join province p on p.idprovince=c.idprovince inner join country d on d.idcountry=c.idcountry inner join advcategory e on a.idadvcategory=e.idadvcategory WHERE (a.active = 1 or a.active=5) AND a.idadvcategory=9 AND pp.idpromo='101' ) aa WHERE enddate > now() 
UNION 
SELECT * FROM 
	(SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname, DATE_ADD( now(), INTERVAL 30 DAY ) AS enddate from advertisement a inner join currency b on a.idcurr=b.idcurr inner join city c on a.advidcity=c.idcity inner join province p on p.idprovince=c.idprovince inner join country d on d.idcountry=c.idcountry inner join advcategory e on a.idadvcategory=e.idadvcategory WHERE (a.active = 1 or a.active=5) AND a.idadvcategory=9 AND a.idadv NOT IN (SELECT idadv FROM (SELECT a.*, b.symbol, c.cityname, d.countryname, e.categoryname , DATE_ADD( pp.startdate, INTERVAL pp.airtime DAY ) AS enddate from advertisement a inner join purchasepromo pp on a.idadv = pp.idadv inner join currency b on a.idcurr=b.idcurr inner join city c on a.advidcity=c.idcity inner join province p on p.idprovince=c.idprovince inner join country d on d.idcountry=c.idcountry inner join advcategory e on a.idadvcategory=e.idadvcategory WHERE (a.active = 1 or a.active=5) AND a.idadvcategory=9 AND pp.idpromo='101' ) g WHERE enddate > now()) ORDER BY inputdate DESC)cc LIMIT 0, 10

font-size: 12px;
font-family: Arial,Helvetica,sans-serif;
color: #666;

<?php
$var1="muach";
$var2="sayang";
$var3=1;
if($var3>0)
{echo $var1." ".$var2;}
?>


