<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $site_url= get_site_url();
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
                                <label>From</label>
                                    <p class="field-para">
                                        <input id="history_from_date" class="form-control" name="history_from_date" type="text" onchange="" placeholder="Select From Date">
                                         <span class="glyphicon glyphicon-calendar"></span> 
                                        <input id="history_to_date" class="form-control" name="history_to_date" type="text" onchange="" placeholder="Select To Date">
                                         <span class="glyphicon glyphicon-calendar"></span> 
                                         <select class="select" id="order_status" name="order_status">
                                                <option value="">- Order Status-</option>
                                                <?php foreach ($order_status as $key => $value) {
                                                         echo '<option value="'.$key.'">'.$value.'</option>';
                                                 }?>
                                        </select>
                                        <a href="javascript:void(0);" onclick="change_MTD()">MTD</a> &nbsp; <a href="javascript:void(0);" onclick="change_YTD()">YTD</a>
                                    </p>
                                     <span class="pull-right mar-top-bottom-10 submit-history">
                                        <!--<span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>-->
                                        <button type="button" class="btn btn-primary btn-sm" onclick="get_order_details()">
                                            <span class="glyphicon glyphicon-menu-ok"></span>
                                            Submit</button>
                                    </span>
                                 </div>
                                   
                                </form>
                                <br/>
                                <div class="col-md-8" id="div_total_amt">
                                       
                                </div>
                                <br/>
          <div class="col-md-12 table-responsive">
              <table class="table table-bordered">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name Of Course</th>
              <th>No of Student</th>
              <th>Total Amount($)</th>
              <th>Status</th>
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