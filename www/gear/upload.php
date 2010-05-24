<?php

// check MimeType
// create Thumbnail
// create Name

//echo time().".jpg";

if ($_FILES['myfile']['type']=='image/jp2' || $_FILES['myfile']['type']=='image/jpeg' || $_FILES['myfile']['type']=='image/jpeg' || $_FILES['myfile']['type']=='image/jpeg' || $_FILES['myfile']['type']=='image/png') {
	$type=".jpg";
} else {
	$type=strstr($_FILES['myfile']['name'],'.');
}

$name=time();
$_FILES['myfile']['newname']=$name.$type;
$_FILES['myfile']['id']=$name;
move_uploaded_file($_FILES['myfile']['tmp_name'], "../data/files/".$_FILES['myfile']['newname']);
echo json_encode(array('files' => $_FILES,'post' => $_POST));
//echo json_encode($_FILES);