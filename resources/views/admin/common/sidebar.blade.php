<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('').Auth::user()->image}}" class="img-circle" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('labels.online') }}</a>
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
        <li class="header">{{ trans('labels.navigation') }}</li>
        <li class="treeview {{ Request::is('admin/dashboard/this_month') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/dashboard/this_month')}}">
            <i class="fa fa-dashboard"></i> <span>{{ trans('labels.header_dashboard') }}</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingLanguages') ? 'active' : '' }} {{ Request::is('admin/addLanguages') ? 'active' : '' }} {{ Request::is('admin/editLanguages/*') ? 'active' : '' }} ">
          <a href="{{ URL::to('admin/listingLanguages')}}">
            <i class="fa fa-language" aria-hidden="true"></i> <span> {{ trans('labels.languages') }} </span> <span class=" android-hide"> / {{ trans('labels.labels') }} </span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingPages') ? 'active' : '' }}  {{ Request::is('admin/addPage') ? 'active' : '' }}  {{ Request::is('admin/editPage/*') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingPages')}}">
            <i class="fa fa-file-text" aria-hidden="true"></i> <span>{{ trans('labels.pages') }}</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingManufacturer') ? 'active' : '' }} {{ Request::is('admin/addManufacturer') ? 'active' : '' }} {{ Request::is('admin/editManufacturer/*') ? 'active' : '' }} ">
          <a href="{{ URL::to('admin/listingManufacturer')}}">
            <i class="fa fa-industry" aria-hidden="true"></i> <span>{{ trans('labels.link_manufacturer') }}</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingCategories') ? 'active' : '' }} {{ Request::is('admin/addCategory') ? 'active' : '' }} {{ Request::is('admin/editCategory/*') ? 'active' : '' }} {{ Request::is('admin/listingSubCategories') ? 'active' : '' }}  {{ Request::is('admin/addSubCategory') ? 'active' : '' }}  {{ Request::is('admin/editSubCategory/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-bars" aria-hidden="true"></i>
<span>{{ trans('labels.link_categories') }} </span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="{{ Request::is('admin/listingCategories') ? 'active' : '' }} {{ Request::is('admin/addCategory') ? 'active' : '' }} {{ Request::is('admin/editCategory/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingCategories')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_main_categories') }}</a></li>
            <li class="{{ Request::is('admin/listingSubCategories') ? 'active' : '' }}  {{ Request::is('admin/addSubCategory') ? 'active' : '' }}  {{ Request::is('admin/editSubCategory/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingSubCategories')}}"><i class="fa fa-circle-o"></i>{{ trans('labels.link_sub_categories') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingProducts') ? 'active' : '' }} {{ Request::is('admin/addProduct') ? 'active' : '' }} {{ Request::is('admin/editAttributes/*') ? 'active' : '' }} {{ Request::is('admin/listingAttributes') ? 'active' : '' }}  {{ Request::is('admin/addAttributes') ? 'active' : '' }}  {{ Request::is('admin/editAttributes/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-database"></i> <span>{{ trans('labels.link_products') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/listingProducts') ? 'active' : '' }} {{ Request::is('admin/addProduct') ? 'active' : '' }} {{ Request::is('admin/editProduct/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingProducts')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_all_products') }}</a></li>
            
            <li class="{{ Request::is('admin/listingAttributes') ? 'active' : '' }}  {{ Request::is('admin/addAttributes') ? 'active' : '' }}  {{ Request::is('admin/editAttributes/*') ? 'active' : '' }}" ><a href="{{ URL::to('admin/listingAttributes' )}}"><i class="fa fa-circle-o"></i> {{ trans('labels.products_attributes') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingNewsCategories') ? 'active' : '' }} {{ Request::is('admin/addNewsCategory') ? 'active' : '' }} {{ Request::is('admin/editNewsCategory/*') ? 'active' : '' }} {{ Request::is('admin/listingNews') ? 'active' : '' }}  {{ Request::is('admin/addSubNews') ? 'active' : '' }}  {{ Request::is('admin/editSubNews/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-database" aria-hidden="true"></i>
<span>{{ trans('labels.link_news') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="{{ Request::is('admin/listingNewsCategories') ? 'active' : '' }} {{ Request::is('admin/addNewsCategory') ? 'active' : '' }} {{ Request::is('admin/editNewsCategory/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingNewsCategories')}}"><i class="fa fa-circle-o"></i>{{ trans('labels.link_news_categories') }}</a></li>
            <li class="{{ Request::is('admin/listingNews') ? 'active' : '' }}  {{ Request::is('admin/addSubNews') ? 'active' : '' }}  {{ Request::is('admin/editSubNews/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingNews')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_sub_news') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingCustomers') ? 'active' : '' }}  {{ Request::is('admin/addCustomers') ? 'active' : '' }}  {{ Request::is('admin/editCustomers/*') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingCustomers')}}">
            <i class="fa fa-users" aria-hidden="true"></i> <span>{{ trans('labels.link_customers') }}</span>
          </a>
        </li>
        
        
        <li class="treeview {{ Request::is('admin/listingCountries') ? 'active' : '' }} {{ Request::is('admin/addCountry') ? 'active' : '' }} {{ Request::is('admin/editCountry/*') ? 'active' : '' }} {{ Request::is('admin/listingZones') ? 'active' : '' }} {{ Request::is('admin/addZone') ? 'active' : '' }} {{ Request::is('admin/editZone/*') ? 'active' : '' }} {{ Request::is('admin/listingTaxClass') ? 'active' : '' }} {{ Request::is('admin/addTaxClass') ? 'active' : '' }} {{ Request::is('admin/editTaxClass/*') ? 'active' : '' }} {{ Request::is('admin/listingTaxRates') ? 'active' : '' }} {{ Request::is('admin/addTaxRate') ? 'active' : '' }} {{ Request::is('admin/editTaxRate/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-money" aria-hidden="true"></i>
<span>{{ trans('labels.link_tax_location') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/listingCountries') ? 'active' : '' }} {{ Request::is('admin/addCountry') ? 'active' : '' }} {{ Request::is('admin/editCountry/*') ? 'active' : '' }} "><a href="{{ URL::to('admin/listingCountries')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_countries') }}</a></li>
            <li class="{{ Request::is('admin/listingTaxClass') ? 'active' : '' }} {{ Request::is('admin/addTaxClass') ? 'active' : '' }} {{ Request::is('admin/editTaxClass/*') ? 'active' : '' }} "><a href="{{ URL::to('admin/listingTaxClass')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_tax_classes') }}</a></li>
            <li class="{{ Request::is('admin/listingTaxRates') ? 'active' : '' }} {{ Request::is('admin/addTaxRate') ? 'active' : '' }} {{ Request::is('admin/editTaxRate/*') ? 'active' : '' }} "><a href="{{ URL::to('admin/listingTaxRates')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_tax_rates') }}</a></li>
            <!--<li><a href="listingTaxZones"><i class="fa fa-circle-o"></i> Tax Zones</a></li>-->
            <li class="{{ Request::is('admin/listingZones') ? 'active' : '' }} {{ Request::is('admin/addZone') ? 'active' : '' }} {{ Request::is('admin/editZone/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/listingZones')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_zones') }}</a></li>
          </ul>
        </li>
        <li class="treeview {{ Request::is('admin/listingCoupons') ? 'active' : '' }} {{ Request::is('admin/editCoupons/*') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingCoupons')}}" ><i class="fa fa-tablet" aria-hidden="true"></i> <span>{{ trans('labels.link_coupons') }}</span></a>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingDevices') ? 'active' : '' }} {{ Request::is('admin/viewDevices/*') ? 'active' : '' }} {{ Request::is('admin/notifications') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingDevices')}} ">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
<span>{{ trans('labels.link_notifications') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/listingDevices') ? 'active' : '' }} {{ Request::is('admin/viewDevices/*') ? 'active' : '' }}">
          		<a href="{{ URL::to('admin/listingDevices')}}"><i class="fa fa-circle-o"></i>{{ trans('labels.link_devices') }} </a>
            </li>  
            <li class="{{ Request::is('admin/notifications') ? 'active' : '' }} ">
            	<a href="{{ URL::to('admin/notifications') }}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_send_notifications') }}</a>
            </li>      
          </ul>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingOrders') ? 'active' : '' }}  {{ Request::is('admin/addOrders') ? 'active' : '' }}  {{ Request::is('admin/viewOrder/*') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingOrders')}}" ><i class="fa fa-list-ul" aria-hidden="true"></i> <span> {{ trans('labels.link_orders') }}</span>
          </a>
        </li>
        <li class="treeview {{ Request::is('admin/shippingMethods') ? 'active' : '' }} {{ Request::is('admin/upsShipping') ? 'active' : '' }} {{ Request::is('admin/flateRate') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/shippingMethods')}}"><i class="fa fa-truck" aria-hidden="true"></i> <span> {{ trans('labels.link_shipping_methods') }}</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/paymentSetting') ? 'active' : '' }}">
          <a  href="{{ URL::to('admin/paymentSetting')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>
          {{ trans('labels.link_payment_methods') }}</span>
          </a>
        </li>
        
        <li class="treeview {{ Request::is('admin/statsCustomers') ? 'active' : '' }} {{ Request::is('admin/productsStock') ? 'active' : '' }} {{ Request::is('admin/statsProductsPurchased') ? 'active' : '' }} {{ Request::is('admin/statsProductsLiked') ? 'active' : '' }} ">
          <a href="#">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
<span>{{ trans('labels.link_reports') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/productsStock') ? 'active' : '' }} "><a href="{{ URL::to('admin/productsStock')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_products_stock') }}</a></li>  
            <li class="{{ Request::is('admin/statsCustomers') ? 'active' : '' }} "><a href="{{ URL::to('admin/statsCustomers')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_customer_orders_total') }}</a></li>             
            <li class="{{ Request::is('admin/statsProductsPurchased') ? 'active' : '' }}"><a href="{{ URL::to('admin/statsProductsPurchased')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_total_purchased') }}</a></li>
            <li class="{{ Request::is('admin/statsProductsLiked') ? 'active' : '' }}"><a href="{{ URL::to('admin/statsProductsLiked')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_products_liked') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{ Request::is('admin/listingBanners') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingBanners')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span> {{ trans('labels.link_Banners') }}</span></a>
        </li>
        
        <!--<li class="treeview {{ Request::is('admin/listingAppLabels') ? 'active' : '' }} {{ Request::is('admin/addAppLabel') ? 'active' : '' }} {{ Request::is('admin/editAppLabel/*') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/listingAppLabels')}}"><i class="fa fa-globe" aria-hidden="true"></i> <span>Labels</span></a>
        </li>  -->      
        
        <li class="treeview {{ Request::is('admin/listingOrderStatus') ? 'active' : '' }}  {{ Request::is('admin/addOrderStatus') ? 'active' : '' }} {{ Request::is('admin/editOrderStatus/*') ? 'active' : '' }} {{ Request::is('admin/setting') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-gears" aria-hidden="true"></i>
<span> {{ trans('labels.link_site_settings') }}</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('admin/listingOrderStatus') ? 'active' : '' }} {{ Request::is('admin/addOrderStatus') ? 'active' : '' }} {{ Request::is('admin/editOrderStatus/*') ? 'active' : '' }} "><a href="{{ URL::to('admin/listingOrderStatus')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_order_status') }}</a></li>
            <li class="{{ Request::is('admin/setting') ? 'active' : '' }}"><a href="{{ URL::to('admin/setting')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_setting') }}</a></li>
          </ul>
        </li>
        
        
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>