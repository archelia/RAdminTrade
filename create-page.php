<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{
	// begin validating
	$error= "";
	if ($_POST["pagename"]==""){$error.="Please fill in the page name !\\n";}
	if (!empty($_FILES['gambar']['name']))
	{	
	    // validasi file gambar
		$allowed_filetypes = array('.jpg','.jpeg','.gif','.bmp','.png');
		$max_filesize = 50242880; //max 5 mega gede'e
		$filename = $_FILES['gambar']['name'];
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); 
		
		//cek filetype
		$ok=1;
		if ($_FILES['gambar']['tmp_name']==''){$ok=0;}
		else
		{
			if(!in_array($ext,$allowed_filetypes))
			{
			   $error.='This type of file can\'t be uploaded !';
			   $ok=0;
			}
			else if(filesize($_FILES['gambar']['tmp_name']) > $max_filesize)
			{
			   $error.='This picture size is too big. Maximum allowed size are 5 MB.';
			   $ok=0;
			}
			else $ok=1;
		}
	}		
	if ($error=="")
	{		
		$newid=0;
		// generate new iduser
		$sqlr = "SELECT max(idpage) as newid from pages";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$newid=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$newid=$rowr['newid']+1;
		$newid=$newid."_1";
		}
		
		// upload gambar bila gambar diisi
		if (!empty($_FILES['gambar']['name']))
		{		
			if ($ok=1)
			{
				// menentukan nama file
				$picname=$newid;			  
				//tentukan path untuk simpan gambar
				$path='pagepics/';
				 
				if(move_uploaded_file($_FILES['gambar']['tmp_name'],$path.$picname.".jpg"))
				{
				 $pesan="and Upload success.";	 
				}
				else 
				{
				$pesan="but Upload fail.";
				}
			}
		} 		
		if ($_POST['pagelink']!=""){$link=$_POST['pagelink'];}else{$link="../page.php?id=".$newid;}
		$content=trim($_POST['pagecontent']);
		$datacontent= str_replace("'",'"',$content);
		// saving data		
		$query="INSERT INTO pages ";
		echo $query.="VALUES ('$newid','$_POST[pagename]','$_POST[pageheadline]','$datacontent','$_POST[pagenb]','$link',1)";
		$result=mysql_query($query);
		$pesan="Page data has been saved ".$pesan;
		echo "<script>alert(\"$pesan\");window.location='./create-page.php';</script>";
	}
	else
	{
		echo '<script type=\'text/javascript\'>var msg; msg='.$error.';</script>';		
		echo "<script>alert(\"$error\")</script>";		
	}
}
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript" src="library/ckeditor.js"></script>
<script src="library/sample.js" type="text/javascript"></script>
<link href="library/sample.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}

</script>
<form action="create-page.php" method="POST" enctype="multipart/form-data">
<table width="60%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Page</h4></td>
<tr>
<tr>
	<td align="right">Name</td>
	<td align="center" >:</td>
	<td align="left"><input type="text" name="pagename" id="pagename" size="65" maxlength='150'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Headline</td>
	<td align="center">:</td>
	<td align="left"><textarea rows="8" cols="50" name="pageheadline" id="pageheadline"></textarea></td>
