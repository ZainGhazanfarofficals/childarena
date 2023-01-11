<div id="header_customer_login" class="header_customer_login">
	<h2 class="title"><?php esc_html_e( 'Login', 'kossy' ); ?></h2>
	<form method="post" class="login" role="form">

		<?php do_action( 'woocommerce_login_form_start' ); ?>

		<p class="form-group form-row form-row-wide">
			<label for="username"><?php esc_html_e( 'Username or email address', 'kossy' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text form-control" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
		</p>
		<p class="form-group form-row form-row-wide">
			<label for="password"><?php esc_html_e( 'Password', 'kossy' ); ?> <span class="required">*</span></label>
			<input class="input-text form-control" type="password" name="password" id="password" />
		</p>

		<?php do_action( 'woocommerce_login_form' ); ?>
		<div class="form-group form-row">
			<span for="rememberme" class="inline">
				<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'kossy' ); ?>
			</span>
		</div>
		<div class="form-group form-row">
			<?php wp_nonce_field( 'woocommerce-login' ); ?>
			
			<input type="submit" class="btn btn-theme btn-block btn-sm" name="login" value="<?php esc_html_e( 'sign in', 'kossy' ); ?>" />
		</div>

		<?php do_action( 'woocommerce_login_form_end' ); ?>

		<div class="form-group clearfix">
			<ul class="topmenu-menu">
				<li class="lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><i class="fa fa-repeat"></i> <?php esc_html_e( 'Lost your password?', 'kossy' ); ?></a>
				</li>
				<li class="register">
					<a class="register" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Register','kossy'); ?>"><i class="fa fa-user-plus"></i> <?php esc_html_e('Register', 'kossy'); ?></a>
				</li>
			</ul>
		</div>

	</form>
</div>