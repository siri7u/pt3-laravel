<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Files;
use DB; 
use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user()->id);

        if(isset(Auth::user()->id)){

            $posts = DB::table('posts')->where('cid', Auth::user()->id)->get();
            //echo $posts





           $postsamis = DB::select('SELECT * FROM partages, posts WHERE partages.cid = '.Auth::user()->id.' AND partages.pid = posts.cid');

           $groups = [];
           foreach($postsamis as $a){

            $groups[$a->id] = [0];
            array_push($groups[$a->id], $a);

           }

    

       


            
            return view('home', ['posts' => $posts, 'listeamis' => $postsamis]);

            
                

        } else {
            return view('home');
        }
        
        return view('home')
                ->with('posts',$posts)
                ->with('success','You have successfully upload a parcours.');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPost(Request $request)
    {

        if ($request->has('file')) {

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
        } else if ($request->has('ami')) {  

            $tab = $request->input();

            $ami = $tab['ami'];


            DB::insert('insert into partages (cid, pid) values (?, ?)', [Auth::user()->id, $ami]);

            return back()
                ->with('success','You have successfully upload a friend.');
        } else {
            return 'salut';
        }

    }



}
