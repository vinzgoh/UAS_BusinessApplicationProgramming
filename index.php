    <?php
    //index.php
    include('database_connection.php');
    if(!isset($_SESSION["type"]))
    {
        header("location:login.php");
    }
    ?>
    <meta http-equiv="Refresh" content="0; url=cashflow.php" />
