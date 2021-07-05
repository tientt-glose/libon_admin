<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Book\Entities\Publisher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class PublisherController extends Controller
{
    protected $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $publishers = $this->publisher->getPublisher();
        return view('book::publishers.index', compact('publishers'));
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
            $pub_name = $request->pub_name;

            $validatorArray = [
                'pub_name' => 'required',
            ];

            $messages = [
                'pub_name.required' => 'Thiếu tên nhà xuất bản',
            ];

            $validator = Validator::make($request->all(), $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $publisher = [
                'name' => $pub_name
            ];
            $this->publisher->insert($publisher);
            DB::commit();
            return redirect()->back()->with(['success' => 'Thêm Nhà xuất bản thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Publisher Add]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function editPublisher(Request $request)
    {
        DB::beginTransaction();
        try {
            $pub_id = $request->pub_id;
            $pub_name = $request->pub_name;

            $validatorArray = [
                'pub_id' => 'required',
                'pub_name' => 'required'
            ];

            $messages = [
                'pub_id.required' => 'Sửa tên Nhà xuất bản không thành công',
                'pub_name.required' => 'Thiếu tên Nhà xuất bản'
            ];

            $validator = Validator::make($request->all(), $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $publisher = [
                'name' => $pub_name
            ];

            $this->publisher->updatePublisher($pub_id, $publisher);
            DB::commit();
            return redirect()->back()->with(['success' => 'Sửa tên Nhà xuất bản thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Publisher Edit]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deletePublisher(Request $request)
    {
        DB::beginTransaction();
        try {
            $pub_id = $request->pub_id;

            if (empty($pub_id)) {
                return redirect()->back()->withErrors('Xóa Nhà xuất bản không thành công');
            }

            //check count of book in this publisher, if count >1 -> error
            $countBook = $this->publisher->find($pub_id)->books()->count();
            if ($countBook > 0) {
                return redirect()->back()->withErrors('Bạn không được phép xóa Nhà xuất bản đang có sách đính kèm');
            }

            $this->publisher->deletePublisher($pub_id);
            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa Nhà xuất bản thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Publisher Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
