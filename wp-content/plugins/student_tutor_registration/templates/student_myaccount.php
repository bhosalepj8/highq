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
                    <div class="student-history">
                       <h3>History table</h3>
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
            </section>

<?php 
return ob_get_clean();
}
