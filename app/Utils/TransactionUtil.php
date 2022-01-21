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
    // public const TRANSACTION_MONEY_BY_WITHDRAWN = 0x05;
    public const TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE = 0x06;
    public const TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN = 0x07;
    public const TRANSACTION_MONEY_WITHDRAWN_SEND = 0x08;
    public const TRANSACTION_MONEY_WITHDRAWN_RECEIVE = 0x09;

    public static function CRETE_TRANSACTION(User $user, $money_type, $amount, User $ref_user1 = null, User $ref_user2 = null)
    {

        switch($money_type) {
            case self::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE:
                $transaction = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);

                self::APPLY_REF_USERS($transaction, $ref_user1, $ref_user2);
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
                $transaction = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, $amount, $user->released, $money_type);

                self::APPLY_REF_USERS($transaction, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_BY_MOVE_NET:
                $transaction = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, $amount, $user->released_from_pending, $money_type);

                self::APPLY_REF_USERS($transaction, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE:
                self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASED_FROM_PENDING, -$amount, $user->released_from_pending, $money_type);
                self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, number_format($amount * 0.8, 2), $user->released, $money_type);
                break;
            case self::TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN:
                self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_RELEASE, -$amount, $user->released, $money_type);
                self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                break;
            case self::TRANSACTION_MONEY_WITHDRAWN_SEND:
                $transaction = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, -$amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction, $ref_user1, $ref_user2);
                break;
            case self::TRANSACTION_MONEY_WITHDRAWN_RECEIVE:
                $transaction = self::CREATE_TRASANCTION_INSTANCE($user, self::TYPE_WITHDRAWN, $amount, $user->withdrawn, $money_type);
                self::APPLY_REF_USERS($transaction, $ref_user1, $ref_user2);
                break;
        }
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

    private static function APPLY_REF_USERS(Transaction $transaction, ?User $ref1=null, ?User $ref2=null)
    {
        if($ref1) {
            $transaction->reference_user_id = $ref1->id;
            $transaction->save();
        }

        if($ref2) {
            $transaction->reference_user2_id = $ref2->id;
            $transaction->save();
        }
    }
}
