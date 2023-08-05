<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
        CRUD::denyAccess('create');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('order_id');
        CRUD::column('invoice_number');
        CRUD::column('total_amount');
        CRUD::column('order_date');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',
            // 'escaped' => true,
            'value' => function($entry) {
                if($entry->status == 1) {
                    $status = '<span class="badge bg-primary">Menunggu Pembayaran</span>';
                }else if($entry->status == 2) {
                    $status = '<span class="badge bg-success">Berhasil</span>';
                }
                return $status;
            }
        ]);
        CRUD::addColumn([
            'name' => 'shipping_status',
            'label' => 'Status',
            'type' => 'custom_html',
            // 'escaped' => true,
            'value' => function($entry) {
                if($entry->shipping_status == 1) {
                    $status = '<span class="badge bg-secondary">Dikemas</span>';
                }else if($entry->shipping_status == 2) {
                    $status = '<span class="badge bg-primary">Dikirim</span>';
                }else if($entry->shipping_status == 3) {
                    $status = '<span class="badge bg-success">Diterima</span>';
                }else if($entry->shipping_status == 4) {
                    $status = '<span class="badge bg-danger">Bermasalah</span>';
                }else if($entry->shipping_status == 5) {
                    $status = '<span class="badge bg-danger">Dikembalikan</span>';
                }
                return $status;
            }
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderRequest::class);

        CRUD::field('user_id');
        CRUD::field('order_date');
        CRUD::field('total_amount');
        CRUD::field('shipping_address');
        CRUD::addField([
            'name'            => 'status',
            'label'           => "Status",
            'type'            => 'select_from_array',
            'options'         => ['1' => 'Menunggu Pembayaran', '2' => 'Berhasil', '3' => 'Batal'],
        ]);
        CRUD::addField([
            'name'            => 'shipping_status',
            'label'           => "Shipping Status",
            'type'            => 'select_from_array',
            'options'         => ['1' => 'Dikemas', '2' => 'Dikirim', '3' => 'Diterima', '4' => 'Bermasalah', '5' => 'Dikembalikan'],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('invoice_number');
        CRUD::column('order_date');
        CRUD::column('total_amount');
        CRUD::column('shipping_address');
        CRUD::column('country');
        CRUD::column('province');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',
            // 'escaped' => true,
            'value' => function($entry) {
                if($entry->status == 1) {
                    $status = '<span class="badge bg-primary">Menunggu Pembayaran</span>';
                }else if($entry->status == 2) {
                    $status = '<span class="badge bg-success">Berhasil</span>';
                }
                return $status;
            }
        ]);
        CRUD::addColumn([
            'name' => 'shipping_status',
            'label' => 'Status',
            'type' => 'custom_html',
            // 'escaped' => true,
            'value' => function($entry) {
                if($entry->shipping_status == 1) {
                    $status = '<span class="badge bg-secondary">Dikemas</span>';
                }else if($entry->shipping_status == 2) {
                    $status = '<span class="badge bg-primary">Dikirim</span>';
                }else if($entry->shipping_status == 3) {
                    $status = '<span class="badge bg-success">Diterima</span>';
                }else if($entry->shipping_status == 4) {
                    $status = '<span class="badge bg-danger">Bermasalah</span>';
                }else if($entry->shipping_status == 5) {
                    $status = '<span class="badge bg-danger">Dikembalikan</span>';
                }
                return $status;
            }
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }
}
