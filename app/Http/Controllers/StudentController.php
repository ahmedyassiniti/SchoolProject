<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\School;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return StudentResource::collection(Student::with('school')->orderBy('school_id','ASC')->orderBy('order', 'ASC')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     $fields = $request->validate([
      'name'=>'required|string',
       
     ]);
        $lastOrder =Student::where('school_id', $request->school_id)->get()->last()->order;
        $nextOrder = $lastOrder+1;
         
         $student = Student::create([
        'name' => $fields['name'],
        'school_id' => $request->school_id,
        'order' => $nextOrder,
          ]);


      return new StudentResource($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $student->update($request->only(['name','school_id','order']));

        return new StudentResource($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
       $student->delete();

      return response()->json(null, 204);
    }


}
