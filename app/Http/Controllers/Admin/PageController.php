<?php

namespace App\Http\Controllers\Admin;


use Exception;
use App\Services\PageService;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Http\Requests\PaginateRequest;
use App\Models\Page;

class PageController extends AdminController
{
    private PageService $pageService;

    public function __construct(PageService $page)
    {
        parent::__construct();
        $this->pageService = $page;
         $this->middleware(['permission:settings'])->only('store', 'update', 'destroy', 'show');
    }

    public function index(PaginateRequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return PageResource::collection($this->pageService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(PageRequest $request): \Illuminate\Http\Response|PageResource
    {
        try {
            return new PageResource($this->pageService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Page $page): \Illuminate\Http\Response | PageResource
    {
        try {
            return new PageResource($this->pageService->show($page));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(PageRequest $request, Page $page): \Illuminate\Http\Response | PageResource
    {
        try {
            return new PageResource($this->pageService->update($request, $page));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Page $page): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->pageService->destroy($page);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
