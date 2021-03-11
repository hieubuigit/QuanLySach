<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sách</title>
</head>

<body>
    <!-- Header -->
    <?php $this->load->view('quan-ly-sach/templates/header'); ?>
    <!-- End Header -->

    <form action="<?php echo base_url('home/insertABook/'); ?>" method="POST">
        <div class="input-content">
            <label class="item item-input">Tên sách:
                <input type="text" class="field" id="book-name" name="book-name" value="<?php echo $aBook['title']; ?>" placeholder="Nhập tên sách..." required ng-minlength="2" ng-maxlength="70">
            </label>
            <br>
            <label class="item item-input">Tác giả:
                <select name="authors" id="authors" class="field">
                    <option value="none-author" disabled selected>Chọn tác giả</option>
                    <?php foreach ($authors as $author_item) : ?>
                        <option name="author" value="<?php echo $author_item['id']; ?>"><?php echo $author_item['name_author']; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <br>
            <label class="item item-input">Giá:
                <input type="number" class="field" id="price" name="price" value="<?php echo $aBook['price']; ?>" placeholder="Nhập giá sách..." required ng-minlength="4" ng-maxlength="70">
                VND
            </label>
        </div>
        <div class="button-add-book">
            <input type="submit" value="Thêm sách" class="btn-add-book" name="insert-a-book">
        </div>
    </form>


    <!-- Footer -->
    <?php $this->load->view('quan-ly-sach/templates/footer'); ?>
    <!-- End Footer -->
</body>

</html>