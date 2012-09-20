<?php
include ('app/Mage.php');
Mage::app('admin');

$collection = Mage::getModel('catalog/product') ->getCollection()->addAttributeToSelect('*');
foreach ($collection as $product) {
        $result[] = $product->toArray();
}

$productcount = count($collection);
$changed = 0;
$wouldchange = 0;

# Select Product (fuzzy search)
$needle   = '10300';

# Shows affected products
$simulation = false;

# New group price
$price = 0.33;

# Tax Class
$taxclass = 1;

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
            $loadedproduct->setTaxClassId($taxclass);
            
            # Deactivate all products, then run this script -> you know it worked if your products are activate when you are done.
            $loadedproduct->setStatus(1);
            $changed++;
            
            try {
            $loadedproduct->save();
            }
            catch (Exception $ex) {  
                echo "Error!\n";
            }
        }
        $wouldchange++;
        echo "Set group price & taxclass for ".$result[$k]['sku']." to ".$price." Euro / Class ".$taxclass." ✔\n";
    }
}

echo "---------------------------------\n";
echo "Productcount: ".$productcount."\n";
echo ($simulation == true ? "Would Change: ".$wouldchange."\n" : "Changed:      ".$changed."\n");
echo "WebsiteID:    ".Mage::app()->getWebsite()->getId()."\n";
echo "StoreID:      ".Mage::app()->getStore()->getId()."\n";
echo "GroupID:      ".Mage::getSingleton('customer/session')->getCustomerGroupId()."\n";
echo "---------------------------------\n";
?>