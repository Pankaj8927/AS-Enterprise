<?php 
    session_start();

    // Check if the user is verified
    if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
        header("Location: OTP.php");
        exit();
    }
    include 'backend/db_connection.php';
    // Query to fetch user from database
    // Get current year and month
    $currentYear = date('Y');
    $currentMonth = date('m');
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
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        ::-webkit-scrollbar {width: 8px;}
        ::-webkit-scrollbar-thumb {background-color: #006769;border-radius:50px;}
        ::-webkit-scrollbar-track {background-color:gray;border-radius:50px;}
    </style>
</head>

<body>
    <div class="mainBody row  g-0">
        <main class="d-flex flex-nowrap sidebar col-auto">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark " style="width:280px; height:100vh;">
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
                            <a href="./parties.php" class="nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class=" fa-solid fa-people-group me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                    <a class="navbar-brand d-flex align-items-center justify-content-center"
                        style="height:50px; width:50px; text-align:center;padding:0;" href="#">
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
                <div class="d-flex justify-content-center align-items-center flex-column text-center p-0"
                    style="width:100%;height:100%">
                    <div class="container-sm d-flex justify-content-center align-items-center">
                        <div class="card text-bg-primary m-3" style="width:20rem;">
                            <div class="card-header">A S ENTERPRISE</div>
                            <div class="card-body bg-light">
                                <a href="./index.php"type="button" class="active btn btn-outline-primary">Active</a>
                            </div>
                        </div>
                        <div class="card text-bg-primary m-3" style="width:20rem;">
                            <div class="card-header">A S AUTO PARTS</div>
                            <div class="card-body bg-light">
                                <a href="./ASAUTOPARTS/index.php"type="button" class="btn btn-outline-primary">Active</a>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid row row-cols-4 justify-content-md-center gap-3">
                        <div class=" col card text-primary">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-file-export" style="color: #00ff88;"></i> Sell</h5>
                                <?php
                                    // SQL query to select the total amount for the current month
                                    $sql = "SELECT SUM(goodsAmount) AS total_amount FROM sell WHERE YEAR(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s')) = $currentYear AND MONTH(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s')) = $currentMonth";
                                    $result = $conn->query($sql);
                                    // Fetch the result
                                    $row = $result->fetch_assoc();
                                    $totalSaleAmount = floatval(round($row['total_amount'], 2));
                                ?>
                                <span class="fs-4"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;<?php echo ($totalSaleAmount === 0) ? 0.0 : $totalSaleAmount ;  ?></span>
                                <p class="card-text"><?php echo "Month (".date('M').")";?></p>
                                <a href="./generate_pdf.php?table=sell" class="btn btn-primary"><i class="fa-solid fa-file-arrow-down"></i>&nbsp;Report</a>
                            </div>
                        </div>
                        <div class=" col card text-primary">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-cart-shopping" style="color: #ff0000;"></i> Purchase</h5>
                                <?php
                                    // SQL query to select the total amount for the current month
                                    $sql = "SELECT SUM(goodsAmount) AS total_amount FROM purchase WHERE YEAR(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s')) = $currentYear AND MONTH(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s')) = $currentMonth";
                                    $result = $conn->query($sql);
                                    // Fetch the result
                                    $row = $result->fetch_assoc();
                                    $totalPayAmount = floatval(round($row['total_amount'], 2));
                                ?>
                                <span class="fs-4"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;<?php echo ($totalPayAmount === 0) ? 0.0 : $totalPayAmount ; ?></span>
                                <p class="card-text"><?php echo "Month (".date('M').")";?></p>
                                <a href="./generate_pdf.php?table=purchase" class="btn btn-primary"><i class="fa-solid fa-file-arrow-down"></i>&nbsp;Report</a>
                            </div>
                        </div>
                        <div class=" col card text-primary">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-wallet" style="color: #00ff88;"></i> Receiving Details</h5>
                                <?php
                                    // SQL query to select the total amount for the current month
                                    $sql = "SELECT SUM(totalAmount - clearAmount) AS total_difference FROM parties WHERE type IN ('sale', 'sale&purchase')";
                                    $result = $conn->query($sql);
                                    // Fetch the result
                                    $row = $result->fetch_assoc();
                                    $totalRecDifference = floatval(round($row['total_difference'], 2));
                                ?>
                                <span class="fs-4"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;<?php echo ($totalRecDifference === 0) ? 0.0 : $totalRecDifference ; ?></span>
                                <p class="card-text fs-6">Add received amount</p>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentReceiveModal">ADD</a>
                            </div>
                        </div>
                        <!-- Payment receive dialog modal -->
                         <?php 
                           $sql = "SELECT id, partiesName FROM parties WHERE type IN ('sale', 'sale&purchase')";
                            // Execute the query
                            $result = $conn->query($sql);
                            // Initialize an empty array to hold options
                            $options = '';
                            // Check if there are results
                            if ($result) {
                                // Fetch results and generate options
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $name = $row['partiesName'];
                                    $options .= "<option value=\"$id\">$name</option>";
                                }
                            } else {echo "Error: " . $conn->error;}
                         ?>
                        <div class="modal fade" id="paymentReceiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-light">
                                        <h1 class="modal-title fs-5" >Received Amount</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <select class="form-select border-primary border-2" id="receiveInput" aria-label="Example select with button addon">
                                                <option selected>Parties...</option>
                                                <?php echo $options; ?>
                                            </select>
                                            <button class="btn btn-outline-primary border-2" id="showButton" type="button">SHOW</button>
                                        </div>
                                        <input type="hidden" id="receivepartiesName">
                                        <input type="hidden" id="receivepartiesPhoneNumber">
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Total amount</span>
                                            <span class="text-end" id="totalAmount"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Clear amount</span>
                                            <span class="text-end" id="clearAmount"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Due amount</span>
                                            <span class="text-end" id="dueAmount"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <select class="form-select border-primary border-2" id="paymentMethod" aria-label="Default select example" onchange="handlePaymentMethodChange(this)">
                                            <option selected value="">Payment Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Account">Account</option>
                                        </select>


                                        </br>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-primary text-light boprder-2 border-primary" id="inputGroup-sizing-default">Amount</span>
                                            <input type="text" class="form-control border-primary border-2" id="dueAmountValue"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="w-100 btn btn-primary rounded-5" id="updateButton">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col card text-primary">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-wallet" style="color: #ff0000;"></i> Paying Details</h5>
                                <?php
                                    // SQL query to select the total amount for the current month
                                    $sql = "SELECT SUM(totalAmount - clearAmount) AS total_difference FROM parties WHERE type IN ('purchase', 'sale&purchase')";
                                    $result = $conn->query($sql);
                                    // Fetch the result
                                    $row = $result->fetch_assoc();
                                    $totalPayDifference = floatval(round($row['total_difference'], 2));
                                ?>
                                <span class="fs-4"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;<?php echo ($totalPayDifference === 0) ? 0.0 : $totalPayDifference ; ?></span>
                                <p class="card-text">Add payed amount</p>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentPayModal">ADD</a>
                            </div>
                        </div></br>
                        <!-- Payment pay dialog modal -->
                        <?php 
                            $sql = "SELECT id, partiesName FROM parties WHERE type IN ('purchase', 'sale&purchase')";
                            // Execute the query
                            $result = $conn->query($sql);
                            // Initialize an empty array to hold options
                            $options = '';
                            // Check if there are results
                            if ($result) {
                                // Fetch results and generate options
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $name = $row['partiesName'];
                                    $options .= "<option value=\"$id\">$name</option>";
                                }
                            } else {echo "Error: " . $conn->error;}
                         ?>
                        <div class="modal fade" id="paymentPayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-light">
                                        <h1 class="modal-title fs-5" >Paying Amount</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <select class="form-select border-primary border-2" id="receiveInput2" aria-label="Example select with button addon">
                                                <option selected>Parties...</option>
                                                <?php echo $options; ?>
                                            </select>
                                            <button class="btn btn-outline-primary border-2" id="showButton2" type="button">SHOW</button>
                                        </div>
                                        <input type="hidden" id="payingpartiesName">
                                        <input type="hidden" id="payingpartiesPhoneNumber">
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Total amount</span>
                                            <span class="text-end" id="totalAmount2"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Clear amount</span>
                                            <span class="text-end" id="clearAmount2"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-4 text-primary">
                                            <span class="text-start">Due amount</span>
                                            <span class="text-end" id="dueAmount2"><i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0000</span>
                                        </div>
                                        <select class="form-select border-primary border-2" id="paymentMethod2"aria-label="Default select example" onchange="handlePaymentMethodChange(this)">
                                            <option selected value="">Payment Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Account">Account</option>
                                        </select>
                                        
                                        </br>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-primary text-light boprder-2 border-primary" id="inputGroup-sizing-default">Amount</span>
                                            <input type="text" class="form-control border-primary border-2" id="dueAmountValue2"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="w-100 btn btn-primary rounded-5" id="updateButton2">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col border border-primary border-5 rounded "id="chart_div" style="width:auto; height:auto;"></div>
                    </div>
                    <input type="hidden" id="paymentReferences">
                    <!-- payment reference -->
                    <div class="modal fade" id="customInputField" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="customModalLabel">Add Payment References</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <input type="text"
                                            class="form-control border border-primary border-2 text-custom"
                                            name="References" id="modalReferencesInput" placeholder="References" aria-label="References">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="paymentREF">SAVE</button>
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

                </div>
            </div>
        </div>
    </div>

    <?php
        // SQL query to fetch the monthly sales data
        $sql = "SELECT DATE_FORMAT(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s'), '%b') AS month_name, SUM(goodsQuantity) AS total_sales FROM sell WHERE YEAR(STR_TO_DATE(dateTime, '%Y.%m.%d-%H:%i:%s')) = $currentYear GROUP BY DATE_FORMAT(STR_TO_DATE(dateTime, '%Y%m%d-%H%i%s'), '%Y-%m') ORDER BY STR_TO_DATE(dateTime, '%Y%m%d-%H%i%s')";
        $result = $conn->query($sql);
        // Initialize an array with all months and sales set to 0
        $allMonths = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0,
            'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
        ];
        // Populate the array with actual sales data
        while ($row = $result->fetch_assoc()) {
            $allMonths[$row['month_name']] = (int)$row['total_sales'];
        }
        $conn->close();
        // Convert the formatted data to a format suitable for Google Charts
        $jsonData = [];
        foreach ($allMonths as $month => $sales) {
            $jsonData[] = [$month, $sales];
        }
        // Encode data to JSON for JavaScript consumption
        $jsonData = json_encode($jsonData);

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { packages: ['corechart', 'line'] });
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {
            var jsonData = <?php echo $jsonData; ?>; // Inject PHP data into JavaScript

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Sales');
            data.addRows(jsonData);

            var options = {
                hAxis: {
                    title: '<?php echo $currentYear; ?> Month',
                    gridlines: { count: 12 } // Ensure there are grid lines for each month
                },
                vAxis: {
                    title: 'Sales',
                    gridlines: { count: 10 }, // Adjust the count based on your data range
                    viewWindow: {
                        min: 0 // Adjust min value if necessary
                    }
                },
                colors: ['#006769'], // Custom color
                lineWidth: 3 // Increase the line width
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        function handlePaymentMethodChange(select) {
            var value = select.value;
            var customModal = new bootstrap.Modal(document.getElementById('customInputField'));

            if (value === "Cheque" || value === "Account") {
                customModal.show();
            }
        }
        $(document).ready(function() {
            $('#showButton').click(function() {
                // Get selected party ID
                var partyId = $('#receiveInput').val(); // Ensure this matches the select element id

                // Check if a valid party is selected
                if (partyId) {
                    $.ajax({
                        url: 'backend/receivedAmount.php', // URL of the PHP script
                        type: 'POST',
                        data: { id: partyId },
                        dataType: 'json', // Expecting JSON response
                        success: function(response) {
                            // Check if the response contains error
                            if (response.error) {
                                alert(response.error);
                            } else {
                                // Update the HTML with the response data
                                $('#receivepartiesName').val(response.partiesName);
                                $('#receivepartiesPhoneNumber').val(response.phoneNumber);
                                $('#totalAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.totalAmount);
                                $('#clearAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.clearAmount);
                                $('#dueAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.dueAmount);
                                
                                // Also set the value of the input field
                                $('#dueAmountValue').val(response.dueAmount);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            alert("An error occurred: " + error);
                        }
                    });
                } else {
                    // Handle case where no party is selected
                    $('#totalAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                    $('#clearAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                    $('#dueAmount').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                }
            });
            $('#showButton2').click(function() {
                // Get selected party ID
                var partyId = $('#receiveInput2').val(); // Ensure this matches the select element id

                // Check if a valid party is selected
                if (partyId) {
                    $.ajax({
                        url: 'backend/receivedAmount.php', // URL of the PHP script
                        type: 'POST',
                        data: { id: partyId },
                        dataType: 'json', // Expecting JSON response
                        success: function(response) {
                            // Check if the response contains error
                            if (response.error) {
                                alert(response.error);
                            } else {
                                // Update the HTML with the response data
                                $('#payingpartiesName').val(response.partiesName);
                                $('#payingpartiesPhoneNumber').val(response.phoneNumber);
                                $('#totalAmount2').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.totalAmount);
                                $('#clearAmount2').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.clearAmount);
                                $('#dueAmount2').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;' + response.dueAmount);
                                
                                // Also set the value of the input field
                                $('#dueAmountValue2').val(response.dueAmount);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            alert("An error occurred: " + error);
                        }
                    });
                } else {
                    // Handle case where no party is selected
                    $('#totalAmoun2t').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                    $('#clearAmount2').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                    $('#dueAmount2').html('<i class="fa-solid fa-indian-rupee-sign" style="color: #006769;"></i>&nbsp;0.00');
                }
            });
            $('#updateButton').click(function() {
                var partyId = $('#receiveInput').val();
                var partyName = $('#receivepartiesName').val();
                var phoneNumber = $('#receivepartiesPhoneNumber').val();
                var dueAmountValue = $('#dueAmountValue').val();
                var paymentMethod = $('#paymentMethod').val(); // Assuming this is a select element
                var paymentReferences = $('#paymentReferences').val();

                // Check if all necessary fields are filled
                if (partyId && paymentMethod) {
                    $.ajax({
                        url: 'backend/updateAmount.php', // Ensure this is the correct path to your PHP script
                        type: 'POST',
                        data: {
                            id: partyId,
                            partyName: partyName,
                            phoneNumber: phoneNumber,
                            dueAmount: dueAmountValue,
                            method: paymentMethod,
                            ref: paymentReferences
                        },
                        dataType: 'json', // Expect JSON response
                        success: function(response) {
                            if (response.success) {
                                alert('Amount updated successfully.');
                                // Refresh the page
                                window.location.reload();
                            } else {
                                alert('Failed to update amount: ' + response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
                } else {
                    alert('Please select a party and enter an amount.');
                }
            });

            $('#updateButton2').click(function() {
                var partyId = $('#receiveInput2').val();
                var partyName = $('#payingpartiesName').val();
                var phoneNumber = $('#payingpartiesPhoneNumber').val();
                var dueAmountValue = $('#dueAmountValue2').val();
                var paymentMethod = $('#paymentMethod2').val(); // Assuming this is a select element
                var paymentReferences = $('#paymentReferences').val();

                // Check if all necessary fields are filled
                if (partyId && paymentMethod) {
                    $.ajax({
                        url: 'backend/updateAmount.php', // Ensure this is the correct path to your PHP script
                        type: 'POST',
                        data: {
                            id: partyId,
                            partyName: partyName,
                            phoneNumber: phoneNumber,
                            dueAmount: dueAmountValue,
                            method: paymentMethod,
                            ref: paymentReferences
                        },
                        dataType: 'json', // Expect JSON response
                        success: function(response) {
                            if (response.success) {
                                alert('Amount updated successfully.');
                                // Refresh the page
                                window.location.reload();
                            } else {
                                console.log(response.error);
                                alert('Failed to update amount: ' + response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
                } else {
                    alert('Please select a party and enter an amount.');
                }
            });


            
            $('#paymentREF').on('click', function() {
                var referenceValue = $('#modalReferencesInput').val();
                $('#paymentReferences').val(referenceValue);
                $('#customInputField').modal('hide');
            });

        });

    </script>

</body>

</html>