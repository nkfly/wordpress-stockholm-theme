<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	
	<div class="u-columns col2-set" id="customer_login">
	
	<div class="u-column1 col-1">

<?php endif; ?>
	
	<h2><?php _e( 'Login', 'qode' ); ?></h2>
	
	<form class="woocomerce-form woocommerce-form-login login" method="post">
		
		<?php do_action( 'woocommerce_login_form_start' ); ?>
		
		<?php /*** Our code modification inside Woo template - begin ***/ ?>
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text placeholder" placeholder="<?php _e('Username or email', 'qode'); ?>" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<input class="woocommerce-Input woocommerce-Input--text input-text placeholder" placeholder="<?php _e('Password', 'qode'); ?>" type="password" name="password" id="password" />
		</p>
		
		<?php do_action( 'woocommerce_login_form' ); ?>
		
		<p class="form-row">
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'qode' ); ?>" />
			<a class="lost_password woo-lost_password2" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'qode' ); ?></a>
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline woo-my-account-rememberme">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'qode' ); ?></span>
			</label>
		</p>
		
		<?php /*** Our code modification inside Woo template - end ***/ ?>
		
		<?php do_action( 'woocommerce_login_form_end' ); ?>
	
	</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	
	</div>
	
	<div class="u-column2 col-2">
		
		<h2><?php _e( 'Register', 'qode' ); ?></h2>
		
		<form method="post" class="register">
			
			<?php do_action( 'woocommerce_register_form_start' ); ?>
			
			<?php /*** Our code modification inside Woo template - begin ***/ ?>
			
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
				
				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text placeholder" placeholder="<?php _e('Username', 'qode'); ?>" name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
				</p>
			
			<?php endif; ?>
			
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text placeholder" placeholder="<?php _e('Email', 'qode'); ?>" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>" />
			</p>
			
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
				
				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text placeholder" placeholder="<?php _e('Password', 'qode'); ?>" name="password" id="reg_password" />
				</p>
			
			<?php endif; ?>
			
			<?php /*** Our code modification inside Woo template - end ***/ ?>
			
			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'qode' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>
			
			<?php do_action( 'woocommerce_register_form' ); ?>
			
			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'qode' ); ?>" />
			</p>
			
			<?php do_action( 'woocommerce_register_form_end' ); ?>
		
		</form>
	
	</div>
	
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>