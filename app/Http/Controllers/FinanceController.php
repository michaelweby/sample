<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\ProductItem2;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    protected $orders ;
    public function report(){
        $shops = Shop::all();
        return view('admin.finance.report',['title'=>'Finances Report','shops'=>$shops,'orders'=>$this->orders]);
    }
    public function analyze(Request $request){
        if($request->shop_id == 0){
            $orders = Order::
            whereBetween('created_at',[new Carbon($request->start), new Carbon($request->end)])->
            where('status','completed')->
            get();
            $total = 0;
            $shoptizer_ratio =0;
            $excel_list_product = [];
            $product_count =0;
            foreach ($orders as $order){
                foreach($order->products as $product){
                    $product_count++;
                    $commission = $product->product->shop->commission;
                    $total += $product->getOriginal('pivot_original_price');
                    $shoptizer_ratio += $product->getOriginal('pivot_original_price') * $commission/100;
                    $specifications = '';
                    $attr_count = count($product->attribute);
                    foreach ($product->attribute as $attr){
                        $attr_count--;
                        $specifications .=$attr->attributeName->name.':'. $attr->value;
                        if($attr_count>0){
                            $specifications.=' - ';
                        }
                    }
                    array_push($excel_list_product,[
                        'name'=>$product->product->name,
                        'specifications'=>$specifications,
                        'shop'=>$product->product->shop->title,
                        'Selling Price'=>$product->getOriginal('pivot_original_price'),
                        'Quantity'=>$product->getOriginal('pivot_quantity'),
                        'Discount'=>$product->getOriginal('pivot_discount').$product->getOriginal('pivot_discount_type'),
                        'Selling Date'=>$order->created_at->format('d M Y H:i s'),
                    ]);


                }
            }
            $vendors_ratio = $total - $shoptizer_ratio;
            $total_calc =  [
                'order_count'=>count($orders),
                'product_count'=>$product_count,
                'collection'=>$total,
                'shoptizer'=>$shoptizer_ratio ,
                'vendor'=> $vendors_ratio,
            ];
            Excel::create('Fixed Report - '.
                (new Carbon($request->start))->format('d-M-Y').' to '.
                (new Carbon($request->end))->format('d-M-y'),function ($excel) use($excel_list_product,$total_calc){

                $excel->sheet('Products List', function($sheet) use ($excel_list_product) {
                    $sheet->fromArray($excel_list_product);

                });
                $excel->sheet('Total',function ($sheet) use($total_calc){
                    $sheet->fromArray([
                        'Orders'.' : '.$total_calc['order_count'],
                        'Product'.' : '.$total_calc['product_count'],
                        'Total Selling'.' : '.$total_calc['collection'],
                        'Shoptizer Profit'.' : '.$total_calc['shoptizer'],
                        'Vendor Profit'.' : '.$total_calc['vendor']
                    ]);
                });
            })->export('xls');
            return $orders;
        }else{
//            dd((new Carbon($request->start))->day);
            $shop = Shop::find($request->shop_id);
            $products = $shop->products;
            $items = [];
            $pivot_orders = [];
            foreach ($products as $product){
                foreach ($product->items as $item){
                    if (count($item_orders = DB::table('order_product')->where('product_id',$item->id)->get())>0){
                        foreach($item_orders as $item_order){
                            if($order =
                                Order::whereBetween('created_at',
                                    [new Carbon($request->start), new Carbon($request->end)])->
                                where('id',$item_order->order_id)->
                                where('status','completed')->
                                first()){
                                array_push($pivot_orders , $item_order);
                            }
                        }
                    }
                }

            }
            $shoptizer_ratio =0;
            $vendor_ratio = 0;
            $collection =0;
            $total_orders=0;
            $product_count =0;
            foreach ($pivot_orders as $order) {
                        $collection+= $total =  $order->quantity*$order->original_price;
                        $product_count+=$order->quantity;
                        $commission =$shop->commission/100;
                        $shoptizer_ratio += $total*$commission;
            }
            $vendor_ratio = $collection - $shoptizer_ratio;
            $excel_order = [];
            foreach($pivot_orders as $order){
                $main_order = Order::find($order->order_id);
                $item = ProductItem2::find($order->product_id);
                $specifications = '';
                $attr_count = count($item->attribute);
                foreach ($item->attribute as $attr){
                    $attr_count--;
                    $specifications .=$attr->attributeName->name.':'. $attr->value;
                    if($attr_count>0){
                        $specifications.=' - ';
                    }
                }
//                dd($order);
                array_push($excel_order,[
                    'Name'=>$item->product->name,
                    'Specifications'=>$specifications,
                    'Selling Price'=>$order->original_price,
                    'Quantity'=>$order->quantity,
                    'Selling Discount'=>$order->discount.$order->discount_type,
                    'Selling Data'=>$main_order->created_at->format('d M Y')
                ]);
            }
            $total_calc =  [
                'order_count'=>count($pivot_orders),
                'product_count'=>$product_count,
                'collection'=>$collection,
                'shoptizer'=>$shoptizer_ratio ,
                'vendor'=> $vendor_ratio,
            ];
//            dd($excel_order);
            Excel::create($shop->title .' - '.
                (new Carbon($request->start))->format('d-M-Y').' to '.
                (new Carbon($request->end))->format('d-M-y'),function ($excel) use($excel_order,$total_calc){

                $excel->sheet('Products List', function($sheet) use ($excel_order) {
                    $sheet->fromArray($excel_order);

                });
                $excel->sheet('Total',function ($sheet) use($total_calc){
                    $sheet->fromArray([
                        'Orders'.' : '.$total_calc['order_count'],
                        'Product'.' : '.$total_calc['product_count'],
                        'Total Selling'.' : '.$total_calc['collection'],
                        'Shoptizer Profit'.' : '.$total_calc['shoptizer'],
                        'Vendor Profit'.' : '.$total_calc['vendor']
                    ]);
                });
            })->export('xls');
            return
                [
                 $request->shop_id,
                 $total_orders,
                 'order_count'=>count($pivot_orders),
                 'product_count'=>$product_count,
                 'collection'=>$collection,
                 'shoptizer'=>$shoptizer_ratio ,
                 'vendor'=> $vendor_ratio,$collection
                ];
        }
        return view('admin.finance.report',['title'=>'Finances Report','shops'=>Shop::all(),'orders'=>$this->orders,'selected_shop'=>Shop::find($request->shop_id)]);

    }
}
