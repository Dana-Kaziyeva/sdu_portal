<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sdu_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the course ID from the URL
$course_id = $_GET['id'];

// Prepare the SQL query
$sql = "
    SELECT DISTINCT 
        courses.id AS course_id,
        courses.name AS course_name,
        courses.code AS course_code,
        CONCAT(teachers.first_name, ' ', teachers.last_name) AS teacher_name
    FROM 
        courses
    LEFT JOIN 
        teachercourse ON courses.id = teachercourse.course_id
    LEFT JOIN 
        teachers ON teachercourse.teacher_id = teachers.id
    WHERE 
        courses.id = ?
";

$stmt = $conn->prepare($sql); // Prepare the query

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("i", $course_id); // "i" indicates the parameter is an integer

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CSS 465 Project Management Grade</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<!--  TOP BAR-->
<div class="top-bar">
    <div class="left-section">
        <a href="page.php">
            <img src="assets/images/logo_sdu_general.png" alt="Logo" class="logo-img">
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

<!--MAIN PART-->
<div class="main-container">
    <div class="rectangle-2" style="height: 800px">
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch only one row
            echo "
        <div class='course-container'>
            <span class='coursepage-title'>" . htmlspecialchars($row['course_code']) . " - " . htmlspecialchars($row['course_name'])  . " (" . htmlspecialchars(isset($row['teacher_name']) ? $row['teacher_name'] : 'No teacher assigned') . ")" ."</span>
        </div>
    ";
        } else {
            echo "<p>No course found.</p>";
        }
        ?>

        <div class="progress-container">
            <span class="total">Total Grade: 1.85</span>
            <div class="progress-bar">
                <div class="divider"></div>
<!--                <div class="progress-fill" ></div>-->
            </div>
            <span id="percentage">0%</span>
        </div>
        <div class="rectangle-g" >
            <div class="flex-row">
              <span class="grade-item">Grade item</span
              ><span class="grade">Grade</span><span class="grade-1">Grade</span
                ><span class="feedback">Feedback</span>
            </div>
            <div class="flex-row-ddd">
                <span class="activity">Activity</span>
                <div class="rectangle2-2"><div class="icon-graph"></div></div>
                <span class="number">1</span><span class="week-1">Week 1</span
                ><span class="percent">100.00 %</span>
            </div>
            <div class="line"></div>
            <div class="flex-row-3">
                <span class="activity-4">Activity</span>
                <div class="rectangle-5"><div class="icon-6"></div></div>
                <span class="week">Week 2</span
                ><span class="percentage-7">85.00 %</span
                ><span class="dot">0.85</span>
            </div>
            <div class="line-8"></div>
            <div class="flex-row-fac">
              <span class="course-total">Course total</span
              ><span class="dash">-</span><span class="number-1-85">1.85</span>
                <div class="icon-9"></div>
            </div>
        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggleAllBtn').click(function() {
            const isExpanded = $('.accordion-collapse.show').length === $('.accordion-collapse').length; // Check if any item is expanded

            if (isExpanded) {
                // If any item is expanded, collapse all and change button text
                $('.accordion-collapse').collapse('hide');
                $(this).text('Expand All');
            } else {
                // If all items are collapsed, expand all and change button text
                $('.accordion-collapse').collapse('show');
                $(this).text('Close All');
            }
        });
    });
</script>

</body>
</html>