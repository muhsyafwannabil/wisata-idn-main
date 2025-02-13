<?php 
namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index()
    {
        $order = Order::all();
        return ResponseHelper::success('List order', $order);
    }
    public function store(Request $request)
    {
        $request->validate([
            'transaction_time' => 'required',
            'total_price' => 'required',
            'total_item' => 'required',
            'payment_amount' => 'required|numeric',
            'cashier_id' => 'nullable|string',
            'cashier_name' => 'nullable|string',
            'payment_method' => 'nullable|boolean',
        ]);
        $order = Order::create($request->all());
        return ResponseHelper::success('order berhasil ditambahkan', $order);
    }
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return ResponseHelper::error('order tidak ditemukan', 404);
        }
        $order->delete();
        return ResponseHelper::success('order berhasil di hapus');
    }
    public function show(Order $order)
    {
        return ResponseHelper::success('detail order', $order);
    }
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return (new ResponseHelper)->error('order tidak ditemukan', [], 404);
        }
        $request->validate([
            'transaction_time' => 'required',
            'total_price' => 'required',
            'total_item' => 'required',
            'payment_amount' => 'required|numeric',
            'cashier_id' => 'nullable|string',
            'cashier_name' => 'nullable|string',
            'payment_method' => 'nullable|boolean',
        ]);
        $order->update($request->all());
        return (new ResponseHelper)->success('Order updated successfully', $order);
    }
}
