=== bS5 Isotope ===

Contributors: craftwerk

Requires at least: 4.5
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: 5.0.0.3
License: MIT License
License URI: https://github.com/craftwerkberlin/bs5-isotope/blob/main/LICENSE

This plugin adds filterable Isotope custom post types to bootScore 5 WordPress theme, Copyright 2021 Bastian Kreiter.


== License & Credits ==

Isotope Commercial License https://isotope.metafizzy.co/license.html#commercial-license


== Installation ==

1. In your admin panel, go to Plugins > and click the Add New button.
2. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
3. Click Activate to use your new Plugin right away.


== Usage ==

Use shortcode [bs-isotope-equal-height type="post" tax="category" cat_parent="CATEGORY PARENT ID"] to show the Isotope grid where you want.

== Documentation ==

https://bootscore.me/documentation/bs-isotope/

== Changelog ==

    = 5.0.0.3 - July 30 2021 =

        * [CHANGED] GPL-2.0 to MIT License 
        * [IMPROVEMENT] Fixed a.badge color by text-* class instead of CSS (cpt-isotope.php)
        * [REMOVED] Folder inc with duplicate templates
        
    = 5.0.0.2 - March 20 2021 =
    
        * [BUGFIX] Added d-inline to read more button sc-equal-height-overlay.php and sc-masonry-overlay.php (MacOS Safari)

    = 5.0.0.1 - February 11 2021 =
    
        * [NEW] Override templates in child-theme 
        * [SEO] Merged jquery.isotope.min.js and isotope-init.js to one file to reduce HTTP requests
        * [SEO] Load js in footer

    = 5.0.0 - December 18 2020 =
    
        * Initial release
