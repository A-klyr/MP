<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //store order and order item
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            //create order
            $order = \App\Models\Order::create([
                'transaction_time' => $request->transaction_time,
                'kasir_id' => $request->kasir_id,
                'total_price' => $request->total_price,
                'total_item' => $request->total_item,
                'payment_method' => $request->payment_method,
            ]);

            //create order item
            foreach ($request->order_items as $item) {
                // Get product to check stock
                $product = \App\Models\Product::find($item['product_id']);
                
                // Check if stock is sufficient
                if ($product->stock < $item['quantity']) {
                    \Illuminate\Support\Facades\DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok produk ' . $product->name . ' tidak mencukupi',
                    ], 400);
                }

                // Decrement stock
                $product->decrement('stock', $item['quantity']);

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            //response
            return response()->json([
                'success' => true,
                'message' => 'Order Created'
            ], 201);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
