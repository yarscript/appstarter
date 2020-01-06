<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo base_url(); ?>">
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <?php if ($back) { ?>
        <div class="d-flex bg-white border-bottom shadow-sm navheader">
            <a class="btn btn btn-primary btn-back" href="<?php echo $back; ?>" role="button">Back to Homepage</a>
        </div>
    <?php } ?>
</header>
