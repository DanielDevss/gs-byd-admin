<x-mails.templete :title="$title" :preheader="$preheader" :locationName="$locationName">
    <p style="margin:0 0 16px; font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#334155;">
        Un usuario ha dejado sus datos de contacto. Prefiere ser atendido por 
        <strong>{{ $contactPreference->value }}</strong>.
    </p>

    <table cellpadding="8" cellspacing="0" border="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; border-collapse:collapse;">
        <tr>
            <td width="200" style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Nombre</strong></td>
            <td style="border:1px solid #e5e7eb;">{{ $name }}</td>
        </tr>
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Teléfono</strong></td>
            <td style="border:1px solid #e5e7eb;">{{ $phone }}</td>
        </tr>
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Correo electrónico</strong></td>
            <td style="border:1px solid #e5e7eb;">{{ $email }}</td>
        </tr>
        @if($textMessage)
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb; vertical-align:top;"><strong>Mensaje</strong></td>
            <td style="border:1px solid #e5e7eb; white-space:pre-wrap; color:#374151;">
                {{ $textMessage }}
            </td>
        </tr>
        @endif
    </table>

    @if($vehicle)
    <hr>
    <p>El prospecto también esta solicitando información de la siguiente unidad:</p>
    <table cellpadding="8" cellspacing="0" border="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; border-collapse:collapse;">
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Modelo</strong></td>
            <td style="border:1px solid #e5e7eb;">{{ $vehicle->name }}</td>
        </tr>
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Año del modelo</strong></td>
            <td style="border:1px solid #e5e7eb;">{{ $vehicle->year }}</td>
        </tr>
        <tr>
            <td style="background:#f9fafb; border:1px solid #e5e7eb;"><strong>Enlace del modelo</strong></td>
            <td style="border:1px solid #e5e7eb;">
                <a href="https://solanabyd.com/modelos/{{ $vehicle->slug }}">Click para ver el modelo</a>
            </td>
        </tr>
    </table>
    @endif

    <p style="margin:16px 0 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#64748b;">
        Por favor, da seguimiento a la brevedad.
    </p>
</x-mails.templete>
