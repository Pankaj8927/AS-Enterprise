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
    $stmt = $conn->prepare("SELECT DISTINCT name, HSNSAC as hsn_sac, gst FROM items WHERE category = ?");
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
                            <a href="./add.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-truck-ramp-box me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                            <li class="nav-item text-center">
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
            <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 text-center"
                id="chnageSection">
                <!--Enter your code here for sell  -->
                <div class="container p-2 d-flex justify-content-center align-items-center">
                    <form action="backend/adproduct.php" method="POST" id="goods_form" class="row row-cols-3 d-flex align-items-center justify-content-center" style="width: 100%;">
                        <div class="col mb-4">
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

                        <div class="col mb-4" id="selectDiv">
                            <select class="form-select border border-primary border-2 text-custom" name="itemname" id="itemname" required>
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
                                                `<option value="${item.name}" data-hsn="${item.hsn_sac}" data-gst="${item.gst}">${item.name}</option>`
                                            );
                                        });
                                    },
                                    error: function() {
                                        alert('Failed to fetch items.');
                                    }
                                });
                            }
                        </script>
                        <div class="col mb-4" id="customInputDiv" style="display: none;">
                            <input type="text" class="form-control border border-primary border-2 text-custom" id="customItemInput" placeholder="Enter custom item name">
                        </div>
                        <div class="col mb-4">
                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                name="hsnsac" id="hsnsac" placeholder="HSN/SAC Number" aria-label="HSN/SAC Number" >
                        </div>
                        <div class="col mb-4">
                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                name="GST" id="gst" placeholder="GST" aria-label="GST" >
                        </div>

                        <div class="col mb-4">
                            <input type="text" id="stockInput" class="form-control border border-primary border-2 text-custom"
                                name="stock" placeholder="Stock" aria-label="stock">
                        </div>
                        <div class="col mb-4 d-flex flex-row align-items-center justify-content-around">
                            <div class="form-check">
                                <input class="form-check-input border border-primary border-2" type="radio" name="trackingType" id="serialTracking" value="serial">
                                <label class="form-check-label" for="serialTracking">
                                    Serial No. Tracking 
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border border-primary border-2" type="radio" name="trackingType" id="chasisTracking" value="chasis">
                                <label class="form-check-label" for="chasisTracking">
                                    Chasis No. Tracking 
                                </label>
                            </div>
                        </div>
                        <div class="overflow-auto row border border-2 border-secondary p-2" style="width:100%; height:50vh">
                            <div id="formContainer" class="row">
                                <div class="col-12 mb-4">
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
                        <div class="row align-items-center g-2 justify-content-end mt-2" style="width:100%;">
                            <div class="col m-1">
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary" id="prevButton">Previous</button>
                                    <input type="text" id="orderNumber" class="form-control border border-primary border-2 text-primary"
                                        name="orderNumber" placeholder="Order Number" aria-label="orderNumber" readonly value="<?php echo $lastOrderNumber;?>">
                                    <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                                </div>
                            </div>

                            <div class="col m-1">
                                <input type="text" id="amount" class="form-control border border-primary border-2 text-custom"
                                    name="amount" placeholder="Amount per pcs" aria-label="Amount">
                            </div>

                            <button type="submit" id="goods_submit" name="goods_submit"class="col m-1 btn btn-primary fs-5 rounded-5">Add Goods</button>
                            <button type="submit" id="items_submit" name="items_submit"class="col m-1 btn btn-primary fs-5 rounded-5">Add Items</button>
                        </div>                    

                    </form>
                    </br>

                    <!-- Category Modal -->
                    <div class="modal fade" id="customInputField" tabindex="-1" role="dialog"
                        aria-labelledby="customModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="customModalLabel">Add New Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <!-- <form id="categoryForm"> -->
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <input type="text"
                                            class="form-control border border-primary border-2 text-custom"
                                            name="category" placeholder="Category" aria-label="Category">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="addCat">ADD
                                        CATEGORY</button>
                                </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div><br>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function handleSelectChange(select) {
            var value = select.value;
            var customModal = new bootstrap.Modal(document.getElementById('customInputField'));

            if (value === "custom") {
                customModal.show();
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
                customItemInput.name = 'itemname'; // Change the name of the input to 'itemname'
                hsnInput.value = ''; // Clear HSN field for custom input
                gstInput.value = ''; // Clear GST field for custom input
            } else {
                selectDiv.style.display = 'block'; // Show the select dropdown
                customInputDiv.style.display = 'none'; // Hide the custom input field
                customItemInput.value = ''; // Reset the custom input field
                customItemInput.required = false;
                select.name = 'itemname'; // Restore the original name of the select
                customItemInput.name = ''; // Remove the name attribute from the custom input

                // Set GST and HSN/SAC from selected option
                var selectedOption = select.options[select.selectedIndex];
                hsnInput.value = selectedOption.getAttribute('data-hsn') || ''; // Fill HSN
                gstInput.value = selectedOption.getAttribute('data-gst') || ''; // Fill GST
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const orderNumberInput = document.getElementById('orderNumber');
            
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
        document.addEventListener('DOMContentLoaded', function() {
            const stockInput = document.getElementById('stockInput');
            const primaryButton = document.getElementById('goods_submit');
            const secondaryButton = document.getElementById('items_submit');
            const elementsToDisable = document.querySelectorAll('.additional');

            function updateUI() {
                if (stockInput.value.trim() === '') {
                    primaryButton.disabled = true;
                    secondaryButton.disabled = false;
                    stockInput.removeAttribute('required');

                    elementsToDisable.forEach(element => {
                        element.disabled = true;
                    });
                } else {
                    primaryButton.disabled = false;
                    secondaryButton.disabled = true;
                    stockInput.setAttribute('required', 'required');

                    elementsToDisable.forEach(element => {
                        element.disabled = false;
                    });
                }
            }

            stockInput.addEventListener('input', updateUI);

            // Initialize the UI on page load
            updateUI();
        });
    </script>
     <script>
        $(document).ready(function () {
            // Add input event listener to the stockInput field
            // $('#stockInput').on('input', function () {
            //     if ($(this).val().trim() !== '') {
            //         toggleInputFields();
            //     }
            // });

            // Add change event listener to the radio buttons
            $('input[name="trackingType"]').on('change', function () {
                if ($('#stockInput').val().trim() !== '') {
                    toggleInputFields();
                }
            });

            function toggleInputFields() {
                if ($('#serialTracking').is(':checked')) {
                    // Disable Chasis-related inputs
                    $('.chasis-input').prop('disabled', true);
                    // Enable Serial-related inputs
                    $('.serial-input').prop('disabled', false);
                } else if ($('#chasisTracking').is(':checked')) {
                    // Enable Chasis-related inputs
                    $('.chasis-input').prop('disabled', false);
                    // Disable Serial-related inputs
                    $('.serial-input').prop('disabled', true);
                }
            }

            $('#stockInput').on('input', function () {
                var stockCount = parseInt(this.value) || 0;
                var formContainer = $('#formContainer');

                formContainer.empty(); // Clear existing input fields

                for (var i = 0; i < stockCount; i++) {
                    var formRow = `
                        <div class="col-12 mb-4">
                            <div class="row g-2">
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional serial-input" name="serialNumber[]" placeholder="Serial Number" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="chasisNumber[]" placeholder="Chasis Number" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="modelNumber[]" placeholder="Model Number" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="motorNumber[]" placeholder="Motor Number" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control border border-primary border-2 text-custom additional chasis-input" name="color[]" placeholder="Color" required>
                                </div>
                            </div>
                        </div>
                    `;
                    formContainer.append(formRow);
                }
            });

            $('#goods_form').on('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serializeArray();
                var jsonData = {};
                var formContainerData = [];

                $.each(formData, function (i, field) {
                    if (field.name.endsWith('[]')) {
                        if (!jsonData[field.name]) {
                            jsonData[field.name] = [];
                        }
                        jsonData[field.name].push(field.value);
                    } else {
                        jsonData[field.name] = field.value;
                    }
                });

                // Separate formContainer data from other data
                formContainerData = {
                    serialNumber: jsonData['serialNumber[]'],
                    chasisNumber: jsonData['chasisNumber[]'],
                    modelNumber: jsonData['modelNumber[]'],
                    motorNumber: jsonData['motorNumber[]'],
                    color: jsonData['color[]']
                };

                // Remove formContainer data from jsonData
                delete jsonData['serialNumber[]'];
                delete jsonData['chasisNumber[]'];
                delete jsonData['modelNumber[]'];
                delete jsonData['motorNumber[]'];
                delete jsonData['color[]'];

                jsonData['formContainerData'] = formContainerData;
                // console.log(jsonData);

                $.ajax({
                    url: 'backend/adproduct.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(jsonData),
                    success: function (response) {
                        // console.log(response); // Log the response for debugging
                        
                        // Parse the JSON response
                        var jsonResponse = JSON.parse(response);
                        
                        // Check if the response status is success
                        if (jsonResponse.status === 'success') {
                            alert('Successfully added goods!');

                            // Reset the form
                            document.getElementById('goods_form').reset();
                        } else {
                            alert('Failed to add goods: ' + jsonResponse.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('An error occurred while adding goods. Please try again.');
                    }
                });

            });

            $('#items_submit').click(function(e) {
                e.preventDefault(); // Prevent the default form submission

                const categoryName = $('#inputGroupSelect02').val();
                const itemName = $('#itemname').val() === 'custom' ? $('#customItemInput').val() : $('#itemname').val();
                const hsnSac = $('#hsnsac').val();
                const gst = $('#gst').val();
                // const stock = $('#stockInput').val();
                const trackingType = $('input[name="trackingType"]:checked').val();

                $.ajax({
                    url: 'backend/add_item.php',
                    type: 'POST',
                    data: {
                        categoryName: categoryName,
                        itemName: itemName,
                        hsnSac: hsnSac,
                        gst: gst,
                        // stock: stock,
                        trackingType: trackingType
                    },
                    success: function(response) {
                        alert(response); // Display the response from the server
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>