<!Doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php');?>
    <title><?php echo $setting_r['site_title'] ?> - FACILITIES</title>
</head>

<body style="background-color: rgb(55,55,55)">
    <?php require('inc/header.php');?>
    <div class="my-5 px-4 text-white">
        <h2 class="fw-bold h-font text-center">
            OUR FACILITIES
        </h2>
        <div class="h-line bg-light"></div>
        <p class="text-center mt-3">
            Never gonna give you up, never gonna let you down, never gonna stay around and hurt you, never gonna make you cried, never gonna say goodbye, never gonna tell a lie and dessert you
        </p>
    </div>

    <div class="container">
        <div class="row">
            <div id="fCards" style="width:100%;"> 
                <?php
                    $res = selectAll("facilities");
                    $path = FACILITIES_IMG_PATH;
                    while($row = mysqli_fetch_assoc($res)){
                        echo<<<data
                            <div class="fCard text-center rounded text-white">
                                <div class="fCard-border"></div>
                                <div class="fCard-content">
                                    <img src="$path$row[icon]" width="40px" style="margin:10px">
                                    <h5>$row[name]</h5>
                                    <p style="margin:10px">$row[description]</p>
                                </div>
                            </div>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php');?>

    <script src="js/cardhover.js"></script>
</body>

</html>