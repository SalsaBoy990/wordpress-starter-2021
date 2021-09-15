# bs5-swiper

Plugin to show posts, pages, custom post types or WooCommerce products in a swiper.js carousel for bootScore 5 WordPress theme.

Demo: https://bootscore.me/plugins/bs-swiper/

Documentation: https://bootscore.me/documentation/bs-swiper/

## Installation

1. Download the zip file right here by pressing the green `code` button above or get plugin through the official [store](https://bootscore.me/shop/products/theme/bs-swiper/) (free). 
2. **If you download via Github**, unzip file and remove `-main` branch from folder name and zip again. Folder name must be `bs5-swiper`, otherwise template override in child-theme will not work.
3. In your admin panel, go to Plugins > and click the Add New button.
4. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
5. Click Activate to use your new Plugin right away.

## Usage

### Posts

Use shortcode to show posts:

#### Cards: 

`[bs-swiper-card type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]`


#### Heroes:

`[bs-swiper-hero type="post" category="water, classic, markup" order="DESC" orderby="date" posts="12"]`

#### Options:

- category: category slug, separated by comma for multiple categories
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display

### Pages

Use shortcode to show child pages:

#### Cards:
`[bs-swiper-card type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]`

#### Heroes:
`[bs-swiper-hero type="page" post_parent="1891" order="ASC" orderby="title" posts="6"]`

#### Options:

- post_parent: ID of parent page
- order: ASC or DESC
- orderby: date or title
- posts: number of pages to display

### Custom Post Types

Use shortcode to show custom post types:

#### Cards:
`[bs-swiper-card type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]`

#### Heroes:
`[bs-swiper-hero type="isotope" tax="isotope_category" cat_parent="224" order="DESC" orderby="date" posts="10"]`

#### Options:

- type: type of custom post type
- tax: taxonomy
- cat_parent: ID of parent taxonomy
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display 

### Products

Use shortcode to display your products in a page:

`[bs-swiper-card-product order="DESC" orderby="date" posts="12" category="sample-category, test-category"]`

#### Options:

- category: category slug, separated by comma for multiple categories
- order: ASC or DESC
- orderby: date or title
- posts: number of posts to display

## License & Credits

- bs5-swiper, MIT License https://github.com/craftwerkberlin/bs5-swiper/blob/main/LICENSE
- swiper.js, nolimits4web, MIT License https://github.com/nolimits4web/swiper/blob/master/LICENSE
- Plugin Update Checker, YahnisElsts, https://github.com/YahnisElsts/plugin-update-checker/blob/master/license.txt
