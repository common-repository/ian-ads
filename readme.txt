=== IAN Ads ===
Contributors: boncom
Tags: ad, ads, advertising, ian
Requires at least: 4.0.0
Tested up to: 5.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Stable Tag: 1.0.5

Easily insert ads from the Interactive Ad Network (IAN) to your Wordpress site.

== Description ==
# What is this for?
If you have signed up to use ads from [Interactive Ad Network](https://interactivead.network/signup) (IAN), you can use this plugin to easily insert ads with no copying and pasting required.

## What is IAN?
IAN stands for Interactive Ad Network. We help you earn revenue by displaying tasteful ads on your site. You can learn more about what we do [here](http://interactivead.network).

## What if I haven't signed up?
That's OK, you can register on our site for free: [Sign up here](http://interactivead.network/signup)

There are basically three steps to getting ads displaying on your Wordpress site:
1. [Signup](http://interactivead.network/signup) for an account and request an Ad Slot (this is what we call the space we display ads on your site)
2. Once the ad slot is approved, install and activate this plugin
3. Ensure that your ad slot id is on your site by going to Settings -> IAN Ad Options
4. Either add an IAN Ad Slot Widget under Appearances -> Widgets (if your theme supports widgets) or use our shortcode to insert the ad slot into your page.

**Note:** It is important when you signup that you put the domain name of your site in correctly for this plugin to work.

## How do I add an Ad Slot to my site?
### If your site supports widgets:
1. Ensure the plugin is installed and activated.
2. In Wordpress Admin, go to Widgets.
3. Look for the Widget on the left side titled "IAN Ad".
4. Click and drag it over to the widget area on the right that you want to add it to.
5. If you have more than one Ad Slot you'll need to choose the one you want to add, otherwise it will just show you what Ad Slot it will use.
6. Click on the "Save" button for the widget.

*Note that if you know how to customize your theme you can also add in a widget that way as well.*

### If you want to add an Ad Slot to a page or post:
Some Wordpress themes don't support widgets. If that is the case you'll want to use our shortcode. You can think of a shortcode as a sort of marker in your content that says, "when you display this page/post, I want you to insert something extra at this spot". Examples of shortcodes are [video], [gallery] or [audio]. In each of these they will insert a video, gallery of pictures or an audio player for an audio clip. No need to understand programming or HTML to get them to work. You'll notice that a shortcode is identified by the square brackets, [], around it. Our shortcode is [ian-ad]. To add the shortcode to your page/post:
1. Ensure the plugin is installed and activated.
2. Edit the page or post that you want to add the Ad Slot to.
3. In the editor that shows the content of your page or post, locate where you want the Ad Slot to appear.
4. Type in [ian-ad] in the place that you want the ad to appear.
5. Click "Update", "Save as Draft" or "Publish" to save the change.

*It is strongly recommended to put the shortcode on its own line in your content, like so:*

`
...and this is the end of one paragraph here.  
[ian-ad]  
Beginning a new paragraph after the Ad slot looks best...
`

Doing it this way will allow the Ad to display without messing up the formatting of your content.
#### If you have more than one Ad Slot
If you have more than one Ad Slot you can indicate which one you want to use by pulling the code of the Ad Slot and adding it to the shortcode.

As an example, let's say that my Ad Slot code was 23245. I would make the shortcode look like the following:
`
[ian-ad code="23245"]
`
That will display that Ad Slot at that location. If you want to use the first Ad Slot (as shown above) don't need to add the `code="23245"` to the shortcode. It will automatically use the first one by default.

## What if I already activated this plugin before I signed up for an account and got an Ad Slot approved?
You can reload your Ad Slots at any time by clicking the "Refresh" button above. This will pull your Ad Slots from our system.

## I'm not seeing any Ad Slots even though I signed up. What's going on?
Just because you've registered with our system doesn't automatically give you an Ad Slot that you can use. We want to make sure the sites we serve ads on are appropriate for the ads we offer. Once you receive notice that your Ad Slot has been approved then you should be able to see that Ad Slot by clicking the refresh button above.

If for some reason you still aren't seeing your Ad Slot. Please feel free to reach out to us (contact number below).

## Questions? Comments?
Don't hesitate to reach out if you are having problems, or have a question or suggestion. You can reach us at [1-800-555-3321](tel:+18005553321).


== Installation ==
1. [Signup](http://interactivead.network/signup) for an account and request an Ad Slot (this is what we call the space we display ads on your site)
2. Once the ad slot is approved, install and activate this plugin
3. Ensure that your ad slot id is on your site by going to Settings -> IAN Ad Options
4. Either add an IAN Ad Slot Widget under Appearances -> Widgets (if your theme supports widgets) or use our shortcode to insert the ad slot into your page.

== Frequently Asked Questions ==
## What is IAN?
IAN stands for Interactive Ad Network. We help you earn revenue by displaying tasteful ads on your site. You can learn more about what we do [here](http://interactivead.network).

## What if I haven't signed up?
That's OK, you can register on our site for free: [Sign up here](http://interactivead.network/signup)

There are basically three steps to getting ads displaying on your Wordpress site:
1. [Signup](http://interactivead.network/signup) for an account and request an Ad Slot (this is what we call the space we display ads on your site)
2. Once the ad slot is approved, install and activate this plugin
3. Ensure that your ad slot id is on your site by going to Settings -> IAN Ad Options
4. Either add an IAN Ad Slot Widget under Appearances -> Widgets (if your theme supports widgets) or use our shortcode to insert the ad slot into your page.

**Note:** It is important when you signup that you put the domain name of your site in correctly for this plugin to work.

## How do I add an Ad Slot to my site?
### If your site supports widgets:
1. Ensure the plugin is installed and activated.
2. In Wordpress Admin, go to Widgets.
3. Look for the Widget on the left side titled "IAN Ad".
4. Click and drag it over to the widget area on the right that you want to add it to.
5. If you have more than one Ad Slot you'll need to choose the one you want to add, otherwise it will just show you what Ad Slot it will use.
6. Click on the "Save" button for the widget.

*Note that if you know how to customize your theme you can also add in a widget that way as well.*

### If you want to add an Ad Slot to a page or post:
Some Wordpress themes don't support widgets. If that is the case you'll want to use our shortcode. You can think of a shortcode as a sort of marker in your content that says, "when you display this page/post, I want you to insert something extra at this spot". Examples of shortcodes are [video], [gallery] or [audio]. In each of these they will insert a video, gallery of pictures or an audio player for an audio clip. No need to understand programming or HTML to get them to work. You'll notice that a shortcode is identified by the square brackets, [], around it. Our shortcode is [ian-ad]. To add the shortcode to your page/post:
1. Ensure the plugin is installed and activated.
2. Edit the page or post that you want to add the Ad Slot to.
3. In the editor that shows the content of your page or post, locate where you want the Ad Slot to appear.
4. Type in [ian-ad] in the place that you want the ad to appear.
5. Click "Update", "Save as Draft" or "Publish" to save the change.

*It is strongly recommended to put the shortcode on its own line in your content, like so:*

`
...and this is the end of one paragraph here.  
[ian-ad]  
Beginning a new paragraph after the Ad slot looks best...
`

Doing it this way will allow the Ad to display without messing up the formatting of your content.
#### If you have more than one Ad Slot
If you have more than one Ad Slot you can indicate which one you want to use by pulling the code of the Ad Slot and adding it to the shortcode.

As an example, let's say that my Ad Slot code was 23245. I would make the shortcode look like the following:
`
[ian-ad code="23245"]
`
That will display that Ad Slot at that location. If you want to use the first Ad Slot (as shown above) don't need to add the `code="23245"` to the shortcode. It will automatically use the first one by default.

## What if I already activated this plugin before I signed up for an account and got an Ad Slot approved?
You can reload your Ad Slots at any time by clicking the "Refresh" button above. This will pull your Ad Slots from our system.

## I'm not seeing any Ad Slots even though I signed up. What's going on?
Just because you've registered with our system doesn't automatically give you an Ad Slot that you can use. We want to make sure the sites we serve ads on are appropriate for the ads we offer. Once you receive notice that your Ad Slot has been approved then you should be able to see that Ad Slot by clicking the refresh button above.

If for some reason you still aren't seeing your Ad Slot. Please feel free to reach out to us (contact number below).

## Questions? Comments?
Don't hesitate to reach out if you are having problems, or have a question or suggestion. You can reach us at [1-800-555-3321](tel:+18005553321).

== Screenshots ==
1. Setting up ad slots.
2. Adding ad slots to sidebar and footer as widgets.

== Changelog ==
= 1.0.5 =
Tested to work with 5.0.0 and PHP 7.2+
= 1.0.4 =
Tested to work with 4.9.8 and 5.0.0-beta5
= 1.0.3 =
Tested to work with 4.9.0
= 1.0.2 =
Fixed issue with activation not working on 4.8.2
= 1.0.1 =
Updated readme.ff2fcf5f.txt for readability.
= 1.0.0 =
Initial release.
