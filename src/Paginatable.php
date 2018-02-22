<?php

namespace ElemenX\ApiPagination;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;

trait Paginatable
{
    public function scopeApiPaginate(Builder $query, $limit = null, $offset = null, $columns = ['*'], $limitName = 'limit', $offsetName = 'offset')
    {
        $limit = $limit ?: Paginator::resolveCurrentLimit($limitName);
        $offset = $offset ?: Paginator::resolveCurrentOffset($offsetName);

        $results = ($total = $this->toBase()->getCountForPagination())
            ? $this->skip($offset)->take($limit)->get($columns)
            : $this->model->newCollection();

        return Container::getInstance()->makeWith(Paginator::class, compact(
            'results',
            'total',
            'limit',
            'offset'
        ));
    }
}
