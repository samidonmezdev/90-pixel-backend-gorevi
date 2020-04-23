<?php

namespace Tests\Unit;
use App;
use PHPUnit\Framework\TestCase;
use App\Jobs\addCategory;
use Illuminate\Support\Facades\Mail;
class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_database_add()
    {
        $addCount=100;
        factory(App\Models\category::class, $addCount)->create();
        $categoryCount = App\Models\category::all()->count();;
        $this->assertTrue($categoryCount>=$addCount);
    }
    
    public function test_can_call_hook()
    {
        $respone=$this->get(env('APP_URL')."/api/category-kontrol");
        $response->assertStatus(200);
    }
    
    public function test_can_send_email(){
        
        $themeData=[
            "file"=>"a.xlsx",
            "addcount"=>"5",
            "totalcount"=>"20"
        ];
        $data = [
            "email" => "sami12gs@gmail.com",
            "name" => "sami     dönmez",
            "subject" => "Görev bilgilendirmesi"
        ];
        $mail = $this->mail("error.success",$themeData,function($m) use ($data){
            $m->to($data['email'],$data['name'])
                ->subject($data['subject']);
        });
        $this->assert(isset($mail));
    }
}
