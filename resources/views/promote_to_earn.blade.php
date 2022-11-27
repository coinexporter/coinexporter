<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Promote To Earn')
@include("layout.menu")

<!-- ======================Main Content================== -->
{!! $promote->description !!}

<section class="dark-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="table_responsive_maas">                
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th width="5%">Serial</th>
                            <th width="10%">Social Channels</th>
                            <th width="5%">Followers/Subscribers</th>
                            <th width="20%">Activeness</th>
                            <th width="10%">No. of Posts</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Personal Twitter Timeline</td>
                            <td>200 Followers</td>
                            <td>Active</td>
                            <td>2 per week</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Personal Facebook Timeline</td>
                            <td>200 Followers</td>
                            <td>Active</td>
                            <td>2 per week</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Personal Instagram Timeline</td>
                            <td>200 Followers</td>
                            <td>Active</td>
                            <td>2 per week</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Personal Tik-Tok Timeline </td>
                            <td>200 Followers</td>
                            <td>Active</td>
                            <td>2 per week</td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>Cryptocurrency Telegram Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>10 per week</td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>Cryptocurrency Facebook Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>10 per week</td>
                          </tr>
                          <tr>
                            <td>7</td>
                            <td>Cryptocurrency Instagram Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>10 per week</td>
                          </tr>
                          <tr>
                            <td>8</td>
                            <td>Cryptocurrency Twitter Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>10 per week</td>
                          </tr>
                          <tr>
                            <td>9</td>
                            <td>Cryptocurrency YouTube Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>4 per week</td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Cryptocurrency Discord Group/Channel</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>4 per week</td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Cryptocurrency Blogging Sites</td>
                            <td></td>
                            <td>Active</td>
                            <td>10 per week</td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Cryptocurrency Reddit
                                Group/Channels</td>
                            <td>500 Members</td>
                            <td>Active</td>
                            <td>5 per week</td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Cryptocurrency Website
                                Listings</td>
                            <td></td>
                            <td>Active</td>
                            <td>k</td>
                          </tr>
                          
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </div>
</section>



<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>



@include("layout.footer")