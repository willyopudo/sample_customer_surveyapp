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
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Survey Details</b></h3>
                        </div>
                        <div class="card-body p-0 py-2">
                            <div class="container-fluid">
                                <p class="green-text"><b><?php echo $stitle ?></b></p>
                                <p class="mb-0">Description:</p>
                                <small><?php echo $description; ?></small>
                                <p>Start: <b class="green-text"><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
                                <p>End: <b class="green-text"><?php echo date("M d, Y",strtotime($end_date)) ?></b></p>

                            </div>
                            <hr class="border-primary">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><b>Customer Details</b></h3>
                        </div>
                        <div class="card-body ui-sortable">
                            <form action="" id="answer-survey-user" name="answer-survey-user">
                                <input type="hidden" name="survey_id1" value="<?php echo $id ?>">
                                <div class="form-group">
                                    <label for="" class="control-label">* Email Address</label>
                                    <input type="email" name="custemail" class="form-control form-control-sm" placeholder="name@example.com" required >
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* First Name</label>
                                    <input type="text" name="firstname" class="form-control form-control-sm"  >
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* Last Name</label>
                                    <input type="text" name="lastname" class="form-control form-control-sm" required >
                                </div>
                                <div class="form-group">
                                    <p>By clicking Begin Survey, I agree to the SUBZ® Inc <a href="#">Terms of Use</a> and <a href="#">Privacy Statement</a>.</p>
                                </div>
                                <div class="d-flex w-100 ">
                                    <button class="btn btn-sm btn-flat bg-gradient-primary mx-1" form="answer-survey-user">Begin survey</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <div class="card card-outline card-success" id="answer-card" style="display:none">
                        <div class="card-header">
                            <h3 class="card-title"><b>Survey Questionaire</b></h3>
                        </div>
                        <form action="" id="manage-survey" name="manage-survey">
                            <input type="hidden" name="survey_id" value="<?php echo $id ?>">
                            <input type="hidden" name="survey_user_id" id="survey_user_id" value="">
                        <div class="card-body ui-sortable">
                            <?php 
                            $question = $conn->query("SELECT * FROM questions where survey_id = $id order by abs(order_by) asc,abs(id) asc");
                            while($row=$question->fetch_assoc()):	
                            ?>
                            <div class="callout callout-info">
                                <h5><?php echo $row['question'] ?></h5>	
                                <div class="col-md-12">
                                <input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
                                <input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">	
                                    <?php
                                        if($row['type'] == 'radio_opt'):
                                            $frm_opts = json_decode($row['frm_option']);
                                            foreach($frm_opts as $k => $v):
                                                if($k == 'inline')
                                                    continue;
                                    ?>
                                    <div class="icheck-primary <?= (isset($frm_opts->inline) && $frm_opts->inline == 1) ? 'd-inline' : '' ?>">
                                        <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
                                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                    </div>
                                        <?php endforeach; ?>
                                <?php elseif($row['type'] == 'check_opt'): 
                                            foreach(json_decode($row['frm_option']) as $k => $v):
                                    ?>
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
                                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                    </div>
                                        <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="form-group">
                                        <textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Write Something Here..." ></textarea>
                                    </div>
                                <?php endif; ?>
                                </div>	
                            </div>
                            <?php endwhile; ?>
                        </div>
                        </form>
                        <div class="card-footer border-top border-success">
                            <div class="d-flex w-100 justify-content-center">
                                <button class="btn btn-sm btn-flat bg-gradient-primary mx-1" form="manage-survey">Submit Answers</button>
                                <button class="btn btn-sm btn-flat bg-gradient-secondary mx-1" type="button" onclick="location.href = 'index.php?page=survey_widget'">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $('#manage-survey').submit(function(e){
            e.preventDefault()
            start_load()
            $.ajax({
                url:'ajax.php?action=save_answer',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp == 1){
                        end_load()
                        alert_toast("Thank You for taking our survey.",'success')
                        $('#manage-survey')[0].reset();
                        setTimeout(function(){
                            location.href = 'finish_survey.php?surveyid=<?php echo $id ?>'
                        },2000)
                    }
                }
            })
        })

        $('#answer-survey-user').submit(function(e){
            e.preventDefault()
            start_load()
            $.ajax({
                url:'ajax.php?action=save_answer_user',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    end_load()
                    if(resp > 0){
                        
                        alert_toast("User details saved success!.",'success')
                        //$('#answer-card').removeAttr("hidden");
                        $("#answer-card").fadeIn(4000);
                        $("#survey_user_id").val(resp);
                    }
                    else{
                        alert_toast("Failed to save user details!.",'error')

                    }
                },
                error:function(resp){
                    end_load()
                    //console.log(resp);
                    alert_toast(" " + resp.statusText,'error');
                }
            })
        })
    </script>
   
</body>
</html>