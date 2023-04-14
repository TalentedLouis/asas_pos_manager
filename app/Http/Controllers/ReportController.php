<?php

namespace App\Http\Controllers;

use App\Enums\TaxableMethodType;
use App\Enums\TaxRateType;
use App\Enums\ProductSearchType;
use App\Enums\ReportType;
use App\Http\Requests\ProductRequest;
use App\Models\ConfigRegi;
use App\Models\Product;
use App\Repositories\StockRepositoryInterface;
use App\Services\CategoryService;
use App\Services\ConfigRegiService;
use App\Services\GenreService;
use App\Services\MakerService;
use App\Services\StockService;
use App\Services\ShopService;
use App\Traits\BarcodeTrait;
use App\UseCases\ProductActions;
use App\UseCases\ReportActions;
use App\UseCases\ShopConfigActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

use function Faker\Provider\pt_BR\check_digit;
use DateTime;

class ReportController extends Controller
{
    private ProductActions $action;
    private CategoryService $categoryService;
    private GenreService $genreService;
    private MakerService $makerService;
    private ConfigRegiService $configRegiService;
    private StockService $stockService;
    private ReportActions $reportAction;
    private ShopService $shopService;

    use BarcodeTrait;

    public function __construct(
        ProductActions  $action,
        CategoryService $categoryService,
        GenreService    $genreService,
        MakerService    $makerService,
        ConfigRegiService $configRegiService,
        StockService $stockService,
        ReportActions  $reportAction,
        ShopService $shopService,
    )
    {
        $this->action = $action;
        $this->categoryService = $categoryService;
        $this->genreService = $genreService;
        $this->makerService = $makerService;
        $this->configRegiService = $configRegiService;
        $this->stockService = $stockService;
        $this->reportAction = $reportAction;
        $this->shopService = $shopService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $entities = $this->action->getAll();
        $productSearchType = ProductSearchType::asSelectArray();
        $reportTypes = ReportType::asSelectArray();
        $reportTypeId = null;
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        $shops = $this->shopService->getSelect();

        $user_code = Auth()->id();
        $dataForExl = DB::table('note'.$user_code)->paginate(15);

        return view('report.index', [
            'products' => $entities,
            'productSearchType' => $productSearchType,
            'from_date' => $trans_date,
            'to_date' => $trans_date,
            'reportTypes' => $reportTypes,
            'reportTypeId' => $reportTypeId,
            'trans_date' => $trans_date,
            'shops'=> $shops,
            'data_for_excel' => $dataForExl
        ]);
    }

    public function search(Request $request): View
    {
        //$product = $this->action->findByCode($jan_code);
        $param = $request->only(['report_type_id','from_date','to_date','shop_id']);
        $reportTypeId = $param['report_type_id'];
        $fromDate = $param['from_date'];
        $toDate = $param['to_date'];
        $shopId = $param['shop_id'];
        $reportTypes = ReportType::asSelectArray();
        $entities = $this->reportAction->findByName('現場',$reportTypeId,$fromDate,$toDate,$shopId);
        $productSearchType = ProductSearchType::asSelectArray();
        $shopConfigAction = App::make(ShopConfigActions::class);
        $trans_date = $shopConfigAction->get_trans_date();
        $shops = $this->shopService->getSelect();

        $user_code = Auth()->id();
        $dataForExl = DB::table('note'.$user_code)->paginate(15);


        return view('report.index', [
            'products' => $entities,
            'productSearchType' => $productSearchType,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'reportTypes' => $reportTypes,
            'reportTypeId' => $reportTypeId,
            'trans_date' => $trans_date,
            'shops'=> $shops,
            'data_for_excel' => $dataForExl
        ]); 
    }

