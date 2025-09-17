@props([
  'preheader' => null,     // Texto oculto en inbox preview (opcional)
  'locationName' => null,  // Ej: 'Tepepan' (opcional)
  'title',                 // Título visible
])

<!doctype html>
<html lang="es" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $attributes->get('title') ?? 'Grupo Solana' }}</title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    /* Responsive */
    @media (max-width:600px){
      .container{ width:100% !important; }
      .px{ padding-left:16px !important; padding-right:16px !important; }
      .py{ padding-top:16px !important; padding-bottom:16px !important; }
      .btn{ width:100% !important; }
    }
    a[x-apple-data-detectors]{ color:inherit !important; text-decoration:none !important; }
  </style>
</head>
<body style="margin:0; padding:0; background:#0B1220; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
  {{-- Preheader oculto --}}
  @if($preheader)
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#0B1220;">
      {{ $preheader }}
    </div>
  @endif

  <!-- Wrapper -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0B1220;">
    <tr>
      <td align="center" style="padding:24px;">
        <img src="https://gruposolana.com/solana/public/images/solana-w.png" width="200px" style="margin: auto; margin-bottom:10px;width:200px" />
        <!-- Contenedor -->
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" class="container" style="width:640px; max-width:640px; background:#FFFFFF; border-radius:12px; overflow:hidden; border:1px solid #E6EEF5;">
          <!-- Barra superior (brand) -->
          <tr>
            <td style="height:6px; background:#1078B0; line-height:6px; font-size:0;">&nbsp;</td>
          </tr>

          <!-- Header -->
          <tr>
            <td class="px py" style="padding:24px; border-bottom:1px solid #E6EEF5;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:700; color:#0E1726;">
                    {{ $title }}
                  </td>
                  <td align="right" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5B6B7C;">
                    {{ now()->format('d/m/Y') }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Contenido -->
          <tr>
            <td class="px py" style="padding:24px;">
              <article style="font-family:Arial, Helvetica, sans-serif; color:#0E1726; font-size:14px; line-height:22px;">
                {!! $slot !!}
              </article>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td class="px py" style="padding:16px 24px 20px 24px; border-top:1px solid #E6EEF5;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#5B6B7C;">
                    <strong style="color:#0E1726;">Grupo Solana</strong>
                    &nbsp;|&nbsp; Enviado desde {{ $locationName }}.
                    <br>
                    Por favor no respondas a este correo. Solo es informativo, si necesitas ayuda contacta con soporte.
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Barra inferior (brand) -->
          <tr>
            <td style="height:6px; background:#0E6A9E; line-height:6px; font-size:0;">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
