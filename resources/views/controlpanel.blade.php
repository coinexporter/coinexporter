@include("layouts.header")
<div class="welcome-dashboard">
    <div class="container">
    @section('title', 'Dashboard')
        @include("layouts.menu")
    </div>
</div>
<style>
  #chart-container-one {
    width: 100%;
    height: auto;
}
#chart-container-two {
    width: 100%;
    height: auto;
}
</style>
<div class="finish-task"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-title">
                    <h3>Welcome to Dashboard page </h3>
                    <!-- <h4>Where you can see your completed tasks, their details and upload the proof of work done</h4> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ptb-50 dark-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-primary border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pending Balance</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalPendingBalanceUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalPendingBalance}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-secondary border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Referral Bonus Balance</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalRefferalBalanceUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalRefferalBalance}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-success border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Actual Balance</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalActualBalanceUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalActualBalance}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-info border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Campaign Bonus Balance</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalCamapignBalanceUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalCamapignBalance}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-info border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Withdrawn Amount</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$withdrawalBalanceUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$withdrawalBalance}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card-dash border-start border-primary border-3 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Balances</div>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalBalancesUsdt}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">USDT</div></div><br>
                        <div class="currency">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{$totalBalances}}</div><div class="h5 mb-0 font-weight-bold text-gray-800">COINEXPT</div></div>
                      </div>
                      <div class="col-auto">
                        <i class="fad fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6">
              <div class="graph-box-board">
                <div id="chart-container-one">
                  <span class="text">Month wise Campaign Earnings</span>
                  <canvas id="graphCanvasOne"></canvas>
                
              </div> 
              </div>
            
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="graph-box-board">
              <div id="chart-container-two">
                <span class="text">Month wise Referral Earnings</span>
                <canvas id="graphCanvasTwo"></canvas>
              </div> 
            </div>
          </div>
        </div>
    </div>
</div>

<div class="finish-table ptb-50">
  <div class="container">
      <div class="row">
          <div class="col-lg-12 col-md-12">
              <div class="finish-head">
                  <div class="table_responsive_maas">                
                      <table class="table table-hover" id="table">
                          <thead>
                            <tr>
                              <th width="10%">ID</th>
                              <th width="10%">Date</th>
                              <th width="30%"> Description</th>
                              <th width="20%">Amount</th>
                              <!-- <th width="20%">Balance</th> -->
                              <th width="10%">Type</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($transactions_log as $key=>$transaction)
                            <tr>
                              <td>{{$transaction->id}}</td>
                              <td>{{ date("d-M-Y", strtotime($transaction->created_at)) }}</td>
                              <td>{{$transaction->description}}</td>
                              @if(($transaction->approved_amount) < 0)
                              <td>{{round((-$transaction->approved_amount),2)}}</td>
                              @else
                              <td>{{round($transaction->approved_amount,2)}}</td>
                              @endif
                              {{--<td>{{$transaction->status}}</td>--}}
                              <td>{{$transaction->transaction_type}}</td>
                              
                            </tr>
                            @endforeach
                            
                          </tbody>
                          
                      </table>
                      <div class="float-end">
                      {{ $transactions_log->links()}}
                    </div>
                   </div>
              </div>

          </div>
      </div>
  </div>
</div>


<!--============================= Scripts =============================-->

<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>
    jQuery(document).ready(function() {
        var offset = 220;
        var duration = 500;
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });

        jQuery('.back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        })
    });
</script>
<script type="text/javascript">
  $(document).ready(function () {
    showReferralGraph();
});

function showReferralGraph(){
    var chartdata = {
        labels: <?php echo $jtdata_refmonth; ?>,
        datasets: [
            {
                label: 'Month wise Referral Earnings',
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#006B54","#008000","#0099CC","#009ACD","#068481","#00FFCC","#104E8B"],
                //borderColor: '#9999ff',
                hoverBackgroundColor: '#9933ff',
                //hoverBorderColor: '#9999ff',
                data: <?php echo $jdata_refamt; ?>
            }
        ]
    };

    var graphTarget = $("#graphCanvasTwo");

    var barGraph = new Chart(graphTarget, {
        type: 'pie',
        data: chartdata,
        options: {
        scales: {
            yAxes: [{
                ticks: {
                  beginAtZero: true //this will remove only the label
                }
            }]
        }
    }
    });
}
</script>

<script type="text/javascript">
  $(document).ready(function () {
    showCamapignGraph();
});

function showCamapignGraph(){
    var chartdata = {
        labels: <?php echo $jtdata_month; ?>,
        datasets: [
            {
                label: 'Month wise Campaign Earnings',
                backgroundColor: ["#6666ff", "#00bfff","#0086b3","#77b300","#b3002d","#ff3366","#b33c00","#77773c","#e6e600","#204060","#ff8533","#bf80ff"],
                //borderColor: '#0000FF',
                hoverBackgroundColor: '#4169E1',
                //hoverBorderColor: '#666666',
                data: <?php echo $jdata_amt; ?>
            }
        ]
    };

    var graphTarget = $("#graphCanvasOne");

    var barGraph = new Chart(graphTarget, {
        type: 'doughnut',
        data: chartdata,
        options: {
        scales: {
            yAxes: [{
                ticks: {
                  beginAtZero: true //this will remove only the label
                }
            }]
        }
    }
    });
}
</script>

@include("layouts.footer")