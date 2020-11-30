<?php
require_once('connect.php');
if(!empty($_POST['idNumber'])){
    $idStudent=$_POST['idNumber'];
    $query="SELECT idNumber FROM users WHERE idNumber=?";
    $stmt=$con->prepare($query);
    $stmt->bind_param("i",$idStudent);
    $stmt->execute();

    $result=$stmt->get_result();
    $count=mysqli_num_rows($result);
    if($count>0){
        echo "<span style='color:yellow'> ID Number already exists .</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
       } else{
           
           echo "<span style='color:#dedcdb'> ID Number available :)</span>";
        echo "<script>$('#submit').prop('disabled',false);</script>";
       }        

    

}

?>