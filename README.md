# HipsterFeed
Display your latest Instagram posts on your WordPress site.

## Setup
1. Register for an Instagram API Key
2. Make sure your redirect URI is set to ```http://example.com/wp/wp-admin/admin.php?page=hipster-feed```
3. Install the plugin
4. Enter in your Client ID and Client Secret and click ```Connect to Instagram```
5. Add the shortcode ```[hipster-feed]``` to any page

You can modify ```public/partials/hipstr-public-content.php``` to change what the front end looks like.

To change how many images to query, see ```public/partials/app.php``` arount line 30.
```$media = $instagram->getUserMedia( 'self', 8 ); //Returns 8 entries for the logged in user```
