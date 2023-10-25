<?php

namespace App\Page\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Page\Domain\Filters\PageFilter;
use App\Page\Domain\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class ListPagesService extends Service
{
    protected $page;

    protected $filter;

    public function __construct(Page $page, PageFilter $filter)
    {
        $this->page   = $page;
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

//$company_id = null;

// if (auth()->guard('company')->check() || auth()->guard('focus')->check())

// {

//     $company_id = auth()->guard('company')->user()->company_id;

// }

// else

// {

//     $company_id = isset($data['company_id']) ? $data['company_id'] : null;
        // }

        $pages = $this->page->filter($this->filter);

        if (isset($data['is_paginated']) && $data['is_paginated'] == 1)
        {
            $pages = $pages
                ->when($all != 1, function ($collection) use ($active)
            {
                    return $collection->where('is_active', $active);
                })

//     ->when($company_id != null, function ($collection) use ($company_id)

// {

//         return $collection->where('company_id', $company_id);

//     })

//     ->when($has_stores == 1, function ($collection)

// {

//         return $collection->whereHas('stores', function ($query)

//     {

//             $query->where('is_active', 1);

//         });
                //     })
                ->when($order == 'name', function ($collection) use ($order_type)
            {
                    return $collection->join('Page_translations', function ($join)
                {
                        $join->on('pages.id', '=', 'Page_translations.Page_id')
                            ->where('Page_translations.locale', '=', app()->getLocale());
                    })

                        ->groupBy('pages.id')
                        ->orderBy('page_translations.name', $order_type)
                        ->select('pages.*', 'Page_translations.id as Page_translation_id');
                }, function ($collection) use ($order, $order_type)
            {
                    $collection->orderBy($order, $order_type);
                })
                ->paginate($limit);

            return new GenericPayload($pages, Response::HTTP_ACCEPTED);
        }
        else
        {
            $pages = $pages->where('is_active', 1)

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

        return new GenericPayload($pages, Response::HTTP_OK);

    }

}
