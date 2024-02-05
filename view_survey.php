<?php include 'db_connect.php' ?>
<?php 

$qry = $conn->query("SELECT * FROM survey_set where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$answers = $conn->query("SELECT distinct(survey_user_id) from answers where survey_id ={$id}")->num_rows;
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title">Survey Details</h3>
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Title: <b><?php echo $stitle ?></b></p>
						<p class="mb-0">Description:</p>
						<small><?php echo $description; ?></small>
						<p>Start: <b><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
						<p>End: <b><?php echo date("M d, Y",strtotime($end_date)) ?></b></p>
						<p>Have Taken: <b><?php echo number_format($answers) ?></b></p>

					</div>
					<hr class="border-primary">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b>Survey Questionaire</b></h3>
					<div class="card-tools">
						<button class="btn btn-block btn-sm btn-default btn-flat border-success new_question" type="button"><i class="fa fa-plus"></i> Add New Question</button>
					</div>
				</div>
				<form action="" id="manage-sort">
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
                                //var_dump(array_values($frm_opts));
                                $first_val  =  reset($frm_opts);
                                if(isset($frm_opts->inline) && $frm_opts->inline == 1 && $first_val != 'Highly Dissatisfied'){
                                    ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <i class='far fa-frown' style='font-size:48px;color:red'></i>
                                                <i class='far fa-smile float-right' style='font-size:48px;color:green'></i>
                                            
                                            </div>
                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 mt-2">

                                                <div class="rb-box">
                                                    <!-- Radio Button Module -->
                                                    <div id="rb-1" class="rb">
                                                        <?php
                                                        $count = 0;
                                                        foreach($frm_opts as $k => $v):
                                                            if($k == 'inline')
                                                                continue;
                                                            $rb_tab_active = ($count == 0) ? "rb-tab-active" : '';
                                                            echo '<div class="rb-tab '. $rb_tab_active .'" data-value="'.$k.'" onclick="handleRateBtnClick(this)" id="'.$k.'">
                                                            <div class="rb-spot">
                                                                <span class="rb-txt">'.$count.'</span>
                                                            </div>
                                                            <input type="radio" id="option_'.$k.'" name="answer['.$row['id'].']" value="'.$k.'" hidden >
                                                            </div>';
                                                            
                                                            // echo ' <button type="button" id="'.$k.'" class="btn btn-light" style="height:50px;width:50px" onclick="handleRateBtnClick(this)">'.$count.'</button>';
                                                            // echo ' <input type="radio" id="option_'.$k.'" name="answer['.$row['id'].']" value="'.$k.'" hidden >';
                                                            $count++;
                                                        endforeach;
                                                        ?>
                                                    
                                                        
                                                    </div>  
                                                </div>
                                            </div>
                                                    
                                                <!-- <div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <?php
                                                    // $count = 0;
                                                    // foreach($frm_opts as $k => $v):
                                                    //     if($k == 'inline')
                                                    //         continue;
                                                    //     echo ' <button type="button" id="'.$k.'" class="btn btn-light" style="height:50px;width:50px" onclick="handleRateBtnClick(this)">'.$count.'</button>';
                                                    //     echo ' <input type="radio" id="option_'.$k.'" name="answer['.$row['id'].']" value="'.$k.'" hidden >';
                                                    //     $count++;
                                                    // endforeach;
                                                    ?>
                                                    
                                                    </div>
                                                </div> -->
                                                
                                        </div>
                                    <?php
                                }
                                elseif(isset($frm_opts->inline) && $frm_opts->inline == 1 && $first_val == 'Highly Dissatisfied'){
                                    ?>
                                    <div class="row">
                                        <div class="col-md-8 co-xs-12 co-sm-12">
                                            <table class="table table-borderless  text-center rating-desc-tbl"> 
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <i class="far fa-frown rating-smiley-frown" ></i>
                                                            <p>Highly Dissatisfied</p>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <p class="mt-50pc">Dissatisfied</p>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <p class="mt-25pc">Neither Satisfied nor Dissatisfied</p>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <p class="mt-50pc">Satisfied</p>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <i class="far fa-smile rating-smiley-smile" ></i>
                                                            <p>Highly Satisfied</p>
                                                        </td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered text-center">
                                                <tbody>
                                                
                                                    <tr>
                                                    <?php
                                                        $count = 0;
                                                        foreach($frm_opts as $k => $v):
                                                            if($k == 'inline')
                                                                continue;
                                                            echo '<td class="col-md-2">
                                                                <div class="icheck-primary">
                                                                    <input type="radio" id="option_'.$k.'" name="answer['.$row['id'].']" value="'.$k.'" >
                                                                    <label for="option_'.$k.'"></label>
                                                                </div>
                                                                </td>';
                                                            $count++;
                                                        endforeach;    
                                                    ?>
                                                    
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <?php
                                }
                                else{
                                    foreach($frm_opts as $k => $v):
                                         if($k == 'inline')
                                            continue;
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
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.ui-sortable').sortable({
			placeholder: "ui-state-highlight",
			 update: function( ) {
			 	alert_toast("Saving question sort order.","info")
		        $.ajax({
		        	url:"ajax.php?action=action_update_qsort",
		        	method:'POST',
		        	data:$('#manage-sort').serialize(),
		        	success:function(resp){
		        		if(resp == 1){
			 				alert_toast("Question order sort successfully saved.","success")
		        		}
		        	}
		        })
		    }
		})
	})
	$('.new_question').click(function(){
		uni_modal("New Question","manage_question.php?sid=<?php echo $id ?>","large")
	})
	$('.edit_question').click(function(){
		uni_modal("New Question","manage_question.php?sid=<?php echo $id ?>&id="+$(this).attr('data-id'),"large")
	})
	
	$('.delete_question').click(function(){
	_conf("Are you sure to delete this question?","delete_question",[$(this).attr('data-id')])
	})
	function delete_question($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_question',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}

    $(".rb-tab").click(function(){
    //Spot switcher:
        $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
        $(this).addClass("rb-tab-active");
    });
</script>