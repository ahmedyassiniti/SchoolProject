<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use App\Events\StudentsOrdered;
class reorderStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:reorder-students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reorder students with school.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

    $students = StudentResource::collection(Student::with('school')->orderBy('school_id','ASC')->orderBy('order', 'ASC')->get());
    
    
    
    $schoolStudents = array();

       foreach ($students as $student) {
       $schoolStudents[$student->school_id][]= array('studentID'=>$student->id,'order'=>$student->order,'schoolID'=>$student->school_id);
       
   
        }
    
      foreach ($schoolStudents as $key => $students) {
      
        $students =array_combine(range(1, count($students)), array_values($students));
   
       foreach ($students as $key1 => $value1) {
        
       Student::where('id',$value1['studentID'])
       ->where('school_id',$key)
       ->update([
           'order' =>$key1
        ]);
       }

      }
        event(new StudentsOrdered('ahmedyassiniti@gmail.com'));

    }
}
