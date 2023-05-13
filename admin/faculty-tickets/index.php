<!DOCTYPE html>
<html lang="en">

<?php
require('../../essentials/_config.php');

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6d20788c52.js" crossorigin="anonymous"></script>
    <!-- <link rel="shortcut icon" href="img/fav.png" type="image/x-icon"> -->

    <link rel="stylesheet" href="/lab/style.css">
    <link rel="stylesheet" href="../style.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <title>Admin | Home</title>
    <style>
        #popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }

        #popup .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 500px;
            height: 500px;
            overflow: auto;
        }

        #popup .popup-content .close {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 20px;
            cursor: pointer;
        }

        #popup .popup-content .close:hover {
            color: red;
        }

        #popup .popup-content .popup-body {
            padding: 20px;
        }

        #reason {
            width: 100%;
            height: 100%;
            /* border: none; */
            outline: none;
            font-size: 16px;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php include('../nav2.php') ?>
    <span class="head1">Tickets</span>
    <span class="btn btn-primary"><a href="../">Student Tickets</a></span>

    <?php
    $sql = "SELECT * FROM `faculty_tickets` where status='0' order by id";
    $result = mysqli_query($conn, $sql);
    if ($result) {

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["id"];
                $uid = $row["uid"];
                $sql2 = "SELECT * from login where id='" . $uid . "'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $name = $row2['name'];

                $lab = $row['lab'];
                $sql4 = "SELECT * FROM labs where id='" . $lab . "'";
                $result4 = mysqli_query($conn, $sql4);
                $row4 = mysqli_fetch_assoc($result4);
                $lab = $row4['name'];


                $slot = $row["time"];

                $sql5 = "SELECT * FROM slots where id='" . $slot . "'";
                $result5 = mysqli_query($conn, $sql5);
                $row5 = mysqli_fetch_assoc($result5);
                $st = $row5['start'];
                $et = $row5['end'];

                echo '<div class="block">';

                echo '<div class=flex-opposite>
        <span class="uid text dt">ID: #' . $id . '</span>';
                // string to date
                $date = date_create($row["dt"]);
                echo '<span class="dt text book-dt"> ' . date_format($date, "d/m/Y H:i:s") . '</span>
        </div>';

                echo '<span class="uid text">Name : ' . $name . '</span>';
                echo '<span class="lab text">Lab : ' . $lab . '</span>';
                echo '<span class="topic text">Purpose of booking : ' . $row["topic"] . '</span>';
                echo '<span class="date text">Booking Date : ' . $row["date"] . '</span>';
                echo '<span class="slot text">Booking Slot : ' . $st . ' -  ' . $et . '</span>';
                echo '<span class="slot text">Requirements : ' . $row['requirements'] . '</span>';
                echo '<div class="flex-opposite">';
                // <a href="essentials/_decline.php?id=' . $id . '" target="_blank" rel="noopener noreferrer"  class="btn btn-sec">Decline</a>
                echo '<span  class="btn btn-sec" onclick="popup()">Decline</span>
        <a href="essentials/_approve.php?id=' . $id . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Approve</a>
        
        </div>';
                echo '</div>';


            }
        } else {
            echo '<div class="block">
            <span class="head2">No pending requests</span>
            </div>';
        }
    }


    ?>


    <div id="popup">
        <div class="popup-content">
            <div class="popup-content-inner">
                <span class="close">&times;</span>
                <div class="popup-content-inner">
                    <form action="" method="post">
                        <span class="head2">Are you sure you want to delete this booking?</span>
                        <input type="text" name="reason" id="reason" placeholder="REASON FOR DECLINING" required>
                        <div class="flex-opposite">
                            <span class="btn btn-sec" id="cancel" onclick="closepop()">Cancel</span>
                            <!-- <span class="btn btn-primary" id="confirm">Confirm</span> -->
                            <!-- button submit -->
                            <button name="confirm" id="confirm" class="btn btn-primary">Confirm</button>

                        </div>
                    </form>
                    <?php
                    if (isset($_POST['confirm'])) {
                        $reason = $_POST['reason'];
                        $sql = "UPDATE `faculty_tickets` SET `status`='2',`reason`='$reason' WHERE id='$id'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            echo '<script>
                            alert("Booking Declined");
                            window.location.href = "index.php";
                            </script>';
                        } else {
                            echo '<script>
                            alert("Error");
                            window.location.href = "index.php";
                            </script>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // refresh page everytime user opens this tab
        window.onfocus = function () {
            location.reload();
        };
        // popup
        function popup() {
            document.getElementById("popup").style.display = "block";
        }
        function closepop() {
            document.getElementById("popup").style.display = "none";
        }

    </script>
</body>

</html>