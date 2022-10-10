<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateFingerprintDeviceAPIRequest;
use App\Http\Requests\API\Hr\UpdateFingerprintDeviceAPIRequest;
use App\Models\Hr\FingerprintDevice;
use App\Repositories\Hr\FingerprintDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\FingerprintDeviceResource;
use Response;

/**
 * Class FingerprintDeviceController
 * @package App\Http\Controllers\API\Hr
 */

class FingerprintDeviceAPIController extends AppBaseController
{
    /** @var  FingerprintDeviceRepository */
    private $fingerprintDeviceRepository;

    public function __construct(FingerprintDeviceRepository $fingerprintDeviceRepo)
    {
        $this->fingerprintDeviceRepository = $fingerprintDeviceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/fingerprintDevices",
     *      summary="Get a listing of the FingerprintDevices.",
     *      tags={"FingerprintDevice"},
     *      description="Get all FingerprintDevices",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/FingerprintDevice")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $fingerprintDevices = $this->fingerprintDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(FingerprintDeviceResource::collection($fingerprintDevices), 'Fingerprint Devices retrieved successfully');
    }

    /**
     * @param CreateFingerprintDeviceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/fingerprintDevices",
     *      summary="Store a newly created FingerprintDevice in storage",
     *      tags={"FingerprintDevice"},
     *      description="Store FingerprintDevice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FingerprintDevice that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FingerprintDevice")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/FingerprintDevice"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFingerprintDeviceAPIRequest $request)
    {
        $input = $request->all();

        $fingerprintDevice = $this->fingerprintDeviceRepository->create($input);

        return $this->sendResponse(new FingerprintDeviceResource($fingerprintDevice), 'Fingerprint Device saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/fingerprintDevices/{id}",
     *      summary="Display the specified FingerprintDevice",
     *      tags={"FingerprintDevice"},
     *      description="Get FingerprintDevice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FingerprintDevice",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/FingerprintDevice"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var FingerprintDevice $fingerprintDevice */
        $fingerprintDevice = $this->fingerprintDeviceRepository->find($id);

        if (empty($fingerprintDevice)) {
            return $this->sendError('Fingerprint Device not found');
        }

        return $this->sendResponse(new FingerprintDeviceResource($fingerprintDevice), 'Fingerprint Device retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFingerprintDeviceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/fingerprintDevices/{id}",
     *      summary="Update the specified FingerprintDevice in storage",
     *      tags={"FingerprintDevice"},
     *      description="Update FingerprintDevice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FingerprintDevice",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FingerprintDevice that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FingerprintDevice")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/FingerprintDevice"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFingerprintDeviceAPIRequest $request)
    {
        $input = $request->all();

        /** @var FingerprintDevice $fingerprintDevice */
        $fingerprintDevice = $this->fingerprintDeviceRepository->find($id);

        if (empty($fingerprintDevice)) {
            return $this->sendError('Fingerprint Device not found');
        }

        $fingerprintDevice = $this->fingerprintDeviceRepository->update($input, $id);

        return $this->sendResponse(new FingerprintDeviceResource($fingerprintDevice), 'FingerprintDevice updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/fingerprintDevices/{id}",
     *      summary="Remove the specified FingerprintDevice from storage",
     *      tags={"FingerprintDevice"},
     *      description="Delete FingerprintDevice",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FingerprintDevice",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var FingerprintDevice $fingerprintDevice */
        $fingerprintDevice = $this->fingerprintDeviceRepository->find($id);

        if (empty($fingerprintDevice)) {
            return $this->sendError('Fingerprint Device not found');
        }

        $fingerprintDevice->delete();

        return $this->sendSuccess('Fingerprint Device deleted successfully');
    }
}
