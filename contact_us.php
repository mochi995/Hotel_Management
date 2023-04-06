<!Doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php');?>
    <title><?php echo $setting_r['site_title'] ?> - CONTACT US</title>
</head>

<body style="background-color: rgb(55,55,55)">
    <?php require('inc/header.php');?>
    <div class="my-5 px-4 text-white">
        <h2 class="fw-bold h-font text-center">
            CONTACT US
        </h2>
        <div class="h-line bg-light"></div>
        <p class="text-center mt-3">
            Never gonna give you up, never gonna let you down, never gonna stay around and hurt you, never gonna make you cried, never gonna say goodbye, never gonna tell a lie and dessert you
        </p>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-secondary rounded">
                <iframe class="w-100" height="450" src="<?php echo $contact_r['iframe']?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="text-white p-4 rounded mb-3">
                    <h5>
                        Call us
                    </h5>
                    <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-white"><i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn1']?></a><br>
                    <a href="tel: +<?php echo $contact_r['pn2']?>" class="d-inline-block mb-2 text-decoration-none text-white"><i class="bi bi-telephone-fill"></i>+<?php echo $contact_r['pn2']?></a>
                </div>
                <div class="text-white p-4 rounded mb-3">
                    <h5>
                        Follow us
                    </h5>
                    <a href="<?php echo $contact_r['tw']?>" class="d-inline-block text-white"><span class="badge fs-6 p-2"><i class="bi bi-twitter me-1"></i>Twitter</span></a><br>
                    <a href="<?php echo $contact_r['fb']?>" class="d-inline-block text-white"><span class="badge fs-6 p-2"><i class="bi bi-facebook me-1"></i>Facebook</span></a><br>
                    <a href="<?php echo $contact_r['insta']?>" class="d-inline-block text-white"><span class="badge fs-6 p-2"><i class="bi bi-instagram me-1"></i>Instagram</span></a>
                </div>
                <div class="text-white p-4 rounded mb-3">
                    <h5>
                        Email
                    </h5>
                    <a href="<?php echo $contact_r['email']?>" class="d-inline-block text-white"><span class="badge fs-6 p-2"><i class="bi bi-envelope-fill me-1"></i><?php echo $contact_r['email']?></span></a>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php');?>

    <script src="js/cardhover.js"></script>
</body>

</html>