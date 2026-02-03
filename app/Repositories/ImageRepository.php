<?php

namespace App\Repositories;

use App\Core\BasicRepository;
use App\Models\Image;

class ImageRepository extends BasicRepository
{
    public function __construct(Image $image)
    {
        parent::__construct($image);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        $keyword = $params['keyword'] ?? request()->get('keyword');
        if (!empty($keyword)) {
            $query->where('url', 'like', "%{$keyword}%");
        }

        return $this->paging($query);
    }
}
