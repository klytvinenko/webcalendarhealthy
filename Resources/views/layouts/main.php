<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Raleway:400,400i,700,700i&amp;subset=latin-ext"
        rel="stylesheet">
    <?php
    if ($title == "Календар") { ?>
        <link rel="stylesheet" href="/Resources/css/calendar.css">
        <?php
    }
    else{
        ?>
        <link rel="stylesheet" href="/Resources/css/index.css">
        <link rel="stylesheet" href="/Resources/css/modal.css">
        <?php
    }
    ?>
    <title><?php echo $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <header class="header">
        <h1>Web - календар здорового харчування</h1>
    </header>
    <?php include($childView); ?>
    <footer class="footer">
        <p>© 2023, Web calendar</p>
    </footer>
    <script src="/Resources/js/Model.js"></script>
    <script src="/Resources/js/Modal.js"></script>
    <script src="/Resources/js/Build.js"></script>
    <script src="/Resources/js/Ajax.js"></script>
    <script src="/Resources/js/API.js"></script>
    <script src="/Resources/js/Other.js"></script>
</body>

</html>