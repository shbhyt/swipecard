<?php
//$name = isset($_POST['name'])? $_POST['name'] : '';
//$gender = isset($_POST['gender'])? $_POST['gender'] : '';

//$filename = time().substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'],'.'));
$filename=$_FILES['file']['name'];
//$filename=file_get_contents($filename);
//$filename=explode("\r\n",$filename);
$response = array();

if(move_uploaded_file($_FILES['file']['tmp_name'], $filename)){
    $response['isSuccess'] = true;
    // $response['name'] = $name;
    // $response['gender'] = $gender;
    $filename=file_get_contents($filename);
    $filename=explode("\r\n",$filename);
    $response['file'] = $filename;
}else{
    $response['isSuccess'] = false;
}

echo json_encode($response);

