<?php
    if(!defined("MODAL"))
        header('Location: ../index.php');
    
    try {
        $result =  $user->runQuery("SELECT cat_name, cat_desc FROM categories WHERE cat_id = :id");
        $result->bindParam(":id", $_GET['cat_id']);
        $result->execute();
        $edit_cat_row = $result->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>

<div class="modal fade" id="editCategoryModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">Редактировать категорию</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <div class="modal-body">
                <form method="post" action="admin/update_cat.php?cat_id=<?php echo $_GET['cat_id']; ?>">
                    <div class="form-group">
                        <label for="catName">Название категории:</label>
                        <input type="text" class="form-control" id="catName" name="catName"
                            value="<?php echo $edit_cat_row['cat_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="catDesc">Описание:</label>
                        <textarea type="text" class="form-control" id="catDesc" name="catDesc"><?php echo $edit_cat_row['cat_desc']; ?></textarea>
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
