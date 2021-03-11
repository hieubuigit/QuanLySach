<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tác giả</title>
</head>

<body>
    <!-- Header -->
    <?php $this->load->view('quan-ly-sach/templates/header'); ?>
    <!-- End Header -->

    <form action="home/insertAAuthor" method="POST">
        <div class="input-content">
            <label class="item item-input">Tên tác giả:
                <input type="text" class="input-mame-author" id="name-author" name="name-author" value="" placeholder="Thêm tên tác giả...">
            </label>
        </div>
        <div class="button-add-book">
            <input type="submit" value="Thêm tác giả" class="btn-add-book" name="insert-a-author">
        </div>
    </form>

    <!-- Footer -->
    <?php $this->load->view('quan-ly-sach/templates/footer'); ?>
    <!-- End Footer -->
</body>

</html>