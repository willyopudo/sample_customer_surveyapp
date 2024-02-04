<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Subscribers</span>
            <span class="info-box-number">
                <?php echo $conn->query("SELECT * FROM users where type = 3")->num_rows; ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Survey</span>
                <span class="info-box-number">
                <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fa fa-check"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Submissions</span>
                <span class="info-box-number">
                <?php echo $conn->query("SELECT * FROM survey_service")->num_rows; ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-default elevation-1"><i class="fa fa-building"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Stores</span>
                <span class="info-box-number">
                <?php echo $conn->query("SELECT * FROM subz_stores")->num_rows; ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Count of Surveys taken by Store</b></h3>
                </div>
                <div class="card-body p-0 py-2">
                    <div class="container-fluid">
                        <canvas id="bar-chart" width="800" height="450"></canvas>
                        

                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Average Overall customer satisfaction rating by Store</b></h3>
                </div>
                <div class="card-body p-0 py-2">
                    <div class="container-fluid">
                        <canvas id="pie-chart" width="800" height="450"></canvas>
                        

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>List of recent Survey Submissions</b></h3>
                </div>
                <div class="card-body p-0 py-2">
                    <div class="container-fluid">
                    <table id="survey-data-table" class="table table-row-bordered gy-5">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Store Name</th>
                                <th>Customer Email</th>
                                <th>Receipt Number</th>
                                <th>Date Submited</th>
                            </tr>
                        </thead>
                        
                    </table>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Surveys Taken</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT distinct(survey_id) FROM answers  where user_id = {$_SESSION['login_id']}")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
          
<?php endif; ?>

<script >
$(document).ready(function(){
    renderBarChart();
    renderPieChart();

    $('#survey-data-table').DataTable( {
        ajax: 'ajax.php?action=fetchall_survey_submissions'
    } );
})

var renderBarChart = function(){
    $.ajax({
        url: 'ajax.php?action=fetch_survey_totals_by_store',
        success: function(data) {
            var chartData = JSON.parse(data);
            var labels = [];
            var data = []
            chartData.forEach(elem => {
                labels.push(elem[1])
                data.push(elem[0])
            });
            createBarChart(labels, data);
        }
    });
}
var renderPieChart = function(){
    $.ajax({
        url: 'ajax.php?action=fetch_satisfaction_score_by_store',
        success: function(data) {
            var chartData = JSON.parse(data);
            //stage possible answers from first row
            var possibleAnswers = JSON.parse(chartData[0][1]);
            //DEclare js object to store stats for each store
            var storeStats = {}; 

            //Labels and data simple array
            var labels = [];
            var data = []

            //Loop through each row of submitted answers and assoc data
            chartData.forEach(elem => {
                //index 3 has store name
                //Get value of random key from possibleAnswers array
                if( storeStats[elem[3]] === undefined )
                    storeStats[elem[3]] = [1, parseInt(possibleAnswers[elem[0]])]
                else{
                    //Increment count of submitted answers by 1 and add submitted rating to the running total for store 
                    storeStats[elem[3]][0] = storeStats[elem[3]][0] + 1;
                    storeStats[elem[3]][1] = storeStats[elem[3]][1] + parseInt(possibleAnswers[elem[0]]);
                }
            });

            for (const key in storeStats) {
                if(!labels.includes(key))
                    labels.push(key)
                data.push(storeStats[key][1] / storeStats[key][0]);
            }
            createPieChart(labels, data);
        }
    });
}
// creat bar chart
var createPieChart = function(labels, data){
    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
        labels: labels,
        datasets: [{
            label: "Average Store rating",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
            data: data
        }]
        },
        options: {
        title: {
            display: true,
            text: 'Average overall customer satisfaction rating by store'
        }
        }
    });
}

// creat bar chart
var createBarChart = function(labels, data){
    new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
            data: data,
            borderWidth: 1,
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9"],
            borderColor:'#00c0ef',
            label: 'Number of surveys taken',
            }]
        },
        options: {
            responsive: true,
            title: {
            display: true,
            text: "Sum of surveys taken by store over specified time period",
            },
            legend: { display: true },
            title: {
                display: true,
                text: 'Sum of surveys taken by store over specified time period'
            },
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                }
            }]
            }
        }
    });
}

// // this post id drives the example data
// var postId = 1;

// // logic to get new data
// var getData = function() {
//   $.ajax({
//     url: 'https://jsonplaceholder.typicode.com/posts/' + postId + '/comments',
//     success: function(data) {
//       // process your data to pull out what you plan to use to update the chart
//       // e.g. new label and a new data point
      
//       // add new label and data point to chart's underlying data structures
//       myChart.data.labels.push("Post " + postId++);
//       myChart.data.datasets[0].data.push(getRandomIntInclusive(1, 25));
      
//       // re-render the chart
//       myChart.update();
//     }
//   });
// };

// // get new data every 3 seconds
// setInterval(getData, 3000);
</script>
