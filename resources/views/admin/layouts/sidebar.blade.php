<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <!-- <li class="menu-title">
                    <span>Main</span>
                </li> -->

                <!-- Dashboard -->
                <li class="{{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i data-feather="compass"></i>
                        <span>
                            {{__('sidebar.dashboard')}}
                        </span>
                    </a>
                </li>
                <!-- /Dashboard -->

                <!-- CMS -->
                <?php //echo auth()->guard('admin')->user(); ?>
                @if(auth()->guard('admin')->user()->can('cmspage-list') || auth()->guard('admin')->user()->can('cmscategory-list'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu">{{__('sidebar.cms')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            @can('cmscategory-list')
                                <li>
                                    <a href="{{ route('cmscategories.index') }}" title="{{__('sidebar.category')}}" class="sidebar-link {{ (request()->is('admin/cmscategories*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.category')}}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('cmspage-list')
                                <li>
                                    <a href="{{ route('cmspages.index') }}" title="{{__('sidebar.cms-pages')}}" class="sidebar-link {{ (request()->is('admin/cmspage*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.cms-pages')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                <!-- /CMS -->
                  <!-- Ad Section-->
                <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu">Ad Section</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul>
                                <li>
                                    <a href="{{ route('adsection.index') }}" title="Ad Section" class="sidebar-link {{ (request()->is('admin/cmscategories*')) ? 'active' : '' }}">
                                        <span class="hide-menu">Ad Section</span>
                                    </a>
                                </li>
                        </ul>
                    </li>
                <!-- /Ad Section-->
               

                <!-- Staff -->
                @if(auth()->guard('admin')->user()->can('user-list') || auth()->guard('admin')->user()->can('role-list') || auth()->guard('admin')->user()->can('permission-list') || auth()->guard('admin')->user()->can('user-activity'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="users"></i>
                            <span class="hide-menu">{{__('sidebar.staff')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            @can('user-list')
                                <li>
                                    <a href="{{ route('users.index') }}" title="{{__('sidebar.staff')}}" class="sidebar-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.staff')}}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('role-list')
                                <li>
                                    <a href="{{ route('roles.index') }}" title="{{__('sidebar.roles')}}" class="sidebar-link {{ (request()->is('admin/roles*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.roles')}}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('permission-list')
                                <li>
                                    <a href="{{ route('permissions.index') }}" title="{{__('sidebar.permissions')}}" class="sidebar-link {{ (request()->is('admin/permissions*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.permission')}}</span>
                                    </a>
                                </li>
                            @endcan
                            {{-- 
                            @can('user-activity')
                                <li>
                                    <a href="/admin/user-activity" title="{{__('sidebar.user-activity')}}" class="sidebar-link {{ (request()->is('admin/setting/useractivity*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.user-activity')}}</span>
                                    </a>
                                </li>
                            @endcan
                            --}}
                        </ul>
                    </li>
                @endif
                <!-- /staff -->
                 <!-- Promotor -->
                 @if(auth()->guard('admin')->user()->can('userpromotor-list'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="users"></i>
                            <span class="hide-menu">{{__('sidebar.user')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                        @can('userpromotor-list')
                                <li>
                                    <a href="{{ route('userpromotors.index') }}" title="{{__('sidebar.user')}}" class="sidebar-link {{ (request()->is('admin/userpromotor*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.user')}}</span>
                                    </a>
                                </li>
                        @endcan
                        @can('activeuser-list')
                                <li>
                                    <a href="{{ route('activeusers.index') }}" title="{{__('sidebar.activeuser')}}" class="sidebar-link {{ (request()->is('admin/activeuser*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.activeuser')}}</span>
                                    </a>
                                </li>
                        @endcan
                        @can('inactiveuser-list')
                                <li>
                                    <a href="{{ route('inactiveusers.index') }}" title="{{__('sidebar.inactiveuser')}}" class="sidebar-link {{ (request()->is('admin/inactiveuser*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.inactiveuser')}}</span>
                                    </a>
                                </li>
                        @endcan
                        @can('deleteduser-list')
                                <li>
                                    <a href="{{ route('deletedusers.index') }}" title="{{__('sidebar.deleteduser')}}" class="sidebar-link {{ (request()->is('admin/deletedusers*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.deleteduser')}}</span>
                                    </a>
                                </li>
                        @endcan
                        </ul>
                    </li>
                    @endif
                <!-- /Promotor -->

                 <!-- Promotor -->
                 @if(auth()->guard('admin')->user()->can('jobs-list'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="clipboard"></i>
                            <span class="hide-menu">{{__('sidebar.job')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                        @can('jobs-list')
                                <li>
                                    <a href="{{ route('jobspaces.index') }}" title="{{__('sidebar.jobs')}}" class="sidebar-link {{ (request()->is('admin/jobspace*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.jobs')}}</span>
                                    </a>
                                </li>
                        @endcan
                        @can('joblist-list')
                            <li>
                                <a href="{{ route('joblists.index') }}" title="{{__('sidebar.joblist')}}" class="sidebar-link {{ (request()->is('admin/joblists*')) ? 'active' : '' }}">
                                    <span class="hide-menu">{{__('sidebar.joblist')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('rejected-list')
                            <li>
                                <a href="{{ route('rejectedjoblists.index') }}" title="{{__('sidebar.rejectedjoblist')}}" class="sidebar-link {{ (request()->is('admin/rejectedjoblists*')) ? 'active' : '' }}">
                                    <span class="hide-menu">{{__('sidebar.rejectedjoblist')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('suspended-list')
                            <li>
                                <a href="{{ route('suspendedjoblists.index') }}" title="{{__('sidebar.suspendedjoblist')}}" class="sidebar-link {{ (request()->is('admin/suspendedjoblists*')) ? 'active' : '' }}">
                                    <span class="hide-menu">{{__('sidebar.suspendedjoblist')}}</span>
                                </a>
                            </li>
                        @endcan

                        @can('deleted-list')
                            <li>
                                <a href="{{ route('deletedjoblists.index') }}" title="{{__('sidebar.deletedjoblist')}}" class="sidebar-link {{ (request()->is('admin/deletedjoblists*')) ? 'active' : '' }}">
                                    <span class="hide-menu">{{__('sidebar.deletedjoblist')}}</span>
                                </a>
                            </li>
                        @endcan
                       
                        @can('reported-campaign')
                            <li>
                                <a href="{{ route('reported_campaign') }}" title="{{__('sidebar.reported_campaign')}}" class="sidebar-link {{ (request()->is('admin/joblists*')) ? 'active' : '' }}">
                                    <span class="hide-menu">{{__('sidebar.reported_campaign')}}</span>
                                </a>
                            </li>
                        @endcan
                        </ul>
                    </li>
                    @endif
                <!-- /Promotor -->

                <!--Disciplinary Officer --->
                @if(auth()->guard('admin')->user()->can('employers-complaints'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="user"></i>
                            <span class="hide-menu">{{__('sidebar.employers complain')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                        @can('employers-complaints')
                                <li>
                                    <a href="{{ route('employers.complain') }}" title="{{__('sidebar.employers complain')}}" class="sidebar-link {{ (request()->is('admin/employer*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.employers complains')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('employers-sociallink')
                               
                                <li>
                                    <a href="{{ route('sociallink_verified.sociallink') }}" title="{{__('sidebar.sociallink_verified')}}" class="sidebar-link {{ (request()->is('admin/sociallink_verified*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.sociallink_verified')}}</span>
                                    </a>
                                </li>
                                @endcan
                        </ul>
                    </li>
                    @endif

                <!--Disciplinary Officer --->
                 <!-- Account Officer -->
                 @if(auth()->guard('admin')->user()->can('sociallink-list'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="user"></i>
                            <span class="hide-menu">{{__('sidebar.social_link')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                        @can('campaigntype-list')
                                <li>
                                    <a href="{{ route('campaigntypes.index') }}" title="{{__('sidebar.campaigntype')}}" class="sidebar-link {{ (request()->is('admin/campaigntypes*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.campaigntype')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('socialplatformlinks-list')
                                <li>
                                    <a href="{{ route('socialplatformlinks.index') }}" title="{{__('sidebar.socialplatformlinks')}}" class="sidebar-link {{ (request()->is('admin/socialplatformlinks*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.socialplatformlinks')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('socialplatform-list')
                                <li>
                                    <a href="{{ route('socialplatforms.index') }}" title="{{__('sidebar.socialplatform')}}" class="sidebar-link {{ (request()->is('admin/socialplatforms*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.socialplatform')}}</span>
                                    </a>
                                </li>
                            @endcan
                             @can('sociallink-list')
                                <li>
                                    <a href="{{ route('sociallinks.index') }}" title="{{__('sidebar.social_link')}}" >
                                        <span class="hide-menu">{{__('sidebar.sociallinks')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('pr-list')
                                <li>
                                    <a href="{{ route('promotion.index') }}" title="{{__('sidebar.prlists')}}" >
                                        <span class="hide-menu">{{__('sidebar.prlists')}}</span>
                                    </a>
                                </li>
                                @endcan
                        </ul>
                    </li>
                    @endif
                <!-- /Account Officer -->
                @if(auth()->guard('admin')->user()->can('influence-list')) 
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu">{{__('sidebar.influence')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            @can('influence-list')
                                <li>
                                    <a href="{{ route('influence_marketing.index') }}" title="{{__('sidebar.influence')}}" class="sidebar-link {{ (request()->is('admin/influence_marketing*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.influence')}}</span>
                                    </a>
                                </li>
                            @endcan

                             </ul>
                    </li>
                @endif
                <!-- /CMS -->
                 <!-- Accountant -->
                 @if(auth()->guard('admin')->user()->can('accountant-list'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="user"></i>
                            <span class="hide-menu">{{__('sidebar.accountant')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                        @can('withdraw-list')
                                <li>
                                    <a href="{{ route('withdraws.index') }}" title="{{__('sidebar.withdraw')}}" class="sidebar-link {{ (request()->is('admin/accountant*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.withdraw')}}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('cancelwithdraw-list')
                                <li>
                                    <a href="{{ route('cancelwithdraw.index') }}" title="{{__('sidebar.cancelwithdraw')}}" class="sidebar-link {{ (request()->is('admin/cancelwithdraw*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.cancelwithdraw')}}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('confirmwithdraw-list')
                                <li>
                                    <a href="{{ route('confirmwithdraw.index') }}" title="{{__('sidebar.confirmwithdraw')}}" class="sidebar-link {{ (request()->is('admin/confirmwithdraw*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.confirmwithdraw')}}</span>
                                    </a>
                                </li>
                                @endcan

                                @can('transaction-list')
                                <li>
                                    <a href="{{ route('transactions.index') }}" title="{{__('sidebar.transaction')}}" class="sidebar-link {{ (request()->is('admin/transaction*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.transaction')}}</span>
                                    </a>
                                </li>
                                @endcan
                        </ul>
                    </li>
                    @endif
                <!-- /Accountant -->
                 <!-- Our Partners-->
                <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu">Our Partners</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul>
                                <li>
                                    <a href="{{ route('ourpartners.index') }}" title="Our Partners" class="sidebar-link {{ (request()->is('admin/ourpartners*')) ? 'active' : '' }}">
                                        <span class="hide-menu">Our Partners</span>
                                    </a>
                                </li>
                        </ul>
                    </li>
                <!-- /Our Partners-->
                   <!-- Reviews-->
                <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu">Reviews</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul>
                                <li>
                                    <a href="{{ route('reviews.index') }}" title="Reviews" class="sidebar-link {{ (request()->is('admin/reviews*')) ? 'active' : '' }}">
                                        <span class="hide-menu">Reviews</span>
                                    </a>
                                </li>
                        </ul>
                    </li>
                <!-- /Our Partners-->
                <!-- Settings -->
                @if(auth()->guard('admin')->user()->can('file-manager') || auth()->guard('admin')->user()->can('currency-list') || auth()->guard('admin')->user()->can('websetting-edit') || auth()->guard('admin')->user()->can('log-view'))
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="settings"></i>
                            <span class="hide-menu">{{__('sidebar.settings')}} </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            {{-- 
                            @can('currency-list')
                                <li>
                                    <a href="{{ route('currencies.index') }}" title="{{__('sidebar.currencies')}}" class="sidebar-link {{ (request()->is('admin/currencies*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.currency')}}</span>
                                    </a>
                                </li>
                            @endcan
                            --}}
                            @can('websetting-edit')
                                <li>
                                    <a href="{{route('website-setting.edit')}}" title="{{__('sidebar.website-setting')}}" class="sidebar-link {{ (request()->is('admin/setting/website-setting*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.website-setting')}}</span>
                                    </a>
                                </li>
                            @endcan
                           
                            @can('file-manager')
                                <li>
                                    <a href="{{route('filemanager.index')}}" title="{{__('sidebar.file-manager')}}" class="sidebar-link {{ (request()->is('admin/setting/file-manager*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.file-manager')}}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('log-view')
                                {{--<li>
                                    <a href="/admin/log-reader" title="{{__('sidebar.read-logs')}}" class="sidebar-link {{ (request()->is('admin/setting/log*')) ? 'active' : '' }}">
                                        <span class="hide-menu">{{__('sidebar.read-logs')}}</span>
                                    </a>
                                </li>--}}
                            @endcan
                           
                        </ul>
                    </li>
                @endif
                <!-- /Settings -->



            </ul>
        </div> <!-- /Sidebar-Menu -->
    </div> <!-- /Sidebar-inner -->
</div><!-- /Sidebar -->
