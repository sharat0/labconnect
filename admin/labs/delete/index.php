<?php
    require('../../../essentials/_config.php');
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql="UPDATE `labs` SET `status` = '0' WHERE `id` =  $id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<script>close();</script>';

        } else {
            echo '<script>alert("Error")</script>';
        }
    }
    else {
        // redirect to ../
        echo '<script>window.location.href = "../"</script>';
    }
?>