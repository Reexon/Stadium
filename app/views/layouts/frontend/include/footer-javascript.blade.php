<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 15/11/14
 * Time: 12:42
 */ 
 ?>
     <!-- Load javascripts at bottom, this will reduce page load time -->
     <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
     <!--[if lt IE 9]>
     {{HTML::script('assets/global/plugins/respond.min.js')}}
     <![endif]--> 
     {{HTML::script('assets/global/plugins/jquery.min.js')}}
     {{HTML::script('assets/global/plugins/jquery-migrate.min.js')}}
     {{HTML::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
     {{HTML::script('assets/frontend/layout/scripts/back-to-top.js')}}
     <!-- END CORE PLUGINS -->
 
     <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
     {{HTML::script('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}<!-- pop up -->
     {{HTML::script('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js')}}<!-- slider for products -->
 
     <!-- BEGIN RevolutionSlider -->
   
     {{HTML::script('assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js')}}
     {{HTML::script('assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js')}}
     {{HTML::script('assets/frontend/pages/scripts/revo-slider-init.js')}}
     <!-- END RevolutionSlider -->
 
     {{HTML::script('assets/frontend/layout/scripts/layout.js')}}