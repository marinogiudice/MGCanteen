<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class CategoryWithDepth
{
    use HasFactory;
    private int $depth;
    private string $category_name;
    private ?string $parent_category;
    private ?string $image_path;
    private ?string $created_at;
    private ?string $updated_at;


    public function __construct(Category $category, $depth) {
        $this->category_name=$category->category_name;
        $this->parent_category=$category->parent_category;
        $this->image_path=$category->image_path;
        $this->created_at=$category->created_at;
        $this->updated_at=$category->updated_at;
        $this->depth = $depth;
    }

    public function get_depth() {
        return $this->depth;
    }

    public function get_category_name() {
        return $this->category_name;
    }

    public function get_parent_category() {
        return $this->parent_category;
    }

    public function get_created_at() {
        return $this->created_at;
    }

    public function get_update_at() {
        return $this->updated_at;
    }

    public function get_image_path() {
        return $this->$image_path;
    }
}
