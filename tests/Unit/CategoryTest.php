<?php

namespace Tests\Unit;
use App\Models\category;
use PHPUnit\Framework\TestCase;
use App\Jobs\addCategory;
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
        factory(category::class, $addCount)->create();
        $categoryCount = category::all()->count();
        $this->assertTrue($addCount==$categoryCount);
    }
    public function test_can_send_email(){
        $addCategory=new addCategory();
        $themeData=[
            "file"=>"a.xlsx",
            "addcount"=>"5",
            "totalcount"=>"20"
        ];
        $data = [
            "email" => "sami12gs@gmail.com",
            "name" => "sami dönmez",
            "subject" => "Görev bilgilendirmesi"
        ];
        $check=$addCategory->sendEmail('email.success',$themeData,$data);
        $this->assertTrue($check);
    }
}
