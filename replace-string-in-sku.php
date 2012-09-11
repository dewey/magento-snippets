<?php
include ('app/Mage.php');
Mage::app('admin');

# Select Attributes
$productCollection = Mage::getModel('catalog/product')->getCollection() ->addAttributeToSelect('sku');

$counter = 0;
foreach($productCollection as $product){
    $sku = $product->getSku();
    $needle   = '_';
    $pos = strpos($sku, $needle);

    if ($pos !== false) {
        $newSKU = preg_replace('/\_/', '-', $sku);
        $product->setSku($newSKU);
        $product->save();
        $counter++;
    }
}
echo $counter.' attributes changed.';
?>
