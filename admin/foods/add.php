<?php
require_once './../../Config.php';
require_once './../../dal/Category.php';
require_once './../../dal/Food.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="./../../public/lib/jquery-3.6.0.min.js"></script>
    <script src="./../../public/lib/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="./../../public/lib/bootstrap/css/bootstrap.css"/>
</head>
<body>
<div class="container">
    <?php
    require_once './../commons/nav.php';
    ?>
    <?php
    $categoryDal = new Category();
    $categoryDal->setPerPage(100);
    $categoryList = $categoryDal->getList(1);
    $foodDal = new Food();
    //nếu như có tồn tại một dữ liệu name
    if (isset($_POST['name'])) {
        //var_dump($_FILES);
        if (isset($_FILES['image']['name'])) {
            //var_dump($_FILES);
            //name;
            //tmp_name;
            //error
            //size
            $fileName = time().$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],
                './../../public/uploads/'.$fileName
            );
            $foodDal->addWithImage($_POST, 'public/uploads/'.$fileName);
        } else {
            $foodDal->add($_POST);
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tên món</label>
            <input type="text" class="form-control" name="name" placeholder="Tên món">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Giá</label>
            <input type="text" class="form-control" name="price" placeholder="Giá">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Danh mục</label>
            <select class="form-control" name="category_id">
                <?php
                foreach ($categoryList as $r) {
                    ?>

                    <option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>

                    <?php
                }
                ?>

            </select>
        </div>


        <input type="file" name="image"/>

        <div class=" col-auto">
            <button type="submit" class="btn btn-primary mb-3">Thêm</button>
        </div>
    </form>

</div>
</body>
</html>