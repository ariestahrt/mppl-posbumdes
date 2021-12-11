<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STRUK BELANJA</title>
  <style>
    @media print 
    {
      @page
      {
        width: 76mm;
        height: auto;
      } 
    }
    h1, h2, h3, h4, h5, h6, p {
      margin: 0;
    }
  </style>
</head>
<body>
  
  <div id="invoice-POS">  
    <div id="mid">
      <div class="info" style="margin: 1rem 0; text-align: center;">
        <h4 style="margin: 0;">Badan Usaha Milik Desa</h4>
        <h3 style="margin: 0;">Bukti Sedana Artha</h3>
        <p>
          No. {{ $id_transaksi }} / {{ $tanggal }}<br />Desa Tihingan, Banjarangkan - Klungkung
        </p>
      </div>
    </div>
    <!--End Invoice Mid-->
  
    <div id="bot">
  
      <div id="table" style="font-family: monospace;">
        <table>
          <thead class="tabletitle">
            <td class="item">
              <h4>Item</h4>
            </td>
            <td class="Hours">
              <h4>Qty</h4>
            </td>
            <td class="Rate">
              <h4>Sub Total</h4>
            </td>
          </thead>
  
          @foreach($barang as $item)
          <tr class="service">
            <td class="tableitem">
              <p class="itemtext">{{ $item['nama_barang'] }}</p>
            </td>
            <td class="tableitem">
              <p class="itemtext">{{ $item['kuantitas'] }}</p>
            </td>
            <td class="tableitem" style="text-align: right;">
              <p class="itemtext">{{ $item['subtotal'] }}</p>
            </td>
          </tr>
          @endforeach
          <hr>
          <tr class="tabletitle">
            <td></td>
            <td class="Rate">
              <h4 style="margin: 0.5rem 0 0;">Total</h4>
            </td>
            <td class="payment" style="text-align: right;">
              <h4 style="margin: 0.5rem 0 0;">{{ $total }}</h4>
            </td>
          </tr>
          <tr class="tabletitle">
            <td></td>
            <td class="Rate">
              <h4 style="margin: 0;">Dibayar</h4>
            </td>
            <td class="payment" style="text-align: right;">
              <h4 style="margin: 0;">{{ $tunai }}</h4>
            </td>
          </tr>
          <tr class="tabletitle">
            <td></td>
            <td class="Rate">
              <h4 style="margin: 0;">Kembalian</h4>
            </td>
            <td class="payment" style="text-align: right;">
              <h4 style="margin: 0;">{{ $kembali }}</h4>
            </td>
          </tr>
  
        </table>
      </div>
      <!--End Table-->
  
      <div id="legalcopy" style="text-align: center;">
        <p class="legal">
          Terima kasih sudah berbelanja.
        </p>
      </div>
  
    </div>
    <!--End InvoiceBot-->
  </div>
  <!--End Invoice-->
  <script>
    function printPage() {
      print();
    }
  </script>
</body>
</html>