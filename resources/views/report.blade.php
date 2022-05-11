<!doctype html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan History Lelang</title>
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.4') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

   <style>
      .page-break{
         page-break-after:always;
       }
      .text-center{
         text-align:center;
       }
      .text-header {
         font-size:1.1rem;
      }
      .size2 {
         font-size:1.4rem;
      }
      .border-bottom {
         border-bottom:1px black solid;
      }
      .border {
         border: 2px block solid;
      }
      .border-top {
         border-top:1px black solid;
      }
      .float-right {
         float:right;
      }
      .mt-4 {
         margin-top:4px;
       }
      .mx-1 {
         margin:1rem 0 1rem 0;
      }
      .mr-1 {
         margin-right:1rem;
      }
      .mt-1 {
         margin-top:1rem;
      }
      ml-2 {
         margin-left:2rem;
      }
      .ml-min-5 {
         margin-left:-5px;
      }
      .text-uppercase {
         font:uppercase;
      }
      .d1 {
         font-size:2rem;
      }
      .img {
         position:absolute;
      }
      .link {
         font-style:underline;
      }
      .text-desc {
         font-size:14px;
      }
      .text-bold {
         font-style:bold;
      }
      .underline {
         text-decoration:underline;
      }
      
      table {
         font-family: Arial, Helvetica, sans-serif;
         color: #666;
         text-shadow: 1px 1px 0px #fff;
         background: #eaebec;
         border: #ccc 1px solid;
      }
      table th {
           padding: 10px 15px;
           border-left:1px solid #e0e0e0;
           border-bottom: 1px solid #e0e0e0;
           background: #ededed;
       }  
       table tr {
           text-align: center;
            padding-left: 20px;
       }
       table td {
             padding: 10px 15px;
             border-top: 1px solid #ffffff;
             border-bottom: 1px solid #e0e0e0;
             border-left: 1px solid #e0e0e0;
             background: #fafafa;
             background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
             background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
      }
      .table-center {
         margin-left:auto;
         margin-right:auto;
      }
      .mb-1 {
         margin-bottom:1rem;
      }

      @media print {
         #printPageButton {
            display: none;
         }
      }
   </style>
   
   <!-- header -->
   <div class="text-center">
      <!-- <img src="{{ public_path('img/logo.png') }}" class="img" alt="logo.png" width="90"> -->
      <div>
         <span class="text-header text-bold text-danger" >
            HISTORY PENAWARAN LELANG <br> LELANG ONLINE <br>
               <span class="size2"></span> <br> 
               SMK TELKOM MALANG <br>
         </span>
      </div>    
      </div>
   <div>
   <!-- /header -->
   
   <hr class="border">
   
   <!-- content -->
   
   <div class="size2 text-center mb-1">
      LAPORAN HISTORY LELANG
   </div>
   
  <table class="table-center mb-1">
      <thead>
         <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor HP</th>
            <th>Penawaran Harga</th>
            <th>Nama Barang</th>
            <th>Harga Awal</th>
            <th>Harga Akhir</th>
            <th>Tanggal Lelang</th>
            <th>Status</th>
         </tr>
      </thead>
      
      <tbody>
         @foreach($historyd as $h)
         <tr>
            <td> {{ $h->nama }} </td>
            <td> {{ $h->alamat }} </td>
            <td> {{ $h->no_hp }} </td>
            <td> {{ $h->penawaran_harga }} </td>
            <td> {{ $h->nama_barang }} </td>
            <td> {{ $h->harga_awal }} </td>
            <td> {{ $h->harga_akhir }} </td>
            <td> {{ $h->tgl_lelang }} </td>
            <td> {{ $h->status_pemenang }} </td>
         </tr>
         @endforeach
      </tbody>
   </table>
<div class="size2 text-center mb-1">
   <div class="center">
      <button id="printPageButton" class="btn btn-primary" onclick="window.print()">Download</button>
   </div>
</div>
   <!-- /content -->      
   
</body>
</html>