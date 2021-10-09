<?php
$currentControllerFunction = Route::currentRouteAction();
$currentCont = preg_match('/([a-z]*)@/i', request()->route()->getActionName(), $currentControllerFunction);
$currentControllerName = Request::segment(1);
//dd($currentControllerName);
$currentFullRouteName = Route::getFacadeRoot()->current()->uri();
$action = Route::currentRouteAction();
?>
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->

            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
            <?php if(!empty(Auth::user()->password_changed)): ?>

            <?php if(!empty(Session::get('program_id'))): ?>
            <li class="nav-item <?php echo (in_array($currentControllerName, array('dashboard', 'library', 'message', 'eresources'))) ? 'start active open' : ''; ?>">
                <a href="<?php echo e(URL::to('dashboard')); ?>"  class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title"><?php echo e(trans('english.DASHBOARD')); ?></span>

                </a>
            </li>

            <?php if(Auth::user()->group_id <= '2' || Auth::user()->group_id == '6'): ?>
            <li class="nav-item <?php echo (in_array($currentControllerName, array('userGroup', 'users', 'designation', 'appointment', 'branch'))) ? 'start active open' : ''; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title"><?php echo e(trans('english.USER_MANAGEMENT')); ?></span>

                    <span class="arrow open"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item <?php echo ($currentControllerName == 'userGroup') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('userGroup')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.USER_GROUP')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'designation') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('designation')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.RANK_MANAGEMENT')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'appointment') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('appointment')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.APPOINTMENT_MANAGEMENT')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'branch') ? 'start active open' : ''; ?> ">
                        <a href="<?php echo e(URL::to('branch')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.BRANCH_MANAGEMENT')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'users') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('users')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.USER_MANAGEMENT')); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo (in_array($currentControllerName, array('jobNature', 'circular'))) ? 'start active open' : ''; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-briefcase"></i>
                    <span class="title"><?php echo e(trans('english.JOB_MANAGEMENT')); ?></span>

                    <span class="arrow open"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item <?php echo ($currentControllerName == 'jobNature') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('jobNature')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.JOB_NATURE')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'circular') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('circular')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.JOB_CIRCULAR')); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?php echo (in_array($currentControllerName, array('applicant', 'discardedApplication', 'reviewedApplication', 'selectForInterview','confirmedApplication','participatedApplicant','recruitedApplicant'))) ? 'start active open' : ''; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-file-text-o"></i>
                    <span class="title"><?php echo e(trans('english.JOB_APPLICATION')); ?></span>

                    <span class="arrow open"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item <?php echo ($currentControllerName == 'applicant') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('applicant')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.PENDING')); ?></span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($currentControllerName == 'discardedApplication') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('discardedApplication')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.DISCARDED')); ?></span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($currentControllerName == 'reviewedApplication') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('reviewedApplication')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.REVIEWED')); ?></span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($currentControllerName == 'selectForInterview') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('selectForInterview')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.SELECTED_FOR_INTERVIEW')); ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item <?php echo ($currentControllerName == 'confirmedApplication') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('confirmedApplication')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.CONFIRMED')); ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item <?php echo ($currentControllerName == 'participatedApplicant') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('participatedApplicant')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.PARTICIPATED')); ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item <?php echo ($currentControllerName == 'recruitedApplicant') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('recruitedApplicant')); ?>" class="nav-link ">
                            <span class="title"><?php echo e(trans('english.RECRUITED')); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

<!--<li class="nav-item <?php echo (in_array($currentControllerName, array('configuration', 'instrForEpe', 'signatory', 'scrollmessage'))) ? 'start active open' : ''; ?>">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-settings"></i>
        <span class="title"><?php echo e(trans('english.SETTING')); ?></span>

        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
       
    </ul>
</li>-->

            <?php endif; ?>

            <?php endif; ?>

            <?php if(in_array(Auth::user()->group_id, [1])): ?>

            <li class="nav-item <?php
            echo (in_array($currentControllerName, array('product', 'qualityFactor'
                , 'statistics', 'certifications', 'services', 'sisterConcerns'
                , 'faculty', 'downloads', 'contact-info', 'ourService'
                , 'support', 'follow-us', 'content', 'coas-trophy'
                , 'torchbearer', 'programFeatures', 'programGallery', 'publication'
                , 'catpublication', 'publication', 'affiliations', 'ourPrograms'
                , 'ourSpecialty', 'businessSegments', 'slider', 'menu', 'whoWeAre'
                , 'messageFromOC', 'newsAndEvents', 'gAlbum', 'gallery', 'majorCategories'
                , 'productCategory', 'product', 'publication', 'contact-info', 'welcomeDcare'
                , 'orderSate'))) ? 'start active open' : '';
            ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-check"></i>
                    <span class="title"><?php echo app('translator')->get('english.WEBSITE'); ?></span>

                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php echo ($currentControllerName == 'menu') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('menu')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.MAIN_MENU'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'content') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('content')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.CONTENT'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'slider') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('slider')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.SLIDER'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'whoWeAre') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('whoWeAre')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.WHO_WE_ARE'); ?></span>
                        </a>
                    </li>
                    <!-- <li class="nav-item <?php echo ($currentControllerName == 'messageFromOC') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('messageFromOC')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.MESSAGE_FROM_OC'); ?></span>
                        </a>
                    </li> -->
<!--                    <li class="nav-item <?php echo ($currentControllerName == 'businessSegments') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('businessSegments')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.BUSINESS_SEGMENTS'); ?></span>
                        </a>
                    </li>-->
                    <li class="nav-item <?php echo ($currentControllerName == 'ourSpecialty') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('ourSpecialty')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.OUR_SPECIALITY'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'majorCategories') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('majorCategories')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.MAJOR_CATEGORIES'); ?></span>
                        </a>
                    </li>



                    <li class="nav-item <?php echo ($currentControllerName == 'affiliations') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('affiliations')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.AFFILIATIONS_MEMBERSHIPS'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($currentControllerName == 'newsAndEvents') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('newsAndEvents')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.LATEST_NEWS_EVENTS'); ?></span>
                        </a>
                    </li>
