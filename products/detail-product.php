<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


    <?php

    if(isset($_POST['submit'])){
        $pro_id = $_POST['pro_id'];
        $pro_title = $_POST['pro_title'];
        $pro_image = $_POST['pro_image'];
        $pro_price = $_POST['pro_price'];
        $pro_qty = $_POST['pro_qty'];
        $pro_subtotal = $_POST['pro_subtotal'];
        $user_id = $_POST['user_id'];

        $insert = $conn->prepare("INSERT INTO cart (pro_id, pro_title, pro_image, pro_price, pro_qty, pro_subtotal, user_id)
        VALUES(:pro_id, :pro_title, :pro_image, :pro_price, :pro_qty, :pro_subtotal, :user_id)");

        $insert->execute([
            ':pro_id'=>$pro_id,
            ':pro_title'=>$pro_title,
            ':pro_image'=>$pro_image,
            ':pro_price'=>$pro_price,
            ':pro_qty'=>$pro_qty,
            ':pro_subtotal'=>$pro_subtotal,
            ':user_id'=>$user_id,
            
        ]);
    }

    if(isset($_GET['id'])){
        //select the the details of a product by its id
        $id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE status = 1 AND id = '$id'";

        $select = $conn->query($sql);
        $select->execute();

        $selectAll = $select->fetch(PDO::FETCH_OBJ);

        //select related products

        $sql2 = "SELECT * FROM products WHERE status = 1 AND category_id = '$selectAll->category_id'
        AND id != '$id'";

        $select2 = $conn->query($sql2);
        $select2->execute();

        $relatedProduct = $select2->fetchAll(PDO::FETCH_OBJ);

       // var_dump($relatedProduct);


       //validating cart products


    if(isset($_SESSION['user_id'])){
        $validate = $conn->query("SELECT * FROM cart WHERE pro_id='$id' AND user_id='$_SESSION[user_id]'");
       $validate->execute();

    }
       

    }else{

    }



    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                    <?php echo $selectAll->title; ?>
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="slider-zoom">
                            <a href="<?php echo APPURL;?>/assets/img/<?php echo $selectAll->image; ?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                                <img alt="Detail Zoom thumbs image" src="<?php echo APPURL; ?>/assets/img/<?php echo $selectAll->image; ?>" style="width: 100%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Overview</strong><br>
                            <?php echo $selectAll->description; ?>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/Pack)<br>
                                    <span class="price">$<?php echo $selectAll->price; ?></span>
                                    <!-- <span class="old-price">Rp 150.000</span> -->
                                </p>
                            </div>
                           
                        </div>
                        <p class="mb-1">
                            <strong>Quantity</strong>
                        </p>
                        <form method="POST" id="basket-data">
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_qty" value="<?php echo $selectAll->quantity; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_title" value="<?php echo $selectAll->title; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_image" value="<?php echo $selectAll->image; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="pro_price form-control" type="hidden" name="pro_price" value="<?php echo $selectAll->price;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="hidden" name="pro_id" value="<?php echo $selectAll->id; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="pro_qty form-control" type="number" name="pro_qty" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $selectAll->quantity; ?>">
                            </div>
                            <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack (1000 gram)</span></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="subtotal_price form-control" type="text" name="pro_subtotal" value="<?php echo $selectAll->price * $selectAll->quantity; ?>">
                            </div>
                        </div>
                        <?php if(isset($_SESSION['username']))  : ?>
                            <?php if($validate->rowCount() > 0) :?>
                            <button type = "submit" name="submit" class="btn-insert mt-3 btn btn-primary btn-lg" disabled>
                                <i class="fa fa-shopping-basket"></i> Added to Cart
                            </button>
                            <?php else: ?>
                            <button type = "submit" name="submit" class="btn-insert mt-3 btn btn-primary btn-lg">
                                <i class="fa fa-shopping-basket"></i> Add to Cart
                            </button>
                            <?php endif; ?>
                            <?php else : ?>
                                <div class = "mt-5 alert alert-success bg-success text-white text-center">
                                                You have to login or register to buy the product

                                        </div>
                        <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section id="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Related Products</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($relatedProduct as $related) : ?>
                            <div class="item">
                                <div class="card card-product">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $related->exp_date; ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="../assets/img/<?php echo $related->image; ?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="<?php echo APPURL;?>/detail-product.php?id=<?php $related->id; ?>"><?php echo $related->title; ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $related->price; ?></span>
                                        </div>
                                        <a href="<?php echo APPURL;?>/detail-product.php?id=<?php $related->id; ?>" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php require "../includes/footer.php"; ?>
    <script>
        $(document).ready(function() {
            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });

            (".btn-insert").on("click", function(e){
            e.preventDefault();

            var basket_data = $("#basket-data").serialize()+'&submit=submit';

            $.ajax({
                url: "detail-product.php?id=<?php echo $id; ?>",
                method: "POST",
                data: basket_data,


                success: function(){
                    alert("Hello! I am an alert box!");
                    $(".btn-insert").html("<i class='fa fa-shopping-basket'></i> Added to Cart").prop("disabled", true);
                    withRef();
                }

            });
           

        });

        function withRef(){
            $("body").load("detail-product.php?id=<?php echo $id; ?>");
        }


        $(".pro_qty").mouseup(function () {
                  
                 

                  var $el = $(this).closest('form');
  
  
                    var pro_qty = $el.find(".pro_qty").val();
                    var pro_price = $el.find(".pro_price").val();
                      
                    var subtotal = pro_qty * pro_price;
                    alert(subtotal);
                    $el.find(".subtotal_price").val("");        
  
                    $el.find(".subtotal_price").val(subtotal);
              });


        })


       

    </script>

