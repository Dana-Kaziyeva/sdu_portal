<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['order_type'] = $_POST['order_type'];
    $_SESSION['language'] = $_POST['language'];
    $_SESSION['delivery_method'] = $_POST['delivery_method'];

    $servername = "localhost"; 
    $username = "root";       
    $password = "";            
    $dbname = "sdu_portal";        

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $order_type = $_SESSION['order_type'] ?? '';
    $language = $_SESSION['language'] ?? '';
    $delivery_method = $_SESSION['delivery_method'] ?? '';

    if (!empty($order_type) && !empty($language) && !empty($delivery_method)) {  
        $sql = "INSERT INTO orders (type, language, delivery_method) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $order_type, $language, $delivery_method);
            if ($stmt->execute()) {
                header('Location: success_page.html');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Online Services</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css" />
</head>
<body>
    <!--  TOP BAR-->
    <div class="top-bar">
        <div class="left-section">
            <a href="../dashboard/page.php">
                <img src="assets/logo_sdu_general.png" alt="Logo" class="logo-img">
            </a>
        </div>
        <ul class="nav" style="width: 20%; padding-left: 4%;">
            <li class="nav-item dropdown" style="margin-left: 10%;">
                <a class="nav-link" href="#" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell-o icon"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdown1">
                    <li><a class="dropdown-item" href="#">Notification 1</a></li>
                    <li><a class="dropdown-item" href="#">Notification 2</a></li>
                    <li><a class="dropdown-item" href="#">Notification 3</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" style="margin-left: -14%;">
                <a class="nav-link" href="#" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-comment-o icon"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdown2">
                    <li><a class="dropdown-item" href="#">Message 1</a></li>
                    <li><a class="dropdown-item" href="#">Message 2</a></li>
                    <li><a class="dropdown-item" href="#">Message 3</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown" style="margin-left: -14%;">
                <a class="nav-link" href="#" id="dropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user-o icon"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdown3">
                    <li><a class="dropdown-item" href="../profile/profile.php">My Profile</a></li>
                    <li><a class="dropdown-item" href="../dashboard/page.php">My Dashboard</a></li>
                    <li><a class="dropdown-item" href="../login/login.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div style="padding-top: 10% ">
        <span class="online-services">Online services</span>
    </div>
<!--    <span class="online-services">Online services</span>-->
    <div class="flex-row-d">
        <div class="rectangle-2">
            <span class="send-order">Send order</span>
        </div>
<!--        <div class="rectangle-3"><span class="orders">Orders</span></div>-->
    </div>

    <form action="" method="POST">
        <div class="rectangle-service" id="form1">
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Order type</span>
                </button>
                <div class="rectangle-5">
                    <select id="orderType" name="order_type" class="rectangle-6" onchange="updateDescription()">
                        <option value=""></option>
                        <option value="Transcript">Transcript</option>
                        <option value="Military Service(Certificate №3)">Military Service(Certificate №3)</option>
                        <option value="Information about Studying Place(University)">Information about Studying Place(University)</option>
                    </select>
                </div>
            </div>
            <div class="flex-row">
                <button class="rectangle-4">
                    <span class="title">Description of Document</span>
                </button>
                <div class="rectangle-5" id="description"></div>
            </div>      
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Language</span>
                </button>
                <div class="rectangle-5">
                    <select name="language" class="rectangle-6">
                        <option value=""></option>
                        <option value="kz">Kazakh</option>
                        <option value="rus">Russian</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
            <div class="flex-row">
                <button type="button" class="rectangle-4">
                    <span class="title">Delivery Method</span>
                </button>
                <div class="rectangle-5">
                    <select name="delivery_method" class="rectangle-6">
                        <option value=""></option>
                        <option value="Advising Desk">Advising Desk</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="rectangle-11"><span class="send">Send</span></button>
        </div>
    </form>

    <div class="rectangle-service" id="form2" style="display: none">
        <div class="rectangle-50">
            <div class="image"></div>
            <span class="order-successfully-sent">Order successfully sent!</span>
        </div>
    </div>

    <!--      FOOTER -->
    <div class="rectangle-14">
        <div class="line-15"></div>
        <div class="flex-container">
            <div class="flex-columns">
                <span class="titles">SDU UNIVERSITY</span>
                <a href="https://sdu.edu.kz/language/en/about-us-3/">
                    <span class="nodes">About us</span>
                </a>
                <a href="https://sdukzlinks.tilda.ws/">
                    <span class="nodes">Connect to us</span>
                </a>
            </div>

            <div class="flex-columns">
                <span class="titles">FACULTIES</span>
                <a href="https://sdu.edu.kz/language/en/business-school/">
                    <span class="nodes">SDU BUSINESS SCHOOL</span>
                </a>
                <a href="https://sdu.edu.kz/language/en/engineering-and-natural-sciences/">
                    <span class="nodes">FACULTY OF ENGINEERING <br />AND NATURAL SCIENCES</span>
                </a>
                <a href="https://sdu.edu.kz/language/en/education-and-humanities/">
                    <span class="nodes">FACULTY OF EDUCATION <br />AND HUMANITIES</span>
                </a>
                <a href="https://sdu.edu.kz/language/en/law-social-science/">
                    <span class="nodes">FACULTY OF LAW AND <br />SOCIAL SCIENCES</span>
                </a>
            </div>

            <div class="flex-columns">
                <span class="titles">RULES</span>
                <a href="https://sdu.edu.kz/language/en/rules/">
                    <span class="nodes">Charter</span>
                </a>
                <a href="https://sdu.edu.kz/language/en/rules/">
                    <span class="nodes">Safety rules</span>
                </a>
            </div>

            <div class="flex-columns">
                <span class="titles">ADDRESS</span>
                <span class="nodes">Almaty region, Karasai district.</span>
                <span class="nodes">040900, city of Kaskelen, st. <br />Abylai Khan 1/1</span>
            </div>
        </div>
        <div class="line-17"></div>
        <div class="flex-row-daab">
            <div>
                <i class="material-icons" >language</i>
                <span class="nodes">SDU UNIVERSITY</span>
            </div>
            <div>
                <i class="material-icons" >phone</i>
                <span class="nodes">Mobile: + 7 727 307 9565</span>
            </div>
            <div>
                <i class="material-icons" >mail_outline</i>
                <span class="nodes">cdl@sdu.edu.kz</span>
            </div>
        </div>
        <span class="copyright-reserved">Copyright © All right reserved SDU University</span>
    </div>

    <script>
        function updateDescription() {
            const orderType = document.getElementById("orderType").value;
            const description = document.getElementById("description");

            const descriptions = {
                "Transcript": "Grades",
                "Military Service(Certificate №3)": "Military Service Proof",
                "Information about Studying Place(University)": "University Enrollment Details"
            };

            description.textContent = descriptions[orderType] || "";
        }
    </script>
</body>
</html>

