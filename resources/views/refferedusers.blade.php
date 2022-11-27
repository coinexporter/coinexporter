@include("layouts.header")

<div class="welcome-dashboard">
	<div class="container">
  @section('title', 'Reffered Users')  
  @include("layouts.menu")
    </div>
</div>


<div class="finish-task">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-title">
                    <h3>Welcome to Reffered Users page </h3>
                    <h4>Where you can see your Reffered Users, their details</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------alert message start------->
<div class="container">
    @include("layouts.alert")

    @if (Session::has('success'))

  <div class="alert success-alert  alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      {{ Session::get('success') }}
  </div>  
  @endif
  @if (Session::has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
  {{ Session::get('error') }}
  </div>
  @endif
</div>
<!--------alert message end------->
<div class="finish-table ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-head">
                    <div class="table_responsive_maas">                
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                <th width="20%">ID</th>
                                <th width="20%">COUNTRY</th>
                                <th width="20%">STATUS</th>
                                <th width="20%">DATE</th>
                              </tr>
                            </thead>
                            <tbody>
								                @if($refferedUsers)	
                                    @foreach($refferedUsers as $val)
                                    <tr>
                                        <td>{{$val->id}}</td>
                                        <td>
                                             @if($val->country)
                                               @php $country = App\Models\Country::where('id',$val->country)->first(); @endphp
                                             @endif
                                             {{$country->country_name;}}
                                          <!-- App\Models\User::find($val->id)->country;  -->

                                        </td>
                                        @php
                                            $now = time(); 
                                            $your_date = strtotime($val->created_at);
                                            $datediff = ceil(($now - $your_date)/86400);
                                            if($datediff <= 30) {
                                              $rectangularbox = 'display: inline-block;border-radius: 4px;background-color: #19b159;width: 16px;height: 16px';
                                            }
                                            else {
                                              $rectangularbox = 'display: inline-block;border-radius: 4px;background-color: #ff0000;width: 16px;height: 16px';
                                            }
                                          @endphp
                                          <td ><span style="{{$rectangularbox}}"></span></td>
                                        <td>
                                        {{date("d-M-Y", strtotime($val->created_at))}}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else 
                                 <tr><td>No Data Found</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="float-end">
                          {{$refferedUsers->links()}}
                        </div>
                     </div>
                </div>

            </div>
        </div>
    </div>
</div>










<!--============================= cancelled =============================-->

<div class="modal fade" id="cancelledexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body can-modal">
        <img src="{{BASEURL}}images/modal-bg.png" alt="">
        <h5 class="modal-title" id="exampleModalLabel">Reson</h5>
        <p>Your cryptocurrency telegram group is full of bots and inactive</p>
      </div>
    <!--   <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>


<!-- ========================== Click Here======================= -->
<div class="modal fade" id="clickexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 514px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Why do you appeal this task to the admin? <br />Clearly state your reason?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea rows="5" style="width: 100%;border-radius: 6px;border: 2px dashed #d5d5d5;padding: 10px 10px;" placeholder="write your reason here and submit to the admin. "></textarea>
      </div>
    </div>
  </div>
</div>

<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>

// $("#submit").click(function()
// {
//   var message = $('#uploadtext').val();
//   alert(message);

// });
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
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	})
});
</script> 
<!-- <script>
function uploadfn() {
  alert("I am an alert box!");
}
</script> -->

@include("layouts.footer")