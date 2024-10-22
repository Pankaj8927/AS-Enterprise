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
    // Handle AJAX request
    if (isset($_POST['category'])) {
        $category = $_POST['category'];

        // Prepare the SQL query
        $stmt = $conn->prepare("SELECT DISTINCT name, HSNSAC as hsn_sac, gst, trackingType FROM items WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $itemresult = $stmt->get_result();

        $items = [];
        if ($itemresult->num_rows > 0) {
            while ($row = $itemresult->fetch_assoc()) {
                $items[] = $row;
            }
        }

        echo json_encode($items);

        $stmt->close();
        exit; // End script execution after sending the JSON response
    }
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
        /* *{border:1px solid red;} */
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
                            <a href="./purchase.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-cart-shopping me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                        <button id="togglessection" class="me-4 btn btn-primary rounded-5">Purchase By Order No</button>
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
            <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 text-center"
                id="chnageSection">
                <!--Enter your code here for sell  -->
                <div class="container p-2 d-flex justify-content-center align-items-center">
                    <form action="javascript:void(0);" id="purchase_form" class="row justify-content-center"
                        style="width: 100%;">
                        <div id="section1"class="row d-flex justify-content-center">
                            <div class="col input-group mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    name="billNo" id="billNo" placeholder="Bill No" aria-label="Bill No" >
                                    <!-- <button id="addGoodsDetails" class="btn btn-primary ">ADD</button> -->
                            </div>  
                            <div class="col mb-2">
                                <select class="form-select border-primary border-2" name="categoryName"
                                    id="inputGroupSelect02" onchange="handleSelectChange(this),findName(this)">
                                    <option value="" disabled selected>Category</option>
                                    <option value="custom" class="bg-primary text-light">Add New Category</option>
                                    <?php
                                            // SQL query to fetch all categories
                                            $sql = "SELECT category_name FROM category";
                                            // Execute the query
                                            $result = $conn->query($sql);
                                            // Check if there are any results
                                            if ($result->num_rows > 0) {
                                                // Loop through the results and generate options
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' .$row['category_name'] . '">' . $row['category_name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No categories found</option>';
                                            }
                                        ?>
                                </select>
                            </div>
                            <div class="col mb-2" id="selectDiv">
                                <select class="form-select border border-primary border-2 text-custom" name="itemname" id="itemname">
                                    <option value="">Select Item</option>
                                    <option value="custom" class="bg-primary text-light">Custom Input</option>
                                </select>
                            </div>
                            <script>
                                function findName(selectElement) {
                                    let category = $(selectElement).val();

                                    $.ajax({
                                        url: '', // The PHP file itself top writen
                                        type: 'POST',
                                        data: { category: category },
                                        success: function(response) {
                                            let items = JSON.parse(response);
                                            let $itemSelect = $('#itemname');
                                            $itemSelect.empty();
                                            $itemSelect.append('<option value="">Select Item</option>');
                                            $itemSelect.append('<option value="custom" class="bg-primary text-light">Custom Input</option>');
                                            items.forEach(item => {
                                                $itemSelect.append(
                                                    `<option value="${item.name}" data-hsn="${item.hsn_sac}" data-gst="${item.gst}" data-type="${item.trackingType}">${item.name}</option>`
                                                );
                                            });
                                        },
                                        error: function() {
                                            alert('Failed to fetch items.');
                                        }
                                    });
                                }
                            </script>
                            <div class="col mb-2" id="customInputDiv" style="display: none;">
                                <input type="text" class="form-control border border-primary border-2 text-custom" id="customItemInput" placeholder="Enter custom item name">
                            </div>
                            <div class="col input-group mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    name="quantity" id="quantity" placeholder="Quantity" aria-label="Quantity" >
                                    <!-- <button id="addGoodsDetails" class="btn btn-primary ">ADD</button> -->
                            </div>                     
                            <div class="d-flex justify-content-center row row-cols-3">
                                <!-- custom half details of goods like serial number chasisnumber modal motor color etc -->
                                <div class="d-flex col mb-4">
                                    <input type="text" class="form-control border border-primary border-2 text-custom"
                                        name="hsnsac" id="hsnsac" placeholder="HSN/SAC Number" aria-label="HSN/SAC Number" >
                                </div>
                                <div class="d-flex col mb-4">
                                    <input type="text" class="form-control border border-primary border-2 text-custom"
                                        name="GST" id="gst" placeholder="GST" aria-label="GST" >
                                </div>
                                <input type="hidden" id="trackingType">
                                <div class="d-flex col mb-4">
                                    <input type="text" id="amount" class="form-control border border-primary border-2 text-custom"
                                        name="amount" placeholder="Amount per pcs" aria-label="Amount">
                                </div>
                                
                                <div class="d-flex justify-content-center col overflow-auto row border border-2 border-secondary mb-2 p-2" style="width:100%;height:40vh">
                                    <div id="formContainer" class="row">
                                        <div class="form-row col-12 mb-4">
                                            <div class="row g-2">
                                                <div class="col">
                                                    <input type="text" class="form-control border border-primary border-2 text-custom additional serial-input" name="serialNumber[]" placeholder="Serial Number" >
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="chasisNumber[]" placeholder="Chasis Number" >
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="modelNumber[]" placeholder="Model Number" >
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="motorNumber[]" placeholder="Motor Number" >
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="color[]" placeholder="Color" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                <strong>Grand Total:</strong> <input class ="border border-2 border-primary rounded-2"type="text" id="grand_total1" readonly></input>
                            </div>
                        </div>
                        <div id="section2"class=" d-none row">
                            <!-- order number input and button with goods table and grenad_total-->
                            <div class="col input-group mb-2">
                                <!-- <select class="col form-select border-primary border-2" name="category" id="category_input" aria-label="Default select example">
                                    <option selected>Goods Serial/ Chasis no.</option>
                                </select> -->
                                <select class="col form-select border-primary border-2" name="category" id="category_input" aria-label="Default select example">
                                    <option selected>Order Number</option>
                                    <?php

                                // SQL query to fetch all unique names from the goods table
                                $sqlorder = "SELECT orderNumber FROM ordernumber ORDER BY orderNumber DESC";

                                $resultorder = $conn->query($sqlorder);

                                // Check if there are any results
                                if ($resultorder->num_rows > 0) {
                                    // Array to keep track of added names
                                    $addedNumbers = [];

                                    // Loop through the results and generate options
                                    while ($row = $resultorder->fetch_assoc()) {
                                        $numbers = htmlspecialchars($row['orderNumber']);
                                        
                                        // Check if the name has already been added
                                        if (!in_array($numbers, $addedNumbers)) {
                                            echo '<option value="' . $numbers . '">' . $numbers . '</option>';
                                            $addedNumbers[] = $name; // Add the name to the array
                                        }
                                    }
                                } else {
                                    echo '<option value="" disabled>No goods found</option>';
                                }
                                ?>
                                </select>
                                <button class="btn btn-outline-primary border-2" type="button"
                                    id="button_addgoodsDetails">ADD</button>
                            </div>
                            <div class="mb-2 overflow-auto" style="height:200px;">
                                <table class="table table-striped" id="goods_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr</th>
                                            <th scope="col">Name</th>
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
                                <!-- <strong>Grand Total:</strong> <span id="grand_total">0.00</span> -->
                                <strong>Grand Total:</strong> <input class ="border border-2 border-primary rounded-2"type="text" id="grand_total"></input>
                            </div>
                        </div>
                        <div class="row row-cols-4">
                            <div class="col mb-2">
                                <?php 
                                    $sql = "SELECT id, partiesName, gstin, phoneNumber, billingAddress, shippingAddress, stateCode  FROM parties";
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
                                            $gst = $row['gstin'];
                                            $contactNo = $row['phoneNumber'];
                                            $billAdd = $row['billingAddress'];
                                            $shipAdd = $row['shippingAddress'];
                                            $stateCode = $row['stateCode'];
                                            $options .= "<option value=\"$id\" data-name=\"$name\" data-gst=\"$gst\" data-contact=\"$contactNo\" data-billadd=\"$billAdd\" data-shipadd=\"$shipAdd\" data-statecode=\"$stateCode\">$name</option>";
                                        }
                                    } else {echo "Error: " . $conn->error;}
                                ?>
                                <select class="form-select border-primary border-2" id="buyer_details"
                                    aria-label="Default select example">
                                    <option selected>Seller Details</option>
                                    <?php echo $options; ?>
                                </select>
                            </div>
                            <input type="hidden" id="buyer_name" placeholder="Name">
                            <input type="hidden" id="gst_field" placeholder="GST">
                            <input type="hidden" id="contact_number" placeholder="Contact No">
                            <input type="hidden" id="billing_field" placeholder="Billing Address">
                            <input type="hidden" id="shipadd_field" placeholder="Shipping Address">
                            <input type="hidden" id="state" placeholder="State Code">
                            <script>
                                // Function to handle the selection change
                                document.getElementById('buyer_details').addEventListener('change', function () {
                                    var selectedOption = this.options[this.selectedIndex];
                                    // Extract values from data attributes
                                    var name = selectedOption.getAttribute('data-name');
                                    var gst = selectedOption.getAttribute('data-gst');
                                    var contact = selectedOption.getAttribute('data-contact');
                                    var billAdd = selectedOption.getAttribute('data-billadd');
                                    var shipAdd = selectedOption.getAttribute('data-shipadd');
                                    var stateCode = selectedOption.getAttribute('data-statecode');

                                    // Update input fields with selected values
                                    document.getElementById('buyer_name').value = name;
                                    document.getElementById('gst_field').value = gst;
                                    document.getElementById('contact_number').value = contact;
                                    document.getElementById('billing_field').value = billAdd;
                                    document.getElementById('shipadd_field').value = shipAdd;
                                    document.getElementById('state').value = stateCode;
                                });
                            </script>
                            <div class="col mb-2">
                                <select class="form-select border-primary border-2" id="paymentMethod2"
                                    aria-label="Default select example" onchange="handlePaymentMethodChange(this)">
                                    <option selected value="">Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Account">Account</option>
                                </select>
                            </div>
                            <input type="hidden" id="paymentReferences">

                            <div class="col mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="discount" placeholder="Discount" aria-label="Discount">
                            </div>
                            <div class="col-3 mb-2">
                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                    id="chaAmount" placeholder="Extra Charges" aria-label="chaAmount">
                            </div>
                            <div class="col-12">
                                <div class="row row-cols-5 justify-content-start">
                                    <?php
                                        // Construct the SQL query to get the last orderNumber based on the highest id
                                        $ordersql = "SELECT orderNumber FROM ordernumber ORDER BY id DESC LIMIT 1";

                                        // Execute the query
                                        $orderResult = $conn->query($ordersql);

                                        // Fetch the result
                                        if ($orderResult && $row = $orderResult->fetch_assoc()) {
                                            $lastOrderNumber = $row['orderNumber']+1;
                                        } else {
                                            $lastOrderNumber = 0; // Default value if no record is found or if there's an error
                                        }
                                    ?>
                                    <div class="col-3 mb-2">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-primary" id="prevButton">Previous</button>
                                            <input type="text" id="buyOdrNo" class="form-control border border-primary border-2 text-primary"
                                                name="orderNumber" placeholder="Order Number" aria-label="orderNumber" readonly value="<?php echo $lastOrderNumber;?>">
                                            <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                                        </div>
                                    </div>
                                    <!-- <div class="col-3 mb-2">
                                        <input type="text"
                                            class="form-control border border-primary border-2 text-custom"
                                            id="buyOdrNo" placeholder="Order No." aria-label="buyOdrNo">
                                    </div> -->
                                    <div class="col-3 mb-2">
                                        <input type="file" class="form-control border border-primary border-2 text-custom"
                                            id="othRef" placeholder="Other References"
                                            aria-label="othRef">
                                    </div>
                                    <div class="col-3 mb-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-text border border-primary border-2">
                                                <input id="toggle-checkbox"
                                                    class="form-check-input mt-0 border border-primary border-2"
                                                    type="checkbox" aria-label="Checkbox for following text input">
                                            </div>
                                            <input id="toggle-input" type="text"
                                                class="form-control border border-primary border-2 text-custom disabled-input"
                                                placeholder="Paid Amount" aria-label="Text input with checkbox"
                                                disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="col-3">
                                        <button type="submit" style="width:100%;" id="purchase_submit"
                                            name="purchase_submit"
                                            class="btn-block col btn btn-primary fs-5 rounded-5">PURCHASE
                                            SUBMIT</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
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
                                        <label for="exampleInputEmail1" class="form-label text-custom">Username</label>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    

    <script>
         document.getElementById("togglessection").addEventListener('click', function() {
            let section1 = document.getElementById("section1");
            let section2 = document.getElementById("section2");
            let toggleButton = document.getElementById("togglessection");

            if (section1.classList.contains('d-flex')) {
                section1.classList.remove('d-flex');
                section1.classList.add('d-none');
                section2.classList.remove('d-none');
                section2.classList.add('d-flex');
            } else {
                section2.classList.remove('d-flex');
                section2.classList.add('d-none');
                section1.classList.remove('d-none');
                section1.classList.add('d-flex');
            }

            if (toggleButton.innerText === "Purchase By Custom Details") {
                toggleButton.innerText = "Purchase By Order No";
            } else {
                toggleButton.innerText = "Purchase By Custom Details";
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const selectElement = document.getElementById("buyer_details");
            const submitButton = document.getElementById("purchase_submit");

            function validateForm() {
                const isOptionSelected = selectElement.value !== "Seller Details";
                submitButton.disabled = !isOptionSelected;
            }

            selectElement.addEventListener("change", validateForm);

            // Initial validation check
            validateForm();
        });


        function handleSelectChange(select) {
            var value = select.value;
            if (value === "custom") {
                window.location.href = "./add.php";
            }
        }
        document.getElementById('itemname').addEventListener('change', function() {
            var select = this;
            var selectDiv = document.getElementById('selectDiv');
            var customInputDiv = document.getElementById('customInputDiv');
            var customItemInput = document.getElementById('customItemInput');
            var hsnInput = document.getElementById('hsnsac');
            var gstInput = document.getElementById('gst');

            if (select.value === 'custom') {
                selectDiv.style.display = 'none'; // Hide the select dropdown
                customInputDiv.style.display = 'block'; // Show the custom input field
                customItemInput.required = true;
                select.name = 'custominput'; // Change the name of the select to 'custominput'
                select.id = 'custominput'; // Change the id of the select to 'custominput'
                customItemInput.name = 'itemname'; // Change the name of the input to 'itemname'
                customItemInput.id = 'itemname'; // Change the id of the input to 'itemname'
            } else {
                selectDiv.style.display = 'block'; // Show the select dropdown
                customInputDiv.style.display = 'none'; // Hide the custom input field
                customItemInput.value = ''; // Reset the custom input field
                customItemInput.required = false;
                select.name = 'itemname'; // Restore the original name of the select
                select.id = 'itemname'; // Restore the original id of the select
                customItemInput.name = ''; // Remove the name attribute from the custom input
                customItemInput.id = 'customItemInput'; // Restore the original id of the custom input

                // Set GST and HSN/SAC from selected option
                var selectedOption = select.options[select.selectedIndex];
                // You can add code here to set gstInput and hsnInput based on the selected option if needed
            }
        });

        function getTextContentByClass(className) {
            const element = document.querySelector(`.${className}`);
            return element ? element.innerText : '';
        }

        function handlePaymentMethodChange(select) {
            var value = select.value;
            var customModal = new bootstrap.Modal(document.getElementById('customInputField'));

            if (value === "Cheque" || value === "Account") {
                customModal.show();
            }
        }
        function calculateGrandTotal() {
            var amount = parseFloat($('#amount').val()) || 0; 
            var quantity = parseInt($('#quantity').val()) || 0; 
            var gstRate = parseFloat($('#gst').val()) || 0; 
            var discountPercent = parseFloat($('#discount').val()) || 0; 
            var extraCharges = parseFloat($('#chaAmount').val()) || 0; 

            var subtotal = amount * quantity;
            var gstAmount = (subtotal * gstRate) / 100;
            var totalBeforeDiscount = subtotal + gstAmount + extraCharges;
            var discountAmount = (totalBeforeDiscount * discountPercent) / 100;
            var grandTotal = totalBeforeDiscount - discountAmount;

            $('#grand_total1').val(grandTotal.toFixed(2));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const orderNumberInput = document.getElementById('buyOdrNo');
            
            let currentOrderNumber = parseInt(orderNumberInput.value, 10) || 0;
            
            // Event listener for Previous button
            prevButton.addEventListener('click', function() {
                if (currentOrderNumber > 0) {
                    currentOrderNumber -= 1;
                }
                orderNumberInput.value = currentOrderNumber;
            });

            // Event listener for Next button
            nextButton.addEventListener('click', function() {
                currentOrderNumber += 1;
                orderNumberInput.value = currentOrderNumber;
            });
        });

        // Call calculateGrandTotal whenever quantity or amount changes
        $('#quantity, #amount, #gst, #discount, #chaAmount').on('input', calculateGrandTotal);

        // Call calculateGrandTotal initially to set the value on page load
        $(document).ready(calculateGrandTotal);
        

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

                $("#goods_table tbody tr").each(function() {
                    let amount = parseFloat($(this).find('input[name="itemAmount"]').val()) || 0;
                    let quantity = parseInt($(this).find('input[name="itemQty"]').val()) || 0;
                    let gst = parseFloat($(this).find('input[name="itemGst"]').val()) || 0;
                    // Calculate total amount including GST
                    let itemTotal = amount * quantity;
                    let gstAmount = (itemTotal * gst) / 100;
                    let itemTotalWithGst = itemTotal + gstAmount;
                    grandTotal += itemTotalWithGst;
                });
                grandTotal += chaAmount;
                // Apply discount to grand total
                let discountAmount = grandTotal * (discount / 100);
                grandTotal -= discountAmount;

                $("#grand_total").val(grandTotal.toFixed(2));
            }

            // Event listener for discount input change
            $('#discount').on('input', function() {
                updateGrandTotal();
            });
            $('#chaAmount').on('input', function() {
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
            // $("#category_select").change(function () {
            //     var selectedCategory = $(this).val();

            //     $.ajax({
            //         url: "backend/get_goods_info.php",
            //         method: "POST",
            //         data: { category: selectedCategory },
            //         success: function (data) {
            //             var parsedData = JSON.parse(data);
            //             var categoryInput = $("#category_input");
            //             categoryInput.empty(); // Clear existing options

            //             if (parsedData.length > 0) {
            //                 parsedData.forEach(function (item) {
            //                     var option = $("<option></option>")
            //                         .attr("value", item) // item represents the serialNumber
            //                         .text(item);
            //                     categoryInput.append(option);
            //                 });
            //             } else {
            //                 categoryInput.append(new Option("No Goods Found", ""));
            //             }
            //         },
            //         error: function (jqXHR, textStatus, errorThrown) {
            //             console.error("Error fetching goods info: ", textStatus, errorThrown);
            //         }
            //     });
            // });
            $('#itemname').change(function() {
                let selectedOption = $(this).find('option:selected');
                let hsn = selectedOption.data('hsn');
                let gst = selectedOption.data('gst');
                let type = selectedOption.data('type');

                $('#hsnsac').val(hsn);
                $('#gst').val(gst);
                $('#trackingType').val(type);
            });

            // When quantity input changes
            $('#quantity').on('input', function () {
                var stockCount = parseInt(this.value) || 0;
                var formContainer = $('#formContainer');
                var trackingType = $('#trackingType').val(); // Get tracking type from hidden input

                formContainer.empty(); // Clear existing input fields

                for (var i = 0; i < stockCount; i++) {
                    var serialInputDisabled = (trackingType === 'serial' || trackingType === '') ? '' : 'disabled';
                    var chasisInputDisabled = (trackingType === 'serial' || trackingType === '') ? 'disabled' : '';

                    var formRow = `
                        <div class="form-row col-12 mb-4">
                            <div class="row g-2">
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional serial-input" name="serialNumber[]" placeholder="Serial Number" ${serialInputDisabled}>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="chasisNumber[]" placeholder="Chasis Number" ${chasisInputDisabled}>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="modelNumber[]" placeholder="Model Number" ${chasisInputDisabled}>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="motorNumber[]" placeholder="Motor Number" ${chasisInputDisabled}>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="color[]" placeholder="Color" ${chasisInputDisabled}>
                                </div>
                            </div>
                        </div>
                    `;
                    formContainer.append(formRow);
                }
            });
                                

            $("#button_addgoodsDetails").click(function () {
                var input = $("#category_input").val().trim();
                if (input != "") {
                    $.ajax({
                        url: "backend/purchaseGetGoodsInfo.php",
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
                                        $("#goods_table tbody").append(`
                                            <tr data-id="${item.id}">
                                                <td>${srCounter}</td>
                                                <td><input style="width:300px;" type="text" name="itemName" value="${item.name}"></td>
                                                <input style="width:300px;" type="hidden" id="itemNameSerial" value="${item.serialNumber}">
                                                <input style="width:300px;" type="hidden" id="itemNameChasis" value="${item.chasisNumber}">
                                                <!--<td><textarea style="width:auto; min-height:30px;height: 30px;" name="itemDesc" data-id="${item.id}" placeholder="Description" onchange="updateField(this, 'description')">${item.description}</textarea></td>-->
                                                <td id="targetid" data-id="${item.id}">
                                                    <div class="dropdown">
                                                        <button class="btn border-2 rounded-2 border-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Show Details
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            ${dropdownItems || '<li class="dropdown-item">No Details Available</li>'}
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><input style="width:50px;" type="text" name="itemGst" value="${item.gst}"></td>
                                                <td class="quantity"><input style="width:50px;" type="text" name="itemQty" value="${item.quantity}" data-id="${item.id}" onchange="updateField(this, 'quantity')"></td>
                                                <td class="amount"><input style="width:100px;" type="text" name="itemAmount" value="${item.amount_per_unit}"></td>
                                            </tr>
                                            
                                        `);

                                        updateGrandTotal();


                                        // Add event listener to the newly added quantity, amount, and description inputs
                                        $("#goods_table tbody").on('input', 'input[name="itemAmount"], input[name="itemQty"], input[name="itemDesc"]', function () {
                                            updateGrandTotal();

                                            // Get the closest row and the data-id attribute
                                            var row = $(this).closest('tr');
                                            var id = row.data('id');
                                            
                                            // Get the values from the inputs
                                            var newQuantity = parseInt(row.find('input[name="itemQty"]').val()) || 0;
                                            var newAmount = parseFloat(row.find('input[name="itemAmount"]').val()) || 0;
                                            var newDescription = row.find('textarea[name="itemDesc"]').val() || ''; // Assuming description might be in a textarea

                                            // Find the item in the categorysToSend array and update it
                                            var categoryToSend = categorysToSend.find(b => b.id === id);
                                            if (categoryToSend) {
                                                categoryToSend.quantity = newQuantity;
                                                categoryToSend.amount_per_unit = newAmount;
                                                categoryToSend.description = newDescription; // Update description if applicable
                                            }
                                        });

                                        categorysToSend.push(item);
                                        // console.log(categorysToSend);

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

        
            $('#paymentREF').on('click', function() {
                var referenceValue = $('#modalReferencesInput').val();
                $('#paymentReferences').val(referenceValue);
                $('#customInputField').modal('hide');
            });

            $("#purchase_submit").click(function () {
                var formData = new FormData();
                
                // Common form values
                formData.append('billNo', $("#billNo").val());
                formData.append('discount', $("#discount").val());
                formData.append('buyer_name', $("#buyer_name").val());
                formData.append('buyer_billAddress', $("#billing_field").val());
                formData.append('buyer_shipAddress', $("#shipadd_field").val());
                formData.append('contact_number', $("#contact_number").val());
                formData.append('state', $("#state").val());
                formData.append('gstin', $("#gst_field").val());
                formData.append('paymentMethod2', $("#paymentMethod2").val());
                formData.append('paymentReferences', $("#paymentReferences").val());
                formData.append('buyOdrNo', $("#buyOdrNo").val());
                formData.append('chaAmount', $("#chaAmount").val());
                formData.append('receivedinput', $("#toggle-input").val());
                formData.append('quantity', $("#quantity").val());

                // Append file to FormData
                var othRefInput = document.getElementById('othRef');
                if (othRefInput.files.length > 0) {
                    formData.append('othRef', othRefInput.files[0]);
                }

                // Check which section has the class 'd-flex' and is visible
                var section1Visible = $('#section1').hasClass('d-flex');
                var section2Visible = $('#section2').hasClass('d-flex');

                if (section1Visible) {
                    // Section 1 data
                    formData.append('grand_total', $("#grand_total1").val());

                    // Gather goods data from Section 1
                    var goodsData = [];
                    $('#formContainer .form-row').each(function() {
                        var categoryName = $('#inputGroupSelect02').val();
                        var hsn = $('#hsnsac').val();
                        var gst = $('#gst').val();
                        var amount = $('#amount').val();
                        var quantity = $('#quantity').val();
                        var trackingType = $('#trackingType').val();
                        var quantityPerRow = quantity / $('#formContainer .form-row').length;
                        var serialNumber = $(this).find('input[name="serialNumber[]"]').val();
                        var chasisNumber = $(this).find('input[name="chasisNumber[]"]').val();
                        var modelNumber = $(this).find('input[name="modelNumber[]"]').val();
                        var motorNumber = $(this).find('input[name="motorNumber[]"]').val();
                        var color = $(this).find('input[name="color[]"]').val();

                        var categoryObject = {
                            category: categoryName,
                            name: $('#itemname').val(),
                            description: '', // You can add more details if needed
                            serialNumber: serialNumber,
                            chasisNumber: chasisNumber,
                            modelNumber: modelNumber,
                            motorNumber: motorNumber,
                            color: color,
                            quantity: quantityPerRow,
                            amount_per_unit: amount,
                            gst: gst,
                            trackingType: trackingType,
                            'HSN/SAC': hsn
                        };

                        goodsData.push(categoryObject);
                    });

                    // Append the goods data to the FormData
                    formData.append('goods', JSON.stringify(goodsData));

                } else if (section2Visible) {
                    // Section 2 data
                    formData.append('grand_total', $("#grand_total").val());

                    // Append goods data for Section 2
                    formData.append('goods', JSON.stringify(categorysToSend));
                }
                // function logFormData(formData) {
                //     for (const [key, value] of formData.entries()) {
                //         console.log(`${key}: ${value}`);
                //     }
                // }
                // logFormData(formData);

                // Post data to PHP
                $.ajax({
                    url: "backend/purchaseBack.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Raw response:", response);
                        try {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                alert("Purchase successfully submitted.");
                                // $("#goods_table tbody").empty();
                                // $("#grand_total").text("0.00");
                                location.reload();
                            } else {
                                console.error("Error: ", data.message);
                            }
                        } catch (e) {
                            console.error("Failed to parse response as JSON", e);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error submitting purchase: ", textStatus, errorThrown);
                        console.error("Response Text: ", jqXHR.responseText);
                    }
                });
            });


            // Function to calculate base price from grand total

        });
        

    </script>
    





</body>

</html>