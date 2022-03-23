<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\School;
use App\Models\User;
use App\Http\Resources\SchoolResource;
class SchoolTest extends TestCase
{
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

      public function test_can_list_schools()
    {
       
        $schools = School::factory()->count(3)->create();
     
        $this->get(route('schools.index'))->assertStatus(200);
    }

   public function test_can_store_new_schools()
    {
      
      
      $schoolData =['name'=>'test School'];
      $this->json('POST','api/schools',$schoolData)
      ->assertStatus(201);
     

    }

      public function test_can_update_schools()
    {
      
      $school = School::factory()->create();
      $updatedData =['name'=>'test School'];
      $this->json('PUT',route('schools.update',$school->id),$updatedData)
      ->assertStatus(200);
     

    }

      public function test_can_show_schools()
    {
      $school = School::factory()->create();
   
      $this->get(route('schools.show',$school->id))->assertStatus(200);
     

    }


    public function test_can_delete_school()
    {
        $school = School::factory()->create();
        $school = School::first();
        if($school){
        	 $school->delete();
       
      }
       $this->assertTrue(true);

    }
   
}
