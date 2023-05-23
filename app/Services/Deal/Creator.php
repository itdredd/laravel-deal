<?php

namespace App\Services\Deal;

use App\Models\Deal;
use App\Models\DealMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Creator
{
    protected Deal $deal;
    protected User $visitor;

    public function __construct()
    {
        $this->deal = new Deal();
        $this->visitor = Auth::user();
    }

    public function create(array $data)
    {
        $this->setupData($data['title'], $data['description']);
        $this->setPrice($data['currency'], $data['value']);
        $this->setGuarantor($data['guarantor_id']);
        $this->setAuthor();

        $this->deal->save();
        return $this->deal;
    }

    protected function setGuarantor($id)
    {
        $user = User::find($id);

        if ($user) {
            $this->deal->guarantor_id = $user->id;
        }
    }

    protected function setupData(string $title, string $description)
    {
        $this->deal->title = $title;
        $this->deal->description = $description;
        $this->deal->status = 'awaiting';
    }

    protected function setPrice(string $currency, int $value)
    {
        $this->deal->currency = $currency;
        $this->deal->value = $value;
    }

    public function setMembers($members)
    {
        $users = User::whereIn('name', $members)->get();

        DealMember::create([
                'user_id' => $this->visitor->id,
                'deal_id' => $this->deal->id
        ]);

        foreach ($users as $user) {
            DealMember::create([
                    'user_id' => $user->id,
                    'deal_id' => $this->deal->id
            ]);
        }

        if ($this->deal->guarantor) {
            DealMember::create([
                    'user_id' => $this->deal->guarantor_id,
                    'deal_id' => $this->deal->id
            ]);
        }
    }

    protected function setAuthor() {
        $this->deal->author_id = $this->visitor->id;
    }

}
