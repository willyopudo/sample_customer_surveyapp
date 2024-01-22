<?php include 'db_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
$qry = $conn->query("SELECT * FROM survey_set where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
include 'header.php'
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include 'topbar.php' ?>
        
        <div class="col-lg-12" style="margin-top: 5%;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        
                        <div class="card-body p-0 py-2 text-center">
                            <div class="container-fluid text-center">
                                <h5 class="text-center"><b>Thank you for taking part in our survey. Please find your promotion code below</b></h5>
                                <br>
                                <h2 class="green-text"><strong><?php echo '098366H65T' ?></strong></h2>
                                <!-- <p class="mb-0">Description:</p>
                                <small><?php echo $description; ?></small> -->
                               

                            </div>
                           
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <footer class="main-footer" style="margin-left : 0%">
    <strong><a href="https://willyf.git.net/">Dev by Willyf</a>.</strong>
    Donate
    <div class="float-right d-none d-sm-inline-block">
      <b>SUBZ Review and Feedback</b>
    </div>
  </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <!-- Bootstrap -->
    <?php include 'footer.php' ?>
    <script>
        $(document).ready(function(){
            $('.navbar-dark').css('margin-left','0px');
        })
    </script>
</body>
</html>