<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" integrity="sha512-gOQQLjHRpD3/SEOtalVq50iDn4opLVup2TF8c4QPI3/NmUPNZOk2FG0ihi8oCU/qYEsw4P6nuEZT2lAG0UNYaw==" crossorigin="anonymous" />
    <title>Quan Ly Sach</title>
</head>

<body>
    <!-- Header -->
    <?php $this->load->view('quan-ly-sach/templates/header'); ?>
    <!-- End Header -->

    <!-- Body -->
    <div class="btn-add">
        <a href="<?php echo base_url('/add-book'); ?>" class="add">Thêm sách</a>
        <a href="<?php echo base_url('/author-manager'); ?>" class="btn-author-manager">Quản lý tác giả</a>
        <p><?php echo $this->session->flashdata('success'); ?></p>
    </div>
    <div>
        <form action="<?php echo base_url('home/processBooksData'); ?>" class="search-form">
            <label for="filter" class="form-name-filter">Tìm kiếm sách:
                <input type="text" class="search-book-name" id="keyword" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ""; ?>" placeholder="Nhập tên sách cần tìm...">
                <input type="submit" value="Tìm kiếm" class="search-button">
            </label>
            <label for="filter" class="form-name-filter">Lọc tác giả:
                <select name="authors" id="authors" class="field">
                    <option value="" disabled selected>Chọn tác giả</option>
                    <?php foreach ($authors as $author_item) : ?>
                        <option <?= $author_item['id'] == $authorIdSelected ? "selected" : ""; ?> value="<?= isset($_GET('authors')) ? $_GET('authors') : ""; ?>"><?php echo $author_item['name_author']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Lọc tác giả" class="filter-button">
            </label>
        </form>
    </div>
    <div>
        <table>
            <tr>
                <th class="header">ID</th>
                <th class="header">Tên sách</th>
                <th class="header">Tác giả</th>
                <th class="header">Giá</th>
                <th class="options"></th>
            </tr>
            <?php foreach ($books as $book_item) : ?>
                <tr id="tr<?php echo $book_item['id'] ?>">
                    <td class="item"><?php echo $book_item['id']; ?></td>
                    <td class="item"><?php echo $book_item['title']; ?></td>
                    <td class="item">
                        <select onchange="updateAuthorOfBook(this)" data-book-id="<?php echo $book_item['id']; ?>" name="list-of-authors" id="list-of-authors" class="list-of-authors">
                            <option value="" disabled selected>Chọn tác giả</option>
                            <?php foreach ($authors as $author_item) : ?>
                                <option <?= $author_item['id'] == $book_item['author_id'] ? "selected" : ""; ?> value=" <?php echo $author_item['id']; ?>" class="author-item"><?php echo $author_item['name_author']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="item"><?php
                                        setlocale(LC_MONETARY, "vi_VN");
                                        echo number_format($book_item['price']) . ' VNĐ'; ?></td>
                    <td>
                        <a href="<?php echo base_url('home/showABook/' . $book_item['id']) ?>" class="edit">Sửa</a>
                        <a href="javascript:void(0)" onclick="removeItem(<?php echo $book_item['id']; ?>)" class="remove">Xoá</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Paginate -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
            <a style="<?= $currentPage == $i ? "background-color: #ffad33;" : "background-color: #ffe033"; ?>" href="<?php
                                                                                                                        if (isset($_GET['keyword'])) {
                                                                                                                            echo $linkNextPage . "/page/" . $i . "/?keyword=" . $_GET['keyword'];
                                                                                                                        } elseif (isset($_GET['authors'])) {
                                                                                                                            echo $linkNextPage . "/page/" . $i . "/?authors=" . $_GET['authors'];
                                                                                                                        } elseif (isset($_GET['keyword']) && isset($_GET['authors'])) {
                                                                                                                            echo $linkNextPage . "/page/" . $i . "/?keyword=" . $_GET['keyword'] . '&authors=' . $_GET['authors'];
                                                                                                                        } else {
                                                                                                                            echo $linkNextPage . "/page/" . $i;
                                                                                                                        } ?>" class="page-number"><?php echo $i; ?></a>
        <?php } ?>
    </div>
    <!-- Paginate -->

    <!-- End Body -->

    <!-- Footer -->
    <?php $this->load->view('quan-ly-sach/templates/footer'); ?>
    <!-- End Footer -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" integrity="sha512-7VTiy9AhpazBeKQAlhaLRUk+kAMAb8oczljuyJHPsVPWox/QIXDFOnT9DUk1UC8EbnHKRdQowT7sOBe7LAjajQ==" crossorigin="anonymous"></script>
</body>
<script type="text/javascript">
    // Remove a book from database
    removeItem = (bookID) => {
        if (confirm('Bạn có muốn xoá sách này không?')) {
            $.ajax({
                url: "<?php echo base_url("home/removeABook/"); ?>",
                type: 'POST',
                data: {
                    book_id: bookID
                },
                error: () => {
                    alert('Xoá thất bại!');
                },
                success: (data) => {
                    $("#tr" + bookID).remove();
                    alert("Xoá thành công!");
                }
            });
        }
    }

    // Update a book from drop-down list
    updateAuthorOfBook = (__this) => {
        let bookID = $(__this).attr('data-book-id');
        let authorID = __this.value;

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("home/updateAuthorOfBook/"); ?>",
            data: {
                book_id: bookID,
                author_id: authorID
            },
            error: () => {
                console.log("Update author of book is failed!");
            },
            success: (response) => {
                console.log("Update author of book is succesfully!" + response);
            }
        });
    }
</script>

</html>