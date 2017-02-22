<?php

namespace Wealthon\System\Models;

use Db;
use Model;
use RainLab\User\Models\User as BaseUser;
use Wealthon\System\Components\App;
use Wealthon\System\Models\Settings as AppSettings;
use Wealthon\System\Models\Generation;
use Wealthon\System\Models\CommissionPlan;
use Wealthon\System\Models\Commission;
use Wealthon\System\Models\CommissionType;

/**
 * Member Model
 */
class Member extends BaseUser {
    #use \October\Rain\Database\Traits\SoftDeleting;

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'users';

    /**
     * Validation rules
     */
    public $rules = [
        'email' => 'required|between:6,255|email|unique:users',
        'password' => 'required:create|between:4,255|confirmed',
        'password_confirmation' => 'required_with:password|between:4,255'
    ];
    public $hasOne = [
        'bank_account' => ['Wealthon\System\Models\BankAccount', 'key' => 'user_id']
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'groups' => ['RainLab\User\Models\UserGroup', 'table' => 'users_groups']
    ];
    public $attachOne = [
        'avatar' => ['System\Models\File']
    ];
    public $hasMany = ['invites' => ['Wealthon\System\Models\Invite', 'key' => 'user_id']];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'surname',
        'login',
        'username',
        'email',
        'password',
        'password_confirmation',
        'package_id',
        'referral_id',
        'parent_id',
        'generation_id',
        'slot_id'
    ];

    /**
     * Purge attributes from data set.
     */
    protected $purgeable = ['password_confirmation', 'send_invite'];
    protected $dates = [
        'last_seen',
        'deleted_at',
        'created_at',
        'updated_at',
        'activated_at',
        'last_login'
    ];
    protected $ancestors = [];
    protected $descendats = [];
    protected $children = [];
    protected $trackId;
    protected $hasChildren;

    public static function getChildrenIds($ids) {
        /*
          $descendants = Member::where('parent_id',$this->id)->orderBy('slot_id','asc')->get();
          if($descendants){
          $this->hasChildren = true;
          return $descendants;

          }
          $this->hasChildren = false;
          return [];
         * 
         */

        return Db::table('users')->whereIn('parent_id', $ids)->lists('id');
    }

    public static function getChildren($ids) {
        /*
          $descendants = Member::where('parent_id',$this->id)->orderBy('slot_id','asc')->get();
          if($descendants){
          $this->hasChildren = true;
          return $descendants;

          }
          $this->hasChildren = false;
          return [];
         * 
         */
        return Member::whereIn('parent_id', $ids)->orderBy('slot_id', 'asc')->get();
        #return Member::where('parent_id', $id)->orderBy('slot_id', 'asc')->get();
    }

    public function getDescendants() {
        $generations = Generation::orderBy('generation', 'asc')->get();
        $ids = [$this->id];
        $descendants = [];
        $result = [];
        /*
         * iterate every ganaration
         */

        foreach ($generations as $generation) {
            if ($ids) {
                $children = Member::getChildren($ids);
                if ($children) {
                    $descendants[$generation->generation] = $children;
                    foreach ($children as $child) {
                        $ids = [];
                        $ids[] = $child->id;
                    }
                } else {
                    # no more children so return;
                    break;
                }
            } else {
                break;
            }
        }
        /*
          $generations->each(function($generation) use (&$generations) {
          #$packagesOptions[$package->id] = $package->name;
          # find the parent of this member
          #$id = $this->parent_id;
          $descendants = Member::where('parent_id', $this->trackId)->orderBy('slot_id', 'asc')->get();
          if ($descendants) {
          $this->trackId = $parent->parent_id;
          $this->ancestors[$generation->generation] = $parent;
          }
          });
         * 
         */
        /*
          foreach ($descendants as $key=>$de){
          if(count($de)>0){
          $result[$key]=$de;
          }
          }
          return $result;
         * 
         */
        return $descendants;
    }

    public function getAncestors() {
        #$cnt = AppSettings::get('max_generations');
        $generations = Generation::orderBy('generation', 'asc')->get();
        $this->trackId = $this->parent_id;
        /*
         * iterate every ganaration
         */
        $generations->each(function($generation) use (&$generations) {
            #$packagesOptions[$package->id] = $package->name;
            # find the parent of this member
            #$id = $this->parent_id;
            $parent = BaseUser::find($this->trackId);
            if ($parent) {
                $this->trackId = $parent->parent_id;
                # the system user is never included
                #if ($parent->is_root == 0) {
                $this->ancestors[$generation->generation] = $parent;
                #}
            }
        });
        return $this->ancestors;
    }

    public static function getMemberIdOptions() {
        $users = BaseUser::all(['id', 'email', 'name', 'surname']);
        $usersOptions = [];

        $users->each(function($user) use (&$usersOptions) {
            $usersOptions[$user->id] = "{$user->email} - {$user->name} {$user->surname}";
        });
        return $usersOptions;
    }

    public static function updateValues($uid, $values) {
        Db::table('users')
                ->where('id', $uid)
                ->update($values);
    }

    public static function findParentByReferral($id) {
        $slot_factor = AppSettings::get('slot_factor');
        $result = [];
        # if referral has space slot me in else find his descandants and slot me somwehere
        $referral_children_ids = Member::getChildrenIds([$id]);
        $cnt_ids = count($referral_children_ids);
        if ($cnt_ids < $slot_factor) {
            # slot me under my referral
            $result['generation_id'] = 1;
            $result['slot_id'] = $cnt_ids + 1;
            $result['parent_id'] = $id;
            return $result;
        }
        # find descendants and slot me in some where
        $referral = Member::find($id);
        $descendants = $referral->getDescendants();
        #return $descendants;
        #dd($descendants);
        $member_cnt = 0;
        $max_members = 0;
        foreach ($descendants as $generation => $members) {
            $member_cnt = count($members);
            #dd("Generation $generation: $member_cnt");
            $max_members = pow($slot_factor, $generation);
            #dd($max_members);
            if ($member_cnt < $max_members) {
                # we have room to add to this generation
                # find a free parent 
                $result['generation_id'] = $generation;
                $result['slot_id'] = $member_cnt + 1;
                #$result['parent_id'] = $id;
                #dd($result);
                #dd($members);
                # we need to find a suitable parent from the last generation
                $pos = ($generation > 1) ? $generation - 1 : 1;
                $last_parents = $descendants[$pos];
                #dd($last_parents);
                foreach ($last_parents as $member) {
                    $ids = Member::getChildrenIds([$member->id]);
                    #dd($ids);
                    if (count($ids) < $slot_factor) {
                        # found a free parent who has lest than $Slot_factor children
                        $result['parent_id'] = $member->id;
                    }
                }
                if (array_key_exists('parent_id', $result) && array_key_exists('slot_id', $result) && array_key_exists('generation_id', $result)) {
                    # we have all we need so lets quit the loop
                    #dd($result);
                    return $result;
                }
            }
        }

        #dd($result);
    }
    # set commisiin based on payment made
    public function setCommissions($registration_fee) {
        /*
         * pay all members commission
         * . get all ancestors
         */
        $type = CommissionType::where('code', 'REG')->first();
        $package = $this->package;
        $parents = $this->getAncestors();
        #dd($package);
        $swap = null;
        # if parent is not the referral
        if ($this->parent_id != $this->referral_id) {
            # we have to swap;
            # referreal get the reward of the parent
            $originalParent = $parents[1];
            #$parentKey = 1;
            $referralKey = 0;
            $referralObj = null;
            #$parentObj = null;
            foreach ($parents as $generation => $parent) {
                /*
                  if ($parent->id == $this->parent_id) {
                  $parentKey = $generation;
                  $parentObj = $parent;
                  }
                 * 
                 */
                if ($parent->id == $this->referral_id) {
                    $referralKey = $generation;
                    $referralObj = $parent;
                }
            }
            # swap
            $parents[$referralKey] = $originalParent;
            $parents[1] = $referralObj;
        }

        foreach ($parents as $generation => $parent) {
            # find the plan

            if ($parent->package_id) {
                $parent_package = $parent->package;
                $plan = CommissionPlan::where('parent_package_id', $parent_package->id)
                                ->where('user_package_id', $package->id)
                                ->where('parent_generation_id', $generation)->first();
                $commission_amt = (($plan->pct / 100) * $registration_fee);
                #dd($commission);
                $commission = new Commission;
                $commission->owner_id = $parent->id;
                $commission->user_id = $this->id;
                $commission->notes = 'Commission earned on member registration';
                $commission->plan_id = $plan->id;
                $commission->amount = $commission_amt;
                $commission->type_id = $type->id;
                $commission->save();
            }
        }
    }

    public static function randomPassword($length = 10) {
        $alphabets = range('A', 'Z');
        $numbers = range('0', '9');
        $additional_characters = array('_', '.');
        $final_array = array_merge($alphabets, $numbers, $additional_characters);

        $password = '';

        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }
    
    public function incentive($status){
        return Commission::where('owner_id',$this->id)->where('status',strtolower($status))->sum('amount');
    }

}
