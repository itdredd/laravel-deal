<?php

namespace App\Services\Deal;

use App\Models\Deal;
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
        $this->setMembers($data['members_id']);
        $this->setAuthor();

        return $this->deal;
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

    protected function setMembers(string $members)
    {
        $users = User::whereIn('name', [$members])->get(); // TODO check this way on invalid data

        foreach ($users as $user) { // TODO bruh?
            if (!$this->deal->members_id) {
                $this->deal->members_id = $user->id;
            } else {
                $this->deal->members_id = $this->deal->members_id.", ".$user->id;
            }
        }
    }

    protected function setAuthor() {
        $this->deal->author_id = $this->visitor->id;
    }

}