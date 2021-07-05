<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Book\Entities\Book;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Book\Entities\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;


class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = $this->category->getCategory();
        return view('book::categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cate_name = $request->cate_name;

            $validatorArray = [
                'cate_name' => 'required',
            ];

            $messages = [
                'cate_name.required' => 'Thiếu tên thể loại',
            ];

            $validator = Validator::make($request->all(), $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $category = [
                'name' => $cate_name
            ];
            $this->category->insert($category);
            DB::commit();
            return redirect()->back()->with(['success' => 'Thêm thể loại thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Category Add]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function editCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $cate_id = $request->cate_id;
            $cate_name = $request->cate_name;

            $validatorArray = [
                'cate_id' => 'required',
                'cate_name' => 'required'
            ];

            $messages = [
                'cate_id.required' => 'Sửa tên thể loại không thành công',
                'cate_name.required' => 'Thiếu tên thể loại'
            ];

            $validator = Validator::make($request->all(), $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $category = [
                'name' => $cate_name
            ];

            $this->category->updateCategory($cate_id, $category);
            DB::commit();
            return redirect()->back()->with(['success' => 'Sửa tên thể loại thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Category Edit]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $cate_id = $request->cate_id;

            if (empty($cate_id)) {
                return redirect()->back()->withErrors('Xóa thể loại không thành công');
            }

            //check count of book in this category, if count >1 -> error
            $countBook = Book::whereHas('categories', function (Builder $q) use ($cate_id) {
                $q->where('category_id', $cate_id);
            })
                ->count();

            if ($countBook > 0) {
                return redirect()->back()->withErrors('Bạn không được phép xóa thể loại đang có sách đính kèm');
            }

            $this->category->deleteCategory($cate_id);
            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa thể loại thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Category Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
