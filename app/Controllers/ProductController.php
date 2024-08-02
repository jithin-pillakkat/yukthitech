<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Bill;
use App\Models\BillItems;
use App\Models\Product;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class ProductController extends BaseController
{
    public function index()
    {
        return view('product/index');
    }

    public function list()
    {
        if (request()->isAJAX()) {
                        
            $db = db_connect();
            $productDetails = $db->table('products p')
                                ->select('p.id, p.name, p.code, p.price, p.qty')  
                                ->orderBy('p.id', 'DESC');                                

            return DataTable::of($productDetails)
            ->addNumbering()            
            ->hide('id')
            ->toJson();
        }

    }

    public function search(){
        if($this->request->isAJAX()){

            $search = $this->request->getGet('search');
        
            $db = db_connect();
            $builder = $db->table('products');
            $builder->like('name', $search);
            $builder->orLike('code', $search);
            $query = $builder->get();
            $result = $query->getResultArray();
           
            return response()->setJSON([
                'data' => $result
            ]);
            
        }
    }

    public function generateBill(){
        if($this->request->isAJAX()){

            $validation = [
                'name' => ['rules' => 'required|min_length[3]|max_length[50]'],
                'phone' => ['rules' => 'required|exact_length[10]|is_natural']
            ];

            if(! $this->validate($validation)){
                return response()->setJSON([
                    'token' => csrf_hash(),
                    'errors' => $this->validator->getErrors()
                ]);
            }else{

                $product = new Product();

                $productId = $this->request->getPost('product_id');
                $qty = $this->request->getPost('qty');
                $billTotal = [];

                for($i=0; $i<count($productId); $i++){
                    
                    $productDetails = $product->asObject()->find($productId[$i]);                    
                    array_push($billTotal, $productDetails->price * $qty[$i]);                    
                }


                $bill = new Bill();
                $billData = [
                    'name' => $this->request->getPost('name'),
                    'phone' => $this->request->getPost('phone'),
                    'total_amount' => array_sum($billTotal)
                ];
                $billId = $bill->insert($billData);

                if($billId){

                    $billItems = [];

                    for($i=0; $i<count($productId); $i++){
                    
                        $productDetails = $product->asObject()->find($productId[$i]);
                        $item = [
                            'bill_id' => $billId,
                            'product_id' => $productId[$i],
                            'price' => $productDetails->price,
                            'qty' => $qty[$i],
                            'amount' => $productDetails->price * $qty[$i]
                        ];
    
                        array_push($billItems, $item);                                          
                    }
                    $billItem = new BillItems();
                    $billItem->insertBatch($billItems);

                    return response()->setJSON([
                        'status' => true,
                        'token' => csrf_hash(),
                        'message' => 'New bill generated successfully'
                    ]);

                }else{
                    return response()->setJSON([
                        'status' => false,
                        'token' => csrf_hash(),
                        'message' => 'Something went wrong !'
                    ]);
                }

            }

        }
    }
}
