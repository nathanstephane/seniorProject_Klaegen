
<!-- SESSION TRACKER -->
<?php
session_start();
error_reporting(0);

include("includes/connect.php");

if(strlen($_SESSION['staffLogin'])==0){
    header('location:00stafflogin.php');
}
else{  
    date_default_timezone_set('Asia/Bangkok');
    $currentTime=date('d-m-Y:i:s A', time());
     



if(isset($_POST['submit'])){

    $imageFile=$_FILES["picture"]["name"];

    /**Extension file */
    $extension = substr($imageFile,strlen($imageFile)-4,strlen($imageFile));

    $allowedExtensions = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowedExtensions))
{
    echo "<script>alert('Invalied file format. You can only upload a jpg; jpeg; png or gif format. Try again')</script>";
}
else
{
    $imageNewFile=md5($imageFile).$extension;
    move_uploaded_file($_FILES["picture"]["tmp_name"],"../klaegenStaff/userimages/".$imageNewFile);

    //inserting file in db
    $query=mysqli_query($con,"update staffusers set image='$imageNewFile' where username='".$_SESSION['staffLogin']."'");

    if($query)
    {
        $feedback="Your profile picture has been successfully updated";

    }
    else
    {
        $errorFeedback="There was an error updating your profile picture";
    }
}

}


?>




<!doctype html>
<html lang="en">

<head>
<title>Klaegen | Page Blank</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/vivify.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/site.min.css">

</head>
<body class="theme-cyan font-montserrat">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

    <!-- Theme Setting -->
<?php include("htmlPagesIncludes/themeSetting.php"); ?>

    <!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">
    <!-- Top Navbar -->
    <?php include("htmlPagesIncludes/topnavbar.php"); ?>
    
    <!-- Search bar -->
    <?php include("htmlPagesIncludes/searchbar.php");?>
    
    <!-- Mega Menu -->
    <?php include("htmlPagesIncludes/megaMenu.php");?>

    <!-- Message Icon -->
    <?php include("htmlPagesIncludes/messageIcon.php");?>

    <!-- Sidebar Panel -->
    <?php include("htmlPagesIncludes/sidebarPanel.php"); ?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <h2>User Dashboard</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Oculux</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Stater Page</li>
                            </ol>
                        </nav>
                    </div>            
                    <div class="col-md-6 col-sm-12 text-right hidden-xs">
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-round" title="">Add New</a>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card planned_task">
                        <div class="header">
                            <h2>Stater Page</h2>
                            <ul class="header-dropdown dropdown">                                
                                <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <h4>User Dashboard</h4>

                        </div>
                        <?php if($feedback)
                      {?>
                      <div class="alert alert-success alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Noice!</b> <?php echo htmlentities($feedback);?></div>

                      <?php if($errorFeedback)
                      {?>
                      <div class="alert alert-danger alert-dismissable">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Looks like something went wrong...</b> </b> <?php echo htmlentities($errorFeedback);?></div>
                      <?php }?>
                      <?php }?>
                        <div class="change_user_photo">

                        <?php $requete=mysqli_query($con,"select * from staffusers where username='".$_SESSION['staffLogin']."'");
                        
                        while($retour=mysqli_fetch_array($requete)){
                        ?>
        <div class="body">
                            <form action="" enctype="multipart/form-data" method="POST" name="profile" >
                        
                        <div class="form-group">
                            <label for="lafoto" class="m-l-60"><?php echo htmlentities($retour['fullName'])?>'s actual picture</label>

                            <div class="col-sm-4 ">
                                <?php $picture=$retour['image'];
                                if($picture==""): ?>
                                <img src="../klaegenStaff/userimages/morph.gif" width="250" height="250" style="object-fit: cover;" class="rounded">
                                <?php else: ?>
                                    <img src="../klaegenStaff/userimages/<?php echo htmlentities($picture);?>" alt=""  class="rounded-circle" width="250" height="250" style="object-fit: cover;">
                                <?php endif;?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="letitre" class="col-sm-4">Upload Picture</label>
                            <div class="col-sm-4">
                                <input type="file" name="picture" required class="form-control" style="border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;">
                            </div>
                        </div>
                        <?php }?>

                        <div class="col-sm-4">
                        <button type="submit" name="submit" class="btn btn-warning btn-block" >Change Picture</button>
                        </div>
                        </form>
                        
        </div>
                        </div>
                                
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>    
<script src="assets/bundles/vendorscripts.bundle.js"></script>
<script src="assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>
<?php } ?>