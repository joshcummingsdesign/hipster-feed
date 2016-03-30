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

				<?php if ( !empty( $options['token'] ) ) : ?>

					<h2>Logged in as <?php echo $options['token']->user->username; ?></h2>
					<img src="<?php echo $options['token']->user->profile_picture; ?>" alt="profile picture">
					<p><button id="hipstr-logout" class="button-primary">Log Out</button></p>

				<?php else : ?>

					<p><label for="hipstr-client-id">Client ID</label></p>
					<p><input id="hipstr-client-id" name="client-id" type="text" value="<?php if (!empty($options['client_id'])) { echo $options['client_id']; } ?>"></p>
					<p><label for="hipstr-client-secret">Client Secret</label></p>
					<p><input id="hipstr-client-secret" name="client-secret" type="text" value="<?php if (!empty($options['client_secret'])) { echo $options['client_secret']; } ?>"></p>

					<button id="hipstr-login" class="button-secondary">Save</button>

					<?php if ( !empty( $options['client_id'] ) && !empty( $options['client_secret'] ) ) : ?>

						<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo $options['client_id']; ?>&redirect_uri=<?php echo WEBSITE_URL; ?>&response_type=code" class="button-primary">Connect to Instagram</a>

					<?php endif; ?>

				<?php endif; ?>

			</div>
		</div>
		<br class="clear">
	</div>
</div>
