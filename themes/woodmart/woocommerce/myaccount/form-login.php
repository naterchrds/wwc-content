<?php
/**
 * Login Form
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$tabs = woodmart_get_opt( 'login_tabs' );
$text = woodmart_get_opt( 'reg_text' );

$class = 'woodmart-registration-page';

if( $tabs && get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
	$class .= ' woodmart-register-tabs';
}

if( $tabs && get_option( 'woocommerce_enable_myaccount_registration' ) !== 'yes' ) {
	$class .= ' woodmart-no-registration';
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="<?php echo esc_attr( $class ); ?>">

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1 col-login">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'woodmart' ); ?></h2>

		<?php woodmart_login_form(); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="u-column2 col-2 col-register">

		<h2><?php esc_html_e( 'Register', 'woodmart' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woodmart' ); ?> <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woodmart' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woodmart' ); ?> <span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'woodmart' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woodmart' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

	<?php if ( $tabs ): ?>
		<div class="col-2 col-register-text">

			<span class="register-or"><?php esc_html_e('Or', 'woodmart') ?></span>

			<h2><?php esc_html_e( 'Register', 'woodmart' ); ?></h2>

			<?php if ($text): ?>
				<div class="registration-info"><?php echo ($text); ?></div>
			<?php endif ?>

			<a href="#" class="btn woodmart-switch-to-register" data-login="<?php esc_html_e( 'Login', 'woodmart') ?>" data-register="<?php esc_html_e( 'Register', 'woodmart') ?>"><?php esc_html_e( 'Register', 'woodmart') ?></a>

		</div>
	<?php endif ?>
	
</div>
<?php endif; ?>

</div><!-- .woodmart-registration-page -->

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
