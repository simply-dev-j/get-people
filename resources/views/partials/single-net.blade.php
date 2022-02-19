@php
    $members = [];
    if ($user) {
        $members = App\Utils\PeopleUtil::getBelongedMember($user);
    }
@endphp

<table class="t_info" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <th colspan="2">
                @if ($user)
                    {{ $user->name ?? '' }} ({{ $user->username ?? '' }})
                @endif
            </th>
        </tr>
        <tr>
            <td style="width: 150px">
                @if (isset($members[0]))
                    {{ $members[0]->username }} ({{ $members[0]->name }})
                    {{ App\Utils\ConfigUtil::AMOUNT_OF_ONE() }}
                @endif
            </td>
            <td style="width: 150px">
                @if (isset($members[1]))
                    {{ $members[1]->username }} ({{ $members[1]->name }})
                    {{ App\Utils\ConfigUtil::AMOUNT_OF_ONE() }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">
                推荐：{{ $user->owner->name ?? '' }}({{ $user->owner->username ?? '' }})
            </td>
        </tr>
        <tr>
            <td colspan="2">
                {{ $user->created_at ?? '' }}
            </td>
        </tr>
    </tbody>
</table>
