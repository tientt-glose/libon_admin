<?php

namespace Modules\Order\Entities;

use Modules\Book\Entities\Book;
use Modules\Book\Entities\TheBook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookInOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [];
    protected $table = 'books_in_orders';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function theBook()
    {
        return $this->belongsTo(TheBook::class);
    }

    public function inputBarcode($orderId, $bookId, $theBookId)
    {
        return $this->where('order_id', $orderId)->where('book_id', $bookId)->update([
            'the_book_id' => $theBookId
        ]);
    }
}
