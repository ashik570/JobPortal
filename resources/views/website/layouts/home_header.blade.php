<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@lang('label.DYSIG_GROUP')</title>
    <meta name="author" content="Swapnoloke Team">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <link href="{{asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/plugins/jquery.countdown.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/skin-dysin.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/dysin.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/custome.css') }}">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{URL::to('/')}}/public/img/favicon.ico" />
</head>

<div class="page-wrapper">
    <header class="header header-14">
        <div class="header-bottom sticky-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-lg-2 col-xl-2 col-xxl-1 header-right">
                        <a href="{{URL::to('/')}}"  class="logo" style="display:block;text-align:center;">
                            <img style="display:inline-block;" src="{{ asset('public/img/logo.png') }}" alt="Logo" width="105" height="25">
                        </a>
                    </div><!-- End .col-xl-3 col-xxl-2 -->

                    <div class="col col-lg-10 col-xl-10 col-xxl-10 header-left">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                              <?php
                              $parentItem = 'parent-item ';
                              foreach ($globalparameterArr['menuArr'] as $menu):
                                  $liClass = 'level1';
                                  $aClass = '';
                                  $caret = '';
                                  $menuIcon = '';
                                  if (array_key_exists('child', $menu)) {
                                      if (sizeof($menu['child']) > 0) {
                                          //print_r($menu['child']);
                                          //$liClass = 'dropdown';
                                          //$aClass = 'dropdown-toggle';
                                          //$caret = '<b class="caret"></b>';

                                      }
                                  }
                                  $activeClass = (Request::url() == $menu['target_url']) ? 'active' : '';

                                  if (!empty($menu['icon'])) {
                                      //$menuIcon = '<span class="menu-icon"><i class="' . $menu['icon'] . '"></i></span>';
                                  }

                                  echo "<li class=\"parent-item ".$activeClass . "\" ><a class='$aClass' id=\"menu-" . $menu['id'] . "\" href=" . $menu['target_url'] . ">" . $menuIcon . $menu['title'] . ' ' . $caret . "</a>";
                                  if (array_key_exists('child', $menu)):
                                      if (!empty($menu['child'])) {
                                          echo "<ul class='sub-menu'>";
                                          foreach ($menu['child'] as $child_menu):
                                              $activeClass = (Request::url() == $child_menu['target_url']) ? 'class="active-child" data-parent-id="' . $child_menu['parent_id'] . '"' : '';
                                              if ($child_menu['open_new_tab'] == 1) {
                                                  echo "<li class='menu-item menu-item-type-custom menu-item-object-custom'><a href='{$child_menu['target_url']}' {$activeClass} target='_blank'>{$child_menu['title']}</a>";
                                              } else {
                                                  echo "<li class='menu-item menu-item-type-custom menu-item-object-custom'><a href='{$child_menu['target_url']}' {$activeClass}>{$child_menu['title']}</a>";
                                              }
                                              if (array_key_exists('child', $child_menu)):
                                                if (!empty($child_menu['child'])) {
                                                  echo "<ul class='sub-menu'>";
                                                  foreach ($child_menu['child'] as $child2_menu) :
                                                      echo "<li><a href='{$child2_menu['target_url']}'>{$child2_menu['title']}</a>";
                                                  endforeach;
                                                  echo "</ul>";
                                                }
                                              endif;
                                          endforeach;
                                          echo "</ul>";
                                      }
                                  endif;
                                  echo "</li>";
                              endforeach;
                              ?>

                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .col-xl-9 col-xxl-10 -->

                </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->
