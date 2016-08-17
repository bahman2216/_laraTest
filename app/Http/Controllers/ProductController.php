<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends Controller
{
    //
    public function store(Request $request)
    {

        $data = $request->only(['product', 'quantity', 'price']);

        $path = base_path() . '/public';
        $file = $path . '/product.json';

        $json = json_decode(file_get_contents($file), TRUE);

        if($json)
        {
            end($json);
            $key = key($json);
            $last_item_id = (int) $key + 1;
        }else{
            $last_item_id = 1;
        }

        $now = date('Y/m/d');
        $json[$last_item_id] = array("product" => $data['product'], "quantity" => $data['quantity'], "price" => $data['price'], "date"=>$now);

        file_put_contents($file, json_encode($json, TRUE));

        return 'Successfully added!';
    }
}
