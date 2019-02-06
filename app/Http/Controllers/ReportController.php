<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterModel\MasterIndustryType;
use App\MasterModel\MasterSectorCategory;
use App\MasterModel\MasterSector;
use App\MasterModel\MasterReport;
use App\MasterModel\MasterProvinceOffice;
use App\LogModel\LogSystem;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $reports = MasterReport::all();
        $industries = MasterIndustryType::all();
        $sectors = MasterSector::all();
        $categories = MasterSectorCategory::where('sector_id', 2)->get();
        $offices = MasterProvinceOffice::all();
        $years = range(date('Y'), date('Y') - 10);

    	return view('report.index', compact('reports', 'industries', 'sectors', 'categories', 'offices', 'years'));
    }

    /**
     * Show the application details.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request) {

        $report = MasterReport::findOrFail($request->report_id);

        $model = '\\App\\ViewModel\\ViewReport' . ucwords($report->type->name) . $report->code;
        $view_report_query = $model::query();

        if($request->industry_type_id) {
            // Filter
            $view_report_query = $view_report_query->where('industry_type_id', $request->industry_type_id);
        }

        if($request->sector_id) {
            // Filter
            $view_report_query = $view_report_query->where('sector_id', $request->sector_id);
        }

        if($request->sector_category_id) {
            // Filter
            $view_report_query = $view_report_query->where('sector_category_id', $request->sector_category_id);
        }

        if($request->province_office_id) {
            // Filter
            $view_report_query = $view_report_query->where('province_office_id', $request->province_office_id);
        }

        if($request->start_year) {
            // Filter
            $view_report_query = $view_report_query->where('year', '>=', $request->start_year);
        }

        if($request->end_year) {
            // Filter
            $view_report_query = $view_report_query->where('year', '<=', $request->end_year);
        }

        $view_report = $view_report_query->get();

        $start_year = $request->start_year ? $request->start_year : date('Y') - 5;
        $end_year = $request->end_year ? $request->end_year : date('Y');
        $name = $report->name;
        
        return view('report.'.$report->type->name.'.'.$report->code.'.index', compact('view_report', 'start_year', 'end_year', 'name', 'view_report_query'));
    }
}
