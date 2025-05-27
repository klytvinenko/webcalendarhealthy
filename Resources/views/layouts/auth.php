<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Resources/css/auth.css">
    <title><?php echo $title; ?></title>
</head>

<body>
    <div class="page-auth" style="width:50%;">
        <?php include($childView); ?>
    </div>
    <script src="Resources/js/Model.js"></script>
    <script src="Resources/js/Other.js"></script>
</body>

</html>