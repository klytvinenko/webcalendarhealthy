<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Raleway:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
        <link rel="stylesheet" href="/Resources/css/calendar.css">
    <title><?php echo $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    
    <?php include($childView); ?>

    <script src="/Resources/js/Model.js"></script>
    <script src="/Resources/js/Modal.js"></script>
    <script src="/Resources/js/Build.js"></script>
    <script src="/Resources/js/Ajax.js"></script>
    <script src="/Resources/js/API.js"></script>
    <script src="/Resources/js/Other.js"></script>
</body>

</html>