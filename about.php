<!Doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php');?>
    <title><?php echo $setting_r['site_title'] ?> - ABOUT</title>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />

</head>

<body style="background-color: rgb(55,55,55)">
    <?php require('inc/header.php');?>
    <div class="my-5 px-4 text-white">
        <h2 class="fw-bold h-font text-center">
            ABOUT US
        </h2>
        <div class="h-line bg-light"></div>
        <p class="text-center mt-3">
            
        </p>
    </div>
    <div class="container text-white">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">
                    <?php echo $setting_r['site_about']?>
                </h3>
            </div>
        </div>
    </div>
    <h3 class="text-center fw-bold h-font text-white">MANAGEMENT TEAM</h3>
    <div class="container px-4 text=white mt-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
            <?php 
                $about_q = selectAll(('team_details'));
                $path = ABOUT_IMG_PATH;
                while($row = mysqli_fetch_assoc($about_q)){
                    echo <<<data
                        <div class="swiper-slide bg-dark text-center overflow-hidden rounded"><img src="$path$row[picture]" class="w-100"><h5 class="mt-3 text-white">$row[name]</h5></div>
                    data;
                }
            ?>
        </div>
        <div class="swiper-pagination"></div>
  </div>
    </div>
    <?php require('inc/footer.php');?>
    <script src="js/cardhover.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 40,
      pagination: {
        el: ".swiper-pagination",
      },
      
      breakpoints:{
            320:{
                slidesPerView: 1,
            },
            640:{
                slidesPerView: 1,
            },
            768:{
                slidesPerView: 3,
            },
            1024:{
                slidesPerView: 3,
            },
        }
    });
  </script>
</body>

</html>