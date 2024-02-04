<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base64_2_image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container col-md-12 mt-5">
        <form action="./index.php" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">File Name</span>
            <input type="text" class="form-control" name="file_name" placeholder="File Name" aria-label="File Name" aria-describedby="basic-addon1">
        </div>

        <div class="input-group">
            <span class="input-group-text">Base 64</span>
            <textarea class="form-control" name="base_64" aria-label="With textarea"></textarea>
        </div>
        <div class="input-group mt-3">
            <button type="submit" name="submit" class="btn btn-success">Create Image</button>
        </div>
        </form>
    </div>
    <?php if(isset($img_url)){?> 
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"></h5>
                <img src="<?php echo $img_url['src'];?>" class="img-fluid" alt="Base 64 Image">
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo explode('/',$img_url['src'])[1];?></h5>
                <p class="card-text">Width x Height = <?php echo $img_url['image_info'][3];?></p>
                <p class="card-text">Type: <?php echo $img_url['image_info']['mime'];?></p>
            </div>
            </div>
        </div>
    </div>
    <?php } ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
<?php

if(isset($_POST['submit'])){
$base_64 = $_POST['base_64'];
$file_info['path']="./";
$file_info['file_name']=$_POST['file_name'];
$img_url = convert_base64_to_image($base_64,$file_info);

}
function convert_base64_to_image($base64,$file_info){
    
    $data = explode(',', $base64)[1];
    $image = base64_decode($data);  
    $image_info = getimagesizefromstring($image);

    if ($image_info !== false) {
        $extension = explode('/',$image_info['mime'])[1];
        $file = $file_info['file_name']."_".date("YmdHis").".".$extension;
        $file_info['path'] = $file_info['path'].$file;
    }

    file_put_contents($file_info['path'], $image);
    $meta_data = array('src'=>$file_info['path'],'image_info'=>$image_info);
    return $meta_data;
}
?>
