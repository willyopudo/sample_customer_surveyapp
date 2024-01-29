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
                                <!-- <p>Start: <b class="green-text"><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
                                <p>End: <b class="green-text"><?php echo date("M d, Y",strtotime($end_date)) ?></b></p> -->

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
                    <div class="card card-outline card-success" id="service-card" style="display:none">
                        <div class="card-header">
                            <h3 class="card-title"><b>Service Details</b></h3>
                        </div>
                        <div class="card-body ui-sortable">
                            <form action="" id="answer-survey-service" name="answer-survey-service">
                                <input type="hidden" name="survey_id2" value="<?php echo $id ?>">
                                <div class="form-group">
                                    <label for="" class="control-label">* Please enter SUBZ store # as listed on your receipt</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-2 mr-1">
                                        <input type="tel" name="storenumber" class="form-control form-control-sm" maxlength="6" size="12"
                                        title="Please enter the first part of your Subway store number (before the dash)" required >
                                    </div>
                                         - 
                                    <div class="col-xs-1 ml-1">
                                        <input type="tel" name="storenumber2" class="form-control form-control-sm" maxlength="2" size="4"
                                        title="Please enter the second part of your Subway store number (after the dash)" value="0" required >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* Please tell us the date of your purchase as listed on your receipt. Only purchases in the past 5 days are valid.</label>
                                    <input type="date" name="servicedate" class="form-control form-control-sm" required >
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* Please tell us the time of your purchase as listed on your receipt:</label>
                                    <label for="" class="control-label">Hours</label>
                                    <select name="servicehour" id="servicehour" class="custom-select custom-select-sm">
										<option value="0">00(12am)</option>
                                        <option value="01">01(1am)</option>
                                        <option value="02">02(2am)</option>
                                        <option value="03">03(3am)</option>
                                        <option value="04">04(4am)</option>
                                        <option value="05">05(5am)</option>
                                        <option value="06">06(6am)</option>
                                        <option value="07">07(7am)</option>
                                        <option value="08">08(8am)</option>
                                        <option value="09">09(9am)</option>
                                        <option value="10">10(10am)</option>
                                        <option value="11">11(11am)</option>
                                        <option value="12">12(12am)</option>
                                        <option value="13">01(1pm)</option>
                                        <option value="14">02(2pm)</option>
                                        <option value="15">03(3pm)</option>
                                        <option value="16">04(4pm)</option>
                                        <option value="17">05(5pm)</option>
                                        <option value="18">06(6pm)</option>
                                        <option value="19">07(7pm)</option>
                                        <option value="20">08(8pm)</option>
                                        <option value="21">09(9pm)</option>
                                        <option value="22">10(10pm)</option>
                                        <option value="23">11(11pm)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* Minutes</label>
                                    <select name="serviceminute" id="serviceminute" class="custom-select custom-select-sm">
                                        <?php
                                        $x = 0;
                                        while($x < 60){
                                            $text = $x < 10 ? '0'.$x : $x;
                                            echo '<option value="'.$text.'">'.$text.'</option>';
                                            $x++;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">* Transaction Number</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-2 mr-1">
                                        <input type="tel" name="txnumber1" title="Please enter the first part of your transaction ID (before the slash)" 
                                        class="form-control form-control-sm" value="1" maxlength="2" size="2" required >
                                    </div>
                                         / 
                                    <div class="col-xs-1 ml-1 mr-1">
                                        <input type="text" name="txnumber2" size="4" title="Please enter the second part of your transaction ID (between the slash and dash)" class="form-control form-control-sm" value="A" required >
                                    </div>
                                    -
                                    <div class="col-xs-1 ml-1">
                                        <input type="tel" name="txnumber3" title="Please enter the third part of your transaction ID (after the dash)" 
                                        class="form-control form-control-sm" maxlength="10" size="12" required >
                                    </div>
                                </div>
                                <div class="d-flex w-100 ">
                                    <button class="btn btn-sm btn-flat bg-gradient-primary mx-1" form="answer-survey-service">Next</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <div class="card card-outline card-success" id="answer-card" style="display:block">
                        <div class="card-header">
                            <h3 class="card-title"><b>Survey Questionaire</b></h3>
                        </div>
                        <form action="" id="manage-survey" name="manage-survey">
                            <input type="hidden" name="survey_id" value="<?php echo $id ?>">
                            <input type="hidden" name="survey_user_id" id="survey_user_id" value="">
                            <input type="hidden" name="survey_service_id" id="survey_service_id" value="">
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
                                            
                                        if(isset($frm_opts->inline) && $frm_opts->inline == 1){
                                            ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <i class='far fa-frown' style='font-size:48px;color:red'></i>
                                                        <i class='far fa-smile float-right' style='font-size:48px;color:green'></i>
                                                    
                                                    </div>
                                                
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                   
                                                       
                                                            
                                                            <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                                <?php
                                                                $count = 0;
                                                                foreach($frm_opts as $k => $v):
                                                                    if($k == 'inline')
                                                                        continue;
                                                                    echo ' <button type="button" id="'.$k.'" class="btn btn-light" style="height:50px;width:50px" onclick="handleRateBtnClick(this)">'.$count.'</button>';
                                                                    echo ' <input type="radio" id="option_'.$k.'" name="answer['.$row['id'].']" value="'.$k.'" hidden >';
                                                                    $count++;
                                                                endforeach;
                                                                ?>
                                                                
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                        else{
                                            foreach($frm_opts as $k => $v):
                                            ?>
                                            <div class="icheck-primary">
                                                <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
                                                <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                            </div>
                                            <?php
                                            endforeach;
                                        }
                                    ?>
                                            
                                    <?php 
                                        elseif($row['type'] == 'check_opt'): 
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
                            <div class="callout callout-info">
                                <h5>Rate the overall service in a scale of 0 to 10</h5>	
                                <div class="col-md-12">
                                <div class="rb-box">
                                    <!-- Radio Button Module -->
                                    <div id="rb-1" class="rb">
                                        <div class="rb-tab rb-tab-active" data-value="0">
                                        <div class="rb-spot">
                                            <span class="rb-txt">0</span>
                                        </div>
                                        </div>
                                        <div class="rb-tab " data-value="1">
                                        <div class="rb-spot">
                                            <span class="rb-txt">1</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="2">
                                        <div class="rb-spot">
                                            <span class="rb-txt">2</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="3">
                                        <div class="rb-spot">
                                            <span class="rb-txt">3</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="4">
                                        <div class="rb-spot">
                                            <span class="rb-txt">4</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="5">
                                        <div class="rb-spot">
                                            <span class="rb-txt">5</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="6">
                                        <div class="rb-spot">
                                            <span class="rb-txt">6</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="7">
                                        <div class="rb-spot">
                                            <span class="rb-txt">7</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="8">
                                        <div class="rb-spot">
                                            <span class="rb-txt">8</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="9">
                                        <div class="rb-spot">
                                            <span class="rb-txt">9</span>
                                        </div>
                                        </div><div class="rb-tab" data-value="10">
                                        <div class="rb-spot">
                                            <span class="rb-txt">10</span>
                                        </div>
                                        </div>
                                    </div>  
                                </div>
                                </div>
                            </div>
                            
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
                        //console.log('finish_survey.php?surveyid=<?php echo $id ?>&userid='+$("#survey_user_id").val());
                        setTimeout(function(){
                            location.href = 'finish_survey.php?surveyid=<?php echo $id ?>&userid='+$("#survey_user_id").val()
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
                        $("#service-card").fadeIn(4000);
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

        $('#answer-survey-service').submit(function(e){
            e.preventDefault()
            start_load()
            $.ajax({
                url:'ajax.php?action=save_answer_service',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    end_load()
                    if(resp > 0){
                        
                        alert_toast("Service details saved success!.",'success')
                        //$('#answer-card').removeAttr("hidden");
                        $("#service-card").fadeOut(4000);
                        $("#answer-card").fadeIn(4000);
                        $("#survey_service_id").val(resp);
                    }
                    else{
                        alert_toast("Failed to save service details!.",'error')

                    }
                },
                error:function(resp){
                    end_load()
                    //console.log(resp);
                    alert_toast(" " + resp.statusText,'error');
                }
            })
        })

        function handleRateBtnClick(elem){
            console.log('option_'+elem.id);
            $("#option_"+elem.id).prop("checked", "checked");
            if($(elem).hasClass('rate-btn-color'))
                $(elem).removeClass('rate-btn-color');
            else{
                $(elem).siblings().removeClass('rate-btn-color')
                $(elem).addClass('rate-btn-color');
            }
        }
        //Switcher function:
        $(".rb-tab").click(function(){
        //Spot switcher:
        $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
        $(this).addClass("rb-tab-active");
        });
    </script>
   
</body>
</html>