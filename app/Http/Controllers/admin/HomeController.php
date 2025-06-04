<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index(){
        $recode = [];
        $totalOrders = Order::where('status','!=','cancelled')->count();
        $totalProduct = Product::count();
        $totalUser = User::count();
        $totalRevenue = Order::where('status','!=','cancelled')->sum('grand_total');

     //this months revenue//

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $RevenueThisMonth = Order::where('status','!=','cancelled')
                            ->whereDate('created_at','>=',$startOfMonth)
                            ->whereDate('created_at','<=',$currentDate)
                            ->sum('grand_total');

     //Last month revenue//

        $startMonthOfDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthOfDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonth = Carbon::now()->subMonth()->endOfMonth()->format('M');
        $lastMonthRevenue = Order::where('status','!=','cancelled')
                            ->whereDate('created_at','>=',$startMonthOfDate)
                            ->whereDate('created_at','<=',$lastMonthOfDate)
                            ->sum('grand_total');

     //Last 30 days sale//

         $lastThirtyDays = Carbon::now()->subDays(30)->format('Y-m-d');
         $lastThirtyDaysRevenue = Order::where('status','!=','cancelled')
         ->whereDate('created_at','>=',$lastThirtyDays)
         ->whereDate('created_at','<=',$currentDate)
         ->sum('grand_total');

     //Delete temp image//

         $dayBeforToday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
         $tempImages = TempImage::where('created_at','<=',$dayBeforToday )->get();
         foreach($tempImages as $tempImage)
         {
          $path = public_path('/temp/'.$tempImage->name);
          $thumbPath = public_path('/temp/thumb/'.$tempImage->name);
          if(File::exists($path)){
            File::delete($path);
          }
          if(File::exists($thumbPath)){
            File::delete($thumbPath);
          }
          TempImage::where('id','<=',$tempImage->id )->delete();
         }

        $recode['totalOrders'] = $totalOrders;
        $recode['totalProduct'] = $totalProduct;
        $recode['totalUser'] = $totalUser;
        $recode['totalRevenue'] = $totalRevenue;
        $recode['RevenueThisMonth'] = $RevenueThisMonth;
        $recode['lastMonthRevenue'] = $lastMonthRevenue;
        $recode['lastThirtyDaysRevenue'] = $lastThirtyDaysRevenue;
        $recode['lastMonth'] = $lastMonth;
        return view('admin.dashboard',$recode);
    }


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
