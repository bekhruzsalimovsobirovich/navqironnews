<?php

namespace App\Http\Controllers\Files;

use App\Domain\Files\Actions\StoreImagesAction;
use App\Domain\Files\Actions\UpdateImagesAction;
use App\Domain\Files\DTO\StoreImagesDTO;
use App\Domain\Files\DTO\UpdateImageDTO;
use App\Domain\Files\Requests\StoreImagesRequest;
use App\Domain\Files\Requests\UpdateImagesRequest;
use App\Domain\Images\Models\Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class FileController extends Controller
{
    /**
     * @param UpdateImagesRequest $request
     * @param UpdateImagesAction $action
     * @return JsonResponse
     */
    public function updateImages(UpdateImagesRequest $request, UpdateImagesAction $action): JsonResponse
    {
        try {
            $dto = UpdateImageDTO::fromArray($request->validated());
            $response = $action->execute($dto);

            return response()
                ->json([
                    'status' => true,
                    'message' => 'Images updated successfully.',
                    'data' => $response,
                ]);
        } catch (Exception $exception) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $exception->getMessage()
                ]);
        }
    }


    /**
     * @param StoreImagesRequest $request
     * @param StoreImagesAction $action
     * @return JsonResponse
     */
    public function storeImages(StoreImagesRequest $request, StoreImagesAction $action): JsonResponse
    {
        try {
            $dto = StoreImagesDTO::fromArray($request->all());
            $response = $action->execute($dto);

            return response()
                ->json([
                    'status' => true,
                    'message' => 'Images saved successfully.',
                    'data' => $response
                ]);
        } catch (Exception $exception) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $exception->getMessage()
                ]);
        }
    }

    public function deleteImages(Request $request)
    {
        try {
            $request->validate([
                'file_ids' => 'required|array'
            ]);
        } catch (ValidationException $validationException) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $validationException->getMessage(),
                    'data' => $validationException->validator->errors()
                ]);
        }

        try {
            $file_ids = $request->file_ids;

            for ($i = 0; $i < count($file_ids); $i++) {
                $file = \App\Domain\Files\Models\File::query()->find($file_ids[$i]);
                \Illuminate\Support\Facades\File::delete('storage/files/' . $file->filename);
                $file->delete();
            }

            return response()
                ->json([
                    'status' => true,
                    'message' => 'Images deleted successfully.'
                ]);
        } catch (Exception $exception) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'request' => $request->all()
                ]);
        }
    }
}
