<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{

    /**
     * @param Request $request
     * @return string
     */
    public function dataTable(Request $request)
    {
        $input = $request->all();
        return $this->outPut($input);
    }

    /**
     * @param $input
     * @return string
     */
    public function outPut($input)
    {
        $list = $this->get_datatables($input);
        $data = array();
        foreach ($list as $key => $mData) {
            // out  put columns data
            $row[$key][] = $mData->name;
            $row[$key][] = $mData->age;
            $data[] = $row[$key];
        }
        $output = array(
            "draw" => $input['draw'],
            "recordsTotal" => $this->count_all($input),
            "recordsFiltered" => $this->count_filtered($input),
            "data" => $data,
        );
        //output to json format
        return json_encode($output);
    }

// get data of table

    /**
     * @param $input
     * @return mixed
     */
    function get_datatables($input)
    {
       
        // pagination  
        if ($input['length'] != -1)
            return DB::select(DB::raw($this->_get_datatables_query($input) . " LIMIT " . $input['length'] . " OFFSET " . $input['start']));
    }

    /**
     * @param $input
     * @return string
     */
    private function _get_datatables_query($input)
    {
        //  all  mysql  querys  
        
        $query = '';
        if ($input['search']['value'] != null) {
            $search = $input['search']['value'];
            $query .= "  WHERE  u.name LIKE  '%" . $search . "%'";
        }
        return "SELECT * FROM user u " . $query;
    }
// count total rows

    /**
     * @param $input
     * @return mixed
     */
    public function count_all($input)
    {
        //  $totalRecords = $this->_get_datatables_query($input);
        $row = DB::select(DB::raw($this->_get_datatables_query($input)));
        return count($row);
    }

    /**
     * @param $input
     * @return mixed
     */
    function count_filtered($input)
    {
        $row = DB::select(DB::raw($this->_get_datatables_query($input)));
        return count($row);
    }
}
