

  @include("layouts.header")


<div class="welcome-dashboard">
  <div class="container">

    @section('title', 'My Campaign')
    @include("layouts.menu")
  </div>
</div>

<div class="campaign-sec">
  <div class="container">
    <div class="tab-box">
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

        <div class="row">
          <form id="form1" action="{{route('mycampaignstore')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12 col-md-10 mx-auto">
              <div class="tab-text">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation" style="width: 100%;">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">For new mass promotion campaign placement application, kindly click</button>
                  </li>
                  <li class="nav-item" role="presentation" style="width: 100%;">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">For new banner placement application on CoinExporter, AMA and other form of promotion services on CoinExporter Telegram, Youtube, Facebook, Twitter and so on, kindly click</button>
                  </li>
                </ul>
                <!-- tab content -->

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- <form> -->
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="selct-box">
                          <label class="form-label" style="align:left;">Campaign Type</label>
                          <select class="form-select" name="campaign_type" form="form1">

                            @php
                            $campaign_category = App\Models\CampaignCategory::all();
                            @endphp
                            @foreach ($campaign_category as $campaign_categoryy)
                            @if (old('campaign_type') == $campaign_categoryy->id)
                            <option value="{{ $campaign_categoryy->id }}" selected>{{ $campaign_categoryy->campaign_category_name }}</option>
                            @else
                            <option value="{{ $campaign_categoryy->id }}">{{ $campaign_categoryy->campaign_category_name }}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                        @error('campaign_type')
                        <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-lg-6">
                        <div class="selct-box">
                          <label class="form-label">Select Social platform for campaign</label>
                          <select class="form-select" name="social_platform" form="form1">
                            @php
                            $social_platform = App\Models\SocialPlatform::all();
                            @endphp
                            @foreach ($social_platform as $social_platforms)
                            @if (old('social_platform') == $social_platforms->id)
                            <option value="{{ $social_platforms->id }}" selected>{{ $social_platforms->social_platform_name }}</option>
                            @else
                            <option value="{{ $social_platforms->id }}">{{ $social_platforms->social_platform_name }}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                        @error('social_platform')
                        <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="col-lg-6">
                        <div class="selct-box">
                          <label class="form-label country">Select Target countries of whom to promote campaign</label>
                          <select id="multipleselect" multiple name="country[]" placeholder="Choose Country" data-search="true" data silent-initial-value-set="true" form="form1" required>
                            @php
                            $countries = App\Models\Country::all();
                            @endphp
                            @foreach ($countries as $country)
                         
                            <option value="{{ $country->id }}" >{{ $country->country_name }}</option>
                            @endforeach
                          </select>
                        </div>

                        @error('country')
                        <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                      </div>
                      {{--<div class="col-lg-6">
                        <div class="selct-box">
                          <label class="form-label">Referral Code (If Any)</label>
                          <input type="text" class="form-control" name="referrer_code" value="{{old('referrer_code')}}" placeholder="Enter your Referral Code" form="form1">
                        </div>

                      </div>--}}
                      <div class="col-lg-12 mx-auto">
                        <div class="text-box">
                          <div class="row">
                            <div class="col-lg-6 col-md-6">
                              <div class="txt-area">
                                <label for="comment">Describe your campaign </label>
                                <textarea class="form-control" rows="6" id="comment1" name="campaign_desc" placeholder="Clearly state what you want and how you want the promoters to promote your campaign " form="form1">{{old('campaign_desc')}}</textarea>

                              </div>
                              @error('campaign_desc')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                              <div class="txt-area">
                                <label for="comment">What do you need as evidence of work done? </label>
                                <textarea class="form-control" rows="6" id="comment2" name="campaign_proof_desc" placeholder="Clearly state what you want as the proof of work done. e.g: links, screenshots upload and so on.  "  form="form1">{{old('campaign_proof_desc')}}</textarea>
                              </div>
                              @error('campaign_proof_desc')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mx-auto">
                        <div class="video-sec ptb-50">
                          <div class="row">
                            <div class="col-lg-4 col-md-4">
                              <label class="form-label">What do you want to upload ?</label>
                              <select class="form-select div-toggle" data-target=".my-info-1" name="file_type" form="form1">
                              <option value="" data-show=".citrus" selected disabled>Select</option>
                                <option value="video" data-show=".citrus">Video</option>
                                <option value="banner" data-show=".citrus">Banner</option>
                                <option value="text_content" data-show=".pome">Text Content</option>
                              </select>
                            </div>
                            <div class="col-lg-8 col-md-8">
                              <div class="my-info-1">
                                <div class="citrus hide">
                                  <div class="drop-zone">
                                    <span class="drop-zone__prompt">Drop file here or click to upload</span>
                                    <input type="file" class="drop-zone__input" name="file_name" form="form1">
                                  </div>
                                  <div class="button-box">
                                    <button type="button">Upload</button>
                                    <button type="button" class="pre">Preview</button>
                                    <button type="button" class="del">Delete</button>
                                  </div>
                                </div>
                                <div class="hide">
                                  <div class="drop-zone">
                                    <span class="drop-zone__prompt">Drop file here or click to upload</span>
                                    <input type="file" name="file_name1" class="drop-zone__input" form="form1">
                                  </div>
                                  <div class="button-box">
                                    <button type="button">Upload</button>
                                    <button type="button" class="pre">Preview</button>
                                    <button type="button" class="del">Delete</button>
                                  </div>
                                </div>
                                <div class="pome hide">
                                  <div class="drop-text">
                                    <textarea rows="8" name="text_content" form="form1"></textarea>
                                  </div>
                                  <div class="button-box">
                                    <button type="button">Submit</button>
                                    <button type="button" class="pre">Edit</button>
                                    <button type="button" class="del">Delete</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-12">
                        <div class="row align-items-center cost-box ">
                          <div class="col-lg-6 col-md-6">
                            <div class="title">
                              <p>To get the campaign cost, tell us number of PROMOTERS (DIRECT MARKETERS) you need for this campaign and how much you can pay each of them.</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                              <label>Select Currency</label>
                              <select class="form-select " name="currency_type" form="form1" style="line-height: 35px;" id="currency">
                              <option value=""  selected disabled>Select</option>
                              
                                <option data-id="WALLET ADDRESS(USDT)" value="USDT" >USDT</option>
                                <option data-id="WALLET ADDRESS(COINEXPT)" value="COINEXPT" >COINEXPT</option>
                              </select>
                              @error('currency_type')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                          <div class="col-lg-4">
                            <div class="cost-input">
                              <label>Promoter to Earn</label>
                              <input type="text" class="promotorEarn form-control" id="proEarn" name="promoters_earn" placeholder="Type amount each" value="{{old('promoters_earn')}}" form="form1">
                              @error('promoters_earn')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="cost-input">
                              <label>Promoters Needed (Minimum of 1)</label>
                              <input type="text" class="promoterNeed form-control" id="proNeeded" name="promoters_needed" placeholder="Type numbers" value="{{old('promoters_needed')}}" form="form1">
                              @error('promoters_needed')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          
                          <div class="col-lg-4">
                            <div class="cost-input">
                              <label>Campaign Cost</label>
                              <input type="text" id="camp_cost" class="form-control" onchange="costFunction()" name="campaign_cost" placeholder="Campaign Cost" value="{{old('campaign_cost')}}" form="form1" readonly>
                              @error('campaign_cost')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 col-md-12">
                        <div class="row color-sec">
                          <div class="col-lg-6 col-md-6">
                            <div class="coo-box">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="color-check">
                                    <p>Select Color</p>
                                    <input type="radio" name="colors" id="highlight_color" value="LG" @if (old('colors') == 'LG') checked @endif data-price="0.3" form="form1">&nbsp;<label>LG</label>
                                    <input type="radio" name="colors" id="highlight_color" value="Y" @if (old('colors') == 'Y') checked @endif data-price="0.3" form="form1">&nbsp;<label>Y</label>
                                    <input type="radio" name="colors" id="highlight_color" value="L" @if (old('colors') == 'L') checked @endif data-price="0.3" form="form1">&nbsp;<label>L</label>
                                  </div>
                                  
                                </div>
                                <div class="col-lg-12">
                                  <div class="color-check2">
                                  <p> Highlight My Campaign ($0.3)(OPTIONAL)</p>
                                    <p><strong>BENEFITS:</strong></p>
                                    <ul>
                                      <li>Appear with background highlighted effect</li>
                                      <li>Easily gets the attention of promoters</li>
                                      <li>Looks aesthetic </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="coo-box">
                              <div class="color-check2">
                              <!-- style="display:block; !important" -->
                                <input type="checkbox" name="featured_campaign" id="featured_campaign" value="1" @if (old('featured_campaign') == '1') checked @endif data-price="0.7" form="form1" style="display:inline-block;">&nbsp;
                                <label>Featured My Campaign ($0.7)(OPTIONAL)</label>
                                <p><strong>BENEFITS:</strong></p>
                                <ul>
                                  <li>Always randomly appear ontop</li>
                                  <li>Easily gets the attention of promoters</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="row align-items-center">
                          <div class="col-lg-6 col-md-6">
                            <div class="with-img">
                              <img src="<?php echo BASEURL; ?>images/withdraw2.png" alt="">
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="with-text">
                              <ul>
                                <li>Select campaign admin</li>
                                <li>Copy wallet address and make UDST or BUSD payment in BEP 20 only</li>
                                <li>Click Paid botton</li>
                                <li>Paste and send your payment transaction harsh</li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="campaign-admin">
                          <div class="table_responsive_maas">
                            <table class="table table-hover" id="example"> 
                              <thead>
                                <tr>
                                  <th width="20%">CAMPAIGN ADMINS</th>
                                  <th width="20%" ><input type="text" id="address" value="WALLET ADDRESS" class="wallet"></th>
                                  <th width="20%">PAID?</th>
                                  <th width="30%">TRANSACTION HARSH</th>
                                  <!-- <th width="10%">SEND?</th> -->
                                </tr>
                              </thead>
                              <tbody>

                                
                                <tr>
                                  <td align="left"><div class="selct-box">
                                    <select class="form-select" name="designation" id="admin">

                                      @foreach ($tvl_admins as $tvl_admin)
                                      @if (old('designation') == $tvl_admin->admin_id)
                                      <option data-id="{{ $tvl_admin->wallet_address }}" value="{{ $tvl_admin->admin_id }}" selected>{{ $tvl_admin->name }}</option>
                                      @else
                                      <option data-id="{{ $tvl_admin->wallet_address }}" value="{{ $tvl_admin->admin_id }}">{{ $tvl_admin->name }}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                  </div>
                                  </td>
                                  <td>
                                  <div class="input-group">
                                    
                                  <input type="text"  name="wallet_addr" id="wallet" class="form-control copy_text" value="{{$tvl_admin->wallet_address}}" readonly>
                                    <div class="input-group-append">
                                    <button class="input-group-text copy" type="submit" form="form2">
                                    <i class="fal fa-copy"></i>
                                    </button>
                                    </div>
                                  </div>
                                    <!-- <input type="text"  name="wallet_addr" class="form-control copy_text" value="{{$tvl_admin->wallet_address}}">
                                    <button class="btn btn-primary copy" type="submit" form="form2">
                                    <i class="fal fa-copy"></i>
                                    </button> -->
                                  
                                  </td>
                                  <td>
                                    <div class="controls"><a href="#" class="click" data-bs-toggle="modal" data-bs-target="#rejectModal">Paid</a></div>
                                  </td>
                                  <td>
                                    <input type="text"  id="field2" name="transaction_amt" class="form-control paste_text"  value="{{old('transaction_amt')}}">
                                    
                                    
                                    @error('transaction_amt')
                              <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                              @enderror</td>
                                  <!-- <td><button type="button" id="submit">Send</td> -->
                                </tr>
                              
                              

                              </tbody>
                            </table>
                          </div>
                          <div class="admin-button">
                            <button type="submit" form="form1">Click here to submit campaign</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- </form> -->
                  </div> 
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table social-box-tab">
                      <tbody>
                      @foreach ($promotion as $promote)
                        <tr>
                          <td scope="row">{{$promote->pr_name}}</td>
                          <td><a href="{{$promote->pr_link}}" target="_blank">Click here to reach agent</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
          </form>
          <div class="col-lg-12 mx-auto finish-head">
            <div class="table_responsive_maas">
              <table class="table table-hover" style="height:20px; overflow-y:scroll">
                <thead>

                  <tr>
                    <th width="5%">ID </th>
                    <th width="25%">Campaign Type</th>
                    <th width="15%">Status</th>
                    <th width="10%">Campaign Upload</th>
                    <th width="25%">Social To Promote campaign</th>
                    <th width="10%">Date </th>
                    <th width="5%">Pending Jobs</th>
                    <th width="5%">History Page</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($tvl_campaigns as $key=>$tvl_campaign)
                  <tr>
                    <td>{{$tvl_campaign->campaign_id}} </td>
                    <td><a href="{{route('jobdetail', ['id' => $tvl_campaign->campaign_id])}}">{{$tvl_campaign->campaign_category_name}}</a></td>
                    @if ($tvl_campaign->tvl_status == 'Pending')
                    <td style="color: #ff7600;font-weight: 500;">Pending</td>
                    @elseif ($tvl_campaign->tvl_status == 'Published')
                    <td style="color: #1dbb00;font-weight: 500;">Published </td>
                    @elseif ($tvl_campaign->tvl_status == 'Rejected')
                    <td style="color: #e11010;font-weight: 500;">Rejected</td>
                    @else
                    <td></td>
                    @endif 
                   
                   @if($tvl_campaign->file_type == 'video')
                    <td>Video</td>
                    @elseif($tvl_campaign->file_type == 'banner')
                    <td>Banner</td>
                    @elseif($tvl_campaign->file_type == 'text_content')
                    <td>Text Content</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <td>{{$tvl_campaign->social_platform_name}}</td>
                    <td>{{date("d-M-Y", strtotime($tvl_campaign->created))}}</td>
                    <td><a href="{{route('jobdone', ['id' => $tvl_campaign->campaign_id])}}" class="click">Click </a></td>
                    <td><a href="{{route('history', ['id' => $tvl_campaign->campaign_id])}}" class="click">Click </a></td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
              <div class="float-end">
                {{$tvl_campaigns->links()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--============================= cancelled =============================-->

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body can-modal">
      <!-- <img src="{{BASEURL}}images/modal-bg.png" alt=""> -->
      <h5 class="modal-title" id="exampleModalLabel">Paid?</h5>
      <p>You said you have sent payment to the 
selected campaign admin? Paste your transaction harsh for verification</p>
    </div>
 
  </div>
</div>
</div>


<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 472px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body rej-modal">
        <div class="rejcet-img">
          <img src="<?php echo BASEURL; ?>images/reject-taskbg.png">
        </div>
        <div class="reject-txt">
          <h5>State reason for rejecting the task</h5>
          <textarea placeholder="write your reason here and submit to admin to review your complaints" rows="5">
          </textarea>

        </div>
        <div class="pass-title" style="margin-top: 30px; margin-bottom: 6px;">
          <button>Submit</button>
        </div>

      </div>
    </div>
  </div>
</div>

<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
<!---=====//Campain Calculation//====--->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
$('input:radio[name="colors"]').change(function(){
  if ($(this).is(':checked')) {
    var feature_cost = parseFloat(0);
    var proNeeded = $("#proNeeded").val();
    var proEarn = $("#proEarn").val();
    proNeeded = (proNeeded == "") ? 0 : parseFloat(proNeeded.replace(/,/g, ''));
    proEarn = (proEarn == "") ? 0 : parseFloat(proEarn.replace(/,/g, ''));
    if ($("#featured_campaign").is(':checked')) {
      feature_cost = $("#featured_campaign").attr('data-price');
    }else{
      feature_cost = 0;
    }
    var highlight_cost = $("#highlight_color").attr('data-price');

    var TotalCost = (parseFloat(proNeeded) * parseFloat(proEarn)) + parseFloat(highlight_cost) + parseFloat(feature_cost);

    var percentage = TotalCost / 100;
    var CampainCost = TotalCost + (9.5 * percentage);
    $("#camp_cost").val(CampainCost);
    //alert(proNeeded);
  }
});

$('input:checkbox[name="featured_campaign"]').change(function(){
  if ($(this).is(':checked')) {
    var highlight_cost = parseFloat(0);
    var proNeeded = $("#proNeeded").val();
    var proEarn = $("#proEarn").val();
    proNeeded = (proNeeded == "") ? 0 : parseFloat(proNeeded.replace(/,/g, ''));
    proEarn = (proEarn == "") ? 0 : parseFloat(proEarn.replace(/,/g, ''));
    if ($("#highlight_color").is(':checked')) {
      highlight_cost = $("#highlight_color").attr('data-price');
    }
    var feature_cost = $("#featured_campaign").attr('data-price');

    var TotalCost = (parseFloat(proNeeded) * parseFloat(proEarn)) + parseFloat(highlight_cost) + parseFloat(feature_cost);

    var percentage = TotalCost / 100;
    var CampainCost = TotalCost + (9.5 * percentage);
    $("#camp_cost").val(CampainCost);
    //alert(proNeeded);
  }else{
    var TotalCost = (parseFloat(proNeeded) * parseFloat(proEarn)) + parseFloat(highlight_cost) ;
    }
});

$('.promoterNeed').on('focusout', function() {
  var feature_cost = parseFloat(0);
  var highlight_cost = parseFloat(0);
  var proNeeded = $("#proNeeded").val();
    var proEarn = $("#proEarn").val();
    proNeeded = (proNeeded == "") ? 0 : parseFloat(proNeeded.replace(/,/g, ''));
    proEarn = (proEarn == "") ? 0 : parseFloat(proEarn.replace(/,/g, ''));
    if ($("#highlight_color").is(':checked')) {
      highlight_cost = $("#highlight_color").attr('data-price');
    }
    if ($("#featured_campaign").is(':checked')) {
      feature_cost = $("#featured_campaign").attr('data-price');
    }else{
      feature_cost = 0;
    }
    var TotalCost = (parseFloat(proNeeded) * parseFloat(proEarn)) + parseFloat(highlight_cost) + parseFloat(feature_cost);
    var percentage = TotalCost / 100;
    var CampainCost = TotalCost + (9.5 * percentage);
    $("#camp_cost").val(CampainCost);
    //alert(proNeeded);
});
$('.promotorEarn').on('focusout', function() {
  var feature_cost = parseFloat(0);
  var highlight_cost = parseFloat(0);
  var proNeeded = $("#proNeeded").val();
    var proEarn = $("#proEarn").val();
    proNeeded = (proNeeded == "") ? 0 : parseFloat(proNeeded.replace(/,/g, ''));
    proEarn = (proEarn == "") ? 0 : parseFloat(proEarn.replace(/,/g, ''));
    if ($("#highlight_color").is(':checked')) {
      highlight_cost = $("#highlight_color").attr('data-price');
    }
    if ($("#featured_campaign").is(':checked')) {
      feature_cost = $("#featured_campaign").attr('data-price');
    }else{
      feature_cost = 0;
    }
    var TotalCost = (parseFloat(proNeeded) * parseFloat(proEarn)) + parseFloat(highlight_cost) + parseFloat(feature_cost);
    var percentage = TotalCost / 100;
    var CampainCost = TotalCost + (9.5 * percentage);
    $("#camp_cost").val(CampainCost);
    //alert(proNeeded);
});
});
  


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

