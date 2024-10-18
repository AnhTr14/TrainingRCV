<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\MstProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    private function createProductId($name)
    {
        $firstLetter = strtoupper(substr($name, 0, 1));
        $lastProduct = MstProduct::where('product_id', 'like', "{$firstLetter}%")
            ->orderBy('product_id', 'desc')
            ->first();
        if ($lastProduct) {
            $lastNumber = (int) substr($lastProduct->product_id, 1);
            $newNumber = str_pad($lastNumber + 1, 9, '0', STR_PAD_LEFT);
        } else {
            $newNumber = str_pad(1, 9, '0', STR_PAD_LEFT);
        }
        return $firstLetter . $newNumber;
    }

    public function index()
    {
        $this->authorize('View Product');
        return view('product.index');
    }

    public function getListProducts(Request $request)
    {
        $this->authorize('View Product');
        $params = $request->all();

        $query = MstProduct::select('id', 'product_name', 'description', 'product_price', 'is_sales', 'product_image');

        if (!empty($params['filterName'])) {
            $query->where('product_name', 'LIKE', "%" . $params['filterName'] . "%");
        }

        if ($params['filterStatus'] != "") {
            $query->where('is_sales', $params['filterStatus']);
        }

        if (isset($params['filterFrom'])) {
            $query->where('product_price', '>=', $params['filterFrom']);
        }

        if (isset($params['filterTo'])) {
            $query->where('product_price', '<=', $params['filterTo']);
        }

        return datatables()->of($query)
            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('Edit Product')) {
                    $button .= '
                        <button class="edit btn btn-info btn-sm" type="button" data-id="' . $row->id . '">
                            <i class="fas fa-pencil-alt"></i>
                        </button>';
                }
                if (auth()->user()->can('Delete Product')) {
                    $button .= '
                        <button class="delete btn btn-danger btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->product_name . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                }
                return $button;
            })
            ->addColumn('product_name', function ($row) {
                $div = '<div class="popup-img" data-toggle="popover"  rel="popover" data-img="\storage\\' . $row->product_image . '">' . $row->product_name . '</div>';
                return $div;
            })
            ->rawColumns(['action', 'product_name'])
            ->make(true);
    }

    public function deleteProduct(Request $request)
    {
        $this->authorize('Delete Product');
        $id = $request->id;
        $product = MstProduct::find($id);
        $image = $product->product_image;
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        $product->delete();
    }

    public function addProduct()
    {
        $this->authorize('Create Product');
        return view('product.add');
    }

    public function storeProduct(Request $request)
    {
        $this->authorize('Create Product');
        $name = $request['productName'];
        $price = $request['productPrice'];
        $description = $request['productDescription'];
        $status = $request['productStatus'];
        $image = $request->file('productImage');
        $userId = $request['currentUserId'];

        $request->validate([
            'productName' => 'required|min:5',
            'productPrice' => 'required|numeric|min:0|max:2147483647',
            'productStatus' => 'required',
            'productImage' => 'required|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1024,max_height=1024'
        ], [
            'productName.required' => 'Vui lòng nhập tên sản phẩm',
            'productName.min' => 'Tên sản phẩm phải từ 5 ký tự',
            'productPrice.required' => 'Vui lòng nhập giá bán',
            'productPrice.numeric' => 'Giá bán chỉ được nhập số',
            'productPrice.min' => 'Giá bán không được nhỏ hơn 0',
            'productPrice.max' => 'Giá bán quá lớn',
            'productStatus.required' => 'Vui lòng chọn trạng thái',
            'productImage.required' => 'Vui lòng chọn hình ảnh',
            'productImage.image' => 'Vui lòng chọn tệp hình ảnh để tải',
            'productImage.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg, png',
            'productImage.max' => 'Dung lượng hình ảnh không được vượt quá 2MB',
            'productImage.dimensions' => 'Kích thước hình ảnh tối đa là 1024x1024 pixels',
        ]);

        // //Store image
        $imagePath = $image->store('images', 'public');
        $imagePath = $imagePath;
        // Product_id
        $product_id = $this->createProductId($name);

        $product = MstProduct::create([
            'product_name' => $name,
            'description' => $description,
            'product_price' => $price,
            'is_sales' => $status,
            'product_id' => $product_id,
            'product_image' => $imagePath,
            'created_by' => $userId
        ]);

        return response()->json(['success' => 'Success']);
    }

    public function detailProduct(Request $request)
    {
        $this->authorize('Edit Product');
        $id = $request->id;
        $product = MstProduct::findOrFail($id);
        return view('product.detail', compact(['product']));
    }

    public function updateProduct(Request $request)
    {
        $this->authorize('Edit Product');
        $name = $request['productName'];
        $price = $request['productPrice'];
        $description = $request['productDescription'];
        $status = $request['productStatus'];
        $image = $request->file('productImage');
        $userId = $request['currentUserId'];

        $id = $request['id'];
        $product = MstProduct::find($id);

        $rules = [
            'productName' => 'required|min:5',
            'productPrice' => 'required|numeric|min:0|max:2147483647',
        ];
        $message = [
            'productName.required' => 'Vui lòng nhập tên sản phẩm',
            'productName.min' => 'Tên sản phẩm phải từ 5 ký tự',
            'productPrice.required' => 'Vui lòng nhập giá bán',
            'productPrice.numeric' => 'Giá bán chỉ được nhập số',
            'productPrice.min' => 'Giá bán không được nhỏ hơn 0',
            'productPrice.max' => 'Giá bán quá lớn',
        ];

        if ($image) {
            $rules['productImage'] = 'image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1024,max_height=1024';
            $message['productImage.image'] = 'Tệp tải lên phải là hình ảnh';
            $message['productImage.mimes'] = 'Hình ảnh phải có định dạng jpg, jpeg, png';
            $message['productImage.max'] = 'Dung lượng hình ảnh không được vượt quá 2MB';
            $message['productImage.dimensions'] = 'Kích thước hình ảnh tối đa là 1024x1024 pixels';
            
        }

        $request->validate($rules, $message);

        //Store image
        if ($image) {
            $oldImage = $product->product_image;
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $imagePath = $image->store('images', 'public');
            $imagePath = $imagePath;
            $product->product_image = $imagePath;
        }

        if ($name != $product->product_name) {
            $product_id = $this->createProductId($name);
            $product->product_id = $product_id;
            $product->product_name = $name;
        }

        $product->product_price = $price;
        $product->description = $description;
        $product->is_sales = $status;
        $product->updated_by = $userId;


        $product->update();

        return response()->json(['success' => "success"], 200);
    }

}
