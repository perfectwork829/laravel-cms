<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(asset('').Auth::user()->image); ?>" class="img-circle" alt="<?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?> Image">
        </div>
        <div class="pull-left info">
          <p><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo e(trans('labels.online')); ?></a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header"><?php echo e(trans('labels.navigation')); ?></li>
        <li class="treeview <?php echo e(Request::is('admin/dashboard/this_month') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>">
            <i class="fa fa-dashboard"></i> <span><?php echo e(trans('labels.header_dashboard')); ?></span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingLanguages') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addLanguages') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editLanguages/*') ? 'active' : ''); ?> ">
          <a href="<?php echo e(URL::to('admin/listingLanguages')); ?>">
            <i class="fa fa-language" aria-hidden="true"></i> <span> <?php echo e(trans('labels.languages')); ?> </span> <span class=" android-hide"> / <?php echo e(trans('labels.labels')); ?> </span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingPages') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addPage') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editPage/*') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingPages')); ?>">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span><?php echo e(trans('labels.pages')); ?></span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingManufacturer') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addManufacturer') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editManufacturer/*') ? 'active' : ''); ?> ">
          <a href="<?php echo e(URL::to('admin/listingManufacturer')); ?>">
            <i class="fa fa-industry" aria-hidden="true"></i> <span><?php echo e(trans('labels.link_manufacturer')); ?></span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingCategories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addCategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCategory/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingSubCategories') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addSubCategory') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editSubCategory/*') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-bars" aria-hidden="true"></i>
<span><?php echo e(trans('labels.link_categories')); ?> </span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="<?php echo e(Request::is('admin/listingCategories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addCategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCategory/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingCategories')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_main_categories')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/listingSubCategories') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addSubCategory') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editSubCategory/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingSubCategories')); ?>"><i class="fa fa-circle-o"></i><?php echo e(trans('labels.link_sub_categories')); ?></a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingProducts') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addProduct') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editAttributes/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingAttributes') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addAttributes') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editAttributes/*') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-database"></i> <span><?php echo e(trans('labels.link_products')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(Request::is('admin/listingProducts') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addProduct') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editProduct/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingProducts')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_all_products')); ?></a></li>
            
            <li class="<?php echo e(Request::is('admin/listingAttributes') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addAttributes') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editAttributes/*') ? 'active' : ''); ?>" ><a href="<?php echo e(URL::to('admin/listingAttributes' )); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.products_attributes')); ?></a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingNewsCategories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addNewsCategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editNewsCategory/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingNews') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addSubNews') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editSubNews/*') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-database" aria-hidden="true"></i>
<span><?php echo e(trans('labels.link_news')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="<?php echo e(Request::is('admin/listingNewsCategories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addNewsCategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editNewsCategory/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingNewsCategories')); ?>"><i class="fa fa-circle-o"></i><?php echo e(trans('labels.link_news_categories')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/listingNews') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addSubNews') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editSubNews/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingNews')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_sub_news')); ?></a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingCustomers') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addCustomers') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editCustomers/*') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingCustomers')); ?>">
            <i class="fa fa-users" aria-hidden="true"></i> <span><?php echo e(trans('labels.link_customers')); ?></span>
          </a>
        </li>
        
        
        <li class="treeview <?php echo e(Request::is('admin/listingCountries') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addCountry') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCountry/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingZones') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addZone') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editZone/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingTaxClass') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addTaxClass') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editTaxClass/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/listingTaxRates') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addTaxRate') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editTaxRate/*') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-money" aria-hidden="true"></i>
<span><?php echo e(trans('labels.link_tax_location')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(Request::is('admin/listingCountries') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addCountry') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCountry/*') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/listingCountries')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_countries')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/listingTaxClass') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addTaxClass') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editTaxClass/*') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/listingTaxClass')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_tax_classes')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/listingTaxRates') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addTaxRate') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editTaxRate/*') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/listingTaxRates')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_tax_rates')); ?></a></li>
            <!--<li><a href="listingTaxZones"><i class="fa fa-circle-o"></i> Tax Zones</a></li>-->
            <li class="<?php echo e(Request::is('admin/listingZones') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addZone') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editZone/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/listingZones')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_zones')); ?></a></li>
          </ul>
        </li>
        <li class="treeview <?php echo e(Request::is('admin/listingCoupons') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCoupons/*') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingCoupons')); ?>" ><i class="fa fa-tablet" aria-hidden="true"></i> <span><?php echo e(trans('labels.link_coupons')); ?></span></a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingDevices') ? 'active' : ''); ?> <?php echo e(Request::is('admin/viewDevices/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/notifications') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingDevices')); ?> ">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
<span><?php echo e(trans('labels.link_notifications')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(Request::is('admin/listingDevices') ? 'active' : ''); ?> <?php echo e(Request::is('admin/viewDevices/*') ? 'active' : ''); ?>">
          		<a href="<?php echo e(URL::to('admin/listingDevices')); ?>"><i class="fa fa-circle-o"></i><?php echo e(trans('labels.link_devices')); ?> </a>
            </li>  
            <li class="<?php echo e(Request::is('admin/notifications') ? 'active' : ''); ?> ">
            	<a href="<?php echo e(URL::to('admin/notifications')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_send_notifications')); ?></a>
            </li>      
          </ul>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingOrders') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addOrders') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/viewOrder/*') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingOrders')); ?>" ><i class="fa fa-list-ul" aria-hidden="true"></i> <span> <?php echo e(trans('labels.link_orders')); ?></span>
          </a>
        </li>
        <li class="treeview <?php echo e(Request::is('admin/shippingMethods') ? 'active' : ''); ?> <?php echo e(Request::is('admin/upsShipping') ? 'active' : ''); ?> <?php echo e(Request::is('admin/flateRate') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/shippingMethods')); ?>"><i class="fa fa-truck" aria-hidden="true"></i> <span> <?php echo e(trans('labels.link_shipping_methods')); ?></span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/paymentSetting') ? 'active' : ''); ?>">
          <a  href="<?php echo e(URL::to('admin/paymentSetting')); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>
          <?php echo e(trans('labels.link_payment_methods')); ?></span>
          </a>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/statsCustomers') ? 'active' : ''); ?> <?php echo e(Request::is('admin/productsStock') ? 'active' : ''); ?> <?php echo e(Request::is('admin/statsProductsPurchased') ? 'active' : ''); ?> <?php echo e(Request::is('admin/statsProductsLiked') ? 'active' : ''); ?> ">
          <a href="#">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
<span><?php echo e(trans('labels.link_reports')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(Request::is('admin/productsStock') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/productsStock')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_products_stock')); ?></a></li>  
            <li class="<?php echo e(Request::is('admin/statsCustomers') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/statsCustomers')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_customer_orders_total')); ?></a></li>             
            <li class="<?php echo e(Request::is('admin/statsProductsPurchased') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/statsProductsPurchased')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_total_purchased')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/statsProductsLiked') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/statsProductsLiked')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_products_liked')); ?></a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(Request::is('admin/listingBanners') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingBanners')); ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> <span> <?php echo e(trans('labels.link_Banners')); ?></span></a>
        </li>
        
        <!--<li class="treeview <?php echo e(Request::is('admin/listingAppLabels') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addAppLabel') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editAppLabel/*') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/listingAppLabels')); ?>"><i class="fa fa-globe" aria-hidden="true"></i> <span>Labels</span></a>
        </li>  -->      
        
        <li class="treeview <?php echo e(Request::is('admin/listingOrderStatus') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addOrderStatus') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editOrderStatus/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/setting') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-gears" aria-hidden="true"></i>
<span> <?php echo e(trans('labels.link_site_settings')); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo e(Request::is('admin/listingOrderStatus') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addOrderStatus') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editOrderStatus/*') ? 'active' : ''); ?> "><a href="<?php echo e(URL::to('admin/listingOrderStatus')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_order_status')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/setting') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/setting')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_setting')); ?></a></li>
          </ul>
        </li>
        
        
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>