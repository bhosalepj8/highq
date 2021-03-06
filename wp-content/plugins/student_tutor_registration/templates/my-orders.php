<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $site_url= get_site_url();
  if ( is_user_logged_in() ) { 
        $current_user = wp_get_current_user();
        $role = $current_user->roles[0];
  }
 ?>

<div class="woocommerce">
<div class="loader"></div>
<!--<h3 class="pippin_header"><?php _e('Order Table History'); ?></h3>-->
<section class="clearfix">
                    <div class="student-registration">
                        <article>
                            <div class="box-one history clearfix">
            <div class="box-heading">
                            <h4><?php _e('Order Table History'); ?></h4>
                          </div>
                        <?php $order_status = wc_get_order_statuses();?>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <form id="tbl_history" name="tbl_history" action="" method="post">
                                    <span class="error" style="display:none;" id="dateerror">Please select From Date & To Date</span>
                                <div class="col-md-12 date-time">
                                
                                    <p class="field-para">
                                    	<strong>From</strong>
                                        <input id="history_from_date" class="form-control" name="history_from_date" type="text" onchange="" placeholder="Select From Date">
                                         <!--<span class="glyphicon glyphicon-calendar"></span>--> </p>
                                         
                                        <p class="field-para"> <strong class="history-labels">To</strong><input id="history_to_date" class="form-control" name="history_to_date" type="text" onchange="" placeholder="Select To Date"></p>
                                         <!--<span class="glyphicon glyphicon-calendar"></span>--> 
                                         <p class="field-para">
                                         <strong></strong>
                                         <select class="select" id="order_status" name="order_status">
                                                <option value="">- Order Status-</option>
                                                <?php foreach ($order_status as $key => $value) {
                                                         echo '<option value="'.$key.'">'.$value.'</option>';
                                                 }?>
                                        </select>
                                        </p>
                                       
                                        
                                       <span class="mtd-ytd"> <a href="javascript:void(0);" onclick="change_MTD()">MTD</a> 
                                       
                                       <a href="javascript:void(0);" onclick="change_YTD()">YTD</a>
                                       </span>
                                    
                                     <span class="mar-top-bottom-10 submit-history">
                                    
                                        <!--<span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>-->
                                         <input type="hidden" id="user_role" name="user_role" value="<?php echo $role;?>"/>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="get_order_details()">
                                            <span class="glyphicon glyphicon-menu-ok"></span>
                                            Submit
                                        </button>
                                    </span>
                                 </div>
                                   
                                </form>
                                
                                <div class="col-md-8" id="div_total_amt">
                                       
                                </div>
                                
          <div class="col-md-12 table-content table-responsive">
              <table id="my_orders_list" class="table table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Order Date</th>
              <th>Name Of Course</th>
              <th>Total Amount($)</th>
              <th>Status</th>
              <?php echo ($role == 'student')? "<th>Action</th>" : '';?>
              <!--<th>Action</th>-->
            </tr>
          </thead>
          <tbody  id="history_table">
            
          </tbody>
        </table>

          </div>
            </div>
        </div>
  </div>
                        </article>
                    </div>    
</section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        
        jQuery("#history_from_date").datepicker( "setDate", firstDay );
        jQuery("#history_to_date").datepicker( "setDate", date );
        get_order_details();
    });
</script>