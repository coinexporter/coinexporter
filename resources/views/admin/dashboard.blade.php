@extends('admin.layouts.master')

@section('page_title')
    {{__('dashboard.title')}}
@endsection

@push('css')
<style>
  #chart-container-one {
    width: 100%;
    height: auto;
}

</style>
@endpush

@section('content')   

            
    <!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title">{{__('dashboard.title')}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active-breadcrumb">
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
					</ul>
				</div>
				<div class="col-md-3">
					{{-- <div class="create-btn pull-right">
						<a href="{{ route('users.create') }}" class="btn custom-create-btn">{{ __('default.form.add-button') }}</a>
					</div> --}}
				</div>
			</div>
		</div><!-- /card finish -->	
	</div><!-- /Page Header -->

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$emp_user}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Users</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-credit-card"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$campaign}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted">Campaign</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$jobdone}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted">Job Done</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-folder"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$pending_campaign}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted">Pending Campaign</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="card">
            <div class="card-body">
              <div id="chart-container-one">
                <canvas id="graphCanvasOne"></canvas>
                </div> 
            </div>
           </div> 
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                <div class="graph-box-board">
                <div id="chart-container-one">
                <span class="text">Month wise Job Done</span>
                <canvas id="graphCanvasTwo"></canvas>
                </div>
                    </div> 
            </div>
            </div>  
        </div>
    </div> 
    <div class="row">
    <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                <div class="graph-box-board">
                <div id="chart-container-one">
                <span class="text">Month wise Transaction</span>
                <canvas id="graphCanvasThree"></canvas>
                </div> 
               </div>
            </div>
            </div>  
        </div>
    </div>

@endsection




@push('css')
	
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/c3.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/chartist.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/chartist.min.css') }}"/> --}}
    <style type="text/css">
    	.card{
    		background-color: #fff;
    	}
    </style>

@endpush

@push('scripts')
<script src="{{ asset('assets/admin/js/Chart.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    showTransactionGraph();
});

function showTransactionGraph(){
    var chartdata = {
        labels: <?php echo $transaction_monthly; ?>,
        datasets: [
            {
                label: 'Month wise Transaction',
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#006B54","#008000","#0099CC","#009ACD","#068481","#00FFCC","#104E8B"],
                //borderColor: '#ff4d4d',
                hoverBackgroundColor: '#ff6666',
                //hoverBorderColor: '#ff6666',
                data: <?php echo $jtotal_transaction; ?>
            }
        ]
    };

    var graphTarget = $("#graphCanvasThree");

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
    showJobdoneGraph();
});

function showJobdoneGraph(){
    var chartdata = {
        labels: <?php echo $jobdone_monthly; ?>,
     
        datasets: [
            {
                label: 'Month wise Job Done',
                backgroundColor: ["#6666ff", "#00bfff","#0086b3","#77b300","#b3002d","#ff3366","#b33c00","#77773c","#e6e600","#204060","#ff8533","#bf80ff"],
                //borderColor: '#9933ff',
                hoverBackgroundColor: '#9999ff',
                //hoverBorderColor: '#9999ff',
                data: <?php echo $jtotal_jobdone; ?>
            }
        ]
    };

    var graphTarget = $("#graphCanvasTwo");

    var barGraph = new Chart(graphTarget, {
        type: 'doughnut',
        data: chartdata,
        options: {
        scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true
            }
            }]
        }
    }
    });
}
</script>

<script type="text/javascript">
  $(document).ready(function () {
    showRegistrationGraph();
});

function showRegistrationGraph(){
    var chartdata = {
        labels: <?php echo $jregister_month; ?>,
        datasets: [
            {
                label: 'Month wise User Registration',
                backgroundColor: '#0000FF',
                borderColor: '#0000FF',
                hoverBackgroundColor: '#4169E1',
                hoverBorderColor: '#666666',
                data: <?php echo $jtotal_register; ?>
            }
        ]
    };

    var graphTarget = $("#graphCanvasOne");

    var barGraph = new Chart(graphTarget, {
        type: 'bar',
        data: chartdata,
        options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true//this will remove only the label
                }
            }]
        }
    }
    });
}
</script>
@endpush
