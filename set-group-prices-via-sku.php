<?php
include ('app/Mage.php');
Mage::app('admin');

$collection = Mage::getModel('catalog/product') ->getCollection()->addAttributeToSelect('*');
foreach ($collection as $product) {
        $result[] = $product->toArray();
}

$productcount = count($collection);
$changed = 0;

# Select Product (fuzzy search)
$needle   = '41000';

# Shows affected products
$simulation = false;

# New group price
$price = 999;

for($k = 0; $k < $productcount; $k++) {
    $pos = strpos($result[$k]['sku'], $needle);

    if ($pos !== false) {
        $loadedproduct = Mage::getModel('catalog/product')->setStoreId(0)->load($result[$k]['entity_id']);
        if($simulation == false) {
            echo "✏ ";
            $loadedproduct->setData('group_price',array (
            array (
                "website_id" => 0,
                "cust_group" => 3,
                "price" => $price
            )));
            $loadedproduct->save();
            $changed++;
        }
        echo "Set group price for ".$result[$k]['sku']." to ".$price." Euro ✔\n";
    }
}

echo "---------------------------------\n";
echo "Productcount: ".$productcount."\n";
echo "Changed:      ".$changed."\n";
echo "WebsiteID:    ".Mage::app()->getWebsite()->getId()."\n";
echo "StoreID:      ".Mage::app()->getStore()->getId()."\n";
echo "GroupID:      ".Mage::getSingleton('customer/session')->getCustomerGroupId()."\n";
echo "---------------------------------\n";
?>