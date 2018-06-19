<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Excel;

class TestController extends Controller
{
   public function index(){
       return view('admin.test.index');
   }

   public function test(Request $request){
       $file = $request->file('file');
       Excel::load($file, function($reader) {
           foreach($reader as $item){
               dd($item->getTitle);
           }
//           foreach($reader as $item ){
               $as = $reader->takeRows(10)->takeColumns(2)->toArray();
               foreach($as as $a){
                   echo"<pre>";
                   var_dump($a);
           }

//           }
       });
   }
}
