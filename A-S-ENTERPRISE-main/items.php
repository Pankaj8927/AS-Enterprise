<?php 
    include 'backend/db_connection.php';
    session_start();
    // Check if the user is verified
    if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
        header("Location: OTP.php");
        exit();
    }
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
                            <a href="./items.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-shapes me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                        <input type="text" style="width:40%"class="form-control border border-primary border-2 text-custom" required id="Search" placeholder="Search......" aria-label="Search">&nbsp;
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
                    <div class="container-fluid  d-flex justify-content-center align-items-center">
                    <div class="overflow-auto d-flex align-items-center flex-column" style="width:100%; height:80vh;">
                        <div class="input-group" style="width:60%;">
                            <select class="form-select border-primary" id="receiveInput2" aria-label="Example select with button addon">
                                <option value="" selected>Category...</option>
                                <?php
                                // Fetch all unique names from the goods table
                                $sqlCat = "SELECT DISTINCT name FROM goods";
                                $resultCat = $conn->query($sqlCat);

                                if ($resultCat->num_rows > 0) {
                                    // Loop through the results and generate options
                                    while ($row = $resultCat->fetch_assoc()) {
                                        $name = htmlspecialchars($row['name']);
                                        echo '<option value="' . $name . '">' . $name . '</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>No goods found</option>';
                                }
                                ?>
                            </select>
                            <button class="btn btn-outline-primary rounded-2" id="showButton2" type="button">SHOW</button>
                            <input class="form-control" style="width:50px;"id="quantityInput" type="text" placeholder="Quantity" aria-label="quantity input example">

                        </div>

                        
                        <table class="table table-striped text-center" id="itemsDetails" style="width:100%; height:auto;">
                            <thead class="table-primary" style="position:sticky; top:0;">
                                <tr>
                                    <th>SL NO.</th>
                                    <th>Category</th>
                                    <th>Item Name</th>
                                    <th>Tracking Type</th>
                                    <th>Serial / Chasis No.</th>
                                    <th>Quantity</th> 
                                    <th>HSN/SAC Number</th>
                                    <th>GST</th>
                                    <th>Amount</th>
                                    <th>Edit/Delete</th>
                                </tr>
                            </thead>
                            <tbody > 
                            <?php                        
                                $sql = "SELECT * FROM goods ORDER BY (quantity >= 1) DESC, id DESC";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<tr scope="row">';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 50px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["id"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["category"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["name"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["trackingType"] .'</td>';
                                        if ($row['trackingType'] === 'serial') {
                                            echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["serialNumber"] .'</td>';
                                        }
                                        elseif ($row['trackingType'] === 'chasis') {
                                            echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">' . $row["chasisNumber"] .'</td>';
                                        }
                                        else {
                                            echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">No Data Available/td>';
                                        }
                                        
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["quantity"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["HSN/SAC"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["gst"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';">'. $row["amount"] .'</td>';
                                        echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">';
                                                if ($user['status'] === 'active') {
                                                    echo '<a class="edit-button" data-id="'.$row['id'].'" data-category="'. $row["category"] .'" data-name="' . $row["name"] .'" data-description="' . $row["description"] .'" data-quantity="'. $row["quantity"] .'" data-hsn-sac="'. $row["HSN/SAC"] .'" data-gst="'. $row["gst"] .'" data-amount="'. $row["amount"] .'" type="button" data-toggle="modal" data-target="#editModalCenter" href="" class="link-dark">
                                                            <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                                                         </a>
                                                        <a href="backend/delete.php?id=' . $row["id"] . '&table=goods" class="link-danger">
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
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['goods_update'])) {
                                        // Assuming $conn is your database connection

                                        // Retrieve form data
                                        $Name = $_POST['itemname'];
                                        $Category = $_POST['categoryName'];
                                        $GST = $_POST['GST'];
                                        $Amount = $_POST['Amount'];
                                        $HSN_SCA = $_POST['hsnsac'];
                                        $Description = $_POST['description'];
                                        $Quantity = $_POST['quantity'];
                                        $id = $_POST['id']; // Assuming you have a hidden field in your form for the party ID

                                        // Update query
                                        $sql = "UPDATE goods 
                                                SET category = '$Category', 
                                                    name = '$Name', 
                                                    amount = '$Amount', 
                                                    gst = '$GST', 
                                                    description = '$Description', 
                                                    `HSN/SAC` = '$HSN_SCA', 
                                                    quantity = '$Quantity'
                                                WHERE id = $id";

                                        // Execute query
                                        if (mysqli_query($conn, $sql)) {
                                            echo "<script>
                                                if (confirm('Items updated successfully.')) {
                                                    window.location.href = './items.php';
                                                } else {
                                                    window.location.href = './index.php'; // Redirect to a different page
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
                                                <!-- <select class="form-select border-primary border-2" name="categoryName"id="inputGroupSelect02"
                                                     onchange="handleSelectChange(this)"> -->
                                                <select  id="inputGroupSelect02" name="categoryName" class="col form-select border-primary border-2" aria-label="Default select example" onchange="handleSelectChange(this)">
                                                    <option id="goodsCategory"></option>
                                                    <option value="custom">Add New Category</option>
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
                                            <div class="mb-4">
                                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                                    id="goodsName"name="itemname" placeholder="Item Name" aria-label="Item Name">
                                            </div>
                                            <div class="mb-4">
                                                <input type="text" class="form-control border border-primary border-2 text-custom"
                                                   id="goodsQuantity" name="quantity" placeholder="Quantity" aria-label="Quantityr">
                                            </div>
                                        </div>
                                        <div class="col">
                                        <div class="mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                                id="goodsHSN_SAC"name="hsnsac" placeholder="HSN/SAC Number" aria-label="HSN/SAC Number">
                                        </div>

                                        <div class="mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                               id="goodsGST" name="GST" placeholder="GST" aria-label="GST">
                                        </div>
                                        <div class="mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                                id="goodsAmount"name="Amount" placeholder="Amount" aria-label="Amount">
                                        </div>
                                        
                                        </div>
                                        <div class="mb-4">
                                                <textarea type="text" class="form-control border border-primary border-2 text-custom"
                                                    id="goodsDescription"name="description" placeholder="Goods Description" aria-label="Goods Description" style="height:100px;"></textarea>
                                        </div>
                                        <!-- <p class="fw-normal fs-9 text-center p-3">Please ensure the add product
                                            correctly. Incomplete or inaccurate information may result in delays,
                                            penalties, or the
                                            rejection of your tax invoice. Double-check all entries to avoid any
                                            discrepancies and
                                            ensure smooth processing.</p> -->
                                        <div class="col">
                                            <button type="submit" id="goods_update" name="goods_update"
                                                class="col btn btn-primary fs-5 rounded-5" style="width:100%;">
                                                UPDATE</button>
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

                </div>
            </div>
            
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        function handleSelectChange(select) {
            var value = select.value;
            if (value === "custom") {
                window.location.href = "add.php";
            }
        }
    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
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
    </script>
<script>
        $(document).ready(function () {
            $('#Search').keyup(function(){
                var query = $(this).val().toLowerCase();
                
                $('#itemsDetails tbody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
                });
            });
            $('#showButton2').click(function() {
                var selectedName = $('#receiveInput2').val();

                if (selectedName) {
                    $.ajax({
                        url: 'backend/fetch_quantity.php', // Path to the PHP file
                        type: 'POST',
                        data: { name: selectedName },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#quantityInput').val('Quantity '+response.totalQuantity);
                            } else {
                                $('#quantityInput').val('Error');
                                console.error('Failed to fetch quantity:', response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#quantityInput').val('Error');
                            console.error("An error occurred:", error);
                        }
                    });
                } else {
                    alert('Please select a category.');
                }
            });
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
                    url: 'category.php', // Your server-side script
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
            // Use event delegation to handle dynamically created elements
            $('.edit-button').on('click', function(event) {
                event.preventDefault(); // Prevent the default action

                // Retrieve data from the clicked element using the data attributes
                var dataId = $(this).data('id');
                var dataCategory = $(this).data('category');
                var dataName = $(this).data('name');
                var dataDescription = $(this).data('description');
                var dataQuantity = $(this).data('quantity');
                var dataGst = $(this).data('gst');
                var dataAmount = $(this).data('amount');
                var dataHSN_SAC = $(this).data('hsn-sac');

                // Set the modal title or any other fields in the modal with the retrieved data
                $('#exampleModalLongTitle').text('Edit "' + dataName + '" Details');

                // Fill in other fields in the modal as needed
                $('#idField').val(dataId);
                $('#goodsCategory').text(dataCategory);
                $('#goodsName').val(dataName);
                $('#goodsDescription').val(dataDescription);
                $('#goodsQuantity').val(dataQuantity);
                $('#goodsGST').val(dataGst);
                $('#goodsAmount').val(dataAmount);
                $('#goodsHSN_SAC').val(dataHSN_SAC);

            });
        });
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>