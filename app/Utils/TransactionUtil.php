<?php

namespace App\Utils;

use App\Models\Transaction;
use App\Models\User;

class TransactionUtil
{
    public const TYPE_ALL = 0x00;
    public const TYPE_PENDDING= 0x01;
    public const TYPE_RELEASE= 0x02;
    public const TYPE_RELEASED_FROM_PENDING= 0x04;
    public const TYPE_WITHDRAWN= 0x03;

    public const TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE= 0x01;
    public const TRANSACTION_MONEY_BY_REGISTRATION_OF_TWO = 0x02;
    public const TRANSACTION_MONEY_BY_TWO_LEAVE = 0x03;
    public const TRANSACTION_MONEY_BY_MOVE_NET = 0x04;
    public const TRANSACTION_MONEY_BY_MOVE_NET_CROSS = 0x05;
    public const TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE = 0x06;
    public const TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN = 0x07;
    public const TRANSACTION_MONEY_WITHDRAWN_SEND = 0x08;
    public const TRANSACTION_MONEY_WITHDRAWN_RECEIVE = 0x09;
    public const TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_WITHDRAWN= 0x0A;
    public const TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_RELEASED= 0x0B;
    public const TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN = 0x0D;
    public const TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED = 0x0E;
    public const TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED_FROM_PEDNING = 0x0F;
    public const TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_RELEASED_FROM_PENDING = 0x0C;
    public const TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_WITHDRAWN = 0x10;
    /**
     * Check if certian type of money is enough for transfering.
     * @param User $user
     * @param int $type
     * @param int $amount
     * @return boolean
     */
    public static function VERIFY_WORTH(User $user, $type, $amount):bool
    {
        $currentAmount = 0;

        switch($type) {
            case self::TYPE_RELEASED_FROM_PENDING:
                $currentAmount = $user->released_from_pending;
                break;
            case self::TYPE_RELEASE:
                $currentAmount = $user->released;
                break;
            case self::TYPE_WITHDRAWN:
                $currentAmount = $user->withdrawn;
                break;
        }

        return $currentAmount >= $amount;
    }

    public static function CRETE_TRANSACTION(User $user, $money_type, $amount, User $ref_user1 = null, User $ref_user2 = null)
    {
        $transaction1 = null;
        $transaction2 = null;

        $newMoney = false;

        switch($money_type) {
            case self::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);

                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);

                $newMoney = true;
                break;
            case self::TRANSACTION_MONEY_BY_REGISTRATION_OF_TWO:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_PENDDING, $amount, $user->pending, $money_type);

                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);


                break;
            case self::TRANSACTION_MONEY_BY_TWO_LEAVE:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_PENDDING, -$amount, $user->pending, $money_type);

                $transaction2 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, $amount, $user->released_from_pending, $money_type);

                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                self::APPLY_REF_USERS($transaction2, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_BY_MOVE_NET:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);

                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);

                $newMoney = true;
                break;
            case self::TRANSACTION_MONEY_BY_MOVE_NET_CROSS:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, $amount, $user->released_from_pending, $money_type);

                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);

                $newMoney = true;
                break;
            case self::TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, -$amount, $user->released_from_pending, $money_type);
                $transaction2 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, (int)($amount * 0.8), $user->released, $money_type);
                break;
            case self::TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, -$amount, $user->released, $money_type);
                $transaction2 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                break;
            case self::TRANSACTION_MONEY_WITHDRAWN_SEND:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, -$amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_WITHDRAWN_RECEIVE:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_WITHDRAWN:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_RELEASED:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);

                $newMoney = true;

                break;
            case self::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_RELEASED_FROM_PENDING:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, $amount, $user->released_from_pending, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;

            case self::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_WITHDRAWN:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;

            case self::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;

            case self::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;

            case self::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED_FROM_PEDNING:
                $transaction1 = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, $amount, $user->released_from_pending, $money_type);
                self::APPLY_REF_USERS($transaction1, $ref_user1, $ref_user2);
                break;
        }

        if ($newMoney) {
            self::UPDATE_MONEY_ADDED_OF_USER($user, $transaction1);
            self::UPDATE_MONEY_ADDED_OF_USER($user, $transaction2);
        }

        // self::CREATE_TRANSACTION_FOR_TOTAL($user, $transaction1);
        // self::CREATE_TRANSACTION_FOR_TOTAL($user, $transaction2);
    }

    private static function CREATE_TRASANCTION_INSTANCE(User $user, $type, $amount, $current_amount, $money_type) : Transaction
    {
        $transaction = $user->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'current_amount' => $current_amount,
            'money_type' => $money_type
        ]);

        return $transaction;
    }

    private static function CREATE_TRANSACTION_FOR_TOTAL(User $user, ?Transaction $transaction) {
        if ($transaction) {
            $transactionOfTotal = $transaction->replicate();

            $transactionOfTotal->current_amount = $user->withdrawn + $user->released + $user->released_from_pending;
            $transactionOfTotal->type = self::TYPE_ALL;

            $transactionOfTotal->save();
        }
    }

    private static function UPDATE_MONEY_ADDED_OF_USER(User $user, ?Transaction $transaction)
    {
        if ($transaction) {
            if ($transaction->amount > 0) {
                $user->increment('money_added', $transaction->amount);
            }
        }

    }

    private static function APPLY_REF_USERS(Transaction $transaction, ?User $ref1=null, ?User $ref2=null): Transaction
    {
        if($ref1) {
            $transaction->reference_user_id = $ref1->id;
            $transaction->save();
        }

        if($ref2) {
            $transaction->reference_user2_id = $ref2->id;
            $transaction->save();
        }

        return $transaction;
    }
}
