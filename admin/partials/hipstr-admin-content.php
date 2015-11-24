<?php

/*****************************************
* Admin content
/****************************************/

?>

<!-- Hide body until redirect -->
<style>
	body {
		display: none;
	}
</style>

<div class="wrap">
	<h1><?php esc_attr_e( 'HipsterFeed', 'hipstr' ); ?></h1>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">

				<?php include 'app.php'; ?>

				<?php if ( isset( $options['token'] ) ) : ?>

					<h2>Logged in as <?php echo $options['token']->user->username; ?></h2>
					<img src="<?php echo $options['token']->user->profile_picture; ?>" alt="profile picture">
					<p><button id="hipstr-logout" class="button-primary">Log Out</button></p>

				<?php else : ?>

					<h2>Logged out</h2>
					<a href="https://api.instagram.com/oauth/authorize/?client_id=7ededb3e85e6482285bb01087356d7e1&redirect_uri=<?php echo WEBSITE_URL; ?>&response_type=code" class="button-primary">Connect to Instagram</a>

				<?php endif; ?>

			</div>
		</div>
		<br class="clear">
	</div>
</div>
