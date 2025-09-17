<?php

namespace App\Http\Controllers;

use App\Enum\ContactPreference;
use App\Enum\ContactType;
use App\Enum\SentType;
use App\Mail\ContactMail;
use App\Models\Email;
use App\Models\Vehicle;
use App\Models\Web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Enum;

class ContactController extends Controller
{
    public function sendContact(Request $request, ContactType $type)
    {
        $appkey = $request->appkey;

        if (!$appkey) {
            return abort(403);
        }

        $web = Web::firstWhere('app_key', $appkey);

        if (!$web) {
            return abort(403);
        }

        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'phone' => 'required|string',
                'contact_preference' => ['required', new Enum(ContactPreference::class)],
                'message' => 'nullable|string',
                'vehicle' => 'nullable|exists:vehicles,id'
            ]);

            $vehicle = null;
            $contactPreference = ContactPreference::from($request->contact_preference);

            if ($request->vehicle) {
                $vehicle = Vehicle::find($request->vehicle);
            }

            $mailesTo = Email::getAvailableWebForm($appkey, $type->value)->pluck('email');
            $mailesCc = Email::getAvailableWebForm($appkey, $type->value, SentType::CC)->pluck('email')->toArray();
            $mailesBcc = Email::getAvailableWebForm($appkey, $type->value, SentType::BCC)->pluck('email')->toArray();

            if ($mailesTo->isEmpty()) {
                Log::warning('No hay destinatarios para este correo', [
                    'section' => $type,
                    'appkey' => $appkey,
                    'request' => $request->except('appkey')
                ]);
            } else {
                Mail::to($mailesTo)->send(new ContactMail(
                    $type,
                    $request->name,
                    $request->email,
                    $request->phone,
                    $request->message,
                    $contactPreference,
                    $vehicle,
                    $web->web,
                    $mailesCc,
                    $mailesBcc
                ));
                Log::info('Ha salido un nuevo correo', [
                    'section' => $type,
                    'appkey' => $appkey
                ]);
            }

            return response()->json([
                'sended' => true,
            ], 200);

        } catch (\Exception $err) {
            Log::error('Ocurrio un error al enviar un correo de contacto', [
                'error' => $err->getMessage(),
                'section' => $type,
                'appkey' => $appkey
            ]);
            return response()->json([
                'sended' => false,
                'error' => $err->getMessage()
            ], 500);
        }

    }
}
