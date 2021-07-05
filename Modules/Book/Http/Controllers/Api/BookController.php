<?php

namespace Modules\Book\Http\Controllers\api;

use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Modules\Book\Entities\Book;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Book\Entities\Comment;
use Illuminate\Support\Facades\Log;
use Modules\Book\Entities\Category;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\ApiController;

class BookController extends ApiController
{
    protected $book;
    protected $category;
    protected $comment;

    //todo: tai sao lai can
    public function __construct(Book $book, Category $category, Comment $comment)
    {
        $this->book = $book;
        $this->category = $category;
        $this->comment = $comment;
    }

    public function getAllBook(Request $request)
    {
        try {
            $listData = new stdClass();
            $listData->book = Book::select('*')->get();

            foreach ($listData->book as $key => $value) {
                if (!empty($value->pic_link)) {
                    $img = json_decode($value->pic_link);
                    $listData->book[$key]->pic1 = $img[0] ? url($img[0]) : null;
                    $listData->book[$key]->pic2 = $img[1] ? url($img[1]) : null;
                } else {
                    $listData->book[$key]->pic1 = null;
                    $listData->book[$key]->pic2 = null;
                }
            }

            $listData->IT = $this->book->getBookIT();

            foreach ($listData->IT as $key => $value) {
                if (!empty($value->pic_link)) {
                    $img = json_decode($value->pic_link);
                    $listData->IT[$key]->pic1 = $img[0] ? url($img[0]) : null;
                    $listData->IT[$key]->pic2 = $img[1] ? url($img[1]) : null;
                } else {
                    $listData->IT[$key]->pic1 = null;
                    $listData->IT[$key]->pic2 = null;
                }
            }

            $listData->theory = $this->book->getBookTheory();

            foreach ($listData->theory as $key => $value) {
                if (!empty($value->pic_link)) {
                    $img = json_decode($value->pic_link);
                    $listData->theory[$key]->pic1 = $img[0] ? url($img[0]) : null;
                    $listData->theory[$key]->pic2 = $img[1] ? url($img[1]) : null;
                } else {
                    $listData->theory[$key]->pic1 = null;
                    $listData->theory[$key]->pic2 = null;
                }
            }

            if ($listData) {
                return $this->successResponse(['result' => $listData], 'Response Successfully');
            } else {
                return $this->errorResponse([], 'Data not exist!');
            }
            //todo: hoi ve dau gach \, hoi ve chuc nang catch o duoi (lay message tu dau)
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage());
        }
    }

    public function getBookDetail(Request $request)
    {
        try {
            $id = $request->id;

            if (empty($id)) {
                return $this->errorResponse([], 'Invalid! Need id of the book.');
            }

            $bookItem = $this->book->getBookById($id);

            if ($bookItem) {
                if (!empty($bookItem->pic_link)) {
                    $bookItem->pic_link = json_decode($bookItem->pic_link);

                    $arr_path = (array) $bookItem->pic_link;
                    $arr = array();
                    foreach ($arr_path as $key => $path) {
                        if ($path) {
                            $arr[$key] = url($path);
                        } else {
                            $arr[$key] = null;
                        }
                    }

                    $bookItem->pic_link = $arr;
                }

                $bookItem->preview_link = $bookItem->preview_link ? url($bookItem->preview_link) : null;

                //borrowable && pending
                if ($bookItem->can_borrow && $this->book->checkPending($bookItem->id)) {
                    $bookItem->can_borrow = $this->book::PENDING;
                }

                return $this->successResponse(['result' => $bookItem], 'Response Successfully');
            } else {
                return $this->errorResponse([], 'None data!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage());
        }
    }

    public function checkPending(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'book_id' => 'required',
            ];
            $messages = [
                'book_id.required' => 'Thiếu thông tin sách',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()], 'Response Successfully');
            }

            $result->isPending = $this->book->checkPending($params['book_id']);
            $result->success = 1;

            return $this->successResponse($result, 'Response Successfully');
        } catch (\Throwable $th) {
            Log::error('[Check Book Pending Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }

    public function checkBorrowable(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();
            $validatorArray = [
                'book_id' => 'required',
            ];
            $messages = [
                'book_id.required' => 'Thiếu thông tin sách',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()], 'Response Successfully');
            }

            $result->isBorrowable = $this->book->checkBorrowable($params['book_id']);
            $result->success = 1;

            return $this->successResponse($result, 'Response Successfully');
        } catch (\Throwable $th) {
            Log::error('[Check Book Borrowable Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }

    public function getBookComment(Request $request)
    {
        try {
            $id = $request->id;

            if (empty($id)) {
                return $this->successResponse(["errors" => 'Invalid! Need id of the book.'], 'Response Successfully');
            }

            $comments = $this->comment->getCommentByBookId($id);

            if ($comments) {
                foreach ($comments as $comment) {
                    $name = $comment->user()->first()->fullname;
                    $userId = $comment->user()->first()->id_staff_student;
                    $comment->user_id = $name . ' ' . $userId;
                }

                return $this->successResponse(['result' => $comments], 'Response Successfully');
            } else {
                return $this->successResponse(["errors" => 'Invalid! Need id of the book.'], 'Response Successfully');
            }
        } catch (\Throwable $th) {
            Log::error('[Get Comment List Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }

    public function createBookComment(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'book_id' => 'required',
                'user_id'  => 'required',
                'content' => 'required',
            ];
            $messages = [
                'content.required' => 'Thiếu nội dung bình luận',
                'user_id.required'  => 'Thiếu thông tin người bình luận',
                'book_id.required' => 'Thiếu thông tin sách',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()], 'Response Successfully');
            }

            $comment = [
                'book_id' => $params['book_id'],
                'user_id' => $params['user_id'],
                'content' => $params['content'],
                'created_at' => Carbon::now(),
            ];

            $this->comment->insert($comment);

            $result->success = 1;

            DB::commit();
            return $this->successResponse($result, 'Response Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Borrow Order Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }
}
