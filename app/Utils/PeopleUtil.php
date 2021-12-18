<?php

namespace App\Utils;

use App\Models\Entry;
use App\Models\User;

class PeopleUtil {

    public static function updateEntry(User $user)
    {
        // reset user's entry first
        self::deleteEntry($user->entry);

        $ownerOfUser = $user->owner;
        $ownerEntry = $ownerOfUser->entry;

        /*  ERROR :( */
        if ($ownerEntry == null) return false;

        // find top entry of target group
        /**
         *        o (super entry)
         *       / \
         *      o   o
         *     / \ / \
         *    o  o o  o
         */
        $superEntry = self::findSuperEntryOfGroup($ownerEntry);

        /**
         * Do action of adding new entry
         */
        self::insertEntryIntoBlankPositionOfGroup($superEntry, $user);

        /* Finished :) */
        return true;

    }

    // Private logic

    /**
     * Find top entry of a group
     */
    private static function findSuperEntryOfGroup(Entry $entry): Entry
    {
        $superEntry = $entry;

        // check 1 level up
        if($superEntry->super_entry) {
            $superEntry = $superEntry->super_entry;
        }

        // check 2 level up
        if($superEntry->super_entry) {
            $superEntry = $superEntry->super_entry;
        }

        return $superEntry;
    }

    /**
     * Insert new entry to blank position of target group.
     */
    private static function insertEntryIntoBlankPositionOfGroup(Entry $super_entry /* super entry */, User $user)
    {
        $attribute = [
            'stage' => $super_entry->stage
        ];

        // new entry for new user.
        $entry = $user->entry()->create($attribute);

        // real parent entry for $entry
        $parentEntry = $super_entry;

        //
        $moneyReceivableUser = $super_entry->user;

        $subEntryCount = self::getTotalSubEntryCount($super_entry);

        if ($subEntryCount < 2) {
            /**
             *        o (super entry)
             *       / \
             *      x   x
             *
             *  Just add amount of one-people to super entry's pending amount.
             */
            $moneyReceivableUser = $super_entry->user;
            $parentEntry = $super_entry;
        } else if ($subEntryCount < 4) {
            /**
             *        o (super entry)
             *       / \
             *   (0)o   o(1)
             *     / \ / \
             *    x  x x  x
             *
             *  Just add amount of one-people to super entry's pending amount.
             */
            $moneyReceivableUser = $super_entry->sub_entries[1]->user;
            $parentEntry = $super_entry->sub_entries[0];
        } else {
            /**
             *        o (super entry)
             *       / \
             *   (0)o   o(1)
             *     / \ / \
             *    o  o x  x
             */
            $moneyReceivableUser = $super_entry->sub_entries[0]->user;
            $parentEntry = $super_entry->sub_entries[1];

        }

        // add money to pending
        $moneyReceivableUser->increment('pending', ConfigUtil::AMOUNT_OF_ONE());
        $moneyReceivableUser->transactions()->create([
            'type' => TransactionUtil::TRANSACTION_TYPE_ADD_PENDING,
            'amount' => ConfigUtil::AMOUNT_OF_ONE()
        ]);

        // add new entry to group
        $parentEntry->sub_entries()->save($entry);

        // finalize
        if ( $subEntryCount + 1 == 6 ) {
            $super_entry->user->increment('released', ConfigUtil::AMOUNT_OF_ONE() * 2);
            $super_entry->user->transactions()->create([
                'type' => TransactionUtil::TRANSACTION_TYPE_RELEASE,
                'amount' => ConfigUtil::AMOUNT_OF_ONE() * 2
            ]);

            $super_entry->user->increment('pending', ConfigUtil::AMOUNT_OF_UP_STAGE());
            $super_entry->user->transactions()->create([
                'type' => TransactionUtil::TRANSACTION_TYPE_ADD_PENDING,
                'amount' => ConfigUtil::AMOUNT_OF_UP_STAGE()
            ]);

            $super_entry_user = $super_entry->user;

            if ($super_entry_user->owner == null) {
                // if user is manager
                self::upgradeEntryStageOfUser($super_entry_user);
                return true;
            } else {
                self::deleteEntry($super_entry);

                // add new entry for super_entry_user because we already deleted entry of him/her
                return self::updateEntry($super_entry_user);
            }
        }

        return true;
    }

    private static function upgradeEntryStageOfUser(User $user)
    {
        $currentEntry = $user->entry;

        self::deleteEntry($user->entry);

        $user->entry()->create([
            'stage' => $currentEntry->stage+1
        ]);
    }

    private static function deleteEntry(?Entry $entry)
    {
        if($entry == null) return;

        foreach($entry->sub_entries as $sub_entry)
        {
            $sub_entry->owner_id = null;
            $sub_entry->save();
        }

        $entry->delete();
    }

    private static function getTotalSubEntryCount(Entry $entry): int
    {
        $total = 0;

        $total += $entry->sub_entries()->count();

        foreach($entry->sub_entries as $sub_entry) {
            $total += $sub_entry->sub_entries()->count();
        }

        return $total;
    }
}
