<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\Page;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        //$this->middleware(['auth','RoleAccess:1']);
    }

    public function index(Request $request)
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Page::find($id);
        return view('admin.page.edit',compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listDataHalaman(Request $request){
        $data = Page::select([
            'id','app_key','judul','konten'
        ]);

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('page', function($query, $keyword)  {
                    $sql = "m_halaman_web.konten like ? OR m_halaman_web.judul like ? ";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('page', function ($data) {
                if(!empty($data->konten)){
                    $konten = $data->konten;    
                }else{
                    $konten = $data->site_url;
                }
                $html = "<h5>{$data->judul}</h5><div class='max-lines-datatable'><p>{$konten}</p></div>";
                return $html;
            })
            ->addcolumn('aksi','<a href="{{url(\'/\')}}/admin/{{$id}}/edithalaman" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>')
            ->rawColumns(['page','aksi'])
            ->make(true);
    }
}
