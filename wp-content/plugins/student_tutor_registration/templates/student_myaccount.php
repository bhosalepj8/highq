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

<section class="clearfix">
                    <div class="box-one clearfix">
            <div class="box-heading">
                            <h4>History</h4>
                          </div>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <div class="col-md-12 date-time">
                                <label>From</label>
                            <p class="field-para">
                                <input id="" class="form-control" name="" type="date" onchange="">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <input id="" class="form-control" name="" type="time" onchange="">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <select class="select">
                                        <optgroup>
                                        <option>-Status-</option>
                                    </optgroup>
                                </select>
                                <a class="" href="">MTD</a> &nbsp; <a class="" href="">YTD</a>
                            </p>
                         </div>
                         <br/>
                         <div class="col-md-8">
                                <label>Total Amount Received from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $200/-
                             </p>
                         </div>

                         <br/>
                         <div class="col-md-8">
                                <label>Total Amount Pending from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $75/-
                             </p>
                         </div>
                          <div class="col-md-12">
                                <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@TwBootstrap</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
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