<!--                    <li class="nav-item <?php echo ($currentControllerName == 'statistics') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('statistics')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.STATISTICS'); ?></span>
                        </a>
                    </li>-->
                    <li class="nav-item <?php echo ($currentControllerName == 'publication') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('publication')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.PUBLICATION'); ?></span>
                        </a>
                    </li>
<!--                    <li class="nav-item <?php echo ($currentControllerName == 'ourPrograms') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('ourPrograms')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.OUR_PROGRAM'); ?></span>
                        </a>
                    </li>-->
                    <li class="nav-item <?php echo ($currentControllerName == 'contact-info') ? 'start active open' : ''; ?>">
                        <a href="<?php echo e(URL::to('contact-info')); ?>" class="nav-link ">
                            <span class="title"><?php echo app('translator')->get('english.CONTACT'); ?></span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo (in_array($currentControllerName, array('gAlbum', 'gallery'))) ? 'start active open' : ''; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-check"></i>
                            <span class="title"><?php echo app('translator')->get('english.GALLERY'); ?></span>

                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu" style="margin-top:5px;">
                            <li class="nav-item <?php echo ($currentControllerName == 'gAlbum') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('gAlbum')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.ALBUM'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo ($currentControllerName == 'gallery') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('gallery')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.GALLERY_IMAGE'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!--<li class="nav-item <?php echo (in_array($currentControllerName, array('ourService', 'contact-info', 'support'))) ? 'start active open' : ''; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-check"></i>
                            <span class="title"><?php echo app('translator')->get('english.FOOTER'); ?></span>

                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu" style="margin-top:5px;">
                            <li class="nav-item <?php echo ($currentControllerName == 'contact-info') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('contact-info')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.CONTACT'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo ($currentControllerName == 'ourService') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('ourService')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.OUR_SERVICES'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($currentControllerName == 'support') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('support')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.SUPPORT'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                    <li class="nav-item <?php echo (in_array($currentControllerName, array('productCategory', 'product', 'welcomeDcare', 'orderSate'))) ? 'start active open' : ''; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-eye"></i>
                            <span class="title"><?php echo app('translator')->get('english.D_CARE'); ?></span>

                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu" style="margin-top:5px;">
                            <li class="nav-item <?php echo ($currentControllerName == 'welcomeDcare') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('welcomeDcare')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.WELCOME'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($currentControllerName == 'productCategory') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('productCategory')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.PRODUCT_CATEGORY'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo ($currentControllerName == 'product') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('product')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.PRODUCT'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php
                            echo (in_array($currentFullRouteName, array('orderSate/pending', 'orderSate/processing', 'orderSate/delivered'
                                , 'orderSate/close', 'orderSate/trackingOrder'))) ? 'start active open' : '';
                            ?>">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-check"></i>
                                    <span class="title"><?php echo app('translator')->get('english.ORDER_STATE'); ?></span>

                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu" style="margin-top:5px;">
                                    <li class="nav-item <?php echo ($currentFullRouteName == 'orderSate/trackingOrder') ? 'start active open' : ''; ?>">
                                        <a href="<?php echo e(URL::to('orderSate/trackingOrder')); ?>" class="nav-link ">
                                            <span class="title"><?php echo app('translator')->get('english.TRACKING_ORDER'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php echo ($currentFullRouteName == 'orderSate/pending') ? 'start active open' : ''; ?>">
                                        <a href="<?php echo e(URL::to('orderSate/pending')); ?>" class="nav-link ">
                                            <span class="title"><?php echo app('translator')->get('english.PENDING'); ?></span>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo ($currentFullRouteName == 'orderSate/processing') ? 'start active open' : ''; ?>">
                                        <a href="<?php echo e(URL::to('orderSate/processing')); ?>" class="nav-link ">
                                            <span class="title"><?php echo app('translator')->get('english.PROCESSING'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php echo ($currentFullRouteName == 'orderSate/delivered') ? 'start active open' : ''; ?>">
                                        <a href="<?php echo e(URL::to('orderSate/delivered')); ?>" class="nav-link ">
                                            <span class="title"><?php echo app('translator')->get('english.DELIVERED'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?php echo ($currentFullRouteName == 'orderSate/close') ? 'start active open' : ''; ?>">
                                        <a href="<?php echo e(URL::to('orderSate/close')); ?>" class="nav-link ">
                                            <span class="title"><?php echo app('translator')->get('english.CLOSE'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!--<li class="nav-item <?php echo (in_array($currentControllerName, array('ourService', 'contact-info', 'support'))) ? 'start active open' : ''; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-check"></i>
                            <span class="title"><?php echo app('translator')->get('english.FOOTER'); ?></span>

                            <span class="arrow open"></span>
                        </a>
                        <ul class="sub-menu" style="margin-top:5px;">
                            <li class="nav-item <?php echo ($currentControllerName == 'contact-info') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('contact-info')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.CONTACT'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo ($currentControllerName == 'ourService') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('ourService')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.OUR_SERVICES'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo ($currentControllerName == 'support') ? 'start active open' : ''; ?>">
                                <a href="<?php echo e(URL::to('support')); ?>" class="nav-link ">
                                    <span class="title"><?php echo app('translator')->get('english.SUPPORT'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </li>
            <?php endif; ?>
            <?php endif; ?>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/includes/sidebar.blade.php ENDPATH**/ ?>