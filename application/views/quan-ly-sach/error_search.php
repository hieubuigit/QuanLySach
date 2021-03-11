<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/error-message.css">
    <title>Quan Ly Sach</title>
</head>

<body>
    <!-- Header -->
    <?php $this->load->view('quan-ly-sach/templates/header'); ?>
    <!-- End Header -->

    <!-- Body -->
    <h3 class="title-error"><?php echo $error_message; ?></h3>
    <!-- End Body -->

    <!-- Footer -->
    <?php $this->load->view('quan-ly-sach/templates/footer'); ?>
    <!-- End Footer -->
</body>

</html>