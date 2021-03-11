<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tác giả</title>
</head>

<body>
    <!-- Header -->
    <?php $this->load->view('quan-ly-sach/templates/header'); ?>
    <!-- End Header -->

    <div class="btn-add">
        <a href="<?php echo base_url('/add-author'); ?>" class="add">Thêm tác giả</a>
        <a href="<?php echo base_url(); ?>" class="add">Danh sách tất cả sách</a>
        <p><?php echo $this->session->flashdata('success'); ?></p>
    </div>
    <div>
        <table>
            <tr>
                <th class="header">ID</th>
                <th class="header">Tác giả</th>
                <th class="options"></th>
            </tr>
            <?php foreach ($authors as $author_item) : ?>
                <tr id="tr<?php echo $author_item['id'] ?>">
                    <td class="item"><?php echo $author_item['id'] ?></td>
                    <td class="item"><?php echo $author_item['name_author'] ?></td>
                    <td class="item">
                        <a href="<?php echo base_url('home/showAAuthor/' . $author_item['id']) ?>" class="edit">Sửa</a>
                        <a href="javascript:void(0)" onclick="removeItem(<?php echo $author_item['id']; ?>)" class="remove">Xoá</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Footer -->
    <?php $this->load->view('quan-ly-sach/templates/footer'); ?>
    <!-- End Footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
<script type="text/javascript">
    // Remove a book from database
    removeItem = (authorID) => {
        if (confirm('Bạn có muốn xoá tác giả này không?')) {
            $.ajax({
                url: "<?php echo base_url("home/removeAAuthor/"); ?>",
                type: 'POST',
                data: {
                    author_id: authorID
                },
                error: () => {
                    alert('Xoa that bai!');
                },
                success: (data) => {
                    $("#tr" + authorID).remove();
                    alert("Xoa thanh cong!");
                }
            });
        }
    }
</script>

</html>