### Snippets for Magento 1.7.x
===

Copy or clone the scripts to your Magento Root folder, read the instructions below and run with `php scriptname.php`.

## replace-string-in-sku.php

Edit the String you want to search for in line 11: `$needle`, add the Replacement String to line 15.

## set-usergroup-based-on-oscommerce-b2b-flag.php

Export the B2B customers from your oscommerce database using:

    SELECT customers_email_address FROM `customers` WHERE `customers_group_name` = "B2B"

Use the phpmyadmin php-array export tool and replace the `$customer` array.

Every customer's usergroup with an email match on the $customer array will get changed to customer group 3 (in my case). Customize on line 22.

## set-group-prices-via-sku.php

Edit `needle`, `simulation` and `price`. Use simulation-mode to preview the search results.