<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Entities\User;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentByBookId($bookId)
    {
        return $this->where('book_id', $bookId)->get();
    }

    public function genColumnHtml($comment)
    {
        $message = "'Bạn có chắc chắn muốn xóa bình luận này không?'";
        $undoMess = "'Bạn có chắc chắn muốn hiển thị lại bình luận này không?'";
        $column = "";
        if (!empty($comment)) {
            if ($comment->deleted_at) {
                $column .= '<a href="' . route('book.comments.undo', $comment->id) . '" onclick="return confirm(' . $undoMess . ')" class="btn btn-primary btn-sm"><i class="fas fa-undo-alt" title="Hiển thị lại bình luận"></i></a>';
            } else {
                $column .= '<a href="' . route('book.comments.destroy', $comment->id) . '" onclick="return confirm(' . $message . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash" title="Xóa bình luận"></i></a>';
            }
        }
        return $column;
    }
}
