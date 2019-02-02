<?php
if (! function_exists('print_stars')) {
    function print_stars($stars)
    {
        $html = '';
        for($i = 0;$i<(integer)$stars ;$i++){
            $html .= '<i class="fas fa-star"></i>';
        }


        if($stars- floor($stars) >0) {
            $html .= '<i class="fas fa-star-half-alt"></i>';

            for ($i = 0; $i < 4 - (integer)$stars; $i++) {
                $html .= '<i class="far fa-star"></i>';
            }
        }
        else{
                for ($i = 0; $i < 5 - (integer)$stars; $i++){
                    $html .= '<i class="far fa-star" ></i >';
                }
            }
        return $html;
    }
}
// check for pound
if (! function_exists('after_discount')) {
    function after_discount($price,$discount,$discount_type){
        if($discount_type == 'pound'){
            $after_discount =$price - $discount;
        }
        else{
            $after_discount =$price - ($price * $discount/100);
        }

        return $after_discount;
    }
}

if (! function_exists('print_static_stars')) {
    function print_static_stars($stars){
        $html = '';
            for ($i = 0 ; $i<$stars ; $i++)
                $html .= ' <i class="fas fa-star"></i>';
        for ($i = 0 ; $i<5-$stars ; $i++)
            $html .= ' <i class="far fa-star"></i>';
        return $html;
    }
}