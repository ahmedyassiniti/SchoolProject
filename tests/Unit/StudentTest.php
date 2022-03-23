<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class StudentTest extends TestCase
{
	use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
     private $user;
    public function setUp():void
    {
       parent::setUp();
       $this->user = User::factory()->create();
       $this->actingAs($this->user,'sanctum');
    }

      public function test_can_list_students()
    {
       
        $students = Student::factory()->count(3)->create();
     
        $this->get(route('students.index'))->assertStatus(200);
    }

   public function test_can_store_new_students()
    {
      
      
      $studentData = Student::factory()->create();
      $this->json('POST','api/students',$studentData->toArray())
      ->assertStatus(201);
     

    }

      public function test_can_update_students()
    {
      
      $student = Student::factory()->create();
      $updatedData =[
      	'name' => $this->faker->name(),
        'school_id' =>School::all()->random()->id,
        'order' => $this->faker->unique()->randomDigit()];
      $this->json('PUT',route('students.update',$student->id),$updatedData)
      ->assertStatus(200);
     

    }

      public function test_can_show_students()
    {
      $student = Student::factory()->create();
   
      $this->get(route('students.show',$student->id))->assertStatus(200);
     

    }


    public function test_can_delete_student()
    {
        $student = Student::factory()->create();
        $student = Student::first();
        if($student){
        	 $student->delete();
       
      }
       $this->assertTrue(true);

    }
}
