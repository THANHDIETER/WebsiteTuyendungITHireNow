<?php
namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use App\Models\EmployerPackage;
use App\Models\CompanyPackageSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function index()
    {
        $packages = EmployerPackage::where('is_active', 1)->orderBy('sort_order')->get();
        $currentSubscription = Auth::user()->company?->activePackage();

        return view('employer.packages.index', compact('packages', 'currentSubscription'));
    }

    public function subscribe(Request $request, $packageId)
    {
        $user = Auth::user();
        $company = $user->company;

        if (! $company) {
            return redirect()->back()->withErrors('Bạn chưa có công ty để mua gói.');
        }

        $package = EmployerPackage::findOrFail($packageId);

        // Hủy kích hoạt gói cũ nếu có
        $company->packageSubscriptions()->where('is_active', true)->update(['is_active' => false]);

        $subscription = new CompanyPackageSubscription([
            'employer_package_id' => $package->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($package->duration_days),
            'post_limit' => $package->post_limit,
            'remaining_posts' => $package->post_limit,
            'highlight_days' => $package->highlight_days,
            'cv_view_limit' => $package->cv_view_limit,
            'support_level' => $package->support_level,
            'price' => $package->price,
            'payment_status' => 'paid', // Nếu không tích hợp cổng thanh toán
            'is_active' => true,
            'purchased_by_user_id' => $user->id,
        ]);

        $company->packageSubscriptions()->save($subscription);

        return redirect()->route('employer.dashboard')->with('success', 'Bạn đã mua gói thành công.');
    }
}

