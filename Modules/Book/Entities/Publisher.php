<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getPublisher()
    {
        return $this->select('*')->get();
    }

    public function updatePublisher($id, $publisher)
    {
        return $this->where('id', $id)->update($publisher);
    }

    public function deletePublisher($id)
    {
        return $this->where('id', $id)->delete();
    }
}
