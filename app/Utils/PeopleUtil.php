<?php

namespace App\Utils;

use App\Models\Entry;
use App\Models\User;

class PeopleUtil {

    public static function isAcceptable()
    {
        $user = auth()->user();

        return $user->withdrawn >= 3000;
    }

    public static function onAccept(User $user)
    {
        $currentUser = auth()->user();

        $currentUser->increment('withdrawn', ConfigUtil::AMOUNT_OF_ONE_WITHDRAWN_FOR_ROOT());
        TransactionUtil::CRETE_TRANSACTION(
            $currentUser,
            TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_WITHDRAWN,
            ConfigUtil::AMOUNT_OF_ONE_WITHDRAWN_FOR_ROOT(),
            $user
        );

        $currentUser->increment('released', ConfigUtil::AMOUNT_OF_ONE_RELEASED_FOR_ROOT());
        TransactionUtil::CRETE_TRANSACTION(
            $currentUser,
            TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_RELEASED,
            ConfigUtil::AMOUNT_OF_ONE_RELEASED_FOR_ROOT(),
            $user
        );
    }

    // 사용자의 전송요청을 수락할때 root로 료금전송.
    public static function onAcceptFundTransferRequest(User $user)
    {
        $root = User::find(1);

        $root->increment('withdrawn', ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST());
        TransactionUtil::CRETE_TRANSACTION(
            $root,
            TransactionUtil::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_WITHDRAWN,
            ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST(),
            $user
        );

        $user->decrement('released_from_pending', ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST());
        TransactionUtil::CRETE_TRANSACTION(
            $user,
            TransactionUtil::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_RELEASED_FROM_PENDING,
            -ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST(),
        );
    }

    public static function updateEntry(User $user, ?Entry $superEntryDefault = null, $newUser=true)
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

        $superEntry = $superEntryDefault;

        if ($superEntryDefault == null) {
            $superEntry = self::findSuperEntryOfGroup($ownerEntry);
        }

        /**
         * Do action of adding new entry
         */
        self::insertEntryIntoBlankPositionOfGroup($superEntry, $user, $newUser);

