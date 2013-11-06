# [![Inchoo](http://inchoo.net/wp-content/themes/inchoo3/images/logo-inchoo.png)](http://inchoo.net) [Featured Products](http://inchoo.net/ecommerce/magento/featured-products-on-magento-frontpage/)

(Revamped version for new Magento CE & EE : for Magento CE lower that 1.6 and EE lower that 1.11, please use [older releases](https://github.com/buric/Inchoo_FeaturedProducts/branches).)

## About

This extension gives your Magento ability for easy management of featured products. Frontend features include separate interface for listing of all featured products and a block usage for easy placement to the interfaces of your choice. Frontend features include:

Featured Products Interface where you can see the list of all featured products and use the options like Sort by, Show X number of products and View type choice.
You can view featured products page on url: ``www.yourstore.com/featured-products/``
Featured Products Block gives you the ability to place the block to the interface or page of your choice. It is mostly used to display featured products o the home page.
Example: put it in Home page content ``{{block type="featuredproducts/listing"}}``
Backend features include:

Easy Management of Featured products via separate interface. You do not have to edit every single product and set it to be featured. You will get the special interface where you will be able to choose the products you want to feature from the list.
Go to admin menu and click on: Catalog -> Featured Products
Configuration Options You will be able to choose layout for Featured product lising interface, use SEO features, Choose the number of products in the block and choose default sort order.

## Installation

- Make a backup of both files and database
- If you're upgrading from older version, please uninstall old version (remove old files from ``app/code/community/Inchoo/FeaturedProducts``, ``app/design/frontend/default/default/template/inchoo``, ``app/design/frontend/default/default/layout/inchoofeaturedproducts.xml`` and ``skin/adminhtml/default/default/images/inchoo``)
- Click [here](https://github.com/buric/Inchoo_FeaturedProducts/archive/master.zip) to download the archive
- Extract the archive and copy files to the server
- If you use custom theme you'll need to copy template and layout files from ``app/design/frontend/default/default`` to ``app/design/frontend/your_package/your/theme`` in order to see anything on frontend
- Clear Magento Cache
- Log out of admin, and log in again
- If you use flat categorys and flat products tables, disable both of them, clear cache
- Enable Catalog Products flat first and save it
- Enable Catalog Categoryes flat and save them

## Changelog

### Version [1.2.3](https://github.com/buric/Inchoo_FeaturedProducts/tree/1.2.3)
 1. Reorganized System->Configuration section - everything from Inchoo is under "Inchoo" tab now
 

### Version [1.2.1](https://github.com/buric/Inchoo_FeaturedProducts/tree/1.2.1)
 1. Fixed bug when Magento's flat tables are enabled
 2. Admin grid extended with product type column and visibility renderer
 3. Added pagination to featured products view
 4. Price column updated/upgraded with currency in admin grid
 5. Reformatted frontend code + code comments
 6. Removed redundant files
 7. Reorganized template files
 8. Additional field in admin configuration for cms block title
 9. Reorganized template files for community version
 10. Added Inchoo's template file for Featured Products listing on separate page, as this way is more stable with your modifications on site (if any)
 11. Fixed ACL permissions - separated Featured Products Data permission (under Catalog menu) and Featured Products Settings permission (under System -> Configuration menu)
 12. Added template and layout files for default themes (Community, Professional, Enterprise)
 13. Added breadcrumbs for Featured Products page
 
### Notice

For Magento versions prior to 1.4 please try to use older extension release ([1.1.3](https://github.com/buric/Inchoo_FeaturedProducts/tree/1.1.3)), however that one is no longer supported