</tr>
<tr>
	<td align="right" width="25%">Content</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="70%">
	<div style="width:430px;">
	<textarea rows="8" cols="80" name="pagecontent" id="pagecontent" style="width:50px;"></textarea>
	<script type="text/javascript">
			//<![CDATA[
				CKEDITOR.replace('pagecontent',
				{
						/*
						 * Style sheet for the contents
						 */
						contentsCss : 'body {color:#000; background-color#:FFF;}',

						/*
						 * Simple HTML5 doctype
						 */
						docType : '<!DOCTYPE HTML>',

						/*
						 * Core styles.
						 */
						coreStyles_bold	: { element : 'b' },
						coreStyles_italic	: { element : 'i' },
						coreStyles_underline	: { element : 'u'},
						coreStyles_strike	: { element : 'strike' },

						/*
						 * Font face
						 */
						// Define the way font elements will be applied to the document. The "font"
						// element will be used.
						font_style :
						{
								element		: 'font',
								attributes		: { 'face' : '#(family)' }
						},

						/*
						 * Font sizes.
						 */
						fontSize_sizes : 'xx-small/1;x-small/2;small/3;medium/4;large/5;x-large/6;xx-large/7',
						fontSize_style :
							{
								element		: 'font',
								attributes	: { 'size' : '#(size)' }
							} ,

						/*
						 * Font colors.
						 */
						colorButton_enableMore : true,

						colorButton_foreStyle :
							{
								element : 'font',
								attributes : { 'color' : '#(color)' },
								overrides	: [ { element : 'span', attributes : { 'class' : /^FontColor(?:1|2|3)$/ } } ]
							},

						colorButton_backStyle :
							{
								element : 'font',
								styles	: { 'background-color' : '#(color)' }
							},

						/*
						 * Styles combo.
						 */
						stylesSet :
								[
									{ name : 'Computer Code', element : 'code' },
									{ name : 'Keyboard Phrase', element : 'kbd' },
									{ name : 'Sample Text', element : 'samp' },
									{ name : 'Variable', element : 'var' },

									{ name : 'Deleted Text', element : 'del' },
									{ name : 'Inserted Text', element : 'ins' },

									{ name : 'Cited Work', element : 'cite' },
									{ name : 'Inline Quotation', element : 'q' }
								],

						on : { 'instanceReady' : configureHtmlOutput }
				});

				/*
				 * Adjust the behavior of the dataProcessor to avoid styles
				 * and make it look like FCKeditor HTML output.
				 */
				function configureHtmlOutput( ev )
				{
					var editor = ev.editor,
						dataProcessor = editor.dataProcessor,
						htmlFilter = dataProcessor && dataProcessor.htmlFilter;

					// Out self closing tags the HTML4 way, like <br>.
					dataProcessor.writer.selfClosingEnd = '>';

					// Make output formatting behave similar to FCKeditor
					var dtd = CKEDITOR.dtd;
					for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) )
					{
						dataProcessor.writer.setRules( e,
							{
								indent : true,
								breakBeforeOpen : true,
								breakAfterOpen : false,
								breakBeforeClose : !dtd[ e ][ '#' ],
								breakAfterClose : true
							});
					}

					// Output properties as attributes, not styles.
					htmlFilter.addRules(
						{
							elements :
							{
								$ : function( element )
								{
									// Output dimensions of images as width and height
									if ( element.name == 'img' )
									{
										var style = element.attributes.style;

										if ( style )
										{
											// Get the width from the style.
											var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec( style ),
												width = match && match[1];

											// Get the height from the style.
											match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec( style );
											var height = match && match[1];

											if ( width )
											{
												element.attributes.style = element.attributes.style.replace( /(?:^|\s)width\s*:\s*(\d+)px;?/i , '' );
												element.attributes.width = width;
												//element.attributes.width = 150px;
											}

											if ( height )
											{
												element.attributes.style = element.attributes.style.replace( /(?:^|\s)height\s*:\s*(\d+)px;?/i , '' );
												element.attributes.height = height;
											}
										}
									}

									// Output alignment of paragraphs using align
									if ( element.name == 'p' )
									{
										style = element.attributes.style;

										if ( style )
										{
											// Get the align from the style.
											match = /(?:^|\s)text-align\s*:\s*(\w*);/i.exec( style );
											var align = match && match[1];

											if ( align )
											{
												element.attributes.style = element.attributes.style.replace( /(?:^|\s)text-align\s*:\s*(\w*);?/i , '' );
												element.attributes.align = align;
											}
										}
									}

									if ( !element.attributes.style )
										delete element.attributes.style;

									return element;
								}
							},

							attributes :
								{
									style : function( value, element )
									{
										// Return #RGB for background and border colors
										return convertRGBToHex( value );
									}
								}
						} );
				}

				/**
				* Convert a CSS rgb(R, G, B) color back to #RRGGBB format.
				* @param Css style string (can include more than one color
				* @return Converted css style.
				*/
				function convertRGBToHex( cssStyle )
				{
					return cssStyle.replace( /(?:rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\))/gi, function( match, red, green, blue )
						{
							red = parseInt( red, 10 ).toString( 16 );
							green = parseInt( green, 10 ).toString( 16 );
							blue = parseInt( blue, 10 ).toString( 16 );
							var color = [red, green, blue] ;

							// Add padding zeros if the hex value is less than 0x10.
							for ( var i = 0 ; i < color.length ; i++ )
								color[i] = String( '0' + color[i] ).slice( -2 ) ;

							return '#' + color.join( '' ) ;
						 });
				}
							//]]>
							
		</script>
	</td>
	<div>
	</tr>
<tr>
	<td align="right">NB</td>
	<td align="center">:</td>
	<td align="left"><textarea rows="8" cols="50" name="pagenb" id="pagenb"></textarea>	  
	</td>
</tr>
<tr>
	<td align="right">Link</td>
	<td align="center">:</td>
	<td align="left"><input type="text" name="pagelink" id="pagelink" size="65" maxlength='150'><br><label class="kecilmiring">Leave it empty if you want to use auto generate link</label></td>
</tr>
<tr>
	<td align="right">Picture</td>
	<td align="center">:</td>
	<td align="left"><input type="file" name="gambar" id="gambar">	  
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">	
		<input type="reset" name="reset" id="Reset">	  
		<input type="submit" name="submit" value="Save"  style="width:70px">		
	</td>
</tr>
</table>
</form>
