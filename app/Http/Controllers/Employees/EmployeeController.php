<?php

namespace App\Http\Controllers\Employees;
use App\Http\Controllers\Controller;
use App\Services\Employees\CreateEmployeeService;
use App\Http\Requests\Employees\CreateEmployeeRequest;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Employees\EmployeeController;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    
    /**
     * EmployeeService Implementation.
     * 
     * @var CreateEmployeeService
     */
    private $employeeService;

     /**
     * Constructor of the controller.
     * 
     * @param \App\Services\Employees\CreateEmployeeService $employeeService
     * @return void
     */
    public function __construct(CreateEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->employeeService->getAllData();
        return view('employees.employee.index');
    }

    public function getList(Request $request)
    {
        if ($request->ajax()) {
            return $this->employeeService->getAllDatatables($this->employeeService->getAllData());
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $this->employeeService->createData($request->all());

        return redirect()->route('user.index')->with(['response' => true, 'type' => 'success', 'title' => 'Berhasil!', 'alert' => 'success', 'message' => 'Data karyawan berhasil di tambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->employeeService->getByIdData($id);

        return view('employees.employee.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->employeeService->getByIdData($id);

        return view('employees.employee.edit', ['data' => $data]);
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateEmployeeRequest $request, $id)
    {
        $validate = $request->validated();
        $data = $this->employeeService->getByIdData($id);
        $this->employeeService->updateData($id, $request->all());

        return redirect()->route('user.index')->with(['response' => true, 'type' => 'success', 'title' => 'Berhasil!', 'alert' => 'success', 'message' => 'Data karyawan berhasil di ubah']);
    }

    public function delete($id)
    {
        $data = $this->employeeService->getByIdData($id);

        return view('employees.employee.delete', ['data' => $data]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->employeeService->deleteData($id);

        return redirect()->route('user.index')->with(['response' => true, 'type' => 'success', 'title' => 'Berhasil!', 'alert' => 'success', 'message' => 'Data karyawan berhasil di hapus']);
    }
}
