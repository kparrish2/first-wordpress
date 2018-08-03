<?php
namespace Rigo\Controller;

use Rigo\Types\Photos;

class PhotosController{
    
    /*public function getHomeData(){
        return [
            'name' => 'Rigoberto'
        ];
    }*/
    
    public function getPhotos(){
        $query = Photos::all([ 'post_status' => 'published' ]);
        return $query->posts;
    }
    
}
?>