
<!Doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php');?>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />
    <title><?php echo $setting_r['site_title'] ?> - HOME</title>

</head>

<body style="background-color: rgb(55,55,55)">
    <?php require('inc/header.php');?>
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
                    $res = selectAll('carousel');
                    while($row = mysqli_fetch_assoc($res)){
                        $path = CAROUSEL_IMG_PATH;
                        echo <<< data
                            <div class="swiper-slide">
                                <img src="$path$row[image]" class="w-100 d-block"/>
                            </div>
                        data;
                    }
                ?>
            </div>
        </div>

    </div>

    <div class="container availability-form" style="background-color: rgb(55,55,55)">
        <div class="row">
            <div class="col-lg-12 text-white p-4 rounded shadow">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form>
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-in</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Check-out</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Adult</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Children</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font text-white"> OUR ROOMS</h2>

    <div class="container">
        <div class="row">
            <?php 
                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3 ",[1,0],'ii');
                while($room_data = mysqli_fetch_assoc($room_res)){
                    $fea_q = mysqli_query($con,"SELECT f.name from `features` f INNER JOIN `room_features`rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
                    $features_data = "";
                    while($fea_row = mysqli_fetch_assoc($fea_q)){
                        $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fea_row[name]</span>";
                        
                    }
                    $fac_q = mysqli_query($con,"SELECT f.name from `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                    $facilities_data = "";
                    while($fac_row = mysqli_fetch_assoc($fac_q)){
                        $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fac_row[name]</span>";
                        
                    }

                    $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                    $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
                    if(mysqli_num_rows($thumb_q)>0){
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                    }

                    $book_btn = "";
                    if(!$setting_r['shutdown']){        
                        $login = 0;
                        if(isset($_SESSION['login'])&& $_SESSION['login']==true){
                            $login=1;
                        }
                        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg'>Book Now</button>";
                    }

                    echo<<<data
                        
                        <div class="col-lg-4 col-md-6 text-white my-3">
                            <div class="card bg-dark" style="max-width: 350px; margin: auto;">
                                <div class="card-border"></div>
                                <div class="card-content">
                                    <img src="$room_thumb" class="card-img-top">
                                    <div class="card-body">
                                        <h5>$room_data[name]</h5>
                                        <h6 class="mb-4">$$room_data[price] per night</h6>
                                        <div class="features" style="margin-bottom: 20px;">
                                            <h6 class="mb-1">Features</h6>
                                            $features_data
                                        </div>
                                        <div class="facilities mb-4">
                                            $facilities_data
                                        </div>
                                        <div class="guest mb-4">
                                            <h6 class="mb-1">Guests</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[adult] Adults</span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[children] Children</span>
                                        </div>
                                        <div class="d-flex justify-content-evenly mb-2">
                                            $book_btn
                                            <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-light text-white btnHoverColor">More Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    data;
                }
            ?>
            <div class="col-lg-12 text-center mt-5 text-white">
                <a href="rooms.php" class="btn btn-sm btn-outline-secondary rounded-0 fw-bold shadow-none text-white" >
                    More Rooms >>>
                </a>
            </div>
        </div>
    </div>

    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font text-white"> OUR FACILITIES</h2>
    <div class="container" style="align-items: center;">
        <div class="row">
            <div id="fCards" style="width:100%;"> 
                <?php
                    $res = mysqli_query($con,"SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 3");
                    $path = FACILITIES_IMG_PATH;
                    while($row = mysqli_fetch_assoc($res)){
                        echo<<<data
                            <div class="fCard text-center rounded text-white">
                                <div class="fCard-border"></div>
                                <div class="fCard-content">
                                    <img src="$path$row[icon]" width="40px" style="margin:10px">
                                    <h5>$row[name]</h5>
                                </div>
                            </div>
                        data;
                    }
                ?>
            </div>
            <div class="col-lg-12 text-center mt-5 text-white">
                <a href="facilities.php" class="btn btn-sm btn-outline-secondary rounded-0 fw-bold shadow-none text-white" >
                    More Facilities >>>
                </a>
            </div>
        </div>
    </div>

    <h2 class="mt-5 pt-4 mb-5 text-center fw-bold h-font text-white">CONTACT US</h2>
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
                    <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-white"><i class="bi bi-telephone-fill me-1"></i>+<?php echo $contact_r['pn1']?></a><br>
                    <a href="tel: +<?php echo $contact_r['pn2']?>" class="d-inline-block mb-2 text-decoration-none text-white"><i class="bi bi-telephone-fill me-1"></i>+<?php echo $contact_r['pn2']?></a>
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

    <!-- Password reset modal -->
    
    <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recovery-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-shield-lock fs-3 me-2"></i> Set up New Password
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="pass" required class="form-control shadow-none">
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn shadow-none  me-2" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php');?>
    <?php 
        if(isset($_GET['account_recovery'])){
            $data = filteration($_GET);
            $t_date = date("Y-m-d");

            $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1", [$data['email'], $data['token'],$t_date], 'sss');

            if(mysqli_num_rows($query)==1){
                echo <<< showModal
                    <script>
                        var myModal = document.getElementById('recoveryModal');

                        myModal.querySelector("input[name='email']").value = '$data[email]';
                        myModal.querySelector("input[name='token']").value = '$data[token]';

                        var modal = bootstrap.Modal.getOrCreateInstance(myModal);
                        modal.show();  
                    </script>  
                showModal;
            }
            else{
                alert("error","Invalid or Expired Link!");
            }

        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
    </script>
    <script src="js/cardhover.js"></script>
    <script>
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
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

        //recovery account
        let recovery_form = document.getElementById('recovery-form');
        recovery_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let data = new FormData();

            data.append('email', recovery_form.elements['email'].value);
            data.append('token', recovery_form.elements['token'].value);
            data.append('pass', recovery_form.elements['pass'].value);
            data.append('recover_user', '');

            var myModal = document.getElementById('recoveryModal');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function() {
                if(this.responseText == 'failed'){
                    alert('error', "Account reset failed!")
                }
                else{
                    alert('success',"Account Reset Successful!");
                    recovery_form.reset();
                }
            }
            xhr.send(data);

        });
    </script>
</body>

</html>