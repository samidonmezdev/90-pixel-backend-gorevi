<?php

namespace App\Http\Controllers;

use App\Imports\CategoryCollection;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class deneme extends Controller
{
    public function handle()
    {
        $category=new category();
        $oldcount = $category->count();
        $disk = 'ftp';
        $dictionary = 'categories';
        $file = $this->findFile($disk, $dictionary);
        $rows = $this->excelToAray($file);
        $check = $this->addCategoriesDatabase($rows);
        if ($check) {
            $totalcount = $category->count();
            $data = [
                "email" => "sami12gs@gmail.com",
                "name" => "sami dönmez",
                "subject" => "Görev bilgilendirmesi"
            ];
            $templatedata = [
                "file" => $file,
                "addcount" => $totalcount - $oldcount,
                "totalcount" => $totalcount
            ];
            $this->sendEmail('email.success', $templatedata, $data);
            return $rows;
        }
    }

    public function addCategoriesDatabase($rows){
        $category=new Category();

        /* foreach ($rows[0] as $row){
             try {
                 $category->addNewCategory($row);
             }catch (Exception $exception){
                 $data = [
                     "email" => "sami12gs@gmail.com",
                     "name" => "sami dönmez",
                     "subject" => "Görev bilgilendirmesi"
                 ];
                 $templatedata = [
                     "code"=>$exception->getCode(),
                     "error"=>$exception->getMessage()
                 ];
                 $this->sendEmail('email.error',$templatedata,$data);
             }
         }*/
        return true;
    }

    public function sendEmail($mailtemplate,$templatedata,$data){
        Mail::send($mailtemplate,$templatedata,function($m) use ($data){
            $m->to($data['email'],$data['name'])
                ->subject($data['subject']);
        });
    }

    public function excelToAray($file){
        return Excel::toArray(new CategoryCollection(), $file, "ftp");
    }

    public function findFile($disk,$dictionary){
        $file = Storage::disk($disk)->files($dictionary);
        $actualfilevalue = 0;
        for ($i = 0; $i < count($file); $i++) {
            if (Str::contains($file[$i], 'xlsx')) {
                $filedatevalue = Str::before(Str::after($file[$i], "-"), ".");
                if (is_numeric($filedatevalue)) {
                    if ((int)$filedatevalue > $actualfilevalue)
                        $actualfilevalue = (int)$filedatevalue;
                }
            }
        }
        //$actualfilevalue = "testformat"; //test etek için kullanılıyor
        return 'categories/kategoriler-' . $actualfilevalue . ".xlsx";
    }
}
