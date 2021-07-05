<?php

namespace Modules\Book\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Book\Entities\Book;
use Modules\Core\Entities\User;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Book\Entities\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class CommentController extends Controller
{
    protected $book;
    protected $user;
    protected $comment;

    public function __construct(Book $book, User $user, Comment $comment)
    {
        $this->book = $book;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $books = $this->book->getBasicBook();
        return view('book::comments.index', compact('books'));
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
                'content' => 'required',
                'book_id' => 'required',
            ];
            $messages = [
                'content.required' => 'Thiếu nội dung bình luận',
                'book_id.required' => 'Thiếu id của đầu sách',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $comment = [
                'content' => $params['content'],
                'book_id' => $params['book_id'],
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
            ];

            $this->comment->insert($comment);
            DB::commit();
            return redirect()->route('book.comments.index')->with(['success' => 'Thêm bình luận thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Comment Add]' . $th->getMessage());
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
                return redirect()->back()->withErrors('Xóa bình luận không thành công');
            }

            $comment = $this->comment->findOrFail($id);

            if (empty($comment->deleted_at)) {
                $comment->delete();
            } else {
                return redirect()->back()->withErrors('Bình luận này đã được xóa rồi');
            }

            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa bình luận thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Comment Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function undo($id)
    {
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return redirect()->back()->withErrors('Hiển thị lại bình luận không thành công');
            }

            $comment = $this->comment->onlyTrashed()->findOrFail($id);

            if ($comment->deleted_at) {
                $comment->restore();
            } else {
                return redirect()->back()->withErrors('Bình luận này đã đang hiển thị rồi');
            }

            DB::commit();
            return redirect()->back()->with(['success' => 'Hiển thị lại bình luận thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Comment Undo]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function get(Request $request)
    {
        $query = $this->comment->withTrashed()->with('book:id,name', 'user:id,fullname');

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (!(empty($value) || $value == -1)) {
                        if ($key == 'search') {
                            $search = $value['value'];
                            $query->whereHas('user', function ($q) use ($search) {
                                $q->where('fullname', 'LIKE', '%' . $search . '%');
                            })
                                ->orWhereHas('book', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', '%' . $search . '%');
                                })
                                ->orWhere('content', 'LIKE', '%' . $search . '%')
                                ->orWhere('id', 'LIKE', '%' . $search . '%');
                        }
                    }
                }
            })
            ->addColumn('book', function ($comment) {
                $text = '[' . $comment->book->id . '] ' . $comment->book->name;
                return $text;
            })
            ->addColumn('user', function ($comment) {
                $text = '[' . $comment->user->id . '] ' . $comment->user->fullname;
                return $text;
            })
            ->addColumn('actions', function ($comment) {
                $html = $this->comment->genColumnHtml($comment);
                return $html;
            })
            ->addColumn('status', function ($comment) {
                $html = '';
                if ($comment->deleted_at) {
                    $html .= '<span class="badge badge-danger">Xóa</span>';
                    return $html;
                } else {
                    $html .= '<span class="badge badge-success">Hiện</span>';
                    return $html;
                }
            })
            ->escapeColumns([])
            ->make(true);
    }
}
