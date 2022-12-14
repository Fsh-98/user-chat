<?php 

namespace App\ModelFilters;
use Illuminate\Support\Facades\Auth;
use EloquentFilter\ModelFilter;
use Carbon\Carbon;

class EmailFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function emailType($type)
    {
        $user = Auth::user();
    
        switch ($type) {
            case 1:
                return $this->where('email_type', 1)->whereJsonContains('recievers', ['email' => $user['email']]);
                break;
            case 2:
                return $this->where('email_type', 2)->whereJsonContains('recievers', ['email' => $user['email']]);
                break;
            case 3:
                return $this->where('email_type', 3)->whereJsonContains('recievers', ['email' => $user['email']]);
                break;
            case 4:
                return $this->where('email_type', 4)->whereJsonContains('recievers', ['email' => $user['email']]);;
                break;
        }
    }

    public function search($search)
    {
        return $this->whereLike('subject', $search);
    }

    public function recievedAt($range)
    {
        $rangeArray = explode(' - ', $range);

        $startDate = Carbon::parse($rangeArray[0])->format('Y-m-d');

        $endDate = Carbon::parse($rangeArray[1])->format('Y-m-d');

        return $this->whereBetween('created_at', [$startDate, $endDate]);
    }
}
