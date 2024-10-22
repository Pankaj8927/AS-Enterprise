<?php
    include 'backend/db_connection.php';
    session_start();
    // Check if the user is verified
    if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
        header("Location: OTP.php");
        exit();
    }
    // Query to fetch user from database
    $query = "SELECT * FROM users WHERE id = '1'";
    $result = mysqli_query($conn, $query);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A S ENTERPRISE</title>
    <script src="https://kit.fontawesome.com/e7678863ec.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,500;1,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        ::-webkit-scrollbar {width: 8px;}
        ::-webkit-scrollbar-thumb {background-color: #006769;border-radius:50px;}
        ::-webkit-scrollbar-track {background-color:gray;border-radius:50px;}
    </style>
</head>

<body>
    <div class="mainBody row  g-0">
        <main class="d-flex flex-nowrap sidebar col-auto">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; height:100vh;">
                <a href="./index.php"
                    class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <img src="icon.png" class="img-thumbnail mx-2" alt="..." style="width: 50px; height:50px;">
                    <span class="fs-5">A S ENTERPRISE</span>
                </a>
                <hr>
                <ul class="overflow-auto bd-sidebar nav nav-pills mb-auto d-flex flex-column list-unstyled ps-0" >
                    <div style="height: calc(100vh - 50px + 30px);">
                        <li class="nav-item">
                            <a href="./sell.php" class="nav-link d-flex align-items-center me-1  p-2 text-light"
                                aria-current="page"><i
                                    class="fa-solid fa-file-invoice-dollar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Sell</span></a>
                        </li>
                        <li>
                            <a href="./sellReturn.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-file-import me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Sell Return</span></a>
                        </li>
                        <li>
                            <a href="./challan.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-truck me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Delivery Challan</span></a>
                        </li>
                        <li>
                            <a href="./add.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-truck-ramp-box me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Add Products</span></a>
                        </li>
                        <li>
                            <a href="./purchase.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="fa-solid fa-cart-shopping me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Add Purchase</span></a>
                        </li>
                        <li>
                            <a href="./purchaseReturn.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="fa-solid fa-file-export me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Purchase Return</span></a>
                        </li>
                        <li>
                            <a href="./items.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-shapes me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Items</span></a>
                        </li>
                        <li>
                            <a href="./parties.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-people-group me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Parties</span></a>
                        </li>
                        <li>
                            <a href="./cashBank.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-building-columns me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                    style=" height: 30px;width:30px"></i> <span class="d-none d-lg-block">Cash & Bank</span></a>
                        </li>
                        <li>
                            <a href="#" class="nav-link d-flex align-items-center me-1 p-2 text-light" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                                <i class="fa-solid fa-plus me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 30px;width:30px"></i>
                                <span class="d-none d-lg-block">Reports <i class="fa-solid fa-caret-down"></i></span>
                            </a>
                            <div class="collapse" id="home-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal ms-5 p-1 small">
                                    <li>
                                        <a href="./sellReport.php" class="fs-7 nav-link d-flex align-items-center p-2 text-light">
                                            <i class="fa-solid fa-chart-bar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 20px;width:20px"></i>
                                            <span class="d-none d-lg-block">Sell Report</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./purchaseReport.php" class="fs-7 nav-link d-flex align-items-center p-2 text-light">
                                            <i class="fa-solid fa-chart-bar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 20px;width:20px"></i>
                                            <span class="d-none d-lg-block">Purchase Report</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="fs-7 nav-link d-flex align-items-center p-2 text-light" data-bs-toggle="collapse" data-bs-target="#gst-collapse" aria-expanded="false">
                                            <i class="fa-solid fa-file-invoice-dollar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 20px;width:20px"></i>
                                            <span class="d-none d-lg-block">GST <i class="fa-solid fa-caret-down"></i></span>
                                            
                                        </a>
                                        <div class="collapse" id="gst-collapse">
                                            <ul class="list-unstyled ms-5 pb-1 small">
                                                <li>
                                                    <a class="nav-link d-flex align-items-center p-2 text-light" href="./gstReport.php?table=sell">
                                                        <i class="fa-solid fa-chart-bar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 20px;width:20px"></i>
                                                        <span class="d-none d-lg-block">GSTR 1</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link d-flex align-items-center p-2 text-light" href="./gstReport.php?table=purchase">
                                                        <i class="fa-solid fa-chart-bar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center" style="height: 20px;width:20px"></i>
                                                        <span class="d-none d-lg-block">GSTR 2</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </div>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="logo.png" alt="" width="42" height="32" class="rounded-circle me-2">
                        <span class="fs-8">Developer</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Contact Us - +91-7319589678</a></li>
                        <li><a class="dropdown-item" href="#">Email - abhijitdey3322@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </main>
        <div class="col d-flex flex-column">
        <nav class="navbar navbar-expand-lg bg-secondary align-self-stretch">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center justify-content-center" style="height:50px; width:50px; text-align:center;padding:0;" href="#">
                        <?php 
                            if (mysqli_num_rows($result) == 1) {
                                $user = mysqli_fetch_assoc($result);
                                if ($user['status'] === 'active') {echo '<img src="admin.png" class=" border rounded-circle"alt="Bootstrap" style="width: 100%; height: 100%; object-fit: contain;">';}
                                else{echo '<img src="accountIcon.png" class=" border rounded-circle"alt="Bootstrap" width="30" height="30">';}
                            }
                        ?>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">
                                    <?php if ($user['status'] === 'active') {echo $user['username'];}else{echo 'Admin Name';}?>
                                </a>
                            </li>
                        </ul>
                        
                        <?php 
                            // Check if user status is inactive
                            if ($user['status'] === 'inactive') {
                                echo '<a class="navbar-brand text-light" style="text-align:center;" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Login <i class="fa-solid fa-right-from-bracket rotate-180"></i></a>';
                            } else {
                                echo '<a class="navbar-brand text-light" style="text-align:center;" href="backend/loginOwner.php?action=logout">Logout <i class="fa-solid fa-right-from-bracket"></i></a>';
                            }
                        ?>
                    </div>
                </div>
            </nav>
            <div class="container-fluid flex-grow-1" id="chnageSection">
                <div class="container-fluid text-center p-0"
                    style="width:100%;height:100%">
                    <div class="row row-cols-1 p-2" style="width:auto; height:85vh;">
                        <div class="col">
                            <div class="row gap-2">
                                <div class="col-3 g-2 d-flex flex-row justify-content-between align-items-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addpartiesModal" data-whatever="@mdo" style="width:45%; font-size:13px;">New party</button>
                                        <a id="ladgerViewButton" href="generateLadger.php?table=ladger"class="btn btn-primary bg-primary text-light rounded-2" style="width:45%; font-size:13px;">VIEW LADGER</a>
                                </div>

                                    <?php 
                                        $sql = "SELECT * FROM parties";
                                        $result = $conn->query($sql);
                                        $options = '';
                                        $finalAmount = 0;
                                        $previews = [];

                                        if ($result) {
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $name = $row['partiesName'];
                                                $totalAmount = $row['totalAmount'];
                                                $clearAmount = $row['clearAmount'];
                                                $gstin = $row['gstin'];
                                                $billingAddress = $row['billingAddress'];
                                                $shippingAddress = $row['shippingAddress'];
                                                $phoneNumber = $row['phoneNumber'];
                                                $emailid = $row['emailId'];
                                                $stateCode = $row['stateCode'];
                                                $type = $row['type'];
                                                $color = '';
                                                if ($type == 'sale') {
                                                    $color = 'success';
                                                } elseif ($type == 'purchase') {
                                                    $color = 'danger';
                                                } elseif ($type == 'sale$purchase') {
                                                    $color = 'primary';
                                                }
                                                $finalAmount = $totalAmount - $clearAmount;
                                                
                                                // Adding all the details as data attributes
                                                $options .= "<option value=\"$name\" data-id=\"$id\">$name</option>";
                                                $previews[$name] = "
                                                <strong>$name</strong>
                                                <span>Total ₹ $totalAmount</span>
                                                <span>Clear ₹ $clearAmount</span>
                                                <span class='text-$color'>Due ₹ $finalAmount 
                                                    &nbsp;";
                                            
                                                if ($user["status"] === "active") {
                                                    $previews[$name] .= "
                                                        <a class='edit-button link-$color' href='#' type='button' data-toggle='modal' data-target='#editModalCenter' data-id='$id' data-name='$name' data-gstin='$gstin' data-billing-address='$billingAddress' data-shipping-address='$shippingAddress' data-phone-number='$phoneNumber' data-emailid='$emailid' data-state-code='$stateCode'>
                                                            <i class='fa-solid fa-pen-to-square fs-5 me-3'></i>
                                                        </a>";
                                                }
                                                
                                                $previews[$name] .= "</span>";
                                            }
                                        } else {
                                            echo "Error: " . $conn->error;
                                        }
                                        ?>

                                <select class="col form-select border-primary border-2" id="Search"
                                    aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <?php echo $options; ?>
                                </select>
                            </div>
                            <div class="col alert border-2 border-primary rounded-3  alert-dismissible fade show mt-2 d-flex justify-content-between" role="alert" id="alertBox" style="height:55px;display: none;">
                                <!-- Alert content will be updated dynamically -->
                                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span> -->
                                <!-- </button> -->
                            </div>
                            

                        </div>
                        <div class="col overflow-auto" style="width:100%; height:65vh;">
                            <div class="col overflow-auto" style="width:100%; height:100%;">
                                <table class="table table-striped text-center" id="partiesDetails"
                                    style="width:100%; height:auto;">
                                    <thead class="table-primary" style="position:sticky; top:0;">
                                        <tr>
                                            <th>SL NO.</th>
                                            <th>Date Time</th>
                                            <th>Buyer Name</th>
                                            <th>Contact Number</th>
                                            <th>Payment Method</th>
                                            <th>Payment Reference</th>
                                            <th>Clear Amount</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT *  FROM ladger ORDER BY id DESC";
                                    
                                        
                                            $result = $conn->query($sql);
                                    
                                            if ($result->num_rows > 0) {
                                                
                                                while($row = $result->fetch_assoc()) {
                                                        echo '<tr scope="row">';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 50px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["id"] .'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 50px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["dateTime"] .'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["partiesName"] .'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["phoneNumber"] .'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'.$row["paymentMethod"].'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["paymentReference"] .'</td>';
                                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["clearAmount"] .'</td>';
                                                        if ($user['status'] === 'active') {
                                                            echo '<td><a href="backend/delete.php?id=' . $row["id"] . '&table=ladger" class="link-danger"><i class="fa-solid fa-trash fs-5"></i></a></td>';
                                                        }
                                                        // echo '</td>';
                                                        echo '</tr>';
                                                }
                                            } else {
                                                echo "0 results";
                                            }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- Add parties modal -->
                    <div class="modal fade" id="addpartiesModal" tabindex="-1" role="dialog"
                        aria-labelledby="addpartiesModal" aria-hidden="true" style="width:100%">
                        <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center flex-grow-1 text-center" role="document" style="max-width:60%; width:auto;">
                        <div class="modal-content " style="width: 150vh;">
                                <div class="modal-header bg-primary text-light d-flex justify-content-between">
                                    <h5 class="modal-title" id="exampleModalLabel">ADD Parties</h5>
                                    <button type="button" class="btn-close " data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                    <?php
                                   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['parties_add'])) {
                                        $PartyName = $_POST['PartyName'];
                                        $StateCode = $_POST['StateCode'];
                                        $billingaddress = $_POST['billingaddress'];
                                        $GSTIN = $_POST['GSTIN'];
                                        $PhoneNo = $_POST['PhoneNo'];
                                        $Shippingaddress = $_POST['Shippingaddress'];
                                        $email = $_POST['email'];
                                        // Check which radio button is selected
                                        if (isset($_POST['saleRadio'])) {
                                            $type = 'sale';
                                        } elseif (isset($_POST['purchaseRadio'])) {
                                            $type = 'purchase';
                                        } else {
                                            $type = ''; // Default or error handling if necessary
                                        }
                                        // $brand = $_REQUEST['SalePrice'];
                                        // Initialize the type variable
                                                                        
                                        $sql = "INSERT INTO `parties` (`partiesName`, `stateCode`, `billingAddress`, `gstin`, `phoneNumber`, `shippingAddress`, `emailid`, `type`) 
                                                VALUES ('$PartyName', '$StateCode', '$billingaddress', '$GSTIN', '$PhoneNo', '$Shippingaddress', '$email', '$type')";
                                    
                                    
                                        if (mysqli_query($conn, $sql)) {
                                            echo "<script>
                                                if (confirm('Party added successfully.')) {
                                                    window.location.href = 'parties.php';
                                                } else {
                                                    window.location.href = 'index.php'; // Redirect to a different page
                                                }
                                                </script>";
                                        } else {
                                            echo "<script>alert('Failed: " . mysqli_error($conn) . "');</script>";
                                        }
                                    
                                        mysqli_close($conn);
                                    }
                                ?>
                                    <form action="" method="POST" id="addParties_form" class="row" style="width: 100%;">
                                        <div class="col">
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required name="PartyName" placeholder="Party Name"
                                                    aria-label="Party Namer">
                                            </div>

                                            <div class="mb-4">
                                                <select class="form-select border-primary border-2" name="StateCode">
                                                    <option selected>State Name , Code</option>
                                                    <option value="Jammu and Kashmir - 1">Jammu and Kashmir - 1</option>
                                                    <option value="Himachal Pradesh - 2">Himachal Pradesh - 2</option>
                                                    <option value="Punjab - 3">Punjab - 3</option>
                                                    <option value="Chandigarh - 4">Chandigarh - 4</option>
                                                    <option value="Uttarakhand - 5">Uttarakhand - 5</option>
                                                    <option value="Haryana - 6">Haryana - 6</option>
                                                    <option value="Delhi - 7">Delhi - 7</option>
                                                    <option value="Rajasthan - 8">Rajasthan - 8</option>
                                                    <option value="Uttar Pradesh - 9">Uttar Pradesh - 9</option>
                                                    <option value="Bihar - 10">Bihar - 10</option>
                                                    <option value="Sikkim - 11">Sikkim - 11</option>
                                                    <option value="Arunachal Pradesh - 12">Arunachal Pradesh - 12
                                                    </option>
                                                    <option value="Nagaland - 13">Nagaland - 13</option>
                                                    <option value="Manipur - 14">Manipur - 14</option>
                                                    <option value="Mizoram - 15">Mizoram - 15</option>
                                                    <option value="Tripura - 16">Tripura - 16</option>
                                                    <option value="Meghalaya - 17">Meghalaya - 17</option>
                                                    <option value="Assam - 18">Assam - 18</option>
                                                    <option value="West Bengal - 19">West Bengal - 19</option>
                                                    <option value="Jharkhand - 20">Jharkhand - 20</option>
                                                    <option value="Odisha - 21">Odisha - 21</option>
                                                    <option value="Chhattisgarh - 22">Chhattisgarh - 22</option>
                                                    <option value="Madhya Pradesh - 23">Madhya Pradesh - 23</option>
                                                    <option value="Gujarat - 24">Gujarat - 24</option>
                                                    <option value="Daman and Diu - 25">Daman and Diu - 25</option>
                                                    <option value="Dadra and Nagar Haveli - 26">Dadra and Nagar Haveli -
                                                        26</option>
                                                    <option value="Maharashtra - 27">Maharashtra - 27</option>
                                                    <option value="Andhra Pradesh (Before Division) - 28">Andhra Pradesh
                                                        (Before Division) - 28</option>
                                                    <option value="Karnataka - 29">Karnataka - 29</option>
                                                    <option value="Goa - 30">Goa - 30</option>
                                                    <option value="Lakshadweep - 31">Lakshadweep - 31</option>
                                                    <option value="Kerala - 32">Kerala - 32</option>
                                                    <option value="Tamil Nadu - 33">Tamil Nadu - 33</option>
                                                    <option value="Puducherry - 34">Puducherry - 34</option>
                                                    <option value="Andaman and Nicobar Islands - 35">Andaman and Nicobar
                                                        Islands - 35</option>
                                                    <option value="Telangana - 36">Telangana - 36</option>
                                                    <option value="Andhra Pradesh (New) - 37">Andhra Pradesh (New) - 37
                                                    </option>
                                                    <option value="Ladakh - 38">Ladakh - 38</option>
                                                </select>
                                            </div>


                                            <div class="mb-4">
                                                <textarea
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required name="billingaddress"
                                                    placeholder="Billing Address" aria-label="Billing Address"
                                                    rows="3"></textarea>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    name="GSTIN" placeholder="GSTIN" aria-label="GSTIN">
                                            </div>
                                            <div class="mb-4">
                                                <input type="number"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required name="PhoneNo" placeholder="Phone Number"
                                                    aria-label="Phone Number">
                                            </div>
                                            <div class="mb-4">
                                                <textarea
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required name="Shippingaddress"
                                                    placeholder="Shipping Address" aria-label="Shipping Address"
                                                    rows="3"></textarea>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <input type="email" name="email"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    placeholder="name@example.com">
                                            </div>
                                            <div class="col mb-4 d-flex flex-row justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input border border-2 border-primary" type="radio" name="saleRadio" id="saleRadio" value="Sale">
                                                    <label class="form-check-label" for="saleRadio">
                                                        Type Sale
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input border border-2 border-primary" type="radio" name="purchaseRadio" id="purchaseRadio" value="Purchase">
                                                    <label class="form-check-label" for="purchaseRadio">
                                                        Type Purchase
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="col">
                                            <button type="submit" id="parties_add" name="parties_add"
                                                class="col btn btn-primary fs-5 rounded-5" style="width:100%;">
                                                SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary ">
                                    <h1 class="modal-title fs-5 text-light" id="exampleModalCenterTitle">Owner Login
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="backend/loginOwner.php" method="POST">
                                        <div class="mb-3 text-start">
                                            <label for="exampleInputEmail1"
                                                class="form-label text-custom">Username</label>
                                            <input type="text" class="form-control border border-primary"
                                                id="exampleInputEmail1" name="username" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label for="exampleInputPassword1"
                                                class="form-label text-custom">Password</label>
                                            <input type="password" class="form-control border border-primary"
                                                id="exampleInputPassword1" name="password">
                                        </div>
                                        <div class="mb-3 text-start form-check">
                                            <input type="checkbox" class="form-check-input border border-primary"
                                                id="exampleCheck1">
                                            <label class="form-check-label text-custom" for="exampleCheck1">Check me
                                                out</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary"
                                            style="width:50%;border-radius:50px;">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit modal -->
                    <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="editModalCenter" aria-hidden="true"style="width:100%">
                        <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center flex-grow-1 text-center" role="document" style="max-width:60%; width:auto;">
                            <div class="modal-content " style="width: 150vh;">
                                <div class="modal-header bg-primary text-light">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['parties_update'])) {
                                        // Assuming $conn is your database connection

                                        // Retrieve form data
                                        $PartyName = $_POST['PartyName'];
                                        $StateCode = $_POST['StateCode'];
                                        $billingaddress = $_POST['billingaddress'];
                                        $GSTIN = $_POST['GSTIN'];
                                        $PhoneNo = $_POST['PhoneNo'];
                                        $Shippingaddress = $_POST['Shippingaddress'];
                                        $email = $_POST['email'];
                                        $id = $_POST['id']; // Assuming you have a hidden field in your form for the party ID
                                        // Check which radio button is selected
                                        if (isset($_POST['saleRadio'])) {
                                            $type = 'sale';
                                        } elseif (isset($_POST['purchaseRadio'])) {
                                            $type = 'purchase';
                                        } else {
                                            $type = ''; // Default or error handling if necessary
                                        }

                                        // Update query
                                        $sql = "UPDATE `parties` 
                                                SET `partiesName` = '$PartyName', 
                                                    `stateCode` = '$StateCode', 
                                                    `billingAddress` = '$billingaddress', 
                                                    `gstin` = '$GSTIN', 
                                                    `phoneNumber` = '$PhoneNo', 
                                                    `shippingAddress` = '$Shippingaddress', 
                                                    `emailid` = '$email',
                                                    `type` = '$type'
                                                WHERE `id` = $id";


                                        // Execute query
                                        if (mysqli_query($conn, $sql)) {
                                            echo "<script>
                                                if (confirm('Party updated successfully.')) {
                                                    window.location.href = 'parties.php';
                                                } else {
                                                    window.location.href = 'index.php'; // Redirect to a different page
                                                }
                                                </script>";
                                        } else {
                                            echo "<script>alert('Failed: " . mysqli_error($conn) . "');</script>";
                                        }

                                        mysqli_close($conn);
                                    }
                                    ?>

                                    <form action="" method="POST" id="editParties_form" class="row" style="width: 100%;">
                                        <div class="col">
                                            <input type="hidden" name="id" id="idField">
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required id="partiesName"name="PartyName" placeholder="Party Name"
                                                    aria-label="Party Namer">
                                            </div>
                                            <div class="mb-4">
                                                <select class="form-select border-primary border-2" name="StateCode"
                                                id="inputGroupSelect02">
                                                    <option  id="stateCodeField"></option>
                                                    <option value="Jammu and Kashmir - 1">Jammu and Kashmir - 1</option>
                                                    <option value="Himachal Pradesh - 2">Himachal Pradesh - 2</option>
                                                    <option value="Punjab - 3">Punjab - 3</option>
                                                    <option value="Chandigarh - 4">Chandigarh - 4</option>
                                                    <option value="Uttarakhand - 5">Uttarakhand - 5</option>
                                                    <option value="Haryana - 6">Haryana - 6</option>
                                                    <option value="Delhi - 7">Delhi - 7</option>
                                                    <option value="Rajasthan - 8">Rajasthan - 8</option>
                                                    <option value="Uttar Pradesh - 9">Uttar Pradesh - 9</option>
                                                    <option value="Bihar - 10">Bihar - 10</option>
                                                    <option value="Sikkim - 11">Sikkim - 11</option>
                                                    <option value="Arunachal Pradesh - 12">Arunachal Pradesh - 12
                                                    </option>
                                                    <option value="Nagaland - 13">Nagaland - 13</option>
                                                    <option value="Manipur - 14">Manipur - 14</option>
                                                    <option value="Mizoram - 15">Mizoram - 15</option>
                                                    <option value="Tripura - 16">Tripura - 16</option>
                                                    <option value="Meghalaya - 17">Meghalaya - 17</option>
                                                    <option value="Assam - 18">Assam - 18</option>
                                                    <option value="West Bengal - 19">West Bengal - 19</option>
                                                    <option value="Jharkhand - 20">Jharkhand - 20</option>
                                                    <option value="Odisha - 21">Odisha - 21</option>
                                                    <option value="Chhattisgarh - 22">Chhattisgarh - 22</option>
                                                    <option value="Madhya Pradesh - 23">Madhya Pradesh - 23</option>
                                                    <option value="Gujarat - 24">Gujarat - 24</option>
                                                    <option value="Daman and Diu - 25">Daman and Diu - 25</option>
                                                    <option value="Dadra and Nagar Haveli - 26">Dadra and Nagar Haveli -
                                                        26</option>
                                                    <option value="Maharashtra - 27">Maharashtra - 27</option>
                                                    <option value="Andhra Pradesh (Before Division) - 28">Andhra Pradesh
                                                        (Before Division) - 28</option>
                                                    <option value="Karnataka - 29">Karnataka - 29</option>
                                                    <option value="Goa - 30">Goa - 30</option>
                                                    <option value="Lakshadweep - 31">Lakshadweep - 31</option>
                                                    <option value="Kerala - 32">Kerala - 32</option>
                                                    <option value="Tamil Nadu - 33">Tamil Nadu - 33</option>
                                                    <option value="Puducherry - 34">Puducherry - 34</option>
                                                    <option value="Andaman and Nicobar Islands - 35">Andaman and Nicobar
                                                        Islands - 35</option>
                                                    <option value="Telangana - 36">Telangana - 36</option>
                                                    <option value="Andhra Pradesh (New) - 37">Andhra Pradesh (New) - 37
                                                    </option>
                                                    <option value="Ladakh - 38">Ladakh - 38</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <textarea
                                                    class="form-control border border-primary border-2 text-custom"
                                                    id="billingAddressField" required name="billingaddress"
                                                    placeholder="Billing Address" aria-label="Billing Address"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required id="gstinField"name="GSTIN" placeholder="GSTIN" aria-label="GSTIN">
                                            </div>
                                            <div class="mb-4">
                                                <input type="number"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    required id="phoneNumberField"name="PhoneNo" placeholder="Phone Number"
                                                    aria-label="Phone Number">
                                            </div>
                                            <div class="mb-4">
                                                <textarea
                                                    class="form-control border border-primary border-2 text-custom"
                                                    id="shippingAddressField" required name="Shippingaddress"
                                                    placeholder="Shipping Address" aria-label="Shipping Address"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <input type="email" name="email"
                                                    class="form-control border border-primary border-2 text-custom"
                                                    id="emailIdField" placeholder="name@example.com">
                                            </div>
                                            <div class="col mb-4 d-flex flex-row justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input border border-2 border-primary" type="radio" name="saleRadio" id="saleRadio" value="Sale">
                                                    <label class="form-check-label" for="saleRadio">
                                                        Type Sale
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input border border-2 border-primary" type="radio" name="purchaseRadio" id="purchaseRadio" value="Purchase">
                                                    <label class="form-check-label" for="purchaseRadio">
                                                        Type Purchase
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <p class="fw-normal fs-9 text-center p-3">Please ensure the add product
                                            correctly. Incomplete or inaccurate information may result in delays,
                                            penalties, or the
                                            rejection of your tax invoice. Double-check all entries to avoid any
                                            discrepancies and
                                            ensure smooth processing.</p> -->
                                        <div class="col">
                                            <button type="submit" id="parties_update" name="parties_update"
                                                class="col btn btn-primary fs-5 rounded-5" style="width:100%;">
                                                UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#Search').change(function () {
                var selectedValue = $(this).val().toLowerCase();

                $('#partiesDetails tbody tr').each(function () {
                    var buyerName = $(this).find('td').eq(2).text().toLowerCase(); // Assuming Buyer Name is in the 3rd column (index 2)

                    if (selectedValue === "" || buyerName.indexOf(selectedValue) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            var previews = <?php echo json_encode($previews); ?>;
            
            // Handle dropdown change
            $('#Search').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === "Open this select menu" || selectedValue === "") {
                    $('#alertBox').hide();
                } else if (selectedValue in previews) {
                    $('#alertBox').html(previews[selectedValue]).show();
                } else {
                    $('#alertBox').hide();
                }
                // Base URL for the href
                var baseHref = "generateLadger.php?table=ladger";
                var newHref = baseHref;
                
                // Update href based on selected value
                if (selectedValue && selectedValue !== "Open this select menu") {
                    newHref += "&user=" + encodeURIComponent(selectedValue);
                }
                // Update the href attribute of the button
                $('#ladgerViewButton').attr('href', newHref)
            });

            // Use event delegation to handle dynamically created elements
            $('#alertBox').on('click', '.edit-button', function(event) {
                event.preventDefault(); // Prevent the default action

                // Retrieve data from the clicked element
                var dataId = $(this).data('id');
                var dataName = $(this).data('name');
                var dataGstin = $(this).data('gstin');
                var dataBillingAddress = $(this).data('billing-address');
                var dataShippingAddress = $(this).data('shipping-address');
                var dataPhoneNumber = $(this).data('phone-number');
                var dataEmailId = $(this).data('emailid');
                var dataStateCode = $(this).data('state-code');

                // Set the modal title or any other fields in the modal with the retrieved data
                $('#exampleModalLongTitle').text('Edit "' + dataName+'" Details');
                // Fill in other fields in the modal as needed
                $('#idField').val(dataId);
                $('#partiesName').val(dataName);
                $('#gstinField').val(dataGstin);
                $('#billingAddressField').val(dataBillingAddress);
                $('#shippingAddressField').val(dataShippingAddress);
                $('#phoneNumberField').val(dataPhoneNumber);
                $('#emailIdField').val(dataEmailId);
                $('#stateCodeField').text(dataStateCode);
                

            });
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>