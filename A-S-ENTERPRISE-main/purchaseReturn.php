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
    <link rel="stylesheet" href="css/style.css">
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
                            <a href="./purchaseReturn.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-file-export me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                        <button id="togglessection" class="me-4 btn btn-primary rounded-5">Show Purchase Return</button>
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
            <!-- <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 text-center"id=""> -->
            <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 text-center"
                id="chnageSection">
                <!--Enter your code here for sell  -->
                <div id="section1" class="container p-2 d-flex justify-content-center align-items-center">
                    <form id="purchase_form" class="row justify-content-center" style="width: 100%;">
                        <div class="row">
                            <div class="col input-group mb-2">
                                <select id="category_select" class="col form-select border-primary border-2"
                                    aria-label="Default select example" onchange="handleSelectChange(this)">
                                    <option value="" disabled selected>Goods Name</option>
                                    <option value="custom" class="bg-primary text-light">Add New Goods</option>
                                    <?php

                                // SQL query to fetch all unique names from the goods table
                                $sqlCat = "SELECT DISTINCT name FROM goods";
                                $resultCat = $conn->query($sqlCat);

                                // Check if there are any results
                                if ($resultCat->num_rows > 0) {
                                    // Array to keep track of added names
                                    $addedNames = [];

                                    // Loop through the results and generate options
                                    while ($row = $resultCat->fetch_assoc()) {
                                        $name = htmlspecialchars($row['name']);
                                        
                                        // Check if the name has already been added
                                        if (!in_array($name, $addedNames)) {
                                            echo '<option value="' . $name . '">' . $name . '</option>';
                                            $addedNames[] = $name; // Add the name to the array
                                        }
                                    }
                                } else {
                                    echo '<option value="" disabled>No goods found</option>';
                                }
                                ?>
                                </select>
                            </div>

                            <!-- <div class="col input-group mb-2">
                                <select class="col form-select border-primary border-2" name="category" id="category_input" aria-label="Default select example">
                                    <option selected>Goods Serial/ Chasis no.</option>
                                    <option value="custom" class="bg-primary text-light">Custom Input</option>
                                </select>
                                <button class="btn btn-outline-primary border-2" type="button" id="button_addgoodsDetails">ADD</button>
                            </div> -->
                            <div class="col mb-2">
                                <div class="input-group">
                                    <span class="toggle-icon btn btn-outline-secondary">🔄</span>
                                    <!-- Icon for toggling -->
                                    <select class="col form-select border-primary border-2" name="category"
                                        id="category_input" aria-label="Default select example">
                                        <option selected>Goods Serial/ Chasis no.</option>
                                        <!-- <option value="custom" class="bg-primary text-light">Custom Input</option> -->
                                    </select>
                                    <input type="text" id="custom_input"
                                        class="form-control d-none border border-primary border-2 text-custom"
                                        placeholder="Enter custom Goods Serial/ Chasis no.">
                                    <button class="btn btn-outline-primary border-2" type="button"
                                        id="button_addgoodsDetails">ADD</button>
                                </div>
                            </div>
                            <div class="mb-2 overflow-auto" style="height:200px;">
                                <table class="table table-striped" id="goods_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Additional Details</th>
                                            <th scope="col">GST</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-2">
                                <!-- <strong>Grand Total:</strong> <input class ="border border-2 border-primary rounded-2"type="text" id="grand_total"></input> -->
                                <!-- <strong>Grand Total:</strong> <span id="grand_total"></span> -->
                                <strong>Grand Total:</strong> <input class="border border-2 border-primary rounded-2"
                                    type="text" id="grand_total" readonly></input>

                            </div>
                        </div>
                        <div class="row row-cols-4">
                            <div class="col mb-2" id="selectDiv">
                                <?php 
                                    $sql = "SELECT id, partiesName, gstin, phoneNumber, billingAddress, shippingAddress, stateCode FROM parties";
                                    $result = $conn->query($sql);
                                    $options = '';
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $name = $row['partiesName'];
                                            $gst = $row['gstin'];
                                            $contactNo = $row['phoneNumber'];
                                            $billAdd = $row['billingAddress'];
                                            $shipAdd = $row['shippingAddress'];
                                            $stateCode = $row['stateCode'];
                                            $options .= "<option value=\"$id\" data-name=\"$name\" data-gst=\"$gst\" data-contact=\"$contactNo\" data-billadd=\"$billAdd\" data-shipadd=\"$shipAdd\" data-statecode=\"$stateCode\">$name</option>";
                                        }
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }
                                ?>
                                <select class="form-select border-primary border-2" id="buyer_details"
                                    aria-label="Default select example">
                                    <option selected>Buyer Details</option>
                                    <option value="custom" class="bg-primary text-light">Add Temporary Parties</option>
                                    <?php echo $options; ?>
                                </select>
                            </div>
                            <input type="hidden" id="buyer_name" placeholder="Name">
                            <input type="hidden" id="gst_field" placeholder="GST">
                            <input type="hidden" id="contact_number" placeholder="Contact No">
                            <input type="hidden" id="billing_field" placeholder="Billing Address">
                            <input type="hidden" id="shipadd_field" placeholder="Shipping Address">
                            <input type="hidden" id="state" placeholder="State Code">

                            <!-- Modal -->
                            <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-light">
                                            <h5 class="modal-title" id="customModalLabel">Add Temporary Party Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="row row-cols-2 modal-body">
                                            <div class="col mb-3">
                                                <input type="text" class="form-control border border-2 border-primary"
                                                    placeholder="Parties Name" id="modalCustomItemInput">
                                            </div>
                                            <div class="col mb-3">
                                                <input type="text" class="form-control border border-2 border-primary"
                                                    placeholder="Parties Number" id="modalCustomContactInput">
                                            </div>
                                            <div class="col mb-3">
                                                <input type="text" class="form-control border border-2 border-primary"
                                                    placeholder="Parties Bill Address" id="modalBillingAddressInput">
                                            </div>
                                            <div class="col mb-3">
                                                <input type="text" class="form-control border border-2 border-primary"
                                                    placeholder="Parties Ship Address" id="modalShippingAddressInput">
                                            </div>
                                            <div class="col mb-3">
                                                <input type="text" class="form-control border border-2 border-primary"
                                                    placeholder="Parties State Code" id="modalStateCodeInput">
                                            </div>
                                            <div class="col mb-3">
                                                <button type="button" class="w-100 btn btn-primary rounded-5"
                                                    id="saveCustomDetails">USE</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="ReturnNo" placeholder="Return No" aria-label="ReturnNo">
                            </div>
                            <!-- <div class="col-12">
                                <div class="row row-cols-5 justify-content-start"> -->

                            <div class="col mb-2">
                                <input type="date" class="form-control border border-primary border-2 text-custom"
                                    id="dated" placeholder="Dated" aria-label="Dated">
                            </div>

                            <div class="col mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="description" placeholder="Description" aria-label="description">
                            </div>
                            <div class="col mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="discount" placeholder="Discount" aria-label="Discount">
                            </div>
                            <div class="mb-4">
                                <select class="form-select border-primary border-2" id="pos" name="StateCode">
                                    <option selected>Place of supply</option>
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
                            <div class="col-3 mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="ReturnAmount" placeholder="Return Amount" aria-label="ReturnAmount">
                            </div>

                            <div class="col-3">
                                <button type="submit" style="width:100%;" id="purchese_return" name="purchese_return"
                                    class="btn-block col btn btn-primary fs-5 rounded-5">Purchase Return</button>
                            </div>
                            <!-- </div>
                            </div> -->
                        </div>
                    </form>
                </div>
                <div id="section2" class="container-fluid overflow-auto d-none justify-content-center"
                    style="width:100%;height:calc(100vh - 80px);">
                    <div class="container-fluid m-0 p-0">
                        <table class="table table-striped text-center" id="itemsDetails"
                            style="width:100%;height:auto;">
                            <thead class="table-primary" style="position:sticky; top:0;">
                                <tr>
                                    <th>SL NO.</th>
                                    <th>Date</th>
                                    <th>Return No</th>
                                    <th>P O S</th>
                                    <th>Parties Name</th>
                                    <th>Contact Number</th>
                                    <th>Serial/Chasis NO.</th>
                                    <th>Total Amount</th>
                                    <th>Return Amount</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                        
                                $sql = "SELECT * FROM purchasereturn ORDER BY id DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<tr scope="row">';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 50px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["id"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["dateTime"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["purchaseReturnNo"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["placeOfSupply"] .'</td>';  
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["partiesName"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["partiesContactNumber"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">';
                                            if ($row['serialNumber']) {
                                                echo "Serial Number- ".$row['serialNumber']."";
                                            }
                                            else {
                                                echo "Chasis Number- ".$row['chasisNumber']."";
                                            }
                                        echo'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["totalAmount"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["returnAmount"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">';
                                                if ($user['status'] === 'active') {
                                                    echo '
                                                        <a href="backend/delete.php?id=' . $row["id"] . '&table=purchasereturn" class="link-danger">
                                                            <i class="fa-solid fa-trash fs-5"></i>
                                                        </a>';
                                                }
                                        echo'    </td>';
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
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <h1 class="modal-title fs-5 text-light" id="exampleModalCenterTitle">Owner Login
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3 text-start">
                                    <label for="exampleInputEmail1" class="form-label text-custom">Username</label>
                                    <input type="email" class="form-control border border-primary"
                                        id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="exampleInputPassword1" class="form-label text-custom">Password</label>
                                    <input type="password" class="form-control border border-primary"
                                        id="exampleInputPassword1">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function handleSelectChange(select) {
            var value = select.value;
            if (value === "custom") {
                window.location.href = "./add.php";
            }
        }
        function handlePaymentMethodChange(select) {
            var value = select.value;
            var customModal = new bootstrap.Modal(document.getElementById('customInputField'));

            if (value === "Cheque" || value === "Account") {
                customModal.show();
            }
        }
        document.getElementById("togglessection").addEventListener('click', function () {
            let section1 = document.getElementById("section1");
            let section2 = document.getElementById("section2");
            let toggleButton = document.getElementById("togglessection");

            section1.classList.toggle('d-none');
            section2.classList.toggle('d-none');

            section1.classList.toggle('d-flex');
            section2.classList.toggle('d-flex');

            section1.id = "temp";
            section2.id = "section1";
            document.getElementById("temp").id = "section2";

            if (toggleButton.innerText === "Show Purchese Return") {
                toggleButton.innerText = "Add Purchase Return";
            } else {
                toggleButton.innerText = "Show Purchase Return";
            }
        });
    </script>
    <script>
        document.getElementById('buyer_details').addEventListener('change', function () {
            var select = this;
            var selectDiv = document.getElementById('selectDiv');
            var buyerName = document.getElementById('buyer_name');
            var gstField = document.getElementById('gst_field');
            var contactNumber = document.getElementById('contact_number');
            var billingField = document.getElementById('billing_field');
            var shipAddField = document.getElementById('shipadd_field');
            var stateField = document.getElementById('state');

            if (select.value === 'custom') {
                selectDiv.style.display = 'block'; // Hide the select dropdown

                // Open the modal
                var customModal = new bootstrap.Modal(document.getElementById('customModal'), {});
                customModal.show();
            } else {
                selectDiv.style.display = 'block'; // Show the select dropdown

                // Set the values from the selected option
                var selectedOption = select.options[select.selectedIndex];
                // Extract values from data attributes
                var name = selectedOption.getAttribute('data-name');
                var gst = selectedOption.getAttribute('data-gst');
                var contact = selectedOption.getAttribute('data-contact');
                var billAdd = selectedOption.getAttribute('data-billadd');
                var shipAdd = selectedOption.getAttribute('data-shipadd');
                var stateCode = selectedOption.getAttribute('data-statecode');
                // Update input fields with selected values
                buyerName.value = name;
                gstField.value = gst;
                contactNumber.value = contact;
                billingField.value = billAdd;
                shipAddField.value = shipAdd;
                stateField.value = stateCode;
            }
        });

        document.getElementById('saveCustomDetails').addEventListener('click', function () {
            var modalCustomItemInput = document.getElementById('modalCustomItemInput').value;
            var modalCustomContactInput = document.getElementById('modalCustomContactInput').value;
            var modalBillingAddressInput = document.getElementById('modalBillingAddressInput').value;
            var modalShippingAddressInput = document.getElementById('modalShippingAddressInput').value;
            var modalStateCodeInput = document.getElementById('modalStateCodeInput').value;

            document.getElementById('buyer_name').value = modalCustomItemInput;
            document.getElementById('contact_number').value = modalCustomContactInput;
            document.getElementById('billing_field').value = modalBillingAddressInput;
            document.getElementById('shipadd_field').value = modalShippingAddressInput;
            document.getElementById('state').value = modalStateCodeInput;

            var customModal = bootstrap.Modal.getInstance(document.getElementById('customModal'));
            customModal.hide();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#addCat').click(function () {
                // Prevent the default button behavior (if needed)
                event.preventDefault();

                // Get the input field value
                var categoryValue = $('input[name="category"]').val();

                // Make sure the input value is not empty
                if (categoryValue.trim() === "") {
                    alert('Please enter a category.');
                    return;
                }

                $.ajax({
                    url: 'backend/category.php', // Your server-side script
                    type: 'POST',
                    data: { category: categoryValue }, // Send input field value to the server
                    success: function (response) {
                        if (response.trim() === "Category added successfully.") {
                            // Redirect to add.php with the category value as a URL parameter
                            window.location.href = 'add.php?category=' + encodeURIComponent(categoryValue);
                        } else {
                            // Handle unexpected responses or errors
                            alert('Error: ' + response);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error - show a message, log the error, etc.
                        alert('An error occurred: ' + error);
                    }
                });
            });
            // Handle the toggle icon click event
            $(".toggle-icon").click(function () {
                var select = $("#category_input");
                var input = $("#custom_input");

                if (input.hasClass("d-none")) {
                    // Show input, hide select, and swap IDs
                    select.addClass("d-none").attr("id", "custom_input");
                    input.removeClass("d-none").attr("id", "category_input");
                } else {
                    // Show select, hide input, and swap IDs
                    input.addClass("d-none").attr("id", "custom_input");
                    select.removeClass("d-none").attr("id", "category_input");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#toggle-checkbox').on('change', function () {
                var isChecked = $(this).is(':checked');
                $('#toggle-input').prop('disabled', !isChecked);
                $('#toggle-input').toggleClass('disabled-input', !isChecked);
            });
            var srCounter = 0; // Initialize the serial number counter
            var categorysToSend = []; // Array to store categorys to be sent to sell.php

            function updateGrandTotal() {
                let grandTotal = 0;
                let discount = parseFloat($('#discount').val()) || 0; // Get discount value from the input
                let chaAmount = parseFloat($('#chaAmount').val()) || 0; // Get charged amount value from the input

                $("#goods_table tbody tr").each(function () {
                    let amount = parseFloat($(this).find('input[name="itemAmount"]').val()) || 0;
                    let quantity = parseInt($(this).find('input[name="itemQty"]').val()) || 0;
                    // let gst = parseFloat($(this).find('input[name="itemGst"]').val()) || 0;
                    // Calculate total amount including GST
                    let itemTotal = amount * quantity;
                    // let gstAmount = (itemTotal * gst) / 100;
                    // let itemTotalWithGst = itemTotal + gstAmount;
                    let itemTotalWithGst = itemTotal;
                    grandTotal += itemTotalWithGst;
                });
                grandTotal += chaAmount;
                // Apply discount to grand total
                let discountAmount = grandTotal * (discount / 100);
                grandTotal -= discountAmount;

                $("#grand_total").val(grandTotal.toFixed(2));
            }

            // Event listener for discount input change
            $('#discount').on('input', function () {
                updateGrandTotal();
            });
            $('#chaAmount').on('input', function () {
                updateGrandTotal();
            });
            window.updateField = function (element, field) {
                const targetId = $(element).data('id');
                const newValue = $(element).val();
                updateJsonData(targetId, field, newValue);
            };

            function updateJsonData(id, field, value) {
                const index = categorysToSend.findIndex(item => item.id === id.toString());

                if (index !== -1) {
                    categorysToSend[index][field] = value;
                    // console.log(`Updated ${field} for ID ${id} at index ${index}: ${categorysToSend[index][field]}`);
                    // console.log(categorysToSend);
                } else {
                    console.log(`ID ${id} not found in the array.`);
                }
            }
            $("#category_select").change(function () {
                var selectedCategory = $(this).val();

                $.ajax({
                    url: "backend/get_goods_info.php",
                    method: "POST",
                    data: { category: selectedCategory },
                    success: function (data) {
                        var parsedData = JSON.parse(data);
                        var categoryInput = $("#category_input");
                        categoryInput.empty(); // Clear existing options

                        if (parsedData.length > 0) {
                            parsedData.forEach(function (item) {
                                var option = $("<option></option>")
                                    .attr("value", item) // item represents the serialNumber
                                    .text(item);
                                categoryInput.append(option);
                            });
                        } else {
                            categoryInput.append(new Option("No Goods Found", ""));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching goods info: ", textStatus, errorThrown);
                    }
                });
            });

            $("#button_addgoodsDetails").click(function () {
                var input = $("#category_input").val().trim();
                if (input != "") {
                    $.ajax({
                        url: "backend/get_goods_info.php",
                        method: "POST",
                        data: { input: input },
                        success: function (data) {
                            var parsedData = JSON.parse(data);
                            if (parsedData.length > 0) {
                                parsedData.forEach(function (item) {
                                    var existingRow = $("#goods_table tbody tr[data-category='" + item.category + "']");
                                    if (existingRow.length && existingRow.find('td:eq(2)').text().trim() === item.name.trim()) {
                                        var currentQuantity = parseInt(existingRow.find('input[name="itemQty"]').val()) || 0;
                                        var newQuantity = currentQuantity + parseInt(item.quantity);
                                        var newAmount = newQuantity * parseFloat(item.amount);

                                        existingRow.find('input[name="itemQty"]').val(newQuantity);
                                        existingRow.find('input[name="itemAmount"]').val(newAmount.toFixed(2));

                                        updateGrandTotal();

                                        var categoryToSend = categorysToSend.find(b => b.category === item.category && b.name === item.name);
                                        if (categoryToSend) {
                                            categoryToSend.quantity = newQuantity;
                                        }
                                    } else {
                                        var dropdownItems = '';
                                        if (item.serialNumber) {
                                            dropdownItems += `<li class="dropdown-item">Serial Number: ${item.serialNumber}</li>`;
                                        }
                                        if (item.chasisNumber) {
                                            dropdownItems += `<li class="dropdown-item">Chasis Number: ${item.chasisNumber}</li>`;
                                            dropdownItems += `<li class="dropdown-item">Motor Number: ${item.motorNumber}</li>`;
                                            dropdownItems += `<li class="dropdown-item">Model Number: ${item.modelNumber}</li>`;
                                            dropdownItems += `<li class="dropdown-item">Colour: ${item.color}</li>`;
                                        }
                                        srCounter++;
                                        let calcAmount;
                                        if (item.gst > 0) {
                                            calcAmount = item.amount_per_unit * (1 + (item.gst / 100));
                                        } else {
                                            calcAmount = item.amount_per_unit;
                                        }


                                        $("#goods_table tbody").append(`
                                            <tr data-id="${item.id}">
                                                <td>${srCounter}</td>
                                                <td><input style="width:300px;" type="text" name="itemName" value="${item.name}"></td>
                                                <input style="width:300px;" type="hidden" id="itemNameSerial" value="${item.serialNumber}">
                                                <input style="width:300px;" type="hidden" id="itemNameChasis" value="${item.chasisNumber}">
                                                <td><textarea style="width:auto; min-height:30px;height: 30px;" name="itemDesc" data-id="${item.id}" placeholder="Description" onchange="updateField(this, 'description')"></textarea></td>
                                                <td id="targetid" data-id="${item.id}">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm border-2 rounded-2 border-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Show Details
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            ${dropdownItems || '<li class="dropdown-item">No Details Available</li>'}
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><input style="width:50px;" type="text" name="itemGst" value="${item.gst}"></td>
                                                <td class="quantity"><input style="width:50px;" type="text" name="itemQty" value="${item.quantity}" data-id="${item.id}" onchange="updateField(this, 'quantity')"></td>
                                                <td class="amount"><input style="width:100px;" type="text" name="itemAmount" value="${calcAmount.toFixed(2)}"></td>
                                            </tr>
                                            
                                        `);

                                        updateGrandTotal();


                                        // Add event listener to the newly added quantity, amount, and description inputs
                                        $("#goods_table tbody").on('input', 'input[name="itemAmount"], input[name="itemQty"], input[name="itemDesc"]', function () {
                                            updateGrandTotal();

                                            // Get the closest row and the data-id attribute
                                            var row = $(this).closest('tr');
                                            var id = row.data('id');

                                            var newQuantity = parseInt(row.find('input[name="itemQty"]').val()) || 0;
                                            var newAmount = parseFloat(row.find('input[name="itemAmount"]').val()) || 0;
                                            var newDescription = row.find('textarea[name="itemDesc"]').val() || ''; // Assuming description might be in a textarea

                                            // Find the item in the categorysToSend array and update it
                                            var categoryToSend = categorysToSend.find(b => b.id === id);
                                            if (categoryToSend) {
                                                categoryToSend.quantity = newQuantity;
                                                categoryToSend.amount_per_unit = newAmount;
                                                categoryToSend.description = newDescription; // Update description if applicable
                                                console.log(categoryToSend);
                                            }
                                        });

                                        categorysToSend.push(item);
                                    }
                                });
                            } else {
                                $("#goods_table tbody").append(`
                                    <tr>
                                        <td colspan="6">No Data Found</td>
                                    </tr>
                                `);
                            }
                            $("#category_input").val('');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error("Error fetching goods info: ", textStatus, errorThrown);
                        }
                    });
                } else {
                    alert("Please enter a category.");
                }
            });

            $('#paymentREF').on('click', function () {
                var referenceValue = $('#modalReferencesInput').val();
                $('#paymentReferences').val(referenceValue);
                $('#customInputField').modal('hide');
            });
            $("#purchese_return").click(function (e) {
                e.preventDefault();
// console.log(categorysToSend);
                var buyerName = $("#buyer_name").val();
                var buyerBillAddress = $("#billing_field").val();
                var buyerShipAddress = $("#shipadd_field").val();
                var contactNumber = $("#contact_number").val();
                var state = $("#state").val();
                var gstin = $("#gst_field").val();
                var discount = $("#discount").val();
                var dated = $("#dated").val();
                var description = $("#description").val();
                var ReturnNo = $("#ReturnNo").val();
                var pos = $("#pos").val();
                var ReturnAmount = $("#ReturnAmount").val();
                var totalAmount = $("#grand_total").val();


                // Assuming categorysToSend is defined and populated elsewhere in your code
                if (typeof categorysToSend === 'undefined' || categorysToSend.length === 0) {
                    alert("No categories to send.");
                    return;
                }

                var dataToSend = {
                    purchese_return: categorysToSend,
                    discount: discount,
                    buyer_name: buyerName,
                    buyer_billAddress: buyerBillAddress,
                    buyer_shipAddress: buyerShipAddress,
                    contact_number: contactNumber,
                    state: state,
                    gstin: gstin,
                    dated: dated,
                    description: description,
                    ReturnNo: ReturnNo,
                    pos: pos,
                    ReturnAmount: ReturnAmount,
                    totalAmount: totalAmount

                };

                $.ajax({
                    url: "purchese_re.php",
                    method: "POST",
                    data: JSON.stringify(dataToSend),
                    contentType: "application/json",
                    success: function (response) {
                        console.log("Data sent to purcheseReturn.php successfully.");
                        console.log(response);
                        alert("purchese Return saved successfully.");
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("Error sending data to purcheseReturn.php: ", textStatus, errorThrown);
                    }
                });
            });


        });


    </script>

</body>

</html>