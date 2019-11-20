<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Files;
use DB; 
use Auth;

  
class tests1UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tests1Upload()
    {
        //dd(Auth::user()->id);

        if(isset(Auth::user()->id)){

            $posts = DB::table('posts')->where('cid', Auth::user()->id)->get();

            return view('tests1', ['posts' => $posts]);
                

        } else {

            return view('tests1');

        }
        
        return view('tests1')
                ->with('posts',$posts)
                ->with('success','You have successfully upload a parcours.');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tests1UploadPost(Request $request)
    {


        $request->validate([
            'file' => 'required',
        ]);
  
        //$filename = time().'.'.$request->file->extension();

        $file = file($request->file, FILE_IGNORE_NEW_LINES);
        $file = implode($file);

        DB::insert('insert into posts (cid, data, name) values (?, ?, ?)', [Auth::user()->id, $file, "test"]);

        $posts = DB::table('posts')->where('cid', Auth::user()->id)->get();
      

        return back()
            ->with('success','You have successfully upload a parcours.')
            ->with('filecontent',$file);
            //->with('posts',$posts);
    }



}