<script>
  $(document).on('change', '.div-toggle', function() {
    var target = $(this).data('target');
    var show = $("option:selected", this).data('show');
    $(target).children().addClass('hide');
    $(show).removeClass('hide');
  });
  $(document).ready(function() {
    $('.div-toggle').trigger('change');
  });
</script>
<script type="text/javascript">
$(document).ready(function () {
$('#admin').on('change',function() {
  $('#wallet').val($('#admin option:selected').data('id'));
    console.log($('#admin option:selected').data('id'));
})
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$('#currency').on('change',function() {
  $('#address').val($('#currency option:selected').data('id'));
    console.log($('#currency option:selected').data('id'));
})
});
</script>

<script>
  document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
      inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
      if (inputElement.files.length) {
        updateThumbnail(dropZoneElement, inputElement.files[0]);
      }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
      dropZoneElement.addEventListener(type, (e) => {
        dropZoneElement.classList.remove("drop-zone--over");
      });
    });

    dropZoneElement.addEventListener("drop", (e) => {
      e.preventDefault();

      if (e.dataTransfer.files.length) {
        inputElement.files = e.dataTransfer.files;
        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
      }

      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  /**
   * Updates the thumbnail on a drop zone element.
   *
   * @param {HTMLElement} dropZoneElement
   * @param {File} file
   */
  function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
      dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
      thumbnailElement = document.createElement("div");
      thumbnailElement.classList.add("drop-zone__thumb");
      dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
      const reader = new FileReader();

      reader.readAsDataURL(file);
      reader.onload = () => {
        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
      };
    } else {
      thumbnailElement.style.backgroundImage = null;
    }
  }
</script>
<script>
  VirtualSelect.init({ 
    ele: '#multipleselect' 
  });
</script>
<script>
$(document).ready(function() {
  var disabled = false;
  $('#submit').click(function() {
      if (disabled) {
          $("#trans_amt").prop('disabled', false);       // if disabled, enable
      }
      else {
          $("#trans_amt").prop('disabled', true);        // if enabled, disable
      }
      disabled = !disabled;
     
  })
  
});
</script>
<script>
var copyTextareaBtn = document.querySelector('.copy');

copyTextareaBtn.addEventListener('click', function(event) {
var copyTextarea = document.querySelector('.copy_text');
copyTextarea.focus();
copyTextarea.select();

try {
  var successful = document.execCommand('copy');
  var msg = successful ? 'successful' : 'unsuccessful';
  console.log('Copying text command was ' + msg);
} catch (err) {
  console.log('Oops, unable to copy');
}
});
</script>


@include("layouts.footer")
