<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>サービス実績記録表</title>

<style>
@font-face {
    font-family: ipag;
    font-style: normal;
    font-weight: normal;
    src: url('{{ storage_path('fonts/migu-1m-regular.ttf') }}') format('truetype');
}
@font-face {
    font-family: ipag;
    font-style: bold;
    font-weight: bold;
    src: url('{{ storage_path('fonts/migu-1m-bold.ttf') }}') format('truetype');
}
@page {
    size: 21.6cm 27.95cm;
    margin: 1.55cm;
}

body {
    background: #ffffff;
    font-family: ipag !important;
}

h4 {
    margin-top:0;
    margin-bottom:0;
}

div {
    margin:0;
}
.flex {
    display: flex;
}
.item-center {
    align-items: center;
}

.w-30 {
    width: 30%;
}
.w-40 {
    width: 40%;
}
.w-50 {
    width: 50%;
}
.w-full {
    width: 100%;
}
td, th {
    border: 1px solid black
}
th {
    background-color: grey;
}
.m-auto {
    margin: auto;
}
.prefix-circle{
    width: 20px;
    height: 20px;
    background: black;
    border-radius: 50%;
    margin-right: 5px;
}
.mt-10 {
    margin-top: 10px;
}
.mb-10 {
    margin-bottom: 10px;
}
</style>
</head>

<body>
  <div>
    <div>
      <div>日報</div>
      <div>[期間]{{$from_date}}~{{$to_date}}<div>
      <div>[店舗]{{$shop_name}}<div>
    </div>
    <div><div>
  </div>
  <div class="flex item-center w-full" >
    <div style="float: left; width: 50%;">
        <div class="flex mt-10 mb-10"><span>●</span>グループ別売上</div>
        <table class="w-full">
          <thead>
            <tr>
              <th>コード</th>
              <th>グループ</th>
              <th>数量</th>
              <th>金額</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data_for_exl as $item)
              <tr>
                <td>{{$item->category_code}}</td>
                <td>{{$item->category_name}}</td>
                <td>{{$item->sale_quantity}}</td>
                <td>{{$item->sale_money}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    <div style="float:right; width: 40%;">
        <div class="flex mt-10 mb-10"><span>●</span>仕入明細</div>
        <table class="w-full">
          <thead>
            <tr>
              <th>コード</th>
              <th>仕入先</th>
              <th>金額</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
          </tbody>
        </table>
    </div>
  </div>
</body>
