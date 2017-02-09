<?php
global $post_id;
$use_top_bar            = skilled_get_option( 'top-bar-use', false );
$use_top_bar_additional = skilled_get_option( 'top-bar-additional-use', false );
$logo_location          = skilled_get_option( 'logo-location', 'main_menu' );
$use_logo               = $logo_location == 'main_menu' ? true : false;
?>
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
                                    Country |
                                    <span class="usd">USD</span> Currency
                                    <div class="search-login">
                                      <form>
                                          <button class="btn btn-primary btn-sm signup-button">Search</button>
                                          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><input name="" value="login" class="btn btn-primary btn-sm signin-button" type="button"></a>
                                        </form>
                                    </div>
                                </div>
                    </div>
                        
              </div>      
		</div>
	</div>
</header>
