<?php
include ('app/Mage.php');
Mage::app('admin');

$collection = Mage::getModel('customer/customer') ->getCollection()->addAttributeToSelect('*');

$i = 0;
$result = array();

$customers = array(
    array('customers_email_address'=>'info@blah.com'),
    array('customers_email_address'=>'info@blah.it'),
    array('customers_email_address'=>'info@blah.at')
);

$changedCounter;
foreach ($collection as $customer) {
    $result[] = $customer->toArray();
    # echo $result[$i]['entity_id']." - ".$result[$i]['group_id'].($result[$i]['group_id'] == 3 ? " -> B2B" : " -> Privat")."\n";
    for($k = 0; $k < count($customers);$k++) {
        if($result[$i]['email'] == $customers[$k]['customers_email_address']) {
            $customer->setGroupId("3");
            $customer->save();
            # echo $result[$i]['email']." - > oscommerce: ".$customers[$k]['customers_email_address']."\n";
            $changedCounter++;
        }
    }
    $i++;
}
echo "Debug: Size of input Array: ".count($customers).". ".$changedCounter." results found.\n";

# Print Magento Customer Groups

$customer_group = new Mage_Customer_Model_Group();
$allGroups  = $customer_group->getCollection()->toOptionHash();
foreach($allGroups as $key=>$allGroup){
    $customerGroup[$key]=array('value'=>$allGroup,'label'=>$allGroup);
}

print(print_r($customerGroup,true));