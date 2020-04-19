<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class category extends Model
{
    use  NodeTrait;
    protected $fillable=["name","_lft","_rgt","parent_id"];
    protected $tablename="categories";
    public  function count(){
        return DB::table($this->tablename)->select()->count();
    }
    public function addNewCategory($row)
    {
        $parent=null;
        for ($i=0;$i<count($row);$i++){
            if ($row[$i]!=null){
                $deger=DB::table($this->tablename)->where("name","=",$row[$i])->select(['id'])->first();
                /** @var integer $deger */
                if(empty($deger)){
                        $id=new category();
                        $id->name=$row[$i];
                        $id->parent_id=$parent;
                        $id->save();
                        $sonuc=DB::table($this->tablename)->where("name","=",$row[$i])->first();
                        $parent=$sonuc->id;
                } else {
                    $parent=$deger->id;
                }
            }
        }
    }
}
