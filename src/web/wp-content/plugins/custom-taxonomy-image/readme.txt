=== Category and Taxonomy Image ===
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=amu02.aftab@gmail.com&item_name=Donation+category+and+Custom+taxonomy+image
Tags: Category Image, Category Images, Categories Images, taxonomy image, taxonomy images, taxonomies images, category icon, categories icons, category logo, categories logos, admin, wp-admin, category image plugin, categories images plugin, category featured image, categories featured images, feature image for category, term image, tag image term images, tag images
Contributors: amu02aftab
Author: amu02aftab
Tested up to: 5.6
License: GPLv2
Requires at least: 3.5.0
Stable tag: 1.0

== Description ==
* Category and Taxonomy Image Plugin allow you to add image with category/taxonomy.
* you can use the following function into your templates to get category/term image:
<pre>
if (function_exists('get_wp_term_image'))
{
    $meta_image = get_wp_term_image($term_id); 
	//It will give category/term image url 
}

echo $meta_image; // category/term image url
</pre>
where $term_id is 'category/term id'

= Features =
* Setting ,for which taxonomy ,image field is to be enable. 
* Very simple in use
* Can be customized easily.

== Screenshots ==
1. Settings page where you can select the taxonomies you want to include it in WP Custom Taxonomy Image
2. Example of the category/taxonomy image under the general category 


== Frequently Asked Questions ==
1. No technical skills needed.

== Changelog ==
This is first version no known errors found

== Upgrade Notice == 
This is first version no known notices yet

== Installation ==
1. Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload
the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to your WP-admin ->Settings menu a new "Taxonomy Image" page is created.
4. Go to your WP-admin ->Settings ->Taxonomy Image displayed in the taxonomies list form where you can select the taxonomies you want to include it in WP Custom Taxonomy Image.
5. Go to your WP-admin select any category/term ,here image text box where you can manage image for that category/term.
6. you can use the following function into your templates to get category/term image:
<pre>
if (function_exists('get_wp_term_image'))
{
    $meta_image = get_wp_term_image($term_id); 
	//It will give category/term image url 
}

echo $meta_image; // category/term image url
</pre>
where $term_id is 'category/term id'