        /* Finished :) */
        return true;

    }

    public static function getNet(User $user)
    {
        $net = [null, null, null, null, null, null, null];

        $superEntry = self::findSuperEntryOfGroup($user->entry);
        $index = 0;

        $net[$index] = $superEntry->user;

        $index ++;

        foreach($superEntry->sub_entries as $subEntry) {
            $net[$index] = $subEntry->user;
            $index ++;
        }

        foreach($superEntry->sub_entries as $subEntry) {
            foreach($subEntry->sub_entries as $subSubEntry) {
                $net[$index] = $subSubEntry->user;
                $index ++;
            }
        }

        return $net;
    }

    public static function getBelongedMember(User $user)
    {
        $net = self::getNet($user);

        $index = 0;
        foreach($net as $i => $net_element)
        {
            if(isset($net_element) && $net_element->id == $user->id)
            {
                $index = $i;
                break;
            }
        }

        if ($index == 0) {
            if ($user->id == 1) {
                // if user is root, then return direct sub members
                return [$net[1], $net[2]];
            } else {
                return [$user->entry->ref1_user, $user->entry->ref2_user];
            }
        } else if($index == 1) {
            return [$net[5], $net[6]];
        } else if($index == 2) {
            return [$net[3], $net[4]];
        } else {
            return [];
        }
    }

    public static function getRefOwners(User $user)
    {
        $entries = Entry::where('ref1', $user->id)->orWhere('ref2', $user->id)->get();

        return $entries;
    }

    /**
     * Get sub-company
     */
    public static function getSubCompanies($desc=false)
    {
        $query = User::where('is_company', true)
            ->where('active', true);

        if ($desc) {
            $query = $query->orderBy('id', 'desc');
        }

        $subCompanies = $query->get();

        return $subCompanies;
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
    private static function insertEntryIntoBlankPositionOfGroup(Entry $super_entry /* super entry */, User $user, $newUser)
    {
        $attribute = [
            'stage' => $super_entry->stage
        ];

        // new entry for new user.
        $entry = $user->entry()->create($attribute);

        // real parent entry for $entry
        $parentEntry = $super_entry;

        //

        $subEntryCount = self::getTotalSubEntryCount($super_entry);

        if ($subEntryCount < 2) {
            /**
             *        o (super entry)
             *       / \
             *      x   x
             *
             *  Just add amount of one-people to super entry's pending amount.
             */
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
            $parentEntry = $super_entry->sub_entries[0];
        } else {
            /**
             *        o (super entry)
             *       / \
             *   (0)o   o(1)
             *     / \ / \
             *    o  o x  x
             */
            $parentEntry = $super_entry->sub_entries[1];

        }

        // if user is new registered, send money to invitee.
        // if ($newUser) {
            $user->owner->increment('released', ConfigUtil::AMOUNT_OF_ONE());
            TransactionUtil::CRETE_TRANSACTION(
                $user->owner,
                TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE,
                ConfigUtil::AMOUNT_OF_ONE(),
                $user
            );
        // }

        // add new entry to group
        $parentEntry->sub_entries()->save($entry);
        $entry->parent_user_id = $parentEntry->user->id;
        $entry->save();

        // increase subEntryCount after new entry is added.
        $subEntryCount ++;

        self::updateCrossRef($super_entry);

        // finalize
        // if net is full.
        if ( $subEntryCount == 6 ) {

            // update cross reference info of user


            // money by finish net.
            $super_entry->user->increment('released', ConfigUtil::AMOUNT_OF_UP_STAGE());
            $super_entry->user->increment('step', 1);

            TransactionUtil::CRETE_TRANSACTION(
                $super_entry->user,
                TransactionUtil::TRANSACTION_MONEY_BY_MOVE_NET,
                ConfigUtil::AMOUNT_OF_UP_STAGE(),
            );

            $super_entry_user = $super_entry->user;

            // 걸린사람에 해당한 차구매적분 증가.
            if ($super_entry->ref1_user) {
                $super_entry->ref1_user->owner->increment('released_from_pending', ConfigUtil::AMOUNT_OF_ONE());
                TransactionUtil::CRETE_TRANSACTION(
                    $super_entry->ref1_user->owner,
                    TransactionUtil::TRANSACTION_MONEY_BY_MOVE_NET_CROSS,
                    ConfigUtil::AMOUNT_OF_ONE(),
                    $super_entry->ref1_user
                );
            }

            if ($super_entry->ref2_user) {
                $super_entry->ref2_user->owner->increment('released_from_pending', ConfigUtil::AMOUNT_OF_ONE());
                TransactionUtil::CRETE_TRANSACTION(
                    $super_entry->ref2_user->owner,
                    TransactionUtil::TRANSACTION_MONEY_BY_MOVE_NET_CROSS,
                    ConfigUtil::AMOUNT_OF_ONE(),
                    $super_entry->ref2_user
                );
            }

            if ($super_entry_user->owner == null) {
                // if user is manager
                self::upgradeEntryStageOfUser($super_entry_user);
                return true;
            } else {
                self::deleteEntry($super_entry);

                // add new entry for super_entry_user because we already deleted entry of him/her
                return self::updateEntry($super_entry_user, null, false);
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

    private static function updateCrossRef(Entry $super_entry)
    {
        // 현재 사용자가 root라면 하위의 null로 보관한다.
        if ($super_entry->user->owner == null) {
            $super_entry->update([
                'ref1' => null,//$super_entry->sub_entries[0]->user->id ?? null,
                'ref2' => null //$super_entry->sub_entries[1]->user->id ?? null,
            ]);
        }

        if (isset($super_entry->sub_entries[0])) {
            $super_entry->sub_entries[0]->update([
                'ref1' => $super_entry->sub_entries[1]->sub_entries[0]->user->id ?? null,
                'ref2' => $super_entry->sub_entries[1]->sub_entries[1]->user->id ?? null
            ]);

            if (isset($super_entry->sub_entries[0]->sub_entries[0])) {
                $super_entry->sub_entries[0]->sub_entries[0]->update([
                    'ref1' => null,
                    'ref2' => null
                ]);
            }
            if (isset($super_entry->sub_entries[0]->sub_entries[1])) {
                $super_entry->sub_entries[0]->sub_entries[1]->update([
                    'ref1' => null,
                    'ref2' => null
                ]);
            }
        }

        if (isset($super_entry->sub_entries[1])) {
            $super_entry->sub_entries[1]->update([
                'ref1' => $super_entry->sub_entries[0]->sub_entries[0]->user->id ?? null,
                'ref2' => $super_entry->sub_entries[0]->sub_entries[1]->user->id ?? null
            ]);

            if (isset($super_entry->sub_entries[1]->sub_entries[0])) {
                $super_entry->sub_entries[1]->sub_entries[0]->update([
                    'ref1' => null,
                    'ref2' => null
                ]);
            }
            if (isset($super_entry->sub_entries[1]->sub_entries[1])) {
                $super_entry->sub_entries[1]->sub_entries[1]->update([
                    'ref1' => null,
                    'ref2' => null
                ]);
            }
        }
    }
}
