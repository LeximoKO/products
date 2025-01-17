<?php 
    require_once("session.php");
    require_once("user_class.php");
    require_once("functions/pagination.php");
    require_once("functions/echo-alert.php");


    define("NAVIGATION", true);
    define("ADMIN_PANEL", true);
    define("MODAL", true);

    $user = new User();

	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] != 1){
		header("location: index.php");
    }

    $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
    if($page <= 0) 
        $page = 1;

    $per_page = 10;
    $start_point = ($page * $per_page) - $per_page;
    $statement = "products ORDER BY prod_id DESC";
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />

    <title>Каталог товаров</title>

    <meta name="description" content="Каталог товаров" />
    <meta name="keywords" content="каталог, товары, online" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" />
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="js/custom-file-input.js"></script>
    <script src="js/sticky-nav.js"></script>
</head>

<body>
    <div class="wrapper">

        <?php
            if($user->isLoggedIn() && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
                require_once('admin-panel.php');
            }
        ?>

        <div class="main-page">
            <header>
                <div class="jumbotron text-center">

                    <?php
                        if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
                        require_once('admin-panel-button.php');
                    }
                    ?>

                    <h1>Каталог товаров</h1>

                </div>
            </header>

            <?php 
            if(!$user->isLoggedIn()){
              require_once('navigations/basic_nav.php');
            }
            else if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
              require_once('navigations/admin_nav.php');
            }
            else 
              require_once('navigations/user_nav.php');
          ?>

            <main>
                <div class="main-content">
                    <div class="container">
                        <h2 class="page-title">Управление товарами</h2>
                        <?php 
                        if(isset($_GET['name_error'])){
                            echoAlert("danger", "Товар с таким названием уже существует!");
                        }
                        else if(isset($_GET['add_result'])){
                            if ($_GET['add_result'] == true) {
                                echoAlert("success", "Новый товар добаавлен!");
                            }
                            else {
                                echoAlert("danger", "Неудалось добавить новый товар!");
                            }
                        }
                        else if(isset($_GET['del_result'])){
                            if($_GET['del_result'] == true){
                                echoAlert("success", "Товар удален!");
                            }
                            else{
                                echoAlert("danger", "Товар не удален!");
                            }

                        }
                        else if(isset($_GET['update_result'])){
                            if($_GET['update_result'] == true){
                                echoAlert("success", "Товар обновлен!");
                            }
                            else{
                                echoAlert("danger", "Товар не обновлен!");
                            }
                        }
                        if(isset($_GET['img_size_error'])){
                            echoAlert("warning", "Внимание! Изображение продукта не было загружено, так как файл слишком большой!");
                        }    
                        
                    ?>

                        <button type="button" class="btn btn-primary add-btn" data-toggle="modal"
                            data-target="#addProductModal">Добавить товар</button>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle" style="width: 10%">ID</th>
                                        <th class="align-middle" style="width: 10%">Изображение</th>
                                        <th class="align-middle" style="width: 20%">Название</th>
                                        <th class="align-middle" style="width: 25%">Описание</th>
                                        <th class="align-middle" style="width: 12.5%">Категория</th>
                                        <th class="align-middle" style="width: 12.5%">Цена</th>
                                        <th class="align-middle" style="width: 5%">Редактировать</th>
                                        <th class="align-middle" style="width: 5%">Отмена</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               
                                try {         
                                   
                                    $result =  $user->runQuery("SELECT * FROM {$statement} LIMIT {$start_point},{$per_page}");                             
                                    $result->execute();  
                                    while($row = $result->fetch(PDO::FETCH_ASSOC)){

                            ?>

                                    <tr>
                                        <td class="text-center align-middle">
                                            <?php echo $row['prod_id']; ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php 
                                                $imgPath = $row['prod_img'];
                                                echo "<img class=\"img-fluid img-thumbnail\" src=\"$imgPath\">"; 
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $row['prod_name']; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php 
                                            $desc =  $row['prod_desc']; 
                                            if (strlen($desc) > 150) {
                                                $descCut = substr($desc, 0, 150);
                                                $endPoint = strrpos($descCut, ' ');
                                                $desc = $endPoint? substr($descCut, 0, $endPoint) : substr($descCut, 0);
                                                $desc .= '...';
                                            }
                                            echo $desc;
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                                $stmt =  $user->runQuery("SELECT cat_name FROM categories WHERE cat_id = :id");
                                                $stmt->bindParam(":id", $row['category_id']);
                                                $stmt->execute();
                                                $cat_row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                echo $cat_row['cat_name']; 
                                             ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $row['prod_price'] . " zł"; ?>
                                        </td>
                                        <td class="text-center align-middle" >
                                        <?php 
                                                $id = $row['prod_id'];
                                                if(isset($_GET['page']) && intval($_GET['page']) != 0){
                                                    echo "<a class=\"admin-panel-table-icon\" href=\"admin_products.php?page=$page&prod_id=$id\">
                                                        <i class=\"fas fa-edit\"></i>
                                                      </a>"; 
                                                }
                                                else{
                                                    echo "<a class=\"admin-panel-table-icon\" href=\"admin_products.php?prod_id=$id\">
                                                        <i class=\"fas fa-edit\"></i>
                                                      </a>";
                                                    }   
                                            ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php 
                                                $type = "prod";     
                                                echo "<a class=\"admin-panel-table-icon\" onclick=\"return confirm('Czy na pewno chcesz usunąć ten produkt?')\" 
                                                         href=\"admin/delete.php?id=$id&type=$type\">
                                                            <i class=\"fas fa-trash-alt\"></i>
                                                        </a>";     
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                    }
                                }
                                
                                catch (PDOException $e){
                                    echo $e->getMessage();
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <?php 
                            echo pagination($user, $statement, $per_page, $page, $url='?');
                        ?>
                    </div>
                </div>
            </main>

            <footer>
                <div class="footer text-center">
                    <div class="footer-social">
                        <a href="#"><i class="footer-social-icon fab fa-facebook-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-instagram"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-twitter-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-youtube-square"></i></a>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <div class="modal fade" id="addProductModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title">Добавить новый товар</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="admin/add_prod.php">
                        <div class="form-group">
                            <label for="prodName">Название:</label>
                            <input type="text" class="form-control" id="prodName" name="prodName" required>
                        </div>
                        <div class="form-group">
                            <label for="prodDesc">Описание:</label>
                            <textarea type="text" class="form-control" id="prodDesc" name="prodDesc"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="prodCat">Категория:</label>
                                <select class="form-control" id="prodCat" name="prodCat">
                                    <option value="" selected disabled hidden>Выберите категорию</option>
                                    <?php 
                                        try {
                                            $stmt =  $user->runQuery("SELECT cat_id, cat_name FROM categories ORDER BY cat_name ASC");
                                            $stmt->execute();
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $cat_id = $row['cat_id'];
                                                echo "<option value=\"$cat_id\">";
                                                echo $row['cat_name'];
                                                echo "</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo $e->getMessage();
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="prodPrice">Цена:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <div class="input-group-text">AZN</div>
                                    </div>
                                    <input type="text" class="form-control" id="prodPrice" name="prodPrice">
                                </div>
                            </div>
                        </div>
                        <div class="form-group custom-file">
                            <input type="file" class="form-control custom-file-input" id="prodImg" name="prodImg" accept="image/*">
                            <label class="custom-file-label" for="prodImg">Изображение товара (maks. 10MB)</label>
                        </div>
                                        
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                </div>

            </div>
        </div>
    </div>

    <?php
        if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
            echo '<script src="js/admin-panel.js" type="text/javascript"></script>';
        }
        if (isset($_GET['prod_id']) && intval($_GET['prod_id']) != 0) { 
            require_once('modals/product-edit-modal.php');?>
            <script type="text/javascript"> $('#editProductModal').modal('show'); </script><?php
        }    
    ?>
</body>

</html>