@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>网体排列</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td colspan="4" align="center">
                            @include('partials.single-net', ['user' => $net[0]])
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center"><img src="/img/line_1.gif" width="50%" height="23"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            @include('partials.single-net', ['user' => $net[1]])
                        </td>
                        <td colspan="2" align="center">
                            @include('partials.single-net', ['user' => $net[2]])
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><img src="/img/line_2.gif" width="50%" height="23"></td>
                        <td colspan="2" align="center"><img src="/img/line_2.gif" width="50%" height="23"></td>
                    </tr>
                    <tr>
                        <td width="25%" align="center">
                            @include('partials.single-net', ['user' => $net[3]])
                        </td>
                        <td width="25%" align="center">
                            @include('partials.single-net', ['user' => $net[4]])
                        </td>
                        <td width="25%" align="center">
                            @include('partials.single-net', ['user' => $net[5]])
                        </td>
                        <td width="25%" align="center">
                            @include('partials.single-net', ['user' => $net[6]])
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
