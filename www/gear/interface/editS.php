<?
if (!defined('PKASASS') || PKASASS!=md5('PKASASS')) { echo 'WTF?'; exit(); }

	if (isset($_POST['title']) && isset($_POST['text']) && !empty($_POST['title']) && !empty($_POST['text'])) {
		file_put_contents("../data/pages/".translit($_POST['title']),$_POST['title']."\r\n".$_POST['text']);
		echo "<script>document.location.href='".$_cfg['www']."/admin/?act=listS'</script>";
		exit();
	}

	$_tmp=explode("\r\n",file_get_contents("../data/pages/".$_GET['page']));
	$_title=$_tmp[0];
	array_shift($_tmp);
	$_text=implode("\r\n",$_tmp);
	$_text=stripslashes($_text);
?>
<FORM METHOD="POST" id="addSForm" enctype="application/x-www-form-urlencoded" ACTION="<?=$_cfg['www'];?>/admin/?act=editS">
<input type="text" name="title" value="<?=$_title;?>">
<input type="hidden" name="time" value="<?=$_GET['page'];?>">
<textarea style="height:200px;" name="text" id="textbox"><?=$_text;?></textarea>
</FORM>

    <script src="<?=$_cfg['www']?>/gear/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?=$_cfg['www']?>/gear/js/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=$_cfg['www']?>/gear/js/ajaxupload.js"></script>
	<script type="text/javascript">/*<![CDATA[*/
	function delF(nameF,id) {
		$.get('<?=$_cfg['www'];?>/gear/interface/delF.php', { name: nameF} ); 
		idElem = document.getElementById(id)
		idElem.parentNode.removeChild(idElem);
	}
	
	$(document).ready(function(){
		new AjaxUpload('uplBtn', {
			action: '<?=$_cfg['www']?>/gear/upload.php',
			name: 'myfile',
			onComplete : function(file, responce){
				//alert(responce);
				var resp = eval('(' + responce+ ')');
				//alert(resp.files.myfile.name);
				var flNObj=document.getElementById('filesList');
				flNObj.innerHTML+='<li id="'+resp.files.myfile.id+'">'+resp.files.myfile.name+' | <span style="cursor:pointer;" onClick="delF(\''+resp.files.myfile.newname+'\',\''+resp.files.myfile.id+'\');">del</span></li>';
				document.getElementById('textbox').value+='<img src="<?=$_cfg['www'];?>/data/files/'+resp.files.myfile.newname+'">';
			}	
		});		
	});/*]]>*/</script>	
	<form action="#" method="post">
		<div>
			<input id="uplBtn" type="file" />
		</div>
		<ol class="files" id="filesList"></ol>
	</form>

<input type="button" value="Ok" onClick="document.getElementById('addSForm').submit();" style="width:563px;">