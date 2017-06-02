<?php
global $post_id;
$use_top_bar            = skilled_get_option( 'top-bar-use', false );
$use_top_bar_additional = skilled_get_option( 'top-bar-additional-use', false );
$logo_location          = skilled_get_option( 'logo-location', 'main_menu' );
$use_logo               = $logo_location == 'main_menu' ? true : false;
?>
<div class="one fourth registration-blog registerbox-resp">
                                <div>
                                    <!--Country 
                                    <span class="usd">USD</span> Currency|-->
                                    <?php if(!is_user_logged_in()){?>
                                    <div class="search-login">
                                      <form>
                                          <a href="<?php echo get_site_url(); ?>/search/"><input name="" value="search" class="btn btn-primary btn-sm signup-button" type="button"></a>
                                          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><input name="" value="login" class="btn btn-primary btn-sm signin-button" type="button"></a>
                                        </form>
                                    </div>
                                    <?php }else{
                                        $current_user = wp_get_current_user();
                                        ?>
                                        <div class="search-login">
                                      <form>
                                          <a class="loggedin-user" href="<?php echo get_site_url();?>/my-account/"><?php echo $current_user->display_name;?></a>
                                          <a href="<?php echo wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) ?>"><input name="" value="Log Out" class="btn btn-primary btn-sm signin-button" type="button"></a>
                                        </form>
                                    </div>
                                    <?php }?>
                                </div>
                                
                    </div>
<header class="<?php echo skilled_class( 'header' ); ?>">
    
	<?php if ( $use_top_bar ): ?>
		<?php get_template_part( 'templates/top-bar' ); ?>
	<?php endif; ?>
	<?php if ( $use_top_bar_additional ): ?>
		<?php get_template_part( 'templates/top-bar-additional' ); ?>
	<?php endif; ?>
	<div class="<?php echo skilled_class( 'main-menu-bar-wrapper' ); ?>">
		<div class="<?php echo skilled_class( 'container' ); ?>">
			<?php if ( $use_logo ): ?>
				<div class="<?php echo skilled_class( 'logo-wrapper' ); ?>">
					<?php get_template_part( 'templates/logo' ); ?>
				</div>
			<?php endif; ?>
			<?php get_template_part( 'templates/logo-sticky' ); ?>
			<!--<div class="<?php echo skilled_class( 'main-menu-wrapper' ); ?>">-->
                    <div class="wh-main-menu three fourths main-navigation wh-padding">
				<?php get_template_part( 'templates/menu-main' ); ?>
                <?php if ( $use_top_bar ): ?>
				<?php get_template_part( 'templates/top-bar' ); ?>
				<?php endif; ?>
			
                    <div class="one fourth registration-blog">
                                <div>
                                    <!--Country 
                                    <span class="usd">USD</span> Currency|-->
                                    <?php if(!is_user_logged_in()){?>
                                    <div class="search-login">
                                      <form>
                                          <a href="<?php echo get_site_url(); ?>/search/"><input name="" value="search" class="btn btn-primary btn-sm signup-button" type="button"></a>
                                          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><input name="" value="login / sign up" class="btn btn-primary btn-sm signin-button" type="button"></a>
                                        </form>
                                    </div>
                                    <?php }else{
                                        $current_user = wp_get_current_user();
                                        ?>
                                        <div class="search-login">
                                      <form>
                                          <a class="loggedin-user" href="<?php echo get_site_url();?>/my-account/"><?php echo $current_user->display_name;?></a>
                                          <a href="<?php echo wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) ?>"><input name="" value="Log Out" class="btn btn-primary btn-sm signin-button" type="button"></a>
                                        </form>
                                    </div>
                                    <?php }?>
                                </div>
                                
                    </div>
                        
              </div>      
		</div>
	</div>
        
</header>

