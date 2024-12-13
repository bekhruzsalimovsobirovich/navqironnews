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
use App\Filters\InformationFilter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
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
}
