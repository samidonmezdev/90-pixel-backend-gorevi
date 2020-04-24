<?php

namespace App\Jobs;

use App\Imports\CategoryCollection;
use App\Models\category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

class addCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $category=new category();
        $oldcount = $category->count();
        $disk = 'ftp';
        $dictionary = 'categories';
        $file = $this->findFile($disk, $dictionary);
        $rows = $this->excelToArray($file);
        $check = $this->addCategoriesDatabase($rows);
        if ($check) {
            $totalcount = $category->count();
            $data = [
                "email" => "buradayim@90pixel.com",
                "name" => "Sistem yöneticisi",
                "subject" => "Görev bilgilendirmesi"
            ];
            $templatedata = [
                "file" => $file,
                "addcount" => $totalcount - $oldcount,
                "totalcount" => $totalcount
            ];
            $this->sendEmail('email.success', $templatedata, $data);
        }
    }

    public function addCategoriesDatabase($rows)
    {
        $category=new Category();
       foreach ($rows[0] as $row){
            try {
                $category->addNewCategory($row);
            }catch (Exception $exception){
                $data = [
                    "email" => "buradayim@90pixel.com",
                    "name" => "sistem yöneticisi",
                    "subject" => "Görev bilgilendirmesi"
                ];
                $templatedata = [
                    "code"=>$exception->getCode(),
                    "error"=>$exception->getMessage()
                ];
                $this->sendEmail('email.error',$templatedata,$data);
            }
        }
       return true;
    }

    public function sendEmail($mailtemplate,$templatedata,$data)
    {
        $mail = Mail::send($mailtemplate,$templatedata,function($m) use ($data){
            $m->to($data['email'],$data['name'])
                ->subject($data['subject']);
        });
        if ($mail){
            return true;
        }else{
            return false;
        }
    }

    public function excelToArray($file)
    {
        $rows = Excel::toArray(new CategoryCollection(), $file, "ftp");
    }

    public function findFile($disk,$dictionary)
    {
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
        //$actualfilevalue = "testformat"; //test etmek için kullanılıyor
        return 'categories/kategoriler-' . $actualfilevalue . ".xlsx";
    }
}
