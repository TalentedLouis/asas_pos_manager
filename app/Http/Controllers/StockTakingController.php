<?php

namespace App\Http\Controllers;

use App\Enums\StockTakingSearchType;
use App\Http\Requests\StockTakingRequest;
//use App\Models\ConfigRegi;
use App\Models\Product;
use App\Repositories\StockRepositoryInterface;
use App\Services\CategoryService;
use App\Services\StockService;
use App\Traits\BarcodeTrait;
use App\UseCases\ProductActions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use function Faker\Provider\pt_BR\check_digit;

class StockTakingController extends Controller
{
    private ProductActions $action;
    private CategoryService $categoryService;
    private StockService $stockService;

    use BarcodeTrait;

    public function __construct(
        ProductActions  $action,
        CategoryService $categoryService,
        StockService $stockService,
    )
    {
        $this->action = $action;
        $this->categoryService = $categoryService;
        $this->stockService = $stockService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = $this->categoryService->getSelect()->toArray();
        $entities = null;
        if($entities === null){
            $entities = $this->action->getKariProduct();
            $stock = $this->stockService->getKariStock();
        }else{
            $stock = $this->stockService->getThisStock($entities->id);
            if($stock === null){
                //在庫データが無いときに確定している税フラグ等を仮入力しておく為。
                $stock = $this->stockService->getKariStock();
            }
        }
        
        //$stockTakingSearchType = StockTakingSearchType::asSelectArray();
        return view('stock_taking.edit', [
            'product' => $entities,
            'stock' => $stock,
            'categories' => $categories,
            /*
            'stockTakingSearchType' => $stockTakingSearchType,
            */
        ]);
    }

    public function show(): View
    {
       $stocks = $this->stockService->getAll();
       return view('stock_taking.list', [
           'stocks' => $stocks,
       ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function select(): View
    {
        /*
        $categories = $this->categoryService->getSelect()->toArray();
        $entities = null;
        if($entities === null){
            $entities = $this->action->getKariProduct();
            $stock = $this->stockService->getKariStock();
        }else{
            $stock = $this->stockService->getThisStock($entities->id);
            if($stock === null){
                //在庫データが無いときに確定している税フラグ等を仮入力しておく為。
                $stock = $this->stockService->getKariStock();
            }
        }
        */
        //$stockTakingSearchType = StockTakingSearchType::asSelectArray();
        return view('stock_taking.index', [
            //'product' => $entities,
            //'stock' => $stock,
            //'categories' => $categories,
            /*
            'stockTakingSearchType' => $stockTakingSearchType,
            */
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('product.create', [
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
        return redirect(route('product.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(StockTakingRequest $request,string $id): View
    {

        $categories = $this->categoryService->getSelect()->toArray();
        
        $entities = $this->action->get((int)$id);
        if($entities === null){
            $entities = $this->action->getKariProduct();
            $stock = $this->stockService->getKariStock();
        }else{
            $stock = $this->stockService->getThisStock($entities->id);
            if($stock === null){
                //在庫データが無いときに確定している税フラグ等を仮入力しておく為。
                $stock = $this->stockService->getKariStock();
            }
        }
        //$stockTakingSearchType = StockTakingSearchType::asSelectArray();
        return view('stock_taking.edit', [
            'product' => $entities,
            'stock' => $stock,
            'categories' => $categories
            /*
            'stockTakingSearchType' => $stockTakingSearchType,
            */
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StockTakingRequest $request
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function update(StockTakingRequest $request, $id): RedirectResponse
    {
        $product = $this->action->get((int)$id);
        $this->action->update_stock_taking($product, $request);
        return redirect(route('stock_taking.index'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function code_search(StockTakingRequest $request): RedirectResponse
    {
        $params = $request->only(['keyword']);
        $jan_code = str_pad($params['keyword'], 12, '0', STR_PAD_LEFT);
        //  20230101 UPD S
        //$jan_code .= $this->calcCheckDigitJan13($jan_code);
        $jan_code = substr($jan_code, 0, 12).$this->calcCheckDigitJan13($jan_code);
        // 20230101 UPD E 
        
        $product = $this->action->findByCode($jan_code);
        if (!$product) {
            //return redirect()->route('product.create', ['code' => $jan_code]);
        } else {
            return redirect()->route('stock_taking.edit', ['product' => $product->id]);
        }
    }

    public function name_search_result(Request $request)
    {
        $products = [];
        if($request->keyword != '' || $request->keyword != null){
            $products = $this->action->findByName($request->keyword);
        }
        else {
            $products = $this->action->getAll();
        }
        return $products;
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

    public function stocks(Request $request) {
        $param1 = $request->id;
        $param2 = $request->stock_quantity;
        return $this->stockService->updateThisStock($param1, $param2);
    }
}
