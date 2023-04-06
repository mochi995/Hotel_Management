<!Doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php');?>
    <title><?php echo $setting_r['site_title'] ?> - ROOMS</title>
</head>

<body style="background-color: rgb(55,55,55)">
    <?php require('inc/header.php');?>
    <div class="my-5 px-4 text-white">
        <h2 class="fw-bold h-font text-center">
            ROOMS
        </h2>
        <div class="h-line bg-light"></div>
    </div>
    
    <div class="container-fluid text-white">
        <div class="row">

            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light rounded shadow bg-dark">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h5 class="mt-2 mb-4">FILTERS</h5>
                        <button class="navbar-toggler shadow-none" style="border-color: white; color:white" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="" role="button" ><i class="fa fa-bars" aria-hidden="true" style="color:#e6e6ff"></i></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch" id="filterDropdown">
                            <div class="border p-3 rounded mb-4" style="background-color: rgba(40, 40, 40, 0.363);">
                                <h6 class="mb-3">CHECK AVAILABILITY</h6>
                                <label class="form-label mb-2" style="font-weight: 500;">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-4">
                                <label class="form-label mb-2" style="font-weight: 500;">Check-out</label>
                                <input type="date" class="form-control shadow-none mb-3">
                            </div>
                            <div class="border p-3 rounded mb-4" style="background-color: rgba(40, 40, 40, 0.363);">
                                <h6 class="mb-3">FACILITIES</h6>
                                <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" style="font-weight: 500;" for="f1">Facilites one</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" style="font-weight: 500;" for="f2">Facilites two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                    <label class="form-check-label" style="font-weight: 500;" for="f3">Facilites three</label>
                                </div>
                            </div>
                            <div class="border p-3 rounded mb-4" style="background-color: rgba(40, 40, 40, 0.363);">
                                <h6 class="mb-3">GUESTS</h6>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <label class="form-label mb-3">Adult</label>
                                        <input type="number" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label mb-3">Children</label>
                                        <input type="number" class="form-control shadow-none mb-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4">
                <?php 
                    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?",[1,0],'ii');
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
                            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 mb-2 text-white custom-bg'>Book Now</button>";
                        }

                        echo<<<data

                            <div class="card mb-4 border-0 shadow bg-dark text-white">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                        <img src="$room_thumb" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="mb-2">$room_data[name]</h5>
                                        <div class="features mb-2">
                                            <h6 class="mb-1">Features</h6>
                                            $features_data
                                        </div>
                                        <div class="facilities mb-2">
                                            <h6 class="mb-1">Facilities</h6>
                                            $facilities_data
                                        </div>
                                        <div class="guest">
                                            <h6 class="mb-1">Guests</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[adult] Adults</span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">$room_data[children] Children</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                        <h6 class="mb-4">$$room_data[price] per night</h6>
                                        $book_btn
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-outline-light text-white btnHoverColor">More Details</a>
                                    </div>
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