<div class="dashboard-pagetitle">
            <div class="row">
                <div class="col-lg-12">
                    <h6>Welcome to @yield('title')</h6>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
  </ol>
</nav>
                </div>
            </div>
    	</div>

        <div class="dashboard-nav">
        	<div class="row">
            <div class="col-lg-12">
                <nav id="cssmenu">
                    <ul>
                      <li class="{{Request::routeIs('controlpanel') ? 'active' : '' }}"><a href="{{ route('controlpanel')}}"><i class="fas fa-tachometer"></i> Dashboard</a></li>
                      <li class="{{Request::routeIs('user.dashboard') ? 'active' : '' }}"><a href="{{ route('user.dashboard')}}"><i class="fas fa-tachometer-alt"></i> Job Space</a></li>
                      <li class="{{Request::routeIs('finishtask') ? 'active' : ''}}"><a href="{{ route('finishtask') }}"><i class="fal fa-clipboard-list-check"></i> Finished Tasks</a></li>
                      <li class="{{Request::routeIs('mycampaign') ? 'active' : ''}}"><a href="{{ route('mycampaign') }}"><i class="far fa-bullhorn"></i> My Campaigns</a></li>
                      <li class="{{Request::routeIs('myaccount') ? 'active' : ''}}"><a href="{{ route('myaccount') }}"><i class="fal fa-file-user"></i> My Account</a></li>
                      <li class="{{Request::routeIs('withdraw') ? 'active' : ''}}"><a href="{{route('withdraw') }}"><i class="far fa-wallet"></i> Withdraw</a></li>
                      <li class="{{Request::routeIs('tutorial') ? 'active' : ''}}"><a href="{{ route('tutorial') }}"><i class="far fa-book-reader"></i> Tutorials</a></li>
                      <li class="{{Request::routeIs('refferedUsers') ? 'active' : ''}}"><a href="{{ route('refferedUsers') }}"><i class="far fa-users"></i> Referred Users</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>