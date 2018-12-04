<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/images/products');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->airport_id = $request->airport;
        $product->service_id = $request->service;
        $product->product_code = $request->code;
        $product->sell_as_agent = $request->sell_as_agent == 'on' ? 1 : 0;
        $product->is_amendable = $request->is_amendable == 'on' ? 1 : 0;
        $product->is_refundable = $request->is_refundable == 'on' ? 1 : 0;

        if($request->file('photo')){
            $path = $this->save_image($request->file('photo'));
            $product->image = $path;            
        }else{
            $path = $product->image;
        }

        $product->save();
        return response()->json(['message' => 'Product Saved', 'image_url' => $path, 'product_id' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function ajax_save_content_product(Request $request){
        $product = Product::where('id',$request->id)->first();
        if($request->field == 'description'){
            $product->product_description = $request->text;
        }
        else if($request->field == 'info'){
            $product->product_info = $request->text;
        }
        else if($request->field == 'directions'){
            $product->product_directions = $request->text;
        }
        $product->save();
        return response()->json(['message' => 'Product Saved']);
    }

    public function ajax_save_show_hide_product(Request $request){
        $product = Product::findOrFail($request->id);
        if($product->show_hide_glag == 1){
            $product->show_hide_glag = 0;
        }else{
            $product->show_hide_glag = 1;
        }
        $product->save();
        return response()->json(['message' => 'Product Saved']);
    }

    function save_image($photo){
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        $imageFileName = rand(1,10000) . '-' . time() . '.' . $photo->getClientOriginalExtension();

        $full_img_path = public_path('images/products/' . $imageFileName);
        Image::make($photo->getRealPath())->save($full_img_path);
        $storagePath = 'images/products/' . $imageFileName;

        return $storagePath;
    }
}
