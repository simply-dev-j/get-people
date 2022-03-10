<?php

namespace App\Utils;

use Carbon\Carbon;

class SecurityUtil {
    public const SECURITY_CASE_USER_ACTIVATION = 'security_case_user_activation';
    public const SECURITY_CASE_FUND_TRANSFER = 'security_case_fund_transfer';
    public const SECURITY_CASE_FUND_COMPANY_EDIT = 'security_case_fund_company_edit';
    public const SECURITY_CASE_FUND_COMPANY_ADJUST = 'security_case_fund_company_adjust';
    public const SECURITY_CASE_FUND_COMPANY_TRANSFER = 'security_case_fund_company_transfer';
    public const SECURITY_CASE_COMPANY_PROMOTION = 'security_case_company_promotion';

    public static function IS_AVAILABLE($case)
    {
        $security_record = auth()->user()->security_case($case);

        if ($security_record->block_until_time == null) {
            return true;
        }

        if (Carbon::now()->gt($security_record->block_until_time)) {
            return true;
        }

        return false;
    }

    public static function SECURITY_CHALLENGE($case, $inputedSecurityCode):bool
    {
        $user = auth()->user();

        if (!self::IS_AVAILABLE($case)) {
            return false;
        }

        if ($user->security_code == $inputedSecurityCode) {
            // 안전코드가 정확하다면 재설정.
            $user->update([
                'security_case' => null,
                'security_attempt_count' => 0
            ]);
            return true;
        } else {
            // 안전코드가 정확하지 않다면.
            if ($user->security_case == $case) {
                // 이미 시도했던 페지라면.
                $user->increment('security_attempt_count', 1);
            } else {
                // 새로운 페지라면.
                $user->update([
                    'security_case' => $case,
                    'security_attempt_count' => 1
                ]);
            }

            if ($user->security_attempt_count == 3) {
                // 3번 시도했다면 사용자기능 12시간동안 블록.

                $user->security_case($case)->update([
                    'block_until_time' => Carbon::now()->addHours(12)
                ]);
            }

            return false;
        }
    }
}
