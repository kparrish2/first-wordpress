<?php

/**
 * To create new Post Types, you have to instanciate the PostTypesManager
*/
$typeManager = new \WPAS\Types\PostTypesManager([ 'namespace' => 'Rigo\\Types\\' ]);

/**
 * Then, start adding your types one by one.
*/
//$typeManager->newType(['type' => 'course', 'class' => 'Course'])->register();

$typeManager -> newType([
    'type' => 'photo',
    'class' => 'Photo',
    'options' => array(
        'supports' => array(
            'title', 'editor', 'thumbnail'
            ),
        'taxonomies' => array(
            'post_tag'
            )
        )
    ])->register();

        
/**
$typeManager->newType(['type' => 'storehome', 'class' => 'StoreHome'])->register();
$typeManager->newType(['type' => 'singleproduct', 'class' => 'SingleProduct'])->register();
$typeManager->newType(['type' => 'shoppingcart', 'class' => 'ShoppingCart'])->register();
$typeManager->newType(['type' => 'checkout', 'class' => 'CheckOut'])->register();
$typeManager->newType(['type' => 'confirmationpage', 'class' => 'ConfirmationPage'])->register();
*/

/**
$typeManager->newType(['type' => 'productID', 'class' => 'ProductID'])->register();
$typeManager->newType(['type' => 'productName', 'class' => 'ProductName'])->register();
$typeManager->newType(['type' => 'productPrice', 'class' => 'ProductPrice'])->register();
$typeManager->newType(['type' => 'productImage', 'class' => 'ProductImage'])->register();
$typeManager->newType(['type' => 'productDescription', 'class' => 'ProductDescription'])->register();
$typeManager->newType(['type' => 'productGallery', 'class' => 'ProductGallery'])->register();
$typeManager->newType(['type' => 'productRating', 'class' => 'ProductRating'])->register();
$typeManager->newType(['type' => 'productCategory', 'class' => 'ProductCategory'])->register();
*/

