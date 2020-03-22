<?php

namespace App\Http\Controllers;

use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller
{
    protected $query;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if not admin user then redirect home
        if(auth()->user()->user_type == 1) {
            return view('visitor.index');
        } else {
            return redirect()->route('home');
        }
    }

    public function getVisitorList(Request $request)
    {
        try{
            $this->query = Visitor::selectRaw('id,first_name,last_name, email, ip_address,created_at');
            $this->preparedQuery($request);
            
            return DataTables::of($this->query)
                ->addIndexColumn()
                ->make(true);

        } catch(\Exception $ex) {
            \Log::error($ex);
        }
    }

    protected function  preparedQuery($request)
    {
        try{
            
            if (isset($request->first_name) && !empty($request->first_name)) {
                $this->query =  $this->query->where('first_name','like','%'.$request->first_name.'%');
            }

            if (isset($request->last_name) && !empty($request->last_name)) {
                $this->query =  $this->query->where('last_name','like','%'.$request->last_name.'%');
            }

            if (isset($request->email) && !empty($request->email)) {
                $this->query =  $this->query->where('email','like','%'.$request->email.'%');
            }

            if (isset($request->ip_address) && !empty($request->ip_address)) {
                $this->query =  $this->query->where('ip_address','like','%'.$request->ip_address.'%');
            }

            if (isset($request->created_at) && !empty($request->created_at)) {
                $createdDate = Carbon::createFromFormat('d-m-Y', $request->created_at)->toDateString();
                $this->query =  $this->query->whereDate('created_at', $createdDate);
            }

        }catch(\Exception $ex) {
            \Log::error($ex);
            
        }
    }

    public function export(Request $request)
    {
        try {
            $this->query = Visitor::selectRaw('first_name,last_name,email,date_of_birth,ip_address,created_at');
            $this->preparedQuery($request);

            $visitors =  $this->query->get()->toArray();
            
            if(count($visitors)) {
                $fileName = 'visitors';
                $path = public_path('export/visitors');
                if(!file_exists($path)) {
                    File::makeDirectory($path,0755,true);
                    chmod($path, 0755);
                }

                Excel::create($fileName, function($excel) use ($visitors) {
                    $excel->sheet('visitor_list', function($sheet) use ($visitors) {
                        $sheet->fromArray($visitors);
                    });
                })->store('csv',$path);

                $fileName = $fileName.'.csv';
                $downloadFile = url('export/visitors/'.$fileName);
                
                return response()->json(['status' => '1', 'url' => $downloadFile, 'message' => 'File Downloaded']);
            } else {
                return response()->json(['status' => '2', 'message' => 'No records found to download']);
            }
        } catch(\Exception $ex) {
            \Log::error($ex);
            return response()->json(['status' => '0', 'message' => 'Something went wrong. Please try after some time.']);
        }

    }
}
