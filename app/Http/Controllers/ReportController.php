<?php

namespace App\Http\Controllers;

use App\Enums\TaxableMethodType;
use App\Enums\TaxRateType;
use App\Enums\ProductSearchType;
use App\Enums\ReportType;
use App\Http\Requests\ProductRequest;
use App\Models\ConfigRegi;
use App\Models\Product;
use App\Models\Shop;
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
use Illuminate\Support\Facades\Schema;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

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

        $dataForExl = [];
        if (Schema::hasTable('note'.$user_code)) {
            $dataForExl = DB::table('note'.$user_code)->paginate(15);
        }

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
        $dataForExl = [];
        if (Schema::hasTable('note'.$user_code)) {
            $dataForExl = DB::table('note'.$user_code)->paginate(15);
        }


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

        $category_filter_type = $request->category_filter_type;
        $arr1 = $request->checked_status;
        $checked_status = [];

        if($category_filter_type == 'true'){
            $checked_status = explode(",", $arr1);
        }

        $user_code = Auth()->id();
        
        $data = [];
        if (Schema::hasTable('note'.$user_code)) {
            if($category_filter_type == 'true'){
                    $query = DB::table('note'.$user_code);
                    foreach ($checked_status as $item) {
                        $query->orWhere('category_code', $item);
                    }
                    $data = $query->paginate(15);
            
            } else {
                $data = DB::table('note'.$user_code)->paginate(15);
            }
        }
        
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $shop_id = $request->shop_id;
        $shop_name = '';
        
        if($shop_id) {
            $shop = Shop::where('id', $shop_id)->first();
            $shop_name = $shop->name;
        }

        $title = "ｸﾞﾙｰﾌﾟ別売上仕入金額表     [期間]".$from_date."〜".$to_date."     [店舗] 22:AS.AS".$shop_name;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
        $sum_sale_quantity=0; 
        $sum_sale_money = 0; 
        $sum_exit_stock_quantity = 0;
        $sum_exit_stock_money = 0;
        $sum_purchase_quantity = 0;
        $sum_purchase_money = 0;
        $sum_entry_stock_quantity = 0;
        $sum_entry_stock_money = 0;

        $beginRowNum = 3;
        foreach ($data as $item) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$beginRowNum, $item->category_code)
            ->setCellValue('B'.$beginRowNum, $item->category_name)
            ->setCellValue('C'.$beginRowNum, $item->sale_quantity)
            ->setCellValue('D'.$beginRowNum, $item->sale_money)
            ->setCellValue('E'.$beginRowNum, 0)
            ->setCellValue('F'.$beginRowNum, 0)
            ->setCellValue('G'.$beginRowNum, 0)
            ->setCellValue('H'.$beginRowNum, $item->exit_stock_quantity)
            ->setCellValue('I'.$beginRowNum, $item->exit_stock_money)
            ->setCellValue('J'.$beginRowNum, $item->purchase_quantity)
            ->setCellValue('K'.$beginRowNum, $item->purchase_money)
            ->setCellValue('L'.$beginRowNum, $item->entry_stock_quantity)
            ->setCellValue('M'.$beginRowNum, $item->entry_stock_money);
            $beginRowNum++;

            $sum_sale_quantity += $item->sale_quantity;
            $sum_sale_money += $item->sale_money;
            $sum_exit_stock_quantity += $item->exit_stock_quantity;
            $sum_exit_stock_money += $item->exit_stock_money;
            $sum_purchase_quantity += $item->purchase_quantity;
            $sum_purchase_money += $item->purchase_money;
            $sum_entry_stock_quantity += $item->entry_stock_quantity;
            $sum_entry_stock_money += $item->entry_stock_money;
        };
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$beginRowNum, '')
        ->setCellValue('B'.$beginRowNum, '総合計カゴ入')
        ->setCellValue('C'.$beginRowNum, $sum_sale_quantity)
        ->setCellValue('D'.$beginRowNum, $sum_sale_money)
        ->setCellValue('E'.$beginRowNum, 0)
        ->setCellValue('F'.$beginRowNum, 0)
        ->setCellValue('G'.$beginRowNum, '')
        ->setCellValue('H'.$beginRowNum, $sum_exit_stock_quantity)
        ->setCellValue('I'.$beginRowNum, $sum_exit_stock_money)
        ->setCellValue('J'.$beginRowNum, $sum_purchase_quantity)
        ->setCellValue('K'.$beginRowNum, $sum_purchase_money)
        ->setCellValue('L'.$beginRowNum, $sum_entry_stock_quantity)
        ->setCellValue('M'.$beginRowNum, $sum_entry_stock_money);
        
        $styleArray = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'fca5a5'],
            ],
        ];
        $objPHPExcel->getActiveSheet()->getStyle('B'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$beginRowNum)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$beginRowNum)->applyFromArray($styleArray);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $pathToFile = Storage::path("帳票".date('d-m-Y').".xlsx");
        $objWriter->save($pathToFile);
        
        return response()->download($pathToFile)->deleteFileAfterSend(true);
    }
    
    /**
     * Generate PDF file.
    */
    public function download_pdf(Request $request)
    {
        $user_code = Auth()->id();
        $data_for_exl = [];
        if (Schema::hasTable('note'.$user_code)) {
            $data_for_exl = DB::table('note'.$user_code)->paginate(15);
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $shop_id = $request->shop_id;
        $shop_name = '';
        
        if($shop_id) {
            $data = Shop::where('id', $shop_id)->first();
            $shop_name = $data->name;
        }
            
        $data = [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'shop_name' => $shop_name,
            'data_for_exl' => $data_for_exl
        ];
        $pdf = PDF::loadView('pdf.tempPDF', $data);
        return $pdf->download('tempPDF.pdf');
    }
}
