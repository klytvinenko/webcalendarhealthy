<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            
        font-family: 'Raleway', sans-serif;
        }
        .row{
            display: flex;
            flex-direction: row;
            justify-content: space-between
        }
        .column{
            display: flex;
            flex-direction: column;
        }
    form{
        display: flex;
        flex-direction: column;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button{
        margin: 5px;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;

    }
    .btn-primary{
        background-color: lightgreen;
    }
    .btn-secondary{
        background-color: lightblue;
    }
    .form-control{
        margin: 5px;
        display: flex;
        flex-direction: column;
        /* width: max-content; */
        width: 100%;

    }
    input{
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    select{
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    textarea{
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    legend{
        font-weight: bold; 
        font-size: 1.5em;
        margin-bottom: 10px;
        align-self: center;
    }
    label{
        margin-bottom: 5px;
        font-weight: bold;
    }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Raleway:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <title><?php echo $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <h1><?=$title?></h1>
    <?php include($childView); ?>
    <script src="/Resources/js/Model.js"></script>
    <script src="/Resources/js/Modal.js"></script>
    <script src="/Resources/js/Build.js"></script>
    <script src="/Resources/js/Ajax.js"></script>
    <script src="/Resources/js/API.js"></script>
    <script src="/Resources/js/Other.js"></script>
</body>

</html>