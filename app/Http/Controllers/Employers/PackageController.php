<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use App\Models\EmployerPackage;
use App\Models\CompanyPackageSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ServicePackage;

class PackageController extends Controller
{
    /**
     * Danh sách các gói dịch vụ hiện có & gói đang dùng
     */
    public function index()
{
    // Lấy tất cả gói do admin tạo, chỉ những gói bật is_active = 1
    $packages = ServicePackage::where('is_active', 1)
        ->orderBy('sort_order')
        ->get();

    $company = Auth::user()->company;
    $currentSubscription = $company?->activePackage(); // vẫn giữ để hiển thị gói dùng

    return view('employer.packages.index', compact('packages', 'currentSubscription'));
}

    /**
     * Trang xác nhận mua gói
     */
    public function purchase($id)
    {
        $package = EmployerPackage::findOrFail($id);
        return view('employer.packages.purchase', compact('package'));
    }

    /**
     * Thực hiện mua gói dịch vụ (giả lập thanh toán thành công)
     */
    public function subscribe(Request $request, $packageId)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->back()->withErrors('Bạn chưa có công ty để mua gói.');
        }

        $package = EmployerPackage::findOrFail($packageId);

        // Hủy kích hoạt các gói hiện tại
        $company->packageSubscriptions()->where('is_active', true)->update(['is_active' => false]);

        // Đăng ký gói mới
        $subscription = new CompanyPackageSubscription([
            'employer_package_id' => $package->id,
            'start_date'          => Carbon::now(),
            'end_date'            => Carbon::now()->addDays($package->duration_days),
            'post_limit'          => $package->post_limit,
            'remaining_posts'     => $package->post_limit,
            'highlight_days'      => $package->highlight_days,
            'cv_view_limit'       => $package->cv_view_limit,
            'support_level'       => $package->support_level,
            'price'               => $package->price,
            'payment_status'      => 'paid', // Nếu không tích hợp thanh toán thật
            'is_active'           => true,
            'purchased_by_user_id'=> $user->id,
        ]);

        $company->packageSubscriptions()->save($subscription);

        return redirect()->route('employer.packages.index')
            ->with('success', 'Bạn đã mua gói thành công. Bây giờ bạn có thể đăng thêm tin tuyển dụng!');
    }

    /**
     * Xem chi tiết một gói (nếu muốn)
     */
    public function show($id)
    {
        $package = EmployerPackage::findOrFail($id);
        return view('employer.packages.show', compact('package'));
    }
}