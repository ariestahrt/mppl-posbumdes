<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TEST</title>
</head>
<body>
  <iframe style="display: none;" id="printf" src="http://127.0.0.1:8000/devs/invoice/3"></iframe>
  <button type="button" id="print_btn">PRINT</button>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript">

    setTimeout(() => {
      var iframe = document.getElementById('printf');
      iframe.src = 'http://127.0.0.1:8000/devs/invoice/1';
    }, 3000)
    $(document).ready(() => {
      let printInvoice = () => {
        document.getElementById("printf").contentWindow.print();
      }

      $('#print_btn').on('click', () => {
        printInvoice();
      })
    });
  </script>

</body>

</html>