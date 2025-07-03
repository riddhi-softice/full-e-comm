<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use DataTables;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::with(['user','product'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function($row) {
                    $user_name = $row->user->name ?? '';
                    return $user_name;
                })
                ->addColumn('product_name', function($row) {
                    $product_name = $row->product->name ?? '';
                    return $product_name;
                })
                ->addColumn('created_at', function($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row) {
                    $btn = '<button data-id="'.$row->id.'" data-toggle="modal" data-target="#confirmDeleteModal" class="btn btn-danger btn-sm deleteData">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action','user_name','product_name'])
                ->make(true);
        }
        return view('admin.reviews.index');
    }

    public function destroy(Review $review)
    {
        $uid = $review->id;
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully'], 200);
    }

}