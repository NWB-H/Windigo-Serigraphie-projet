<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomerReview::all();
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'commentaire' => 'required|string',
            'note' => 'required|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
        ]);
        $formFields['user_id'] = Auth::id();


        $customerreview = CustomerReview::create($formFields);
        return response()->json($customerreview);
    }

    /**
     * Display the specified resource.
     */

    public function show(CustomerReview $customerreview)
    {
        return response()->json($customerreview);
    }

    public function reviewsByProduct($product_id)
    {

        $customerreview = CustomerReview::with(['user', 'product'])
            ->where('product_id', $product_id)
            ->get();
        return response()->json($customerreview);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $customerreview = CustomerReview::findOrFail($id);

        $formFields = $request->validate(
            [
                'commentaire' => 'string',
                'note' => 'integer|min:1|max:5',
            ],
        );

        $customerreview->update($formFields);

        return response()->json($customerreview);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerReview $customerreview)
    {
        $customerreview->delete();
        return response()->json(['success' => 'success']);
    }
}
