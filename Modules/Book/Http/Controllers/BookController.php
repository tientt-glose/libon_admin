<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Book\Entities\Book;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Book\Entities\Category;
use Illuminate\Support\Facades\File;
use Modules\Book\Entities\Publisher;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\Book\Entities\TheBook;

class BookController extends Controller
{
    protected $book;
    protected $category;
    protected $publisher;
    protected $theBook;

    public function __construct(Book $book, Category $category, Publisher $publisher, TheBook $theBook)
    {
        $this->book = $book;
        $this->category = $category;
        $this->publisher = $publisher;
        $this->theBook = $theBook;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = $this->category->getCategory();
        $actions = request()->route()->getAction();
        $controller = (explode("@", $actions['controller']));
        $controller = $controller[0];

        return view('book::books.index', compact('categories', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $selectedCategories = array();
        $categories = $this->category->getCategory();

        foreach ($categories as $category) {
            $selectedCategories[$category->id] = $category->name;
        }

        $selectedPublishers = array();
        $publishers = $this->publisher->getPublisher();

        foreach ($publishers as $publisher) {
            $selectedPublishers[$publisher->id] = $publisher->name;
        }

        return view('book::books.create', compact('selectedCategories', 'selectedPublishers'));
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
            // dd($request, $request->all());
            $params = $request->all();

            $validatorArray = [
                'book_name' => 'required',
                'pub_id' => 'required',
                'page_number' => 'required|integer|min:1',
                'cate_id' => 'required|array',
                'content' => 'required',
                'author' => 'required',
                'cover_path' => 'required|array|min:1|max:5',
                'pdf' => 'mimes:pdf|max:2048'
            ];
            $messages = [
                'book_name.required' => 'Thiếu tên đầu sách',
                'pub_id.required' => 'Thiếu tên Nhà xuất bản',
                'page_number.required' => 'Thiếu số trang sách',
                'page_number.integer' => 'Số trang phải là một số',
                'page_number.min' => 'Số trang phải lớn hơn 0',
                'cate_id.required' => 'Thiếu tên thể loại',
                'cate_id.array' => 'Phải là 1 tập (mảng) thể loại',
                'content.required' => 'Thiếu nội dung tóm tắt',
                'author.required' => 'Thiếu tên tác giả',
                'cover_path.required' => 'Thiếu ảnh chính',
                'cover_path.array' => 'Ảnh upload phải là 1 tập ảnh',
                'cover_path.min' => 'Ảnh upload phải từ 1 ảnh trở lên',
                'cover_path.max' => 'Ảnh upload chỉ tối đa 5 ảnh',
                'pdf.mimes' => 'Định dạng file phải là pdf',
                'pdf.max' => 'Kích thước file tối đa là 2MB'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $listImg = array();
            for ($i = 0; $i < 5; $i++) {
                if (!empty($request->cover_path[$i])) {
                    $filename = '/img/books/_' . substr(md5('_' . time()), 0, 15) . $i . '.png';
                    $path = public_path($filename);
                    Image::make($request->cover_path[$i])->orientate()->save($path);
                    $listImg[$i] = $filename;
                } else {
                    $listImg[$i] = null;
                }
            }

            $saveFile = null;

            if (array_key_exists('pdf', $params)) {
                $fileName = '_' . substr(md5('_' . time()), 0, 15) . '.' . $request->pdf->extension();
                $request->pdf->move(public_path('uploads'), $fileName);
                $saveFile = 'uploads/' . $fileName;
            }

            $book = [
                'name' => $params['book_name'],
                'publisher_id' => $params['pub_id'],
                'page_number' => $params['page_number'],
                'content_summary' => $params['content'],
                'author' => $params['author'],
                'pic_link' => json_encode($listImg),
                'preview_link' => $saveFile
            ];

            $createdBookId = $this->book->insertGetId($book);
            $this->book->find($createdBookId)->categories()->sync($params['cate_id']);
            DB::commit();
            return redirect()->route('book.books.index')->with(['success' => 'Thêm đầu sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Book Add]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $book = $this->book->getBookById($id);

        if (!empty($book->pic_link)) {
            $book->pic_link = json_decode($book->pic_link);
        }

        $listImgName = array();
        foreach ($book->pic_link as $key => $value) {
            $listImgName[$key] = substr($value, strpos($value, '_'));
        }

        $listCate = array();
        //todo: hoi, co cach nao select duoc luon ko
        foreach ($book->categories()->get() as $cate) {
            array_push($listCate, $cate->id);
        };
        $listCate = implode(', ', $listCate);

        $selectedCategories = array();
        $categories = $this->category->getCategory();

        foreach ($categories as $category) {
            $selectedCategories[$category->id] = $category->name;
        }

        $selectedPublishers = array();
        $publishers = $this->publisher->getPublisher();

        foreach ($publishers as $publisher) {
            $selectedPublishers[$publisher->id] = $publisher->name;
        }

        $uploadedFile = null;
        if (!empty($book->preview_link)) {
            $uploadedFile = substr($book->preview_link, strpos($book->preview_link, '_'));
            $book->preview_link = url($book->preview_link);
        }

        return view('book::books.edit', compact('selectedCategories', 'selectedPublishers', 'book', 'listCate', 'uploadedFile', 'listImgName'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $validatorArray = [
                'book_name' => 'required',
                'pub_id' => 'required',
                'page_number' => 'required|integer|min:1',
                'cate_id' => 'required|array',
                'content' => 'required',
                'author' => 'required',
                'cover_path' => 'array|max:5',
                'pdf' => 'mimes:pdf|max:2048'
            ];
            $messages = [
                'book_name.required' => 'Thiếu tên đầu sách',
                'pub_id.required' => 'Thiếu tên Nhà xuất bản',
                'page_number.required' => 'Thiếu số trang sách',
                'page_number.integer' => 'Số trang phải là một số',
                'page_number.min' => 'Số trang phải lớn hơn 0',
                'cate_id.required' => 'Thiếu tên thể loại',
                'cate_id.array' => 'Phải là 1 tập (mảng) thể loại',
                'content.required' => 'Thiếu nội dung tóm tắt',
                'author.required' => 'Thiếu tên tác giả',
                'cover_path.required' => 'Thiếu ảnh chính',
                'cover_path.array' => 'Ảnh upload phải là 1 tập ảnh',
                'cover_path.min' => 'Ảnh upload phải từ 1 ảnh trở lên',
                'cover_path.max' => 'Ảnh upload chỉ tối đa 5 ảnh',
                'pdf.mimes' => 'Định dạng file phải là pdf',
                'pdf.max' => 'Kích thước file tối đa là 2MB'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $deleteImg = array();
            $oldListImage = $this->book->getPicLink($id);
            $oldListImage = $oldListImage[0];
            $oldListImage = json_decode($oldListImage->pic_link);
            $oldListImage = (array)$oldListImage;

            $listImg = array();

            if (!empty($request->cover_path)) {
                for ($i = 0; $i < 5; $i++) {
                    if (!empty($request->cover_path[$i])) {
                        $filename = '/img/books/_' . substr(md5('_' . time()), 0, 15) . $i . '.png';
                        $path = public_path($filename);
                        Image::make($request->cover_path[$i])->orientate()->save($path);
                        $listImg[$i] = $filename;
                        array_push($deleteImg, $oldListImage[$i]);
                    } else {
                        $listImg[$i] = $oldListImage[$i];
                    }
                }
            } else {
                $listImg = $oldListImage;
            }

            $saveFile = $this->book->getPreviewLink($id)->preview_link;
            $deleteFile = null;

            if (array_key_exists('pdf', $params)) {
                $fileName = '_' . substr(md5('_' . time()), 0, 15) . '.' . $request->pdf->extension();
                $request->pdf->move(public_path('uploads'), $fileName);
                $deleteFile = $saveFile; // =old file
                $saveFile = 'uploads/' . $fileName;
            }

            $book = [
                'name' => $params['book_name'],
                'publisher_id' => $params['pub_id'],
                'page_number' => $params['page_number'],
                'content_summary' => $params['content'],
                'author' => $params['author'],
                'pic_link' => json_encode($listImg),
                'preview_link' => $saveFile
            ];

            $this->book->updateBook($id, $book);

            foreach ($deleteImg as $picPath) {
                $picLink = public_path($picPath);
                if (File::exists($picLink)) {
                    File::delete($picLink);
                }
            }

            if ($deleteFile) {
                $deleteLink = public_path($deleteFile);
                if (File::exists($deleteLink)) {
                    File::delete($deleteLink);
                }
            }

            $this->book->find($id)->categories()->sync($params['cate_id']);

            DB::commit();
            return redirect()->route('book.books.index')->with(['success' => 'Sửa đầu sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Book Edit]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return redirect()->back()->withErrors('Xóa đầu sách không thành công');
            }

            // check the book with book
            $theBookExist = $this->book->checkStatusOfBook2($id);
            if ($theBookExist) {
                return redirect()->back()->withErrors('Bạn không được phép xóa đầu sách đang có sách đính kèm');
            }

            $book = $this->book->find($id);
            // Xoa cate
            $book->categories()->detach();
            // Xoa comment
            $book->comments()->forceDelete();


            $listImg = json_decode($book->pic_link);
            $listImg = (array)$listImg;
            foreach ($listImg as $pic_path) {
                $pic_link = public_path($pic_path);
                if (File::exists($pic_link)) {
                    File::delete($pic_link);
                }
            }

            if ($book->preview_link) {
                $deleteLink = public_path($book->preview_link);
                if (File::exists($deleteLink)) {
                    File::delete($deleteLink);
                }
            }

            $this->book->deleteBook($id);
            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa đầu sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Book Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function get(Request $request)
    {
        $query = $this->book->with('categories', 'publisher');

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (!(empty($value) || $value == -1)) {
                        if ($key == 'category_id') {
                            $query->whereHas('categories', function ($q) use ($value) {
                                $q->where('category_id', $value);
                            });
                        }
                        if ($key == 'search') {
                            $search = $value['value'];
                            $query->where('name', 'LIKE', "%$search%")->orWhere('content_summary', 'LIKE', "%$search%")->orWhere('author', 'LIKE', "%$search%");
                        }
                    }
                }
            })
            ->escapeColumns([])
            ->addColumn('actions', function ($book) {
                $html = $this->book->genColumnHtml($book);
                return $html;
            })
            ->addColumn('status', function ($book) {
                $html = '';
                if ($book->can_borrow == $this->book::BORROWABLE) {
                    $html .= '<span class="badge badge-success">Có thể mượn</span>';
                    return $html;
                } else if ($book->can_borrow == $this->book::UNBORROWABLE) {
                    $html .= '<span class="badge badge-danger">Hết</span>';
                    return $html;
                }
            })
            ->addColumn('publisher', function ($book) {
                if (!empty($book->publisher)) {
                    $data = 'NXB ' . $book->publisher->name;
                    return $data;
                } else {
                    return '';
                }
            })
            ->addColumn('categories', function ($book) {
                if (!empty($book->categories)) {
                    $allCate = array();
                    foreach ($book->categories as $cate) {
                        array_push($allCate, $cate->name);
                    }
                    $data = implode(', ', $allCate);
                    return $data;
                } else {
                    return '';
                }
            })
            ->addColumn('pic_link', function ($book) {
                if (!empty($book->pic_link)) {
                    $data = json_decode($book->pic_link);
                    $data = (array)$data;
                    $html = '';
                    if (!empty($data)) {
                        $html .= '<img class="image-book" src="' . (($data[0] != null) ? url($data[0]) : "") . '">';
                    }
                    return $html;
                } else {
                    return '';
                }
            })
            ->make(true);
    }
}
