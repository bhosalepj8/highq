<?php function myaccount_student_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
//            print_r($current_user_meta);

        }
//        print_r(get_woocommerce_currencies());
 ?>

<section class="student-registration clearfix">
                    <div class="box-one history clearfix">
            <div class="box-heading">
                            <h4><?php _e('My Upcoming Sessions'); ?></h4>
                          </div>
                        <?php $order_status = wc_get_order_statuses();?>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <form id="tbl_sessionhistory" name="tbl_sessionhistory" action="" method="post">
                                    <span class="error" style="display:none;" id="dateerror">Please select From Date & To Date</span>
                                <div class="col-md-12 date-time">
                                <label>From</label>
                                    <p class="field-para">
                                        <input id="session_from_date" class="form-control" name="session_from_date" type="text" onchange="" placeholder="Session From Date">
                                         <span class="glyphicon glyphicon-calendar"></span> 
                                        <input id="session_to_date" class="form-control" name="session_to_date" type="text" onchange="" placeholder="Session To Date">
                                        <!--<a href="javascript:void(0);" onclick="change_MTD()">MTD</a> &nbsp; <a href="javascript:void(0);" onclick="change_YTD()">YTD</a>-->
                                        <input type="hidden" value="<?php echo $user_id;?>" id="user_id" name="user_id">
                                    </p>
                                     <span class="pull-right mar-top-bottom-10 submit-history">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="get_studentsession_details()">
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
              <th>Name Of Tutor</th>
              <th>Total no of Sessions</th>
              <th>Sessions Completed</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="session_history_table">
            
          </tbody>
        </table>
          </div>
            </div>
        </div>
  </div>
            </section>

<?php 
return ob_get_clean();
}