    public function name_search(Request $request): View
    {
        //$product = $this->action->findByCode($jan_code);
        $param = $request->only(['keyword','product_search_type']);
        $param = $param['keyword'];
        //dd($param);
        $entities = $this->action->findByName($param);
        $productSearchType = ProductSearchType::asSelectArray();
        return view('product.index', [
            'products' => $entities,
            'productSearchType' => $productSearchType,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        $params = $request->only(['code']);
        if (count($params) == 0) {
            $code = '';
        } else {
            $code = $params['code'];
        }

        $categories = $this->categoryService->getSelect()->toArray();
        $genres = $this->genreService->getSelect()->toArray();
        $makers = $this->makerService->getSelect()->toArray();
        $taxRateTypes = TaxRateType::asSelectArray();
        $taxableMethodTypes = TaxableMethodType::asSelectArray();
        return view('product.create', [
            'categories' => $categories,
            'genres' => $genres,
            'makers' => $makers,
            'taxRateTypes' => $taxRateTypes,
            'taxableMethodTypes' => $taxableMethodTypes,
            'code' => $code
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductRequest $request): Redirector|RedirectResponse|Application
    {
        $this->action->create($request);
        return redirect(route('product.create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = $this->categoryService->getSelect()->toArray();
        $genres = $this->genreService->getSelect()->toArray();
        $makers = $this->makerService->getSelect()->toArray();
        $taxRateTypes = TaxRateType::asSelectArray();
        $taxableMethodTypes = TaxableMethodType::asSelectArray();
        $stock = $this->stockService->getThisStock($product->id);
        $is_add = true;
        //在庫データが無いときに他店で登録したデータを仮取得する。
        if($stock === null){
            $stock = $this->stockService->getOtherStock($product->id);
            $is_add = false;
        }
        //未登録時に税フラグ等を仮入力しておく為。
        if($stock === null){
            $stock = $this->stockService->getKariStock();
            $is_add = false;
        }
        return view('product.edit', [
            'product' => $product,
            'categories' => $categories,
            'genres' => $genres,
            'makers' => $makers,
            'taxRateTypes' => $taxRateTypes,
            'taxableMethodTypes' => $taxableMethodTypes,
            'stock' => $stock,
            'is_add' => $is_add,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ProductRequest $request, Product $product): Redirector|RedirectResponse|Application
    {
        $this->action->update($product, $request);
        return redirect(route('product.create'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Product $product): Redirector|RedirectResponse|Application
    {
        $this->action->delete($product);
        return redirect(route('product.index'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function code_search(Request $request): RedirectResponse
    {
        $params = $request->only(['keyword']);
        $jan_code = str_pad($params['keyword'], 12, '0', STR_PAD_LEFT);
        //  20230101 UPD S
        //$jan_code .= $this->calcCheckDigitJan13($jan_code);
        $jan_code = substr($jan_code, 0, 12).$this->calcCheckDigitJan13($jan_code);
        // 20230101 UPD E 
        $product = $this->action->findByCode($jan_code);
        if (!$product) {
            return redirect()->route('product.create', ['code' => $jan_code]);
        } else {
            return redirect()->route('product.edit', ['product' => $product->id]);
        }
    }

    public function code_create(): RedirectResponse
    {
        // Create new code
        $code_suffix = $this->configRegiService->getProductCodeSuffix();
        $code_suffix = str_pad($code_suffix, 2, '0', STR_PAD_LEFT);
        $code_sequence = $this->configRegiService->getProductCodeSequence();
        $code_sequence = str_pad($code_sequence, 10, '0', STR_PAD_LEFT);
        $jan_code = $code_suffix . $code_sequence;
        $jan_code .= $this->calcCheckDigitJan13($jan_code);
        return redirect()->route('product.create', ['code' => $jan_code]);
    }

    public function download_excel(Request $request)
    {
        try{
            $objPHPExcel = IOFactory::load(Storage::path("template.xls"));
        } catch(Exception $ex){
            return response()->json([
                'message' => 'Template file does not exist!',
            ], 400);
        }

        // $allData;
        // if($request){
        //     $prefectures = $request->prefectures;
        //     $industry = $request->industry;
        //     $site_url = $request->siteUrl;
        //     $capital = $request->capital;
        //     $amount_of_sales = $request->amountOfSales;
        //     $free_keyword = $request->freeKeyword;
        //     $establish_date_from = $request->establishDateFrom;
        //     $establish_date_to = $request->establishDateTo;
            
        //     $allData = Company::where(function ($query) use ($prefectures, $industry, $site_url, $free_keyword, $establish_date_from, $establish_date_to) {
        //         if($prefectures && $prefectures != 0 )
        //             $query->where('address', 'LIKE', $prefectures.'%');
        //         if($industry && $industry != 0 )
        //             $query->where('category_id', 'LIKE', '%'.$industry.'%');
        //         if($free_keyword)
        //             $query->orWhere('name', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('furi', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('en_name', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('category_id', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('url', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('contact_url', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('zip', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('pref', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('address', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('tel', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('dainame', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('corporate_number', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('established', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('capital', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('earnings', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('employees', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('category_txt', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('houjin_flg', 'Like', '%'.$free_keyword.'%')
        //                     ->orWhere('status', 'Like', '%'.$free_keyword.'%');
        //         if($site_url == 1)
        //             $query->where('url', '!=', '');
        //         if($site_url == 2)
        //             $query->where('url', '');
        //     });
        // } else {
        //     $allData = Company::all();
        // }

        // $beginRowNum = 2;
        // foreach ($allData->lazy(1000) as $company) {
        //     $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A'.$beginRowNum, $company->name)
        //     ->setCellValue('B'.$beginRowNum, $company->furi)
        //     ->setCellValue('C'.$beginRowNum, $company->en_name)
        //     ->setCellValue('D'.$beginRowNum, $company->category_id)
        //     ->setCellValue('E'.$beginRowNum, $company->url)
        //     ->setCellValue('F'.$beginRowNum, $company->contact_url)
        //     ->setCellValue('G'.$beginRowNum, $company->zip)
        //     ->setCellValue('H'.$beginRowNum, $company->address)
        //     ->setCellValue('I'.$beginRowNum, $company->tel)
        //     ->setCellValue('J'.$beginRowNum, $company->dainame)
        //     ->setCellValue('K'.$beginRowNum, $company->corporate_number)
        //     ->setCellValue('L'.$beginRowNum, $company->established)
        //     ->setCellValue('M'.$beginRowNum, $company->capital)
        //     ->setCellValue('N'.$beginRowNum, $company->earnings)
        //     ->setCellValue('O'.$beginRowNum, $company->employees)
        //     ->setCellValue('P'.$beginRowNum, $company->category_txt)
        //     ->setCellValue('Q'.$beginRowNum, $company->created)
        //     ->setCellValue('R'.$beginRowNum, $company->modifi);
        //     $beginRowNum++;
        // };
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $pathToFile = Storage::path("帳票".date('d-m-Y').".xlsx");
        $objWriter->save($pathToFile);
        
        return response()->download($pathToFile)->deleteFileAfterSend(true);
    }
}
