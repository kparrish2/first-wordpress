<?php
namespace Rigo\Controller;

use WC_Product_Query;
use WP_Query;
use StdClass;

/*e  Rigo\Types\product;*/

class ProductController{
  
     public function getAllProducts( $request ){
        $products = new WP_Query([
            'post_type' => 'post'//,
                //'show_product_on_only_premium' => 'yes',
            ]);

        $args = array(
            'status' => 'publish',
        );
        $products = wc_get_products( $args );
        $tempArr = [];
        foreach($products as $product){
            $product_obj = json_decode($product-> __toString());
            $product_obj->img_src = wp_get_attachment_image_src($product_obj->image_id,'full')[0];
            $images_ids = $product-> get_gallery_image_ids();
            
            $images_arr = [];
            for($i = 0, $j = count($images_ids); $i < $j;$i++ ){
                $image_query = wp_get_attachment_image_src($images_ids[$i]);
                $img = new StdClass;
                $img->src = $image_query [0];
                array_push($images_arr, $img);
            }
            $product_obj->gallery = $images_arr;
            array_push($tempArr, $product_obj);
        }
        return $tempArr;
    } 
    
    /*public function wp_get_attachment_image_url( $attachment_id, $size = 'thumbnail', $icon = false ) {
    $image = wp_get_attachment_image_src( $attachment_id, $size, $icon );
    return isset( $image['0'] ) ? $image['0'] : false;
    }
    
    public function get_image( $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true ) {
        if ( has_post_thumbnail( $this->get_id() ) ) {
            $image = get_the_post_thumbnail( $this->get_id(), $size, $attr );
        } elseif ( ( $parent_id = wp_get_post_parent_id( $this->get_id() ) ) && has_post_thumbnail( $parent_id ) ) {
            $image = get_the_post_thumbnail( $parent_id, $size, $attr );
        } elseif ( $placeholder ) {
            $image = wc_placeholder_img( $size );
        } else {
            $image = '';
        }
        return apply_filters( 'woocommerce_product_get_image', wc_get_relative_url( $image ), $this, $size, $attr, $placeholder );
    }*/
    

}
?>