<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php 
    
    if(isset($_POST['delete'])){
        $id = $_POST['pro_id'];


        $delete = $conn->prepare("DELETE FROM cart WHERE pro_id='$id'");
        $delete->execute();
    }


?>



<?php require "../includes/footer.php"; ?>