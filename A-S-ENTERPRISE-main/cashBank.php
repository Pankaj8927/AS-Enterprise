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
                            <a href="./cashBank.php" class="active nav-link d-flex align-items-center me-1 p-2 text-light"><i
                                    class="bg-dark fa-solid fa-building-columns me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
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
                <div class="d-flex justify-content-top align-items-center flex-column text-center p-0"
                    style="width:100%;height:100%">
                    <div class="row row-cols-1 g-2 w-100 mt-2 h-100 d-flex justify-content-top">
                        <div class="col container d-flex justify-content-between align-items-center text-start"style="height:22vh">
                            <div>
                                <?php
                                    $CompnayDetailsSQL = "SELECT * FROM companydetails WHERE id = '1'";
                                    $CompnayDetailsRESULT = mysqli_query($conn, $CompnayDetailsSQL);

                                    if ($CompnayDetailsRESULT) {
                                        $companyDetails = mysqli_fetch_assoc($CompnayDetailsRESULT);
                                        if ($companyDetails) {
                                            echo '<p class="text-custom m-0 p-0 fw-bolder"><span>';
                                            // Check if user status is inactive
                                            if ($user['status'] === 'active') {
                                                echo '<i class="fa-solid fa-pen-to-square" type="button" data-bs-toggle="modal" data-bs-target="#editBankModalCenter"></i>';
                                            }
                                            echo ' Bank Name: ' . htmlspecialchars($companyDetails['CompanyBankName']) . '</span></p>';
                                            echo '<p class="text-custom m-0 p-0 fw-normal"><span>Account Number: ' . htmlspecialchars($companyDetails['CompanyBankAccountNumber']) . '</span></p>';
                                            echo '<p class="text-custom m-0 p-0 fw-normal"><span>IFS Code: ' . htmlspecialchars($companyDetails['CompanyBankIFSC']) . '</span></p>';
                                            echo '<p class="text-custom m-0 p-0 fw-normal"><span>Branch: ' . htmlspecialchars($companyDetails['CompanyBranch']) . '</span></p>';
                                            echo '<p class="text-custom m-0 p-0 fw-normal"><span>UPI ID: ' . htmlspecialchars($companyDetails['CompanyUPI']) . '</span></p>';
                                        } else {
                                            echo '<p>No company details found.</p>';
                                        }
                                    } else {
                                        echo '<p>Failed to fetch company details.</p>';
                                    }
                                ?>
                            </div>
                            <div class="d-flex flex-column align-items-start">
                                <div class=" form-check form-check-inline">
                                    <input class="form-check-input border border-primary" type="radio" name="paymentFilter" id="allFilter" value="All" checked onclick="filterTable('All')">
                                    <label class="text-start form-check-label btn btn-sm btn-primary" style="width:100px;" for="allFilter">All</label>
                                </div>
                                <div class=" form-check form-check-inline">
                                    <input class="form-check-input border border-primary" type="radio" name="paymentFilter" id="cashFilter" value="Cash" onclick="filterTable('Cash')">
                                    <label class="text-start form-check-label btn btn-sm btn-primary" style="width:100px;" for="cashFilter">Cash</label>
                                </div>
                                <div class=" form-check form-check-inline">
                                    <input class="form-check-input border border-primary" type="radio" name="paymentFilter" id="accountFilter" value="Account" onclick="filterTable('Account')">
                                    <label class="text-start form-check-label btn btn-sm btn-primary" style="width:100px;" for="accountFilter">Account</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="overflow-auto col w-100 d-flex align-items-center flex-column" style="height:60vh;">
                            <table class="table table-striped text-center" id="itemsDetails" style="width:100%; height:auto;">
                                <thead class="table-primary" style="position:sticky; top:0;">
                                    <tr>
                                        <th>SL NO.</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment References</th>
                                        <th>Parties Name</th>
                                        <th>Parties Contact Number</th>
                                        <th>Amount</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = "SELECT dateTime, partiesName, phoneNumber, paymentMethod, paymentReference, SUM(clearAmount) as totalClearAmount
                                            FROM ladger 
                                            GROUP BY partiesName, phoneNumber, paymentMethod
                                            ORDER BY id DESC";
                                    $result = $conn->query($sql);
                                    $sl_no = 1;

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $sl_no++ . '</td>';
                                            echo '<td>' . htmlspecialchars($row["dateTime"]) . '</td>';
                                            echo '<td>' . htmlspecialchars($row["paymentMethod"]) . '</td>';
                                            echo '<td>' . htmlspecialchars($row["paymentReference"]) . '</td>';
                                            echo '<td>' . htmlspecialchars($row["partiesName"]) . '</td>';
                                            echo '<td>' . htmlspecialchars($row["phoneNumber"]) . '</td>';
                                            echo '<td>' . htmlspecialchars($row["totalClearAmount"]) . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No results found</td></tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- edit bank details modal -->
                    <div class="modal fade" id="editBankModalCenter" tabindex="-1" role="dialog" aria-labelledby="editBankModalCenter" aria-hidden="true" style="width:100%">
                        <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center flex-grow-1 text-center" role="document" style="max-width:60%; width:auto;">
                            <div class="modal-content" style="width: 150vh;">
                                <div class="modal-header bg-primary text-light">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Bank Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                <?php
                                    if (isset($_POST['update_bank_details'])) {
                                        // Fetch the new details from the form and escape them
                                        $bankName = mysqli_real_escape_string($conn, $_POST['CompanyBankName']);
                                        $accountNumber = mysqli_real_escape_string($conn, $_POST['CompanyBankAccountNumber']);
                                        $ifsc = mysqli_real_escape_string($conn, $_POST['CompanyBankIFSC']);
                                        $branch = mysqli_real_escape_string($conn, $_POST['CompanyBranch']);
                                        $upi = mysqli_real_escape_string($conn, $_POST['CompanyUPI']);

                                        // Update the database
                                        $updateSQL = "UPDATE companydetails SET CompanyBankName = '$bankName', CompanyBankAccountNumber = '$accountNumber', CompanyBankIFSC = '$ifsc', CompanyBranch = '$branch', CompanyUPI = '$upi' WHERE id = '1'";

                                        if (mysqli_query($conn, $updateSQL)) {
                                            // Redirect or provide success message
                                            echo "<script>window.location.href = window.location.href;</script>";
                                        } else {
                                            // Handle error
                                            echo "<script>alert('Error updating bank details: " . mysqli_error($conn) . "');</script>";
                                        }

                                    }
                                    ?>
                                    <form action="" method="POST" id="editBank_form" class="row row-cols-3" style="width: 100%;">
                                        <div class="col mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                                id="CompanyBankName" name="CompanyBankName" placeholder="Bank Name" aria-label="Bank Name"
                                                value="<?php echo htmlspecialchars($companyDetails['CompanyBankName']); ?>">
                                        </div>
                                        <div class="col mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                                id="CompanyBankAccountNumber" name="CompanyBankAccountNumber" placeholder="Account Number" aria-label="Account Number"
                                                value="<?php echo htmlspecialchars($companyDetails['CompanyBankAccountNumber']); ?>">
                                        </div>
                                        <div class="col mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                            id="CompanyBankIFSC" name="CompanyBankIFSC" placeholder="IFS Code" aria-label="IFS Code"
                                            value="<?php echo htmlspecialchars($companyDetails['CompanyBankIFSC']); ?>">
                                        </div>
                                        <div class="col mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                                id="CompanyBranch" name="CompanyBranch" placeholder="Branch" aria-label="Branch"
                                                value="<?php echo htmlspecialchars($companyDetails['CompanyBranch']); ?>">
                                        </div>
                                        <div class="col mb-4">
                                            <input type="text" class="form-control border border-primary border-2 text-custom"
                                            id="CompanyUPI" name="CompanyUPI" placeholder="UPI ID" aria-label="UPI ID"
                                            value="<?php echo htmlspecialchars($companyDetails['CompanyUPI']); ?>">
                                        </div>
                                        <div class="col mb-4">
                                            <button type="submit" name="update_bank_details" class="col btn btn-primary fs-5 rounded-5" style="width:100%;">
                                                UPDATE
                                            </button>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <script>
        function filterTable(paymentMethod) {
            var rows = document.querySelectorAll("tbody tr");
            rows.forEach(function(row) {
                var paymentMethodCell = row.querySelector("td:nth-child(3)").innerText;
                if (paymentMethod === "All" || paymentMethodCell === paymentMethod || (paymentMethod === "Account" && (paymentMethodCell === "Cheque" || paymentMethodCell === "Account"))) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>