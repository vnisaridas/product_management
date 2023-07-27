<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesOptions;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('id','desc')->paginate(10);
        return view('products',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $product = Product::create([
            'title'             => $data['title'],
            'description'       => $data['description'],
            'image'             => $data['image_name']
        ]);        

        if(isset($data['size']) && count($data['size']) > 0){
            $attributeId = ProductAttributes::create([
                'product_id'    => $product->id,
                'name'          => 'size'
            ]);

            foreach($data['size'] as $size):
                ProductAttributesOptions::create([
                    'product_attribute_id'  => $attributeId->id,
                    'value'                 => $size,
                ]);
            endforeach;
        }

        if(isset($data['color']) && count($data['color']) > 0){
            $attributeId = ProductAttributes::create([
                'product_id'    => $product->id,
                'name'          => 'color'
            ]);

            foreach($data['color'] as $color):
                ProductAttributesOptions::create([
                    'product_attribute_id'  => $attributeId->id,
                    'value'                 => $color,
                ]);
            endforeach;
        }
        
        Session::flash('success', "Product Created Successfully");
        return redirect(route('products'));
        //return redirect(route('products'))->back()->with('success', 'Product Created Successfully');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_image(Request $request)
    {
        $data = $request->all();
        if(isset($data['image'])):                
            $image      = $data['image'];
            $fileName   = 'product-'.time() . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();                 
            });
            $img->stream();
            Storage::disk('public')->put('products/thumbnail/'.$fileName, $img, 'public');
            $image->storeAs('products/full/', $fileName);
            return response(json_encode(['response' => 'success', 'message' => 'Image Created','filename' => $fileName,'image_url' => asset('storage/products/thumbnail/'.$fileName)]));
        endif; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $obj = Product::with('product_attributes.attributes')->find($id);
        return view('products-update',compact('obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();        
        $product = Product::where(['id' => $data['id']])->update([
            'title'             => $data['title'],
            'description'       => $data['description'],
            'image'             => $data['image_name']
        ]);

        if(isset($data['size']) && count($data['size']) > 0){
            $getAttribute = ProductAttributes::where(['product_id' => $data['id'],'name' => 'size'])->first();
            $attributeId = '';
            if ($getAttribute === null) {
                $attributeId = ProductAttributes::create([
                    'product_id'    => $data['id'],
                    'name'          => 'size'
                ]); 
            }else{
                $attributeId = $getAttribute;
            }            
            $getAttributes = ProductAttributesOptions::where(['product_attribute_id' => $attributeId->id])->pluck('id')->toArray();
            foreach($data['size'] as $size):
                if(!in_array($size,$getAttributes)){
                    ProductAttributesOptions::create([
                        'product_attribute_id'  => $attributeId->id,
                        'value'                 => $size,
                    ]);
                }
            endforeach;
            $getArrayDiff = array_diff($getAttributes,$data['size']);
            if(count($getArrayDiff) > 0):
                $datavar = ProductAttributesOptions::whereIn('id',array_values($getArrayDiff))->delete();
            endif;
        }else{
            $getAttribute = ProductAttributes::where(['product_id' => $data['id'],'name' => 'size'])->first();

            if ($getAttribute != null) {
                $getAttributes = ProductAttributesOptions::where(['product_attribute_id' => $getAttribute->id])->pluck('id')->toArray();
                ProductAttributesOptions::whereIn('id',$getAttributes)->delete();
                ProductAttributes::where('id',$getAttribute->id)->delete();
            }
        }


        if(isset($data['color']) && count($data['color']) > 0){
            $getAttribute = ProductAttributes::where(['product_id' => $data['id'],'name' => 'color'])->first();
            $attributeId = '';
            if ($getAttribute === null) {
                $attributeId = ProductAttributes::create([
                    'product_id'    => $data['id'],
                    'name'          => 'color'
                ]); 
            }else{
                $attributeId = $getAttribute;
            }            
            $getAttributes = ProductAttributesOptions::where(['product_attribute_id' => $attributeId->id])->pluck('id')->toArray();
            foreach($data['color'] as $color):
                if(!in_array($color,$getAttributes)){
                    ProductAttributesOptions::create([
                        'product_attribute_id'  => $attributeId->id,
                        'value'                 => $color,
                    ]);
                }
            endforeach;
            $getArrayDiff = array_diff($getAttributes,$data['color']);
            if(count($getArrayDiff) > 0):
                $datavar = ProductAttributesOptions::whereIn('id',array_values($getArrayDiff))->delete();
            endif;
        }else{
            $getAttribute = ProductAttributes::where(['product_id' => $data['id'],'name' => 'color'])->first();

            if ($getAttribute != null) {
                $getAttributes = ProductAttributesOptions::where(['product_attribute_id' => $getAttribute->id])->pluck('id')->toArray();
                ProductAttributesOptions::whereIn('id',$getAttributes)->delete();
                ProductAttributes::where('id',$getAttribute->id)->delete();
            }
        }

        Session::flash('warning', "Product Updated Successfully");

        return redirect(route('products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id',$id)->delete();
        Session::flash('error', "Product Deleted Successfully");
        return redirect(route('products'));
    }
}
