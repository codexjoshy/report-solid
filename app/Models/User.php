<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enrolled_date' => 'date',
    ];


    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'user_category', 'user_id', 'category_id');
    }

    // /**
    //  * Get the category that owns the User
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(UserCategory::class, 'user_id', 'other_key');
    // }

    /**
     * Get the referrer that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    public function isCustomer():bool
    {
        $userCategories =  $this->category;
        foreach ($userCategories as $category) {
            if(in_array($category->id, [(UserCategoryEnum::CUSTOMER)->value])) return true;
        }
        return false;
    }

    public function isDistributor():bool
    {
        $userCategories =  $this->category;
        foreach ($userCategories as $category) {
            if(in_array($category->id, [(UserCategoryEnum::DISTRIBUTOR)->value])) return true;
        }
        return false;
    }
}
