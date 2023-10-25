<?php

namespace App\File\Domain\Services;

use App\File\Domain\Filters\FileFilter;
use App\File\Domain\Models\File;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListFilesService extends Service
{
    protected $File;

    protected $filter;

    public function __construct(File $File, FileFilter $filter)
    {
        $this->File   = $File;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $order      = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit      = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active     = isset($data['active']) ? $data['active'] : 1;
        //  $has_stores = isset($data['has_stores']) ? $data['has_stores'] : 0;
        $all = isset($data['all']) ? $data['all'] : 1;

        $Files = $this->File->filter($this->filter);

        if (isset($data['is_paginated']) && $data['is_paginated'] == 1)
        {
            $Files = $Files
                ->when($all != 1, function ($collection) use ($active)
            {
                    return $collection->where('is_active', $active);
                })

                ->when($order == 'name', function ($collection) use ($order_type)
            {
                    return $collection->join('file_translations', function ($join)
                {
                        $join->on('files.id', '=', 'file_translations.file_id')
                            ->where('file_translations.locale', '=', app()->getLocale());
                    })

                        ->groupBy('files.id')
                        ->orderBy('file_translations.name', $order_type)
                        ->select('files.*', 'file_translations.id as file_translation_id');
                }, function ($collection) use ($order, $order_type)
            {
                    $collection->orderBy($order, $order_type);
                })
                ->paginate($limit);

            return new GenericPayload($Files, Response::HTTP_ACCEPTED);
        }
        else
        {
            $Files = $Files->where('is_active', 1)

//     ->when($store_id != null, function ($collection) use ($store_id)

// {

//         return $collection->where('store_id', $store_id);

//     })

//     ->when($has_stores == 1, function ($collection)

// {

//         return $collection->whereHas('stores', function ($query)

//     {

//             $query->where('is_active', 1);

//         });
            //     })
                ->orderBy($order, $order_type)
                ->get();
        }

        return new GenericPayload($Files, Response::HTTP_OK);

    }

}
