<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class BillController extends BaseController
{
    public function index()
    {
        return view('bill/index');
    }

    public function list()
    {
        if (request()->isAJAX()) {

            $db = db_connect();
            $billDetails = $db->table('bills b')
                ->select('b.id, b.name, b.phone, b.total_amount, b.created_at')
                ->orderBy('b.id', 'DESC');
            return DataTable::of($billDetails)
                ->addNumbering()
                ->format('created_at', function ($value, $meta) {
                    return date('d-M-Y h:i A', strtotime($value));
                })
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-light btn-sm me-1 view-bill" title="Details" data-id="' . $row->id . '"><i class="bi bi-eye"></i></button>';
                }, 'last')
                ->toJson();
        }
    }

    public function view()
    {
        if ($this->request->isAJAX()) {

            $billId = $this->request->getGet('id');

            $db = db_connect();
            $builder = $db->table('bill_items b')
                ->select('p.name, b.price, b.qty, b.amount')
                ->join('products p', 'p.id = b.product_id')
                ->where('b.bill_id', $billId);
            $query = $builder->get();
            $billDetails = $query->getResult();

            return response()->setJSON([
                'status' => true,
                'data' => $billDetails
            ]);
        }
    }
}
