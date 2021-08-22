<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;

class CrudController extends Controller
{

    protected $model;
    protected $filters;

    public function __construct()
    {
        $this->model = $this->getModelInstance();
        $this->filters = $this->registeredFilters();
    }


    /**
     * @throws \Exception
     */
    protected function getFormRequestInstance(): FormRequest
    {
        if (!method_exists($this, 'formRequest')) {
            throw new \Exception("No form request defined!");
        }

        return app()->make($this->formRequest());
    }

    protected function validateRequest(): FormRequest
    {
        $formRequest = $this->getFormRequestInstance();

        if (!$formRequest) {
            throw new \Exception('From Request Binding Exception');
        }

        return $formRequest;

    }

    /**
     * @throws \Exception
     */
    protected function getModelInstance(): Model
    {
        if (!method_exists($this, 'model')) {
            throw new \Exception("No model defined!");
        }

        return app()->make($this->model());
    }

    /**
     * @throws \Exception
     */
    public function store(): JsonResponse
    {
        $formRequest = $this->validateRequest();

        $dataFromDb = $this->model->create($formRequest->validated());

        return $this->ok('Model Created', $dataFromDb, 201);
    }

    public function index(): AnonymousResourceCollection
    {
        $data = app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through($this->filters)
            ->via('process')
            ->thenReturn()
            ->paginate(request('per_page') ?? 5);

        return AnonymousResourceCollection::make($data, null);
    }

    public function show($id): JsonResponse
    {
        $data = $this->model->find($id);
        if (is_null($data)) return $this->notFound();

        return $this->ok('Data found Successfully', $data);
    }

    public function destroy($id) : JsonResponse
    {
        $data = $this->model->find($id);
        if (is_null($data)) return $this->notFound();

        $data->delete();
        return $this->ok('Data deleted Successfully', $data);
    }

    /**
     * @throws \Exception
     */
    public function update($id) : JsonResponse
    {
        $formRequest = $this->validateRequest();

        $data = $this->model->find($id);
        if (is_null($data)) return $this->notFound();

        $data->update($formRequest->validated());
        return $this->ok('Data updated Successfully', $data);
    }

    protected function ok($message, $data = null, $statusCode = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $statusCode);
    }

    protected function notFound($message = null, $statusCode = 404): JsonResponse
    {
        return response()->json(['message' => $message ?? 'Data not found'], $statusCode);
    }


}
