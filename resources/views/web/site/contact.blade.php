<?php
use App\Http\Controllers\ConfigController;

$cc = new ConfigController();
?>

@extends('web.layouts.master')

@section('content')
<div class="commonContactDiv">
    <div class="contactLeft">
        <div class="logo"></div>

        <table>
            <tbody>
            <tr>
                <td><i class="lnr lnr-phone"></i>&nbsp;&nbsp;</td>
                <td>{{ $cc->getWebsiteContact('phone') }}</td>
            </tr>
            <tr>
                <td><i class="lnr lnr-printer"></i>&nbsp;&nbsp;</td>
                <td>{{ $cc->getWebsiteContact('fax') }}</td>
            </tr>
            <tr>
                <td><i class="lnr lnr-envelope"></i>&nbsp;&nbsp;</td>
                <td>{{ $cc->getWebsiteContact('email') }}</td>
            </tr>
            <tr>
                <td><i class="lnr lnr-home"></i>&nbsp;&nbsp;</td>
                <td>{{ $cc->getWebsiteContact('address') }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="contactRight">
        <iframe width="690" height="410" frameborder="0" style="border:0;" src="map.html"></iframe>
    </div>
</div>
@endsection
