<?php include 'db_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
<?php 
$qry = $conn->query("select a.answer,q.question,q.frm_option,ss.storenumber,ss.servicedate,ss.transactionnumber from answers a 
inner join questions q on a.question_id = q.id
inner join survey_service ss on a.survey_service_id = ss.id
where a.survey_id = ".$_GET['surveyid']. " and a.survey_user_id = ".$_GET['userid']. " and q.question like '%How much would you recomend a friend%'")->fetch_array();

include 'header.php'
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include 'topbar.php' ?>
        
        <div class="col-lg-12" style="margin-top: 5%;">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-outline card-primary">
                        
                        <div class="card-body p-0 py-2">
                            <div class="container-fluid">
                                <?php
                                if(isset($qry)){
                                    //var_dump(json_encode($qry));
                                    foreach($qry as $k => $v){
                                        
                                        $$k = $v;
                                    }
                                    $possible_answers = json_decode($frm_option);
                                    $datepart = explode('-', $servicedate)[1].explode(' ', explode('-', $servicedate)[2])[0];

                                    ?>
                                    <h4 class="green-text text-center">Thank you</h4>
                                
                                    <p class="">
                                        <b>As promised, here’s your offer and we look forward to seeing you soon:<br><br>

                                            Enjoy one (1) delicious cookie on us WITH the purchase of any sub or salad.<br><br>

                                            This offer is valid at participating SUBZ restaurants for in-restaurant orders only. Additional charge for Extras. No cash value. Not for sale. One time use. One offer code use per qualifying item(s).  Cannot be combined with promotional offers. Void if transferred, sold, auctioned, reproduced, purchased or altered, & where prohibited.</b><br><br>

                                        <b>Please write the offer code below on your purchase receipt and show it to any of our team member when you check out. Offer can be redeemed at any participating SUBZ location by the expiration date listed below. Hurry in!</b>
                                    </p>
                                    <br>
                                    <h2 class="green-text text-center">Offer Code :<strong><?php echo ' '.$possible_answers->$answer.'-'.$storenumber.'-'.$datepart.'-'.substr($transactionnumber,0,4) ?></strong></h2>
                                    <h6 class="green-text text-center"><small >Expires on: 2/30/2024</small></h6>
                                    <!-- <p class="mb-0">Description:</p>
                                    <small><?php echo $description; ?></small> -->
                                    <?php

                                }else{
                                   echo '<p style="color:red">Oops! We could not find a survey associated with your request. Please contact support.</p>';
                                }
                                ?>
                                
                               

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