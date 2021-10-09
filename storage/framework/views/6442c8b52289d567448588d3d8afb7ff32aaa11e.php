<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a class="mt-3" href="<?php echo e(URL::to('/')); ?>" target="_blank">
                <img src="<?php echo e(URL::to('/')); ?>/public/img/swapnoloke.png" alt="dysin" width="75%" class="logo-default" title="<?php echo e(trans('english.VISIT_WEBSITE')); ?>" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PROGRAM SWITCH -->



        <!-- END PROGRAM SWITCH -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                <!-- END INBOX DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <?php if(isset(Auth::user()->photo)): ?>
                        <img class="img-circle" width="40" height="40" src="<?php echo e(URL::to('/')); ?>/public/uploads/user/<?php echo e(Auth::user()->photo); ?>">
                        <?php else: ?>
                        <img class="img-circle" width="40" height="40" src="<?php echo e(URL::to('/')); ?>/public/img/unknown.png">
                        <?php endif; ?>
                        <span class="username username-hide-on-mobile"> <?php echo e(Auth::user()->first_name.' '. Auth::user()->last_name); ?> (<?php echo e(Auth::user()->UserGroup->name); ?>)  </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <?php if(!empty(Auth::user()->password_changed)): ?>
                        <li>
                            <a href="<?php echo e(URL::to('users/profile/')); ?>">
                                <i class="icon-user"></i> <?php echo e(trans('english.MY_PROFILE')); ?> </a>
                        </li>
                        <li>
                            <a href="<?php echo e(URL::to('users/cpself/')); ?>">
                                <i class="icon-lock"></i> <?php echo e(trans('english.CHANGE_PASSWORD')); ?> </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i><?php echo app('translator')->get('english.LOGOUT'); ?>
                            </a>

                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                            document.getElementById('logout-form2').submit();" title="" data-original-title="<?php echo app('translator')->get('english.LOGOUT_'); ?>" data-toggle="tooltip" data-placement="bottom" class="show-tooltip">
                        <i class="fa fa-power-off"></i>
                    </a>
                    <form id="logout-form2" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/includes/header.blade.php ENDPATH**/ ?>