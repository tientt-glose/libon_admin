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
            $params = $request->all();

            $validatorArray = [
                'book_name' => 'required',
                'pub_id' => 'required',
                'page_number' => 'required|integer|min:1',
                'cate_id' => 'required|array',
                'content' => 'required',
                'author' => 'required',
                'cover_path' => 'required|array|min:1|max:5'
            ];
            $messages = [
                'book_name.required' => 'Thi???u t??n ?????u s??ch',
                'pub_id.required' => 'Thi???u t??n Nh?? xu???t b???n',
                'page_number.required' => 'Thi???u s??? trang s??ch',
                'page_number.integer' => 'S??? trang ph???i l?? m???t s???',
                'page_number.min' => 'S??? trang ph???i l???n h??n 0',
                'cate_id.required' => 'Thi???u t??n th??? lo???i',
                'cate_id.array' => 'Ph???i l?? 1 t???p (m???ng) th??? lo???i',
                'content.required' => 'Thi???u n???i dung t??m t???t',
                'author.required' => 'Thi???u t??n t??c gi???',
                'cover_path.required' => 'Thi???u ???nh ch??nh',
                'cover_path.array' => '???nh upload ph???i l?? 1 t???p ???nh',
                'cover_path.min' => '???nh upload ph???i t??? 1 ???nh tr??? l??n',
                'cover_path.max' => '???nh upload ch??? t???i ??a 5 ???nh',
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

            $book = [
                'name' => $params['book_name'],
                'publisher_id' => $params['pub_id'],
                'page_number' => $params['page_number'],
                'content_summary' => $params['content'],
                'author' => $params['author'],
                'pic_link' => json_encode($listImg)
            ];

            $createdBookId = $this->book->insertGetId($book);
            $this->book->find($createdBookId)->categories()->sync($params['cate_id']);
            DB::commit();
            return redirect()->route('book.books.index')->with(['success' => 'Th??m ?????u s??ch th??nh c??ng']);
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

        return view('book::books.edit', compact('selectedCategories', 'selectedPublishers', 'book', 'listCate'));
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
                'cover_path' => 'array|max:5'
            ];
            $messages = [
                'book_name.required' => 'Thi???u t??n ?????u s??ch',
                'pub_id.required' => 'Thi???u t??n Nh?? xu???t b???n',
                'page_number.required' => 'Thi???u s??? trang s??ch',
                'page_number.integer' => 'S??? trang ph???i l?? m???t s???',
                'page_number.min' => 'S??? trang ph???i l???n h??n 0',
                'cate_id.required' => 'Thi???u t??n th??? lo???i',
                'cate_id.array' => 'Ph???i l?? 1 t???p (m???ng) th??? lo???i',
                'content.required' => 'Thi???u n???i dung t??m t???t',
                'author.required' => 'Thi???u t??n t??c gi???',
                'cover_path.required' => 'Thi???u ???nh ch??nh',
                'cover_path.array' => '???nh upload ph???i l?? 1 t???p ???nh',
                'cover_path.min' => '???nh upload ph???i t??? 1 ???nh tr??? l??n',
                'cover_path.max' => '???nh upload ch??? t???i ??a 5 ???nh',
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

            $book = [
                'name' => $params['book_name'],
                'publisher_id' => $params['pub_id'],
                'page_number' => $params['page_number'],
                'content_summary' => $params['content'],
                'author' => $params['author'],
                'pic_link' => json_encode($listImg)
            ];

            $this->book->updateBook($id, $book);

            foreach ($deleteImg as $picPath) {
                $picLink = public_path($picPath);
                if (File::exists($picLink)) {
                    File::delete($picLink);
                }
            }

            $this->book->find($id)->categories()->sync($params['cate_id']);

            DB::commit();
            return redirect()->route('book.books.index')->with(['success' => 'S???a ?????u s??ch th??nh c??ng']);
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
                return redirect()->back()->withErrors('X??a ?????u s??ch kh??ng th??nh c??ng');
            }

            // check the book with book
            $theBookExist = $this->book->checkStatusOfBook2($id);
            if ($theBookExist) {
                return redirect()->back()->withErrors('B???n kh??ng ???????c ph??p x??a ?????u s??ch ??ang c?? s??ch ????nh k??m');
            }

            $book = $this->book->find($id);
            // Xoa cate
            $book->categories()->detach();

            $listImg = json_decode($book->pic_link);
            $listImg = (array)$listImg;
            foreach ($listImg as $pic_path) {
                $pic_link = public_path($pic_path);
                if (File::exists($pic_link)) {
                    File::delete($pic_link);
                }
            }

            $this->book->deleteBook($id);
            DB::commit();
            return redirect()->back()->with(['success' => 'X??a ?????u s??ch th??nh c??ng']);
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
                    $html .= '<span class="badge badge-success">C?? th??? m?????n</span>';
                    return $html;
                } else if ($book->can_borrow == $this->book::UNBORROWABLE) {
                    $html .= '<span class="badge badge-danger">H???t</span>';
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
