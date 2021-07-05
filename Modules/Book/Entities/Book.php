<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\BookInOrder;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    protected $fillable = [
        'name',
        'publisher_id',
        'page_number',
        'content_summary',
        'author',
        'pic_link'
    ];

    const BORROWABLE = 1;
    const UNBORROWABLE = 0;
    const PENDING = 2;
    const THEORY = 'Giáo trình';
    const IT = 'Công nghệ thông tin';

    public function theBooks()
    {
        return $this->hasMany(TheBook::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id')->withTimestamps();
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function booksInOrders()
    {
        return $this->hasMany(BookInOrder::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getBookById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getBookWithPubById($id)
    {
        return $this->where('id', $id)->with('publisher')->first();
    }

    public function getPicLink($id)
    {
        return $this->select('pic_link')->where('id', $id)->get();
    }

    public function getPreviewLink($id)
    {
        return $this->select('preview_link')->where('id', $id)->first();
    }

    public function getBasicBook()
    {
        return $this->select('id', 'name')->get();
    }

    public function getStatus($bookId)
    {
        return $this->select('can_borrow')->where('id', $bookId)->first()->can_borrow;
        // return Book::select('can_borrow')->where('id', $bookId)->first()->can_borrow;
    }

    public function getBookTheory()
    {
        $cateId = Category::select('id')->where('name', 'LIKE', '%' . $this::THEORY . '%')->first()->id;
        return $this->whereHas('categories', function ($q) use ($cateId) {
            $q->where('category_id', $cateId);
        })->get();
    }

    public function getBookIT()
    {
        $cateId = Category::select('id')->where('name', 'LIKE', '%' . $this::IT . '%')->first()->id;
        return $this->whereHas('categories', function ($q) use ($cateId) {
            $q->where('category_id', $cateId);
        })->get();
    }

    public function checkStatusOfBook($id)
    {
        return $this->where('id', $id)->whereHas('theBooks', function (Builder $query) {
            $query->where('status', '!=', 0);
        })->exists();
    }

    public function checkStatusOfBook2($id)
    {
        $book = $this->where('id', $id)->whereHas('theBooks')->exists() || $this->where('id', $id)->whereHas('booksInOrders')->exists() ;
        return $book;
    }

    public function updateBook($id, $book)
    {
        return $this->where('id', $id)->update($book);
    }

    public function updateQuantity($id, $count)
    {
        return $this->where('id', $id)->update([
            'quantity' => $count
        ]);
    }
    public function updateBorrowed($id, $count)
    {
        return $this->where('id', $id)->update([
            'borrowed' => $count
        ]);
    }

    public function updateStatus($id, $status)
    {
        return $this->where('id', $id)->update([
            'can_borrow' => $status
        ]);
    }

    public function deleteBook($id)
    {
        return $this->where('id', $id)->delete();
    }

    public static function genColumnHtml($data)
    {
        $message = "'Bạn có chắc chắn muốn xóa đầu sách này không?'";
        $column = "";
        if (!empty($data)) {
            $column .= '<a href="' . route('book.books.the-books.index', $data->id) . '" class="btn btn-info btn-sm"><i class="fas fa-book" title="Danh sách cuốn sách"></i></a>';
            $column .= '<a href="' . route('book.books.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit" title="Sửa đầu sách"></i></a>';
            $column .= '<a href="' . route('book.books.destroy', $data->id) . '" onclick="return confirm(' . $message . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash" title="Xóa đầu sách"></i></a>';
        }
        return $column;
    }

    public function checkPending($bookId)
    {
        // $book = Book::where('id', $bookId)->first();
        // if (Book::getStatus($bookId) == Book::BORROWABLE) {
        //     return $book->booksInOrders()->whereNull('the_book_id')->count() >= $book->theBooks()->where('status', TheBook::AVAILABLE)->count();
        // }
        // else {
        //     return false;
        // }
        $book = $this->where('id', $bookId)->first();
        if ($this->getStatus($bookId) == $this::BORROWABLE) {
            return $book->booksInOrders()->whereNull('the_book_id')->count() >= $book->theBooks()->where('status', TheBook::AVAILABLE)->count();
        } else {
            return false;
        }
    }

    public function checkBorrowable($bookId)
    {
        if ($this->getStatus($bookId) == $this::BORROWABLE) {
            return true;
        } else {
            return false;
        }
    }
}
