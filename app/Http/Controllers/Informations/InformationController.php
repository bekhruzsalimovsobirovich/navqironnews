<?php

namespace App\Http\Controllers\Informations;

use App\Domain\Informations\Actions\StoreInformationAction;
use App\Domain\Informations\Actions\UpdateInformationAction;
use App\Domain\Informations\DTO\StoreInformationDTO;
use App\Domain\Informations\DTO\UpdateInformationDTO;
use App\Domain\Informations\Models\Information;
use App\Domain\Informations\Repositories\InformationRepository;
use App\Domain\Informations\Requests\InformationFilterRequest;
use App\Domain\Informations\Requests\StoreInformationRequest;
use App\Domain\Informations\Requests\UpdateInformationRequest;
use App\Domain\Informations\Resources\InformationResource;
use App\Domain\Informations\Resources\MainInformationResource;
use App\Filters\InformationFilter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InformationController extends Controller
{
    /**
     * @var mixed|InformationRepository
     */
    public mixed $information;

    /**
     * @param InformationRepository $informationRepository
     */
    public function __construct(InformationRepository $informationRepository)
    {
        $this->information = $informationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InformationFilterRequest $request)
    {
        $filter = app()->make(InformationFilter::class, ['queryParams' => array_filter($request->validated())]);
        return InformationResource::collection($this->information->paginate(\request()->query('pagination', 20),$filter));
    }

    public function createTags(Request $request,Information $information)
    {
        $request->validate([
            'tags' => ['required','array'],
            'tags.*.name' => ['required','string']
        ]);

        try{
            foreach ($request->tags as $tagName) {
                $information->tags()->create([
                    'name' => $tagName['name'],
                ]);
            }

            return $this->successResponse('All tags created successfully.');
        }catch (Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param StoreInformationRequest $request
     * @param StoreInformationAction $action
     * @return JsonResponse
     */
    public function store(StoreInformationRequest $request, StoreInformationAction $action)
    {
        try {
            $dto = StoreInformationDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return $this->successResponse('Information created', new InformationResource($response));
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInformationRequest $request, Information $information, UpdateInformationAction $action)
    {
        try {
            $dto = UpdateInformationDTO::fromArray(array_merge($request->validated(), ['information' => $information]));
            $response = $action->execute($dto);

            return $this->successResponse('Information updated', new InformationResource($response));
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function updateViewCount(Information $information)
    {
        $information->increment('view_count');
        $information->update();

        return $this->successResponse('Sanaldi.');
    }

    /**
     * @param Information $information
     * @return JsonResponse
     */
    public function destroy(Information $information)
    {
        $information->delete();

        return $this->successResponse('Information deleted.');
    }



//    ----------------------------------------------------- MAIN PAGE --------------------------------------------------
    public function paginate(InformationFilterRequest $request)
    {
        $filter = app()->make(InformationFilter::class, ['queryParams' => array_filter($request->validated())]);
        return MainInformationResource::collection($this->information->paginate(\request()->query('pagination', 20),$filter));
    }

    public function getThreeLatestInformation()
    {
        return $this->successResponse('', MainInformationResource::collection($this->information->getInformation(3, 'created_at', 'desc', true)));
    }

    public function getTenLatestInformation()
    {
        return $this->successResponse('', MainInformationResource::collection($this->information->getInformation(10, 'created_at', 'desc', true)));
    }

    public function getMoreReadInformation()
    {
        return $this->successResponse('', MainInformationResource::collection($this->information->getInformation(10, 'view_count', 'desc', false)));
    }

    public function getEightGroupByCategoryInformation()
    {
        return $this->information->getEightGroupByCategoryInformation()->map(function ($group, $categoryName) {
            return [
                'category' => $categoryName,
                'informations' => MainInformationResource::collection($group), // Resurslar to'plamini yaratish
            ];
        })->values(); // Guruhlarni indekslash uchun values() chaqiriladi
    }

    public function showInformation()
    {
        return $this->successResponse('', new MainInformationResource(Information::query()->find(request()->segment(4))));
    }

    public function getOtherInformations()
    {
        return $this->successResponse('', MainInformationResource::collection($this->information->getOtherInformations()));
    }

    public function getCategoryInformation($category_id)
    {
        return $this->successResponse('', MainInformationResource::collection($this->information->getCategoryInformation(\request()->query('pagination',20),\request()->segment(4))));
    }
}
