<?php

namespace App\Http\Controllers\Categories;

use App\Domain\Categories\Actions\StoreCategoryAction;
use App\Domain\Categories\Actions\UpdateCategoryAction;
use App\Domain\Categories\DTO\StoreCategoryDTO;
use App\Domain\Categories\DTO\UpdateCategoryDTO;
use App\Domain\Categories\Models\Category;
use App\Domain\Categories\Repositories\CategoryRepository;
use App\Domain\Categories\Requests\CategoryFilterRequest;
use App\Domain\Categories\Requests\StoreCategoryRequest;
use App\Domain\Categories\Requests\UpdateCategoryRequest;
use App\Domain\Categories\Resources\CategoryResource;
use App\Filters\CategoryFilter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * @var mixed|CategoryRepository
     */
    public mixed $categories;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository;
    }

    /**
     * @param CategoryFilterRequest $request
     * @return AnonymousResourceCollection
     * @throws BindingResolutionException
     */
    public function index(CategoryFilterRequest $request): AnonymousResourceCollection
    {
        $filter = app()->make(CategoryFilter::class, ['queryParams' => array_filter($request->validated())]);
        return CategoryResource::collection($this->categories->paginate(\request()->query('pagination', 20),$filter));
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->successResponse('', CategoryResource::collection($this->categories->getAll()));
    }

    /**
     * @param StoreCategoryRequest $request
     * @param StoreCategoryAction $action
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request, StoreCategoryAction $action): JsonResponse
    {
        try {
            $dto = StoreCategoryDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Category created.', new CategoryResource($response));
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @param UpdateCategoryAction $action
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategoryAction $action): JsonResponse
    {
        try {
            $dto = UpdateCategoryDTO::fromArray(array_merge($request->validated(), ['category' => $category]));
            $response = $action->execute($dto);

            return $this->successResponse('Category updated.', new CategoryResource($response));
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->successResponse('Category deleted.');
    }
}
