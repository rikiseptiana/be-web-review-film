<!doctype html>
<html>
  <head>
    <meta http-equiv=3D"Content-Type" content=3D"text/html; charset=3DUTF-8">
  </head>
  <body style=3D"font-family: sans-serif;">
    <div style=3D"display: block; margin: auto; max-width: 600px;" class=3D"main">
      <h1 style=3D"font-size: 18px; font-weight: bold; margin-top: 20px">Register Berhasil!</h1>
      <p>Selamat datang, {{ $name }} !</p>
      <p>Silahkan masukan OTP Code dibawah, Batas kadaluarsa 5 menit.</p>
      <p style="font-bold; background-color:yellow; text-align:center; font-size:30px;">{{ $otp }}</p>
      <p>Good luck! Hope it works.</p>
    </div>
    <!-- Example of invalid for email html/css, will be detected by Mailtrap: -->
    <style>
      .main { background-color: white; }
      a:hover { border-left-width: 1em; min-height: 2em; }
    </style>
  </body>
</html>