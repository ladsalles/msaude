<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PacienteCreateRequest;
use App\Http\Requests\PacienteUpdateRequest;
use App\Repositories\PacienteRepository;
use App\Repositories\UbsRepository;
use App\Validators\PacienteValidator;

/**
 * Class PacientesController.
 *
 * @package namespace App\Http\Controllers;
 */
class PacientesController extends Controller
{
    /**
     * @var PacienteRepository
     */
    protected $repository;
    protected $ubsRepository;

    /**
     * @var PacienteValidator
     */
    protected $validator;

    /**
     * PacientesController constructor.
     *
     * @param PacienteRepository $repository
     * @param PacienteValidator $validator
     */
    public function __construct(
        PacienteRepository $repository, PacienteValidator $validator,
        UbsRepository $ubsRepository)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->ubsRepository = $ubsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $pacientes = $this->repository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $pacientes,
            ]);
        }

        return view('pacientes.index', compact('pacientes'));
    }

    public function create(){
        $ubs = $this->ubsRepository->all();
        return view('pacientes.create', compact('ubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PacienteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PacienteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            
            $paciente = $this->repository->create($request->all());

            $response = [
                'message' => 'Paciente created.',
                'data'    => $paciente->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paciente = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $paciente,
            ]);
        }

        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paciente = $this->repository->find($id);

        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PacienteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PacienteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $paciente = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Paciente updated.',
                'data'    => $paciente->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Paciente deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Paciente deleted.');
    }
}
