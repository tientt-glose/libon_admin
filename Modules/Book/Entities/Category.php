<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    protected $table = 'categories';

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_category', 'category_id', 'book_id')->withTimestamps();
    }

    public function getCategory()
    {
        return $this->select('*')->get();
    }

    public function updateCategory($id, $category)
    {
        return $this->where('id', $id)->update($category);
    }

    public function deleteCategory($id)
    {
        return $this->where('id', $id)->delete();
    }
}
