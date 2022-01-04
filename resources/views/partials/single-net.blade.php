@php

@endphp

<table class="t_info" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <th colspan="2">{{ $user->name ?? '' }}</th>
        </tr>
        <tr>
            <td colspan="2">{{ $user->username ?? '' }}</td>
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
