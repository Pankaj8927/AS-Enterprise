<?php
include "backend/db_connection.php";

// Fetch data from your 'sell' table
$sql = "SELECT goodsName, COUNT(*) AS count FROM sell GROUP BY goodsName";
$result1 = mysqli_query($conn, $sql);
// Query to fetch user from database
$query = "SELECT * FROM users WHERE id = '1'";
$result = mysqli_query($conn, $query);
// Prepare data array for JavaScript
$data = array();

// Push column headers first
$data[] = ['Goods Name', 'Sell']; // Header row for Google Charts

// Check if there are results
if (mysqli_num_rows($result1) > 0) {
    // Iterate through results and populate data array
    while ($row = mysqli_fetch_assoc($result1)) {
        $goodsName = $row['goodsName'];
        $count = (int)$row['count']; // Ensure count is integer

        // Adding each goods data as a row in the array
        $data[] = [$goodsName, $count]; // Adjust this based on your actual requirements
    }
} else {
    // If no results, provide default data or a message
    $data[] = ['No Data', 0]; // Example of default data
}

// Convert PHP array to JSON format for JavaScript consumption
$jsonData = json_encode($data);

mysqli_close($conn); // Close connection
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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawMultSeries);
    
    function drawMultSeries() {
        var jsonData = <?php echo $jsonData; ?>; // Inject PHP data into JavaScript

        var data = google.visualization.arrayToDataTable(jsonData);

        var options = {
            title: 'Sell Details of Goods/Products',
            chartArea: {width: '80%'},
            orientation: 'horizontal',  // Set orientation to vertical
            hAxis: {
                title: 'GOODS'
            },
            vAxis: {
                title: 'Count',
                minValue: 0
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

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
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="./sell.php" class="nav-link d-flex align-items-center my-3  p-2 text-light"
                            aria-current="page"><i
                                class="fa-solid fa-file-invoice-dollar me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                style=" height: 30px;width:30px"></i> SELL</a>
                    </li>
                    <li>
                        <a href="./add.php" class="nav-link d-flex align-items-center my-3  p-2 text-light"><i
                                class="fa-solid fa-cart-plus me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                style=" height: 30px;width:30px"></i> ADD PRODUCTS</a>
                    </li>
                    <li>
                        <a href="./details.php"
                            class="nav-link active d-flex align-items-center my-3  p-2 text-light"><i
                                class="bg-dark fa-solid fa-file-lines me-2 bg-primary p-1 rounded-circle d-flex align-items-center justify-content-center"
                                style=" height: 30px;width:30px"></i> SELL DETAILS</a>
                    </li>
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


            <div class="container d-flex justify-content-center align-items-center flex-column flex-grow-1 text-center"
                id="chnageSection">
                <!--Enter your code here for sell  -->
                    <!-- google graph bar -->
                    <div id="chart_div" style="width: 900px; height: 300px;"></div>
                    <div class="container  p-0">
                        <div class="overflow-auto" style="height:250px;">
                        <table class="table table table-striped text-center" id="sellDetails">
                            <thead class="table-primary" style="position:sticky; top:0;">
                                    <tr>
                                    <th >SL NO.</th>
                                    <th >Staff Name</th>
                                    <th >Barcode No.</th>
                                    <th >Goods Name</th>
                                    <th >Amount</th>
                                    <th >Invoice</th>
                                    <th >Delete</th>
                                    </tr>
                                </thead>
                                <tbody >
                                <?php
                                        include "backend/db_connection.php";
                                
                                        // SQL query
                                        $sql = "SELECT id, barcodeNumber, goodsName, goodsAmount, invoiceMakerName, dateTime, invoiceFiles, brand, description FROM sell ORDER BY id DESC";
                                
                                        // Execute query
                                        $result1 = $conn->query($sql);
                                
                                        if ($result1->num_rows > 0) {
                                            // Output data of each row
                                            while($row = $result1->fetch_assoc()) {
                                                echo '<tr scope="row">';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["id"].'">' . $row["id"] . '</td>';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["invoiceMakerName"].'">' . $row["invoiceMakerName"] . '</td>';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["barcodeNumber"].'">' . $row["barcodeNumber"] . '</td>';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["goodsName"].'">' . $row["goodsName"] . '</td>';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["goodsAmount"].'">' . $row["goodsAmount"] . '</td>';
                                                echo '<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" onmouseover="this.style.whiteSpace=\'normal\'; this.style.overflow=\'visible\'; this.style.textOverflow=\'inherit\';" onmouseout="this.style.whiteSpace=\'nowrap\'; this.style.overflow=\'hidden\'; this.style.textOverflow=\'ellipsis\';"title="'.$row["invoiceFiles"].'">';
                                                if (!empty($row["invoiceFiles"])) {
                                                    echo '<a href="invoices/' . $row["invoiceFiles"] . '" style="text-decoration:none; font-weight:600;">VIEW</a>';
                                                }
                                                echo '</td>';
                                                if ($user['status'] === 'active') {
                                                    echo '<td><a href="backend/delete.php?id=' . $row["id"] . '&table=sell" class="link-danger"><i class="fa-solid fa-trash fs-5"></i></a></td>';
                                                }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            // Function to handle live search
            $('#Search').keyup(function(){
                var query = $(this).val().toLowerCase();
                
                $('#sellDetails tbody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
                });
            });
        });
    </script>
</body>

</html>