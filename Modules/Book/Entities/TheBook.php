<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\BookInOrder;

class TheBook extends Model
{
    protected $fillable = [
        'barcode',
        'publishing_year',
        'book_id'
    ];
    protected $table = 'the_books';
    const AVAILABLE = 1;
    const UNBORROWABLE = 0;

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function booksInOrders()
    {
        return $this->hasMany(BookInOrder::class);
    }

    public function countTheBookWithBookId($bookId)
    {
        return $this->where('book_id', $bookId)->count();
    }

    public function getTheBook($barcode)
    {
        return $this->where('barcode', $barcode)->first();
    }

    public function getTheBookByBarcode($barcode)
    {
        return $this->with('book:id,name,author,pic_link')->where('barcode', $barcode)->first();
    }

    public function getStatusTheBookByBarcode($barcode)
    {
        return $this->select('status')->where('barcode', $barcode)->first();
    }

    public function getTheBookByBarcodeAndBookId($barcode, $bookId)
    {
        return $this->where('barcode', $barcode)->where('book_id', $bookId)->first();
    }

    public function updateTheBook($id, $theBook)
    {
        return $this->where('id', $id)->update($theBook);
    }

    public function updateStatusByBarcode($barcode, $status)
    {
        return $this->where('barcode', $barcode)->update([
            'status' => $status
        ]);
    }

    public function deleteTheBook($id)
    {
        return $this->where('id', $id)->delete();
    }

    public static function genColumnHtml($data)
    {
        $message = "'Bạn có chắc chắn muốn xóa sách này không?'";
        $column = "";
        if (!empty($data)) {
            $column .= '<i class="fas fa-edit btn btn-primary btn-sm icon_button edit-the-book" data-toggle="modal"
            data-target="#modal-edit-the-book" data-id="' . $data->id . '"
            data-barcode="' . $data->barcode . '"
            data-pub-year="' . $data->publishing_year . '" title="Sửa sách"></i>';
            $column .= '<a href="' . route('book.the-books.destroy', ['id' => $data->id, 'book_id' => $data->book_id]) . '" onclick="return confirm(' . $message . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash" title="Xóa sách"></i></a>';
        }
        return $column;
    }
}
