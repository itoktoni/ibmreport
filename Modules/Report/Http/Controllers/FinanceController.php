<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Report\Dao\Enums\PaymentType;
use Modules\Report\Dao\Repositories\CustomerRepository;
use Modules\Report\Dao\Repositories\ProductionRepository;
use Modules\Report\Dao\Repositories\ProductRepository;
use Modules\Report\Dao\Repositories\ReportPiutang;
use Modules\Report\Dao\Repositories\ReportUtang;
use Modules\Report\Dao\Repositories\ReportUtangPenjahit;
use Modules\Report\Dao\Repositories\ReportUtangSupplier;
use Modules\Report\Dao\Repositories\SupplierRepository;
use Modules\Report\Dao\Repositories\TeamRepository as RepositoriesTeamRepository;
use Modules\System\Dao\Repositories\TeamRepository;
use Modules\System\Http\Services\ReportService;
use Modules\System\Plugins\Views;

class FinanceController extends Controller
{
    public static $template;
    public static $service;
    public static $model;
    public static $history;
    public static $summary;

    private function share($data = [])
    {
        $user = Views::option(new TeamRepository());
        $product = Views::option(new ProductRepository());
        $supplier = Views::option(new SupplierRepository());
        $production = Views::option(new ProductionRepository());
        $customer = Views::option(new CustomerRepository());
        $type = PaymentType::getOptions();

        $view = [
            'customer' => $customer,
            'production' => $production,
            'supplier' => $supplier,
            'product' => $product,
            'type' => $type,
            'user' => $user,
        ];

        return array_merge($view, $data);
    }

    public function utangPenjahit(ReportUtangPenjahit $repository)
    {
        $preview = false;
        if ($name = request()->get('name')) {
            $preview = $repository->generate($name)->data();
        }

        $status = [
            '' => '- Pilih Status -',
            'OPEN' => 'OPEN',
            'APPROVED' => 'APPROVED',
            'PREPARED' => 'PREPARED',
            'PRODUCTION' => 'PRODUCTION',
            'DELIVERED' => 'DELIVERED',
        ];

        return view(Views::form(__FUNCTION__, config('page'), config('folder')))
            ->with($this->share([
                'model' => $repository,
                'preview' => $preview,
                'status' => $status,
            ]));
    }

    public function utangPenjahitExport(ReportService $service, ReportUtangPenjahit $repository)
    {
        return $service->generate($repository, 'export_utang_penjahit');
    }

    public function utangSupplier(ReportUtangSupplier $repository)
    {
        $preview = false;
        if ($name = request()->get('name')) {
            $preview = $repository->generate($name)->data();
        }

        $status = [
            '' => '- Pilih Status -',
            'OPEN' => 'OPEN',
            'APPROVED' => 'APPROVED',
            'DELIVERED' => 'DELIVERED',
        ];
        return view(Views::form(__FUNCTION__, config('page'), config('folder')))
            ->with($this->share([
                'model' => $repository,
                'preview' => $preview,
                'status' => $status,
            ]));
    }

    public function utangSupplierExport(ReportService $service, ReportUtangSupplier $repository)
    {
        return $service->generate($repository, 'export_utang_supplier');
    }

    public function piutang(ReportPiutang $repository)
    {
        $preview = false;
        if ($name = request()->get('name')) {
            $preview = $repository->generate($name)->data();
        }

        $user = Views::option(new RepositoriesTeamRepository(),false, true);
        $sales = $user->where('group_user', 'sales')->pluck('name', 'email')->prepend('- Select Sales -', '');
        $status = [
            '' => '- Pilih Status -',
            'CONFIRM' => 'CONFIRM',
            'APPROVED' => 'APPROVED',
            'PREPARED' => 'PREPARED',
            'COMPLETE' => 'COMPLETE',
        ];

        return view(Views::form(__FUNCTION__, config('page'), config('folder')))
            ->with($this->share([
                'model' => $repository,
                'sales' => $sales,
                'preview' => $preview,
                'status' => $status,
            ]));
    }

    public function piutangExport(ReportService $service, ReportPiutang $repository)
    {
        return $service->generate($repository, 'export_piutang');
    }
